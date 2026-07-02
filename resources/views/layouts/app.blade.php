<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sistema de Residencias UTGZ') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-utgz-text bg-utgz-bg h-screen flex overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-utgz-sidebar text-white flex flex-col hidden md:flex">
            <div class="h-16 flex items-center justify-center border-b border-gray-700">
                <h1 class="text-xl font-bold tracking-wider">Residencias UTGZ</h1>
            </div>
            
            <div class="p-4 border-b border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-utgz-primary flex items-center justify-center text-lg font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400 capitalize">{{ Auth::user()->roles->pluck('name')->implode(', ') }}</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-2 py-4 space-y-2 overflow-y-auto">
                @hasrole('coordinador')
                <a href="{{ route('coordinador.dashboard') }}" class="flex items-center px-4 py-2.5 rounded-md transition-colors {{ request()->routeIs('coordinador.dashboard') ? 'bg-utgz-primary border-l-4 border-utgz-accent' : 'hover:bg-utgz-primary/50 hover:border-l-4 hover:border-gray-500' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>
                @endhasrole

                @hasrole('asesor')
                <a href="{{ route('asesor.dashboard') }}" class="flex items-center px-4 py-2.5 rounded-md transition-colors {{ request()->routeIs('asesor.dashboard') ? 'bg-utgz-primary border-l-4 border-utgz-accent' : 'hover:bg-utgz-primary/50 hover:border-l-4 hover:border-gray-500' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>
                @endhasrole

                @hasrole('alumno')
                <a href="{{ route('alumno.dashboard') }}" class="flex items-center px-4 py-2.5 rounded-md transition-colors {{ request()->routeIs('alumno.dashboard') ? 'bg-utgz-primary border-l-4 border-utgz-accent' : 'hover:bg-utgz-primary/50 hover:border-l-4 hover:border-gray-500' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Progreso
                </a>
                @endhasrole

                <!-- Otros Enlaces Comunes -->
                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2.5 rounded-md transition-colors hover:bg-utgz-primary/50 hover:border-l-4 hover:border-gray-500">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Mi Perfil
                </a>
            </nav>

            <div class="p-4 border-t border-gray-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2.5 text-sm text-red-400 rounded-md hover:bg-red-500/10 transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-hidden">
            <!-- Mobile Header -->
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-4 md:hidden">
                <h1 class="text-lg font-bold text-utgz-primary">Residencias UTGZ</h1>
                <button class="text-gray-500 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </header>

            <!-- Page Header -->
            @isset($header)
                <div class="bg-white shadow-sm border-b border-gray-200 px-8 py-5">
                    {{ $header }}
                </div>
            @endisset

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto p-8">
                {{ $slot }}
            </div>
        </main>
    </body>
</html>
