<!doctype html>
<html>
<head>
    <title>Freelance App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="p-3 border-bottom">
    <a href="{{ route('jobs.index') }}">Aktivni oglasi</a> |
    <a href="{{ route('jobs.create') }}">Dodaj oglas</a> |
    <form action="{{ route('logout') }}" method="POST" style="display:inline">
        @csrf
        <button class="btn btn-link p-0">Logout</button>
    </form>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

</body>
</html>
