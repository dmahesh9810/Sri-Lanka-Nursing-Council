<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nurse Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans text-gray-900">

<nav class="bg-blue-600 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a class="flex items-center text-white font-bold text-xl" href="{{ route('dashboard') }}">
                    <i class="bi bi-hospital icon mr-2"></i> Nurse Management
                </a>
                
                @auth
                <div class="hidden lg:flex ml-10 space-x-4">
                    {{-- Dashboard: All staff --}}
                    <a class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-blue-800' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>

                    {{-- Temporary Registrations: Admin, User1, User2 --}}
                    @if(auth()->user()->hasRole('Admin', 'User1', 'User2'))
                    <a class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('temporary-registrations.*') ? 'bg-blue-800' : '' }}" href="{{ route('temporary-registrations.index') }}">Temp. Reg</a>
                    @endif

                    {{-- Permanent Registrations: Admin, User2, User3, User4, User5 --}}
                    @if(auth()->user()->hasRole('Admin', 'User2', 'User3', 'User4', 'User5'))
                    <a class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('permanent-registrations.*') ? 'bg-blue-800' : '' }}" href="{{ route('permanent-registrations.index') }}">Perm. Reg</a>
                    @endif

                    {{-- Permanent Certificates: Admin, User3 --}}
                    @if(auth()->user()->hasRole('Admin', 'User3'))
                    <a class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('permanent-certificates.*') ? 'bg-blue-800' : '' }}" href="{{ route('permanent-certificates.index') }}">Certificates</a>
                    @endif

                    {{-- Additional Qualifications: Admin, User4 --}}
                    @if(auth()->user()->hasRole('Admin', 'User4'))
                    <a class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('additional-qualifications.*') ? 'bg-blue-800' : '' }}" href="{{ route('additional-qualifications.index') }}">Qualifications</a>
                    @endif

                    {{-- Foreign Certificates: Admin, User5 --}}
                    @if(auth()->user()->hasRole('Admin', 'User5'))
                    <a class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('foreign-certificates.*') ? 'bg-blue-800' : '' }}" href="{{ route('foreign-certificates.index') }}">Foreign</a>
                    @endif

                    {{-- Reports: All roles --}}
                    @if(auth()->user()->hasRole('Admin', 'User1', 'User2', 'User3', 'User4', 'User5'))
                    <a class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('reports.*') ? 'bg-blue-800' : '' }}" href="{{ route('reports.index') }}">Reports</a>
                    @endif
                </div>
                @endauth
            </div>

            <div class="flex items-center">
                @auth
                <div class="hidden sm:flex items-center mr-4">
                    <form action="{{ route('global.search') }}" method="GET" class="relative">
                        <input class="bg-blue-500 text-white placeholder-blue-200 text-sm rounded-full py-1 px-4 pl-8 focus:outline-none focus:bg-white focus:text-gray-900 w-40 lg:w-64 transition-all duration-300" type="search" name="q" placeholder="NIC Search..." value="{{ request('q') }}" required>
                        <div class="absolute left-3 top-1.5 text-blue-200">
                            <i class="bi bi-search icon text-xs"></i>
                        </div>
                    </form>
                </div>
                
                <div class="flex items-center space-x-3">
                    <span class="text-white text-xs hidden md:block opacity-75">{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-md text-xs font-medium flex items-center transition-colors">
                            <i class="bi bi-box-arrow-right icon mr-1 w-4 h-4"></i> Logout
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm flex justify-between items-center" role="alert">
            <div class="flex items-center">
                <i class="bi bi-check-circle-fill mr-2"></i>
                <p>{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm flex justify-between items-center" role="alert">
            <div class="flex items-center">
                <i class="bi bi-exclamation-triangle-fill mr-2"></i>
                <p>{{ session('error') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    @endif

    @yield('content')
</main>

</body>
</html>
