<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-utgz-primary leading-tight">
            {{ __('Dashboard Coordinador') }}
        </h2>
    </x-slot>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 fade-in-up">
        <a href="{{ route('coordinador.alumnos.index') }}" class="block">
            <div class="bg-white rounded-xl shadow-sm p-6 flex items-center transition-all duration-200 hover:-translate-y-1 hover:shadow-md border border-transparent hover:border-utgz-accent cursor-pointer">
                <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm font-medium">Alumnos Registrados</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalAlumnos }}</p>
                </div>
            </div>
        </a>

        <a href="{{ route('coordinador.asesores.index') }}" class="block">
            <div class="bg-white rounded-xl shadow-sm p-6 flex items-center transition-all duration-200 hover:-translate-y-1 hover:shadow-md border border-transparent hover:border-utgz-accent cursor-pointer">
                <div class="w-12 h-12 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm font-medium">Asesores Activos</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalAsesores }}</p>
                </div>
            </div>
        </a>

        <div class="bg-white rounded-xl shadow-sm p-6 flex items-center transition-all duration-200 hover:-translate-y-1 hover:shadow-md">
            <div class="w-12 h-12 rounded-full bg-orange-50 flex items-center justify-center text-utgz-warning">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm font-medium">Doc. Pendientes (Total)</h3>
                <p class="text-2xl font-bold text-gray-800">{{ $documentosPendientes }}</p>
            </div>
        </div>
    </div>

    <!-- Layout Dividido: Gráfica y Actividad -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 fade-in-up delay-100">
        
        <!-- Columna de Gráfica -->
        <div class="lg:col-span-1 bg-white rounded-xl shadow-sm overflow-hidden p-6 border border-gray-100">
            <h3 class="text-lg font-semibold text-utgz-primary mb-4">Estado Global de Documentos</h3>
            <div class="relative w-full aspect-square flex items-center justify-center">
                @if($documentosPendientes == 0 && $documentosAprobados == 0 && $documentosRechazados == 0)
                    <div class="text-center text-gray-400">
                        <svg class="w-16 h-16 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        <p class="text-sm">Sin datos para graficar</p>
                    </div>
                @else
                    <canvas id="documentStatusChart"></canvas>
                @endif
            </div>
        </div>

        <!-- Columna de Actividad Reciente -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 flex flex-col">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-lg font-semibold text-utgz-primary flex items-center gap-2">
                    <svg class="w-5 h-5 text-utgz-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Actividad Reciente
                </h3>
            </div>
            
            <div class="p-6 flex-1 overflow-y-auto max-h-[400px]">
                @if(count($actividadReciente) > 0)
                    <div class="relative border-l-2 border-gray-200 ml-3 space-y-8">
                        @foreach($actividadReciente as $actividad)
                            <div class="relative pl-6">
                                <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-utgz-accent ring-4 ring-white"></div>
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100 transition-all duration-200 hover:shadow-md hover:-translate-y-0.5">
                                    <div class="flex justify-between items-start mb-1">
                                        <h4 class="font-semibold text-gray-800">{{ $actividad->titulo }}</h4>
                                        <span class="text-xs font-medium text-gray-400 bg-white px-2 py-1 rounded-full border border-gray-200">{{ $actividad->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">{{ $actividad->mensaje }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="h-full flex flex-col items-center justify-center text-gray-500 py-8">
                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        <p>No hay actividad reciente en el sistema.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Cargar Chart.js -->
    @if($documentosPendientes > 0 || $documentosAprobados > 0 || $documentosRechazados > 0)
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('documentStatusChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Pendientes', 'Aprobados', 'Rechazados'],
                    datasets: [{
                        data: [
                            {{ $documentosPendientes }}, 
                            {{ $documentosAprobados }}, 
                            {{ $documentosRechazados }}
                        ],
                        backgroundColor: [
                            '#FCD34D', // yellow-300
                            '#34D399', // green-400
                            '#F87171'  // red-400
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                font: {
                                    family: "'Inter', sans-serif",
                                    size: 13
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endif
</x-app-layout>
