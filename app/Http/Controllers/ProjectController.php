<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string)$request->query('q', ''));

        $projects = Project::with('klien')
            ->withCount('bids')
            ->when($search !== '', fn ($q) => $q -> where(fn ($w) => ($w) 
                ->where('judul', 'like', "%{$search}%")
                ->orWhere('kategori', 'like', "%{$search}%")))
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('projects.index', compact('projects', 'search'));
    }

    public function show(Project $project)
    {
        $project->load(['klien', 'bids.developer']);

        $user = auth()->user();
        $isOpen = $project->status === 'terbuka'
            && $project->batas_lelang->toDateString() >= now()->toDateString();
        $isOwner = $user !== null && (int)$user->id === (int)$project->klien_id;

        return view('projects.show', compact('project', 'user', 'isOpen', 'isOwner'));
    }
    
    public function create()
    {
        abort_unless(auth()->user()->role === 'klien', 403);

        return view('projects.create');
    }

    public function store(Request $request)
    {
        abort_unless($request->user()->role === 'klien', 403);

        $data = $request->validate([
        'judul'        => ['required', 'string', 'max:200'],
        'deskripsi'    => ['required', 'string', 'max:5000'],
        'kategori'     => ['required', 'string', 'max:50'],
        'budget_min'   => ['required', 'integer', 'min:0'],
        'budget_max'   => ['required', 'integer', 'gte:budget_min'],
        'batas_lelang' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
        ]);

        $request->user()->projects()->create($data);

        return redirect()->route('dashboard')
        ->with('status', 'Proyek berhasil dipasang.');
    }
}