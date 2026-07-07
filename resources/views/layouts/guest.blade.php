<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Residencias UTGZ') }} - Acceso</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
            <style>
            .fade-in {
                animation: fadeIn 0.8s ease-out forwards;
            }
            .slide-in-right {
                animation: slideInRight 0.8s ease-out forwards;
            }
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            @keyframes slideInRight {
                from { opacity: 0; transform: translateX(30px); }
                to { opacity: 1; transform: translateX(0); }
            }
            .bg-split-pattern {
                background-color: #020617; /* Slate 950 */
                background-image: radial-gradient(circle at top right, #064e3b 0%, transparent 60%),
                                  radial-gradient(circle at bottom left, #047857 0%, transparent 50%);
            }
        </style>
    </head>
    <body class="font-sans antialiased text-slate-900 bg-white">
        <div class="min-h-screen flex overflow-hidden">
            
            <!-- Left Side: Branding & Decoration (Hidden on mobile) -->
            <div class="hidden lg:flex lg:w-1/2 bg-split-pattern relative flex-col justify-between p-12 text-white fade-in">
                <!-- Top Logo -->
                <div class="flex items-center gap-3 relative z-10">
                    <img src="{{ asset('images/logo_bis.png') }}" alt="Logo BIS UTGZ" class="h-12 object-contain brightness-0 invert opacity-90 hover:opacity-100 transition-opacity">
                </div>

                <!-- Center Content -->
                <div class="relative z-10 max-w-lg">
                    <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight mb-6 leading-tight">
                        Plataforma de <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-200">Residencias</span>
                    </h1>
                    <p class="text-lg text-gray-300 font-light leading-relaxed">
                        Gestiona, revisa y aprueba el progreso de los estudiantes de manera eficiente y centralizada.
                    </p>
                </div>

                <!-- Bottom Footer -->
                <div class="relative z-10 text-sm text-gray-400 font-medium">
                    &copy; {{ date('Y') }} Universidad Tecnológica de Gutiérrez Zamora.
                    <br>
                    <a href="{{ url('/privacidad') }}" class="text-emerald-400 hover:text-emerald-300 transition mt-2 inline-block">Aviso de Privacidad</a>
                </div>

                <!-- Abstract overlapping circles for depth -->
                <div class="absolute top-1/4 right-10 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-1/4 left-10 w-48 h-48 bg-teal-500/10 rounded-full blur-3xl animate-pulse delay-700"></div>
            </div>

            <!-- Right Side: Login Form Container -->
            <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 relative slide-in-right">
                
                <!-- Mobile Logo (Only visible on small screens) -->
                <div class="absolute top-8 left-8 flex items-center gap-3 lg:hidden">
                    <div class="w-10 h-10 bg-utgz-primary rounded-lg flex items-center justify-center text-white font-bold text-xl shadow-md">
                        U
                    </div>
                    <span class="font-bold text-xl tracking-tight text-utgz-primary">UTGZ</span>
                </div>

                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
                
            </div>
        </div>

    </body>
</html>
