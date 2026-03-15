<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nurse Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <i class="bi bi-hospital"></i> Nurse Management System
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            @auth
            <form action="{{ route('global.search') }}" method="GET" class="d-flex ms-lg-4 my-2 my-lg-0">
                <div class="input-group input-group-sm bg-white rounded">
                    <input class="form-control border-0 shadow-none" type="search" name="q" placeholder="Global search by NIC..." aria-label="Search" value="{{ request('q') }}" required>
                    <button class="btn btn-light border-0" type="submit"><i class="bi bi-search text-muted"></i></button>
                </div>
            </form>
            @endauth
            <ul class="navbar-nav ms-auto">

                {{-- Dashboard: Admin only --}}
                @if(auth()->check() && auth()->user()->hasRole(\App\Models\User::ROLE_ADMIN))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a>
                </li>
                @endif

                {{-- Temporary Registrations: Admin, User1, User2 --}}
                @if(auth()->check() && auth()->user()->hasRole(\App\Models\User::ROLE_ADMIN, \App\Models\User::ROLE_USER1, \App\Models\User::ROLE_USER2))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('temporary-registrations.*') ? 'active' : '' }}" href="{{ route('temporary-registrations.index') }}">Temp. Registrations</a>
                </li>
                @endif

                {{-- Permanent Registrations: Admin, User2, User3, User4, User5 --}}
                @if(auth()->check() && auth()->user()->hasRole(\App\Models\User::ROLE_ADMIN, \App\Models\User::ROLE_USER2, \App\Models\User::ROLE_USER3, \App\Models\User::ROLE_USER4, \App\Models\User::ROLE_USER5))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('permanent-registrations.*') ? 'active' : '' }}" href="{{ route('permanent-registrations.index') }}">Perm. Registrations</a>
                </li>
                @endif

                {{-- Permanent Certificates: Admin, User3 --}}
                @if(auth()->check() && auth()->user()->hasRole(\App\Models\User::ROLE_ADMIN, \App\Models\User::ROLE_USER3))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('permanent-certificates.*') ? 'active' : '' }}" href="{{ route('permanent-certificates.index') }}">Perm. Certificates</a>
                </li>
                @endif

                {{-- Additional Qualifications: Admin, User4 --}}
                @if(auth()->check() && auth()->user()->hasRole(\App\Models\User::ROLE_ADMIN, \App\Models\User::ROLE_USER4))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('additional-qualifications.*') ? 'active' : '' }}" href="{{ route('additional-qualifications.index') }}">Add. Qualifications</a>
                </li>
                @endif

                {{-- Foreign Certificates: Admin, User5 --}}
                @if(auth()->check() && auth()->user()->hasRole(\App\Models\User::ROLE_ADMIN, \App\Models\User::ROLE_USER5))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('foreign-certificates.*') ? 'active' : '' }}" href="{{ route('foreign-certificates.index') }}">Foreign Certs</a>
                </li>
                @endif

                {{-- Reports: All roles --}}
                @if(auth()->check() && auth()->user()->hasRole(\App\Models\User::ROLE_ADMIN, \App\Models\User::ROLE_USER1, \App\Models\User::ROLE_USER2, \App\Models\User::ROLE_USER3, \App\Models\User::ROLE_USER4, \App\Models\User::ROLE_USER5))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">Reports</a>
                </li>
                @endif

                @auth
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-link nav-link text-danger"><i class="bi bi-box-arrow-right me-1"></i>Logout</button>
                    </form>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @yield('content')
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
