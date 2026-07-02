<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-utgz-primary leading-tight">
            {{ __('Mi Progreso - Residencias') }}
        </h2>
    </x-slot>

    <!-- Timeline Progress -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-8 fade-in-up">
        <h3 class="text-lg font-semibold text-utgz-primary mb-6">Etapas del Proceso</h3>
        <div class="relative">
            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-200">
                <div style="width: 25%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-utgz-accent"></div>
            </div>
            <div class="flex justify-between text-xs font-medium text-gray-500">
                <span class="text-utgz-accent font-bold">Carta de presentación</span>
                <span>Reporte parcial</span>
                <span>Reporte final</span>
                <span>Evaluación</span>
            </div>
        </div>
    </div>

    <!-- Main Action Card -->
    <div class="bg-white rounded-xl shadow-sm p-8 text-center max-w-2xl mx-auto border-t-4 border-utgz-accent fade-in-up delay-100">
        <div class="w-20 h-20 mx-auto bg-blue-50 rounded-full flex items-center justify-center text-utgz-accent mb-4">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
        </div>
        <h3 class="text-2xl font-bold text-utgz-primary mb-2">Carta de Presentación</h3>
        <p class="text-gray-500 mb-6">Actualmente estás en la Etapa 1. Sube tu carta de presentación firmada para que tu asesor pueda revisarla y aprobarla.</p>
        
        <button class="bg-utgz-accent hover:bg-utgz-primary text-white font-medium py-2.5 px-6 rounded-md transition-colors shadow-sm">
            Subir Documento
        </button>
    </div>
</x-app-layout>
