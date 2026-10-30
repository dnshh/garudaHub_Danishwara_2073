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
}