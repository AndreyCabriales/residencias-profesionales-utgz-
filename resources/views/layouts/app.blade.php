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

        <style>
            .fade-in-up {
                animation: fadeInUp 0.5s ease-out forwards;
                opacity: 0;
                transform: translateY(15px);
            }
            .delay-100 { animation-delay: 100ms; }
            .delay-200 { animation-delay: 200ms; }
            .delay-300 { animation-delay: 300ms; }

            @keyframes fadeInUp {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
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
                
                <a href="{{ route('coordinador.alumnos.index') }}" class="flex items-center px-4 py-2.5 rounded-md transition-colors {{ request()->routeIs('coordinador.alumnos.*') ? 'bg-utgz-primary border-l-4 border-utgz-accent' : 'hover:bg-utgz-primary/50 hover:border-l-4 hover:border-gray-500' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Alumnos
                </a>

                <a href="{{ route('coordinador.asesores.index') }}" class="flex items-center px-4 py-2.5 rounded-md transition-colors {{ request()->routeIs('coordinador.asesores.*') ? 'bg-utgz-primary border-l-4 border-utgz-accent' : 'hover:bg-utgz-primary/50 hover:border-l-4 hover:border-gray-500' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Asesores
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
                <form method="POST" action="{{ route('logout') }}" class="confirm-action" data-confirm-title="¿Cerrar sesión?" data-confirm-text="Tendrás que volver a iniciar sesión para acceder al sistema." data-confirm-button-text="Sí, cerrar sesión">
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
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Interceptar formularios o botones con la clase 'confirm-action'
                const confirmForms = document.querySelectorAll('.confirm-action');
                
                confirmForms.forEach(form => {
                    form.addEventListener('submit', function (e) {
                        e.preventDefault();
                        
                        const title = this.dataset.confirmTitle || '¿Estás seguro?';
                        const text = this.dataset.confirmText || 'Esta acción no se puede deshacer.';
                        const icon = this.dataset.confirmIcon || 'warning';
                        const confirmButtonText = this.dataset.confirmButtonText || 'Sí, confirmar';
                        const confirmButtonColor = this.dataset.confirmButtonColor || '#d33';
                        
                        Swal.fire({
                            title: title,
                            text: text,
                            icon: icon,
                            showCancelButton: true,
                            confirmButtonColor: confirmButtonColor,
                            cancelButtonColor: '#374151',
                            confirmButtonText: confirmButtonText,
                            cancelButtonText: 'Cancelar',
                            background: '#0D1B2A',
                            color: '#F0F4F8',
                            width: '26em',
                            heightAuto: false,
                            customClass: {
                                popup: 'border border-gray-700 shadow-2xl rounded-xl',
                                title: 'text-xl font-bold',
                                confirmButton: 'font-bold rounded-lg px-5 py-2.5 shadow-lg hover:-translate-y-0.5 transition-transform',
                                cancelButton: 'font-bold rounded-lg px-5 py-2.5 shadow-lg hover:-translate-y-0.5 transition-transform'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.submit();
                            }
                        });
                    });
                });
                // Interceptar formularios o botones con la clase 'reject-action' (con prompt)
                const rejectForms = document.querySelectorAll('.reject-action');
                
                rejectForms.forEach(form => {
                    form.addEventListener('submit', function (e) {
                        e.preventDefault();
                        
                        const title = this.dataset.confirmTitle || 'Motivo de rechazo';
                        const text = this.dataset.confirmText || 'Ingresa las correcciones que el alumno debe hacer:';
                        
                        Swal.fire({
                            title: title,
                            text: text,
                            input: 'textarea',
                            inputPlaceholder: 'Escribe el motivo aquí...',
                            inputAttributes: {
                                'aria-label': 'Motivo de rechazo',
                                'required': 'true'
                            },
                            showCancelButton: true,
                            confirmButtonColor: '#EF4444',
                            cancelButtonColor: '#374151',
                            confirmButtonText: 'Rechazar documento',
                            cancelButtonText: 'Cancelar',
                            background: '#0D1B2A',
                            color: '#F0F4F8',
                            width: '26em',
                            heightAuto: false,
                            customClass: {
                                popup: 'border border-gray-700 shadow-2xl rounded-xl',
                                title: 'text-xl font-bold',
                                input: 'bg-gray-800 text-white border-gray-600 focus:border-red-500 rounded-lg',
                                confirmButton: 'font-bold rounded-lg px-5 py-2.5 shadow-lg hover:-translate-y-0.5 transition-transform',
                                cancelButton: 'font-bold rounded-lg px-5 py-2.5 shadow-lg hover:-translate-y-0.5 transition-transform'
                            },
                            preConfirm: (value) => {
                                if (!value) {
                                    Swal.showValidationMessage('Debes ingresar un motivo de rechazo');
                                }
                                return value;
                            }
                        }).then((result) => {
                            if (result.isConfirmed && result.value) {
                                // Buscar el input oculto de retroalimentación dentro de este form
                                const retroInput = this.querySelector('input[name="retroalimentacion"]');
                                if (retroInput) {
                                    retroInput.value = result.value;
                                }
                                this.submit();
                            }
                        });
                    });
                });
            });
        </script>
    </body>
</html>
