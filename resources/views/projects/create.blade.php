@extends('layouts.app')
@section('title', 'Pasang Proyek')
@section('content')
<div class="card"><h1>Pasang Proyek</h1>
    <form method="POST" action="{{ route('projects.store') }}">@csrf
        <label for="judul">Judul</label><input id="judul" name="judul" maxlength="200" required value="{{ old('judul') }}">
        <label for="deskripsi">Deskripsi</label><textarea id="deskripsi" name="deskripsi" required>{{ old('deskripsi') }}</textarea>
        <label for="kategori">Kategori</label><input id="kategori" name="kategori" maxlength="50" placeholder="Web, Mobile, Desain, Data, AI..." required value="{{ old('kategori') }}">
        <div class="row"><div><label for="budget_min">Budget minimum (Rp)</label><input id="budget_min" type="number" name="budget_min" min="0" required value="{{ old('budget_min') }}"></div>
        <div><label for="budget_max">Budget maksimum (Rp)</label><input id="budget_max" type="number" name="budget_max" min="0" required value="{{ old('budget_max') }}"></div>
        <div><label for="batas_lelang">Batas lelang</label><input id="batas_lelang" type="date" name="batas_lelang" min="{{ now()->toDateString() }}" required value="{{ old('batas_lelang') }}"></div></div>
        <p><button type="submit">Pasang proyek</button></p>
    </form>
</div>
@endsection
