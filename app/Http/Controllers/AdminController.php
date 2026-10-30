<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index', [
            'users'    => User::orderBy('id')->get(),
            'projects' => Project::with('klien')->orderBy('id')->get(),
        ]);
    }

    public function updateRole(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return back()->with('status', 'Tidak dapat mengubah peran akun sendiri.')
                         ->with('status_type', 'err');
        }

        $data = $request->validate([
            'role' => ['required', Rule::in(['klien', 'developer', 'admin'])],
        ]);

        $user->update($data);

        return back()->with('status', 'Peran diperbarui.');
    }

    public function destroyUser(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return back()->with('status', 'Tidak dapat menghapus akun sendiri.')
                         ->with('status_type', 'err');
        }

        $user->delete(); // proyek dan penawaran ikut terhapus lewat cascadeOnDelete

        return back()->with('status', 'Pengguna dihapus.');
    }

    public function destroyProject(Project $project)
    {
        $project->delete(); // penawaran ikut terhapus lewat cascadeOnDelete

        return back()->with('status', 'Proyek dihapus.');
    }
}