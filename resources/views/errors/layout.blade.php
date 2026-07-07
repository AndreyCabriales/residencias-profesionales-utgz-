<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Residencias UTGZ</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bg-hero-pattern {
            background-color: #020617; /* Slate 950 */
            background-image: radial-gradient(circle at 20% 150%, #064e3b 0%, transparent 50%), 
                              radial-gradient(circle at 80% -50%, #047857 0%, transparent 50%);
        }
        .float-slow { animation: floatSlow 12s ease-in-out infinite; }
        .float-delayed { animation: floatDelayed 15s ease-in-out infinite; animation-delay: 2s; }
        @keyframes floatSlow {
            0% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(150px, -150px) scale(1.2); }
            66% { transform: translate(-100px, 100px) scale(0.8); }
            100% { transform: translate(0, 0) scale(1); }
        }
        @keyframes floatDelayed {
            0% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(-200px, 150px) scale(1.3); }
            66% { transform: translate(150px, -100px) scale(0.85); }
            100% { transform: translate(0, 0) scale(1); }
        }
    </style>
</head>
<body class="antialiased font-sans bg-hero-pattern min-h-screen text-white flex flex-col overflow-hidden relative items-center justify-center">
    
    <!-- Elegant Floating Spheres -->
    <div class="absolute top-1/4 left-10 w-64 h-64 bg-emerald-500/10 rounded-full blur-[80px] float-slow pointer-events-none"></div>
    <div class="absolute bottom-1/4 right-10 w-80 h-80 bg-teal-500/10 rounded-full blur-[100px] float-delayed pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-2xl px-6 text-center">
        <!-- Error Box -->
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-10 sm:p-14 rounded-3xl shadow-2xl">
            <div class="flex justify-center mb-6">
                <div class="bg-white/10 p-4 rounded-2xl border border-white/20">
                    <img src="{{ asset('images/logo_bis.png') }}" alt="UTGZ" class="h-12 object-contain brightness-0 invert">
                </div>
            </div>
            
            <div class="text-7xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-200 mb-2">
                @yield('code')
            </div>
            
            <h1 class="text-3xl font-bold tracking-tight text-white mb-4">
                @yield('message')
            </h1>
            
            <p class="text-emerald-100/60 mb-10 text-lg font-light leading-relaxed">
                @yield('description', 'Lo sentimos, ha ocurrido un error inesperado. Por favor, intenta nuevamente o regresa a un lugar seguro.')
            </p>
            
            <a href="{{ url('/') }}" class="inline-flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white px-8 py-3.5 rounded-xl font-bold transition-all shadow-lg hover:shadow-emerald-500/30 hover:-translate-y-1 focus:outline-none focus:ring-4 focus:ring-emerald-500/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Regresar al Inicio
            </a>
        </div>
    </div>
</body>
</html>
