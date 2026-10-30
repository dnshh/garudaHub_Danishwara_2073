<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BidController extends Controller
{
    // Developer mengajukan penawaran
    public function store(Request $request, Project $project)
    {
        $user = $request->user();

        abort_unless($user->role === 'developer', 403, 'Hanya developer yang boleh menawar.');

        $masihTerbuka = $project->status === 'terbuka'
            && $project->batas_lelang->toDateString() >= now()->toDateString();

        if (! $masihTerbuka) {
            return back()->with('status', 'Lelang proyek ini sudah ditutup.')
                         ->with('status_type', 'err');
        }

        if ($project->bids()->where('developer_id', $user->id)->exists()) {
            return back()->with('status', 'Anda sudah mengajukan penawaran untuk proyek ini.')
                         ->with('status_type', 'err');
        }

        $data = $request->validate([
            'harga'    => ['required', 'integer', 'min:1'],
            'durasi'   => ['required', 'integer', 'min:1'],
            'proposal' => ['required', 'string', 'max:2000'],
        ]);

        $project->bids()->create($data + ['developer_id' => $user->id]);

        return redirect()->route('projects.show', $project)
            ->with('status', 'Penawaran berhasil dikirim.');
    }

    // Klien memilih pemenang
    public function pick(Request $request, Project $project, Bid $bid)
    {
        abort_unless((int) $project->klien_id === (int) $request->user()->id, 403);
        abort_unless((int) $bid->project_id === (int) $project->id, 404);

        $berhasil = DB::transaction(function () use ($project, $bid) {
            // Kunci baris proyek agar dua klik bersamaan tidak membuat dua pemenang
            $p = Project::whereKey($project->id)->lockForUpdate()->firstOrFail();

            if ($p->status !== 'terbuka') {
                return false;
            }

            $bid->update(['is_winner' => true]);
            $p->update(['status' => 'ditutup']);

            return true;
        });

        if (! $berhasil) {
            return back()->with('status', 'Proyek ini sudah ditutup.')
                         ->with('status_type', 'err');
        }

        return redirect()->route('projects.show', $project)
            ->with('status', 'Pemenang berhasil dipilih. Lelang ditutup.');
    }
}