@extends('layouts.app')
@section('title', 'Masuk')
@section('content')
<div class="card narrow"><h1>Masuk</h1>
    <form method="POST" action="{{ route('login.store') }}">@csrf
        <label for="email">Email</label><input id="email" type="email" name="email" required value="{{ old('email') }}" autocomplete="email">
        <label for="password">Password</label><input id="password" type="password" name="password" required autocomplete="current-password">
        <p><button type="submit">Masuk</button> <a href="{{ route('register') }}">Belum punya akun?</a></p>
    </form>
</div>
@endsection
