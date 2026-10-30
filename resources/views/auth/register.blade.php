@extends('layouts.app')
@section('title', 'Daftar')
@section('content')
<div class="card narrow"><h1>Daftar Akun</h1>
    <form method="POST" action="{{ route('register.store') }}">@csrf
        <label for="nama">Nama</label><input id="nama" name="nama" maxlength="100" required value="{{ old('nama') }}">
        <label for="email">Email</label><input id="email" type="email" name="email" maxlength="100" required value="{{ old('email') }}">
        <label for="password">Password</label><input id="password" type="password" name="password" minlength="6" required>
        <label for="role">Daftar sebagai</label><select id="role" name="role"><option value="klien" @selected(old('role', 'klien') === 'klien')>Klien</option><option value="developer" @selected(old('role') === 'developer')>Developer</option></select>
        <p><button type="submit">Daftar</button></p>
    </form>
</div>
@endsection
