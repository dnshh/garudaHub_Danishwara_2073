@extends('layouts.app')
@section('title', 'Dasbor')
@section('content')
@if(auth()->user()->role === 'klien')
<div class="card"><h1>Proyek Saya</h1><p><a class="btn" href="{{ route('projects.create') }}">+ Pasang proyek</a></p>
    @if($projects->isEmpty())<p>Anda belum memasang proyek.</p>@else
    <table><thead><tr><th>Judul</th><th>Status</th><th>Batas</th><th>Penawaran</th></tr></thead><tbody>
    @foreach($projects as $project)<tr><td><a href="{{ route('projects.show', $project) }}">{{ $project->judul }}</a></td><td><span class="badge {{ $project->status === 'terbuka' ? 'open' : 'closed' }}">{{ $project->status }}</span></td><td>{{ $project->batas_lelang->format('Y-m-d') }}</td><td>{{ $project->bids_count }}</td></tr>@endforeach
    </tbody></table>@endif
</div>
@else
<div class="card"><h1>Penawaran Saya</h1>
    @if($bids->isEmpty())<p>Anda belum mengajukan penawaran. <a href="{{ route('projects.index') }}">Cari proyek</a>.</p>@else
    <table><thead><tr><th>Proyek</th><th>Harga</th><th>Durasi</th><th>Hasil</th></tr></thead><tbody>
    @foreach($bids as $bid)<tr><td><a href="{{ route('projects.show', $bid->project) }}">{{ $bid->project->judul }}</a></td><td>Rp {{ number_format($bid->harga, 0, ',', '.') }}</td><td>{{ $bid->durasi }} hari</td><td>@if($bid->is_winner)<span class="badge win">Menang</span>@elseif($bid->project->status === 'terbuka')Menunggu @else Tidak terpilih @endif</td></tr>@endforeach
    </tbody></table>@endif
</div>
@endif
@endsection
