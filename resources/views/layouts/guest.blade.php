<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Residencias UTGZ') }} - Ingreso</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .fade-in {
                animation: fadeIn 0.6s ease-out forwards;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50 relative overflow-hidden">
            
            <!-- Decorative Background Elements -->
            <div class="absolute top-0 left-0 w-full h-64 bg-utgz-primary/5 skew-y-3 transform origin-top-left -z-10"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-utgz-accent/5 rounded-full blur-3xl -z-10 translate-x-1/2 translate-y-1/2"></div>

            <div class="fade-in">
                <a href="/" class="flex flex-col items-center gap-2 mb-6 transition-transform hover:scale-105">
                    <div class="w-16 h-16 bg-utgz-primary rounded-2xl flex items-center justify-center shadow-lg shadow-utgz-primary/30">
                        <span class="text-3xl font-bold text-white tracking-wider">U</span>
                    </div>
                    <span class="text-xl font-bold text-utgz-primary tracking-tight">UTGZ Residencias</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-2 px-8 py-10 bg-white shadow-2xl shadow-gray-200/50 overflow-hidden sm:rounded-3xl border border-gray-100 fade-in" style="animation-delay: 100ms; opacity: 0;">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-sm text-gray-400 fade-in" style="animation-delay: 200ms; opacity: 0;">
                &copy; {{ date('Y') }} Universidad Tecnológica de Gutiérrez Zamora
            </div>
        </div>
    </body>
</html>
