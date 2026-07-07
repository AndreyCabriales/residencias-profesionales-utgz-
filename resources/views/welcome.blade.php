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
            animation: fadeInUp 1s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
        .delay-700 { animation-delay: 700ms; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .bg-hero-pattern {
            background-color: #020617; /* Slate 950 - Extremely elegant dark */
            background-image: radial-gradient(circle at 20% 150%, #064e3b 0%, transparent 50%), 
                              radial-gradient(circle at 80% -50%, #047857 0%, transparent 50%);
        }

        /* Float animations for spheres */
        .float-slow {
            animation: floatSlow 12s ease-in-out infinite;
        }
        
        .float-delayed {
            animation: floatDelayed 15s ease-in-out infinite;
            animation-delay: 2s;
        }

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
<body class="antialiased font-sans bg-hero-pattern min-h-screen text-white flex flex-col overflow-hidden relative" x-data="{ showCredits: false, activeTab: 'equipo' }">
    
    <!-- Navbar -->
    <nav class="w-full p-4 sm:p-6 flex justify-center sm:justify-start items-center z-10 relative fade-in-up">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo_bis.png') }}" alt="Logo BIS UTGZ" class="h-8 sm:h-10 object-contain brightness-0 invert opacity-90 hover:opacity-100 transition-opacity">
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="flex-1 flex items-center justify-center relative z-10 px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-4xl mx-auto">
            <div class="inline-block mb-4 px-4 py-1.5 rounded-full bg-white/5 border border-white/10 backdrop-blur-md text-xs sm:text-sm font-medium fade-in-up delay-100 text-emerald-200">
                 Plataforma de Gestión Académica
            </div>
            <h1 class="text-4xl sm:text-5xl md:text-7xl font-extrabold tracking-tight mb-6 fade-in-up delay-200 leading-tight">
                Sistema de Registro de <br class="hidden sm:block">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-200">Residencias Profesionales</span>
            </h1>
            <p class="text-base sm:text-lg md:text-xl text-gray-300 mb-10 max-w-2xl mx-auto px-2 fade-in-up delay-300 font-light leading-relaxed">
                Digitalizando el proceso de seguimiento, revisión y aprobación de documentos para alumnos y asesores de la Universidad Tecnológica de Gutiérrez Zamora.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center fade-in-up delay-300">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-white text-slate-900 px-8 py-4 rounded-full font-bold text-lg transition-all hover:-translate-y-1 shadow-xl hover:shadow-white/20">
                            Ir a mi Panel
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="bg-white text-slate-900 px-8 py-4 rounded-full font-bold text-lg transition-all hover:-translate-y-1 shadow-xl hover:shadow-white/20">
                            Ingresar al Sistema
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </main>

    <!-- Elegant Floating Spheres -->
    <div class="absolute top-1/4 left-10 w-64 h-64 bg-emerald-500/10 rounded-full blur-[80px] float-slow pointer-events-none"></div>
    <div class="absolute bottom-1/4 right-10 w-80 h-80 bg-teal-500/10 rounded-full blur-[100px] float-delayed pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-emerald-700/10 rounded-full blur-[120px] pointer-events-none"></div>

    <footer class="p-6 pb-20 sm:pb-6 text-center text-xs sm:text-sm text-gray-500 fade-in-up delay-300 relative z-10">
        &copy; {{ date('Y') }} Universidad Tecnológica de Gutiérrez Zamora. Todos los derechos reservados.
    </footer>

    <!-- Floating Info Button -->
    <div class="fixed bottom-4 right-4 sm:bottom-6 sm:right-8 z-40 flex items-center justify-center">
        <button @click="showCredits = true" class="relative text-emerald-400 hover:text-emerald-900 transition-all duration-300 hover:scale-110 hover:-translate-y-1 focus:outline-none animate-pulse">
            <svg class="w-12 h-12 sm:w-14 sm:h-14 drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </button>
    </div>

    <!-- Credits Modal -->
    <div x-show="showCredits" 
         style="display: none;"
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
         
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
            <!-- Background overlay -->
            <div x-show="showCredits" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" 
                 @click="showCredits = false"></div>

            <!-- Modal Panel -->
            <div x-show="showCredits"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full w-full">
                
                <!-- Logo Section (White) -->
                <div class="bg-white p-6 flex justify-center">
                    <img src="{{ asset('images/logo_bis.png') }}" alt="UTGZ" class="h-16 object-contain">
                </div>

                <!-- Title Banner (Dark Green/Black) -->
                <div class="bg-utgz-sidebar p-6 text-center relative">
                    <button @click="showCredits = false" class="absolute top-4 right-4 text-white/70 hover:text-white transition-colors focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    
                    <h3 class="text-2xl font-bold text-white tracking-tight" id="modal-title">Créditos</h3>
                    <p class="text-emerald-400 text-sm mt-1 font-medium">Universidad Tecnológica de Gutiérrez Zamora</p>
                </div>

                <!-- Tabs Navigation -->
                <div class="flex border-b border-gray-200 bg-white text-gray-500 font-medium">
                    <button @click="activeTab = 'equipo'" 
                            :class="activeTab === 'equipo' ? 'border-emerald-600 text-emerald-700' : 'border-transparent hover:text-gray-800 hover:bg-gray-50'"
                            class="w-1/2 py-4 text-sm border-b-2 transition-colors focus:outline-none text-center">
                        Equipo
                    </button>
                    <button @click="activeTab = 'proyecto'"
                            :class="activeTab === 'proyecto' ? 'border-emerald-600 text-emerald-700' : 'border-transparent hover:text-gray-800 hover:bg-gray-50'"
                            class="w-1/2 py-4 text-sm border-b-2 transition-colors focus:outline-none text-center">
                        Proyecto
                    </button>
                </div>

                <!-- Tab Contents -->
                <div class="p-8 bg-white min-h-[300px] text-slate-800">
                    
                    <!-- Tab: Equipo -->
                    <div x-show="activeTab === 'equipo'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <p class="text-center text-sm text-gray-500 mb-6">Desarrollado con dedicación por talento de la UTGZ</p>
                        
                        <div class="space-y-4 max-h-96 overflow-y-auto pr-2 custom-scrollbar">
                            
                            <!-- Developer Card: Josué Pérez -->
                            <div class="bg-gray-50 hover:bg-gray-100 rounded-xl p-4 flex items-center justify-between border border-gray-200 transition-colors group">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center text-2xl border border-emerald-200 shadow-sm">
                                        👨‍💻
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-base">Josué Pérez Tapia</h4>
                                        <p class="text-xs text-gray-500 font-medium">Desarrollador FullStack</p>
                                    </div>
                                </div>
                                <div class="flex gap-2 opacity-60 group-hover:opacity-100 transition-opacity">
                                    <a href="#" class="text-gray-400 hover:text-slate-800 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path></svg>
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Developer Card: Andrey Cabriales -->
                            <div class="bg-gray-50 hover:bg-gray-100 rounded-xl p-4 flex items-center justify-between border border-gray-200 transition-colors group">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center text-2xl border border-emerald-200 shadow-sm">
                                        👨‍💻
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-base">Andrey Emilio Cabriales Ramirez</h4>
                                        <p class="text-xs text-gray-500 font-medium">Desarrollador FullStack</p>
                                    </div>
                                </div>
                                <div class="flex gap-2 opacity-60 group-hover:opacity-100 transition-opacity">
                                    <a href="#" class="text-gray-400 hover:text-slate-800 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path></svg>
                                    </a>
                                </div>
                            </div>

                            <!-- Developer Card: Ángel de Gabriel -->
                            <div class="bg-gray-50 hover:bg-gray-100 rounded-xl p-4 flex items-center justify-between border border-gray-200 transition-colors group">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-2xl border border-blue-200 shadow-sm">
                                        ⚙️
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-base">Ángel de Gabriel Aparicio Maldonado</h4>
                                        <p class="text-xs text-gray-500 font-medium">Desarrollador Backend</p>
                                    </div>
                                </div>
                                <div class="flex gap-2 opacity-60 group-hover:opacity-100 transition-opacity">
                                    <a href="#" class="text-gray-400 hover:text-slate-800 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path></svg>
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Developer Card: Alondra San Martín -->
                            <div class="bg-gray-50 hover:bg-gray-100 rounded-xl p-4 flex items-center justify-between border border-gray-200 transition-colors group">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center text-2xl border border-pink-200 shadow-sm">
                                        🎨
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-base">Alondra San Martín Hdz</h4>
                                        <p class="text-xs text-gray-500 font-medium">Desarrolladora Frontend</p>
                                    </div>
                                </div>
                                <div class="flex gap-2 opacity-60 group-hover:opacity-100 transition-opacity">
                                    <a href="#" class="text-gray-400 hover:text-slate-800 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path></svg>
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Developer Card: Andrey Garcia Bastian -->
                            <div class="bg-gray-50 hover:bg-gray-100 rounded-xl p-4 flex items-center justify-between border border-gray-200 transition-colors group">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center text-2xl border border-emerald-200 shadow-sm">
                                        👨‍💻
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-base">Andrey Garcia Bastian</h4>
                                        <p class="text-xs text-gray-500 font-medium">Desarrollador FullStack</p>
                                    </div>
                                </div>
                                <div class="flex gap-2 opacity-60 group-hover:opacity-100 transition-opacity">
                                    <a href="#" class="text-gray-400 hover:text-slate-800 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path></svg>
                                    </a>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <!-- Tab: Proyecto -->
                    <div x-show="activeTab === 'proyecto'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" style="display: none;">
                        <h4 class="text-lg font-bold text-slate-800 mb-3">Acerca del Sistema de Residencias</h4>
                        <p class="text-gray-600 text-sm leading-relaxed mb-4">
                            Esta plataforma fue desarrollada específicamente por y para la Universidad Tecnológica de Gutiérrez Zamora (UTGZ), con el fin de modernizar, agilizar y transparentar todo el proceso de Residencias Profesionales de nuestros estudiantes.
                        </p>
                        
                        <h5 class="font-bold text-slate-800 mb-3">Objetivos de la Plataforma</h5>
                        <ul class="space-y-3">
                            <li class="flex gap-2">
                                <span class="text-emerald-500 mt-1">•</span>
                                <span class="text-sm text-gray-600">Digitalizar la entrega, revisión y validación de documentos (Cartas de Presentación, Aceptación, Reportes).</span>
                            </li>
                            <li class="flex gap-2">
                                <span class="text-emerald-500 mt-1">•</span>
                                <span class="text-sm text-gray-600">Agilizar la comunicación síncrona y asíncrona (Chat y Videollamadas) entre asesores y residentes.</span>
                            </li>
                            <li class="flex gap-2">
                                <span class="text-emerald-500 mt-1">•</span>
                                <span class="text-sm text-gray-600">Automatizar el control del calendario de asesorías y el registro de bitácoras del cuatrimestre.</span>
                            </li>
                            <li class="flex gap-2">
                                <span class="text-emerald-500 mt-1">•</span>
                                <span class="text-sm text-gray-600">Centralizar la información para el área de Servicios Escolares y Coordinación de Carrera.</span>
                            </li>
                        </ul>
                    </div>
                    
                </div>
                
                <!-- Footer -->
                <div class="bg-white border-t border-gray-100 p-4 text-center">
                    <p class="text-xs text-gray-500">
                        &copy; {{ date('Y') }} UTGZ. Todos los derechos reservados.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
