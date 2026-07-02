<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Residencias Profesionales - UTGZ</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
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
        
        .bg-hero-pattern {
            background-color: #0D1B2A;
            background-image: radial-gradient(circle at 20% 150%, #1A3A6B 0%, transparent 50%), 
                              radial-gradient(circle at 80% -50%, #2D7DD2 0%, transparent 50%);
        }
    </style>
</head>
<body class="antialiased font-sans bg-hero-pattern min-h-screen text-white flex flex-col">
    
    <!-- Navbar -->
    <nav class="w-full p-6 flex justify-between items-center z-10 relative fade-in-up">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center text-utgz-primary font-bold text-xl shadow-lg">
                U
            </div>
            <span class="font-bold text-xl tracking-wide">UTGZ</span>
        </div>
        <div>
            @if (Route::has('login'))
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-white hover:text-gray-300 transition-colors">Ir al Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="bg-utgz-accent hover:bg-blue-500 text-white px-6 py-2.5 rounded-full font-medium transition-all shadow-lg hover:shadow-blue-500/30">
                        Iniciar Sesión
                    </a>
                @endauth
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="flex-1 flex items-center justify-center relative z-10 px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-4xl mx-auto">
            <div class="inline-block mb-4 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-md text-sm font-medium fade-in-up delay-100">
                 Plataforma de Gestión Académica
            </div>
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-6 fade-in-up delay-200 leading-tight">
                Sistema de Registro de <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-utgz-accent">Residencias Profesionales</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-300 mb-10 max-w-2xl mx-auto fade-in-up delay-300 font-light">
                Digitalizando el proceso de seguimiento, revisión y aprobación de documentos para alumnos y asesores de la Universidad Tecnológica de Gutiérrez Zamora.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center fade-in-up delay-300">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-white text-utgz-sidebar px-8 py-4 rounded-full font-bold text-lg transition-all hover:scale-105 shadow-xl hover:shadow-white/20">
                            Ir a mi Panel
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="bg-white text-utgz-sidebar px-8 py-4 rounded-full font-bold text-lg transition-all hover:scale-105 shadow-xl hover:shadow-white/20">
                            Ingresar al Sistema
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </main>

    <!-- Floating UI Elements for decoration -->
    <div class="absolute top-1/4 left-10 w-24 h-24 bg-blue-500/20 rounded-full blur-2xl animate-pulse"></div>
    <div class="absolute bottom-1/4 right-10 w-32 h-32 bg-utgz-accent/20 rounded-full blur-2xl animate-pulse delay-700"></div>

    <footer class="p-6 text-center text-sm text-gray-400 fade-in-up delay-300">
        &copy; {{ date('Y') }} Universidad Tecnológica de Gutiérrez Zamora. Todos los derechos reservados.
    </footer>
</body>
</html>
