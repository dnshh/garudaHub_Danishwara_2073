@extends('layouts.app')
@section('title', $project->judul)
@section('content')
<div class="card">
    <h1>{{ $project->judul }} <span class="badge {{ $project->status === 'terbuka' ? 'open' : 'closed' }}">{{ $project->status }}</span></h1>
    <p class="muted">Kategori: {{ $project->kategori }} | Klien: {{ $project->klien->nama }} | Budget: Rp {{ number_format($project->budget_min, 0, ',', '.') }} - Rp {{ number_format($project->budget_max, 0, ',', '.') }} | Batas lelang: {{ $project->batas_lelang->format('Y-m-d') }}</p>
    <p>{!! nl2br(e($project->deskripsi)) !!}</p>
</div>
<div class="card">
    <h2>Penawaran ({{ $project->bids->count() }})</h2>
    @if($project->bids->isEmpty())<p>Belum ada penawaran.</p>
    @else
    <table><thead><tr><th>Developer</th><th>Harga</th><th>Durasi</th><th>Proposal</th><th>Aksi</th></tr></thead><tbody>
    @foreach($project->bids as $bid)
        <tr class="{{ $bid->is_winner ? 'winner' : '' }}"><td>{{ $bid->developer->nama }} @if($bid->is_winner)<span class="badge win">Pemenang</span>@endif</td>
            <td>Rp {{ number_format($bid->harga, 0, ',', '.') }}</td><td>{{ $bid->durasi }} hari</td><td>{!! nl2br(e($bid->proposal)) !!}</td><td>
            @if($isOwner && $project->status === 'terbuka')
                <form method="POST" action="{{ route('projects.bids.pick', [$project, $bid]) }}" onsubmit="return confirm('Pilih penawaran ini sebagai pemenang?')">@csrf<button class="sm">Pilih pemenang</button></form>
            @endif
        </td></tr>
    @endforeach
    </tbody></table>
    @endif
</div>
@if(auth()->check() && auth()->user()->role === 'developer')
    @if($isOpen)
    <div class="card"><h2>Ajukan Penawaran</h2>
        <form method="POST" action="{{ route('projects.bids.store', $project) }}">@csrf
            <div class="row"><div><label for="harga">Harga (Rp)</label><input id="harga" type="number" name="harga" min="1" required value="{{ old('harga') }}"></div>
            <div><label for="durasi">Durasi (hari)</label><input id="durasi" type="number" name="durasi" min="1" required value="{{ old('durasi') }}"></div></div>
            <label for="proposal">Proposal</label><textarea id="proposal" name="proposal" required>{{ old('proposal') }}</textarea><p><button type="submit">Kirim penawaran</button></p>
        </form>
    </div>
    @else<div class="card"><p class="muted">Lelang sudah ditutup; penawaran tidak dapat diajukan.</p></div>@endif
@elseif(!auth()->check() && $isOpen)
    <div class="card"><p><a href="{{ route('login') }}">Masuk</a> sebagai developer untuk mengajukan penawaran.</p></div>
@endif
@endsection
