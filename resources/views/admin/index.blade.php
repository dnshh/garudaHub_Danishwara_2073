@extends('layouts.app')
@section('title', 'Administrasi')
@section('content')
<div class="card"><h1>Admin: Pengguna</h1>
    <table><thead><tr><th>ID</th><th>Nama</th><th>Email</th><th>Peran</th><th>Aksi</th></tr></thead><tbody>
    @foreach($users as $user)<tr><td>{{ $user->id }}</td><td>{{ $user->nama }}</td><td>{{ $user->email }}</td><td>{{ $user->role }}</td><td>
        <form class="inline" method="POST" action="{{ route('admin.users.role', $user) }}">@csrf @method('PATCH')
            <select name="role" aria-label="Peran">@foreach(['klien', 'developer', 'admin'] as $role)<option value="{{ $role }}" @selected($user->role === $role)>{{ $role }}</option>@endforeach</select>
            <button class="sm sec">Ubah</button>
        </form>
        @if($user->id !== auth()->id())<form class="inline" method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus pengguna beserta proyek dan penawarannya?')">@csrf @method('DELETE')<button class="sm danger">Hapus</button></form>@endif
    </td></tr>@endforeach
    </tbody></table>
</div>
<div class="card"><h1>Admin: Proyek</h1>
    <table><thead><tr><th>ID</th><th>Judul</th><th>Klien</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
    @foreach($projects as $project)<tr><td>{{ $project->id }}</td><td><a href="{{ route('projects.show', $project) }}">{{ $project->judul }}</a></td><td>{{ $project->client->nama }}</td><td><span class="badge {{ $project->status === 'terbuka' ? 'open' : 'closed' }}">{{ $project->status }}</span></td><td>
        <form class="inline" method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('Hapus proyek ini?')">@csrf @method('DELETE')<button class="sm danger">Hapus</button></form>
    </td></tr>@endforeach
    </tbody></table>
</div>
@endsection
