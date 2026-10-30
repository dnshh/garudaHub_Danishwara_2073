<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        abort_unless(in_array($user->role, ['klien', 'developer']), 403);

        if ($user->role === 'klien') {
            return view('dashboard.index', [
                'projects' => $user->projects()->withCount('bids')->latest('id')->get(),
            ]);
        }

        return view('dashboard.index', [
            'bids' => $user->bids()->with('project')->latest('id')->get(),
        ]);
    }
}