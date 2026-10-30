<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Garuda-Hub') - Garuda-Hub</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<header><div class="in">
    <a class="brand" href="{{ route('projects.index') }}">Garuda-Hub</a>
    <a href="{{ route('projects.index') }}">Proyek</a>
    @auth
        @if(auth()->user()->role === 'klien')<a href="{{ route('projects.create') }}">Pasang Proyek</a>@endif
        @if(auth()->user()->role !== 'admin')<a href="{{ route('dashboard') }}">Dasbor</a>@endif
        @if(auth()->user()->role === 'admin')<a href="{{ route('admin.index') }}">Admin</a>@endif
        <span>{{ auth()->user()->nama }} ({{ auth()->user()->role }})</span>
        <form method="POST" action="{{ route('logout') }}" class="inline">@csrf<button class="sm sec">Keluar</button></form>
    @else
        <a href="{{ route('login') }}">Masuk</a><a href="{{ route('register') }}">Daftar</a>
    @endauth
</div></header>
<main>
    @if(session('status'))<div class="flash {{ session('status_type', 'ok') }}">{{ session('status') }}</div>@endif
    @if($errors->any())<div class="flash err"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    @yield('content')
</main>
<footer>Garuda-Hub - prototipe pembelajaran. Jangan dipasang di server publik tanpa pengamanan tambahan.</footer>
<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
