<!doctype html>
<html>
<head>
    <title>Freelance App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom mb-4">
    <div class="container">

        <!-- LOGO / NAZIV -->
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
            FreelanceApp
        </a>

        <!-- TOGGLER ZA MOBILNE -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- LINKOVI -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('jobs.index') ? 'active fw-semibold' : '' }}"
                       href="{{ route('jobs.index') }}">
                        Aktivni oglasi
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('jobs.create') ? 'active fw-semibold' : '' }}"
                       href="{{ route('jobs.create') }}">
                        Dodaj oglas
                    </a>
                </li>
            </ul>

            <!-- DESNO: USER / LOGOUT -->
            <form action="{{ route('logout') }}" method="POST" class="d-flex">
                @csrf
                <button class="btn btn-outline-danger btn-sm">
                    Logout
                </button>
            </form>
        </div>

    </div>
</nav>


<div class="container mt-4">
    @yield('content')
</div>

</body>
</html>
