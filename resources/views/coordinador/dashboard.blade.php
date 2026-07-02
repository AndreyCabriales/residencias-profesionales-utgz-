<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-utgz-primary leading-tight">
            {{ __('Dashboard Coordinador') }}
        </h2>
    </x-slot>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 flex items-center">
            <div class="w-12 h-12 rounded-full bg-utgz-bg flex items-center justify-center text-utgz-accent">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm font-medium">Total Alumnos</h3>
                <p class="text-2xl font-bold text-utgz-primary">3</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 flex items-center">
            <div class="w-12 h-12 rounded-full bg-utgz-bg flex items-center justify-center text-utgz-accent">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm font-medium">Asesores Activos</h3>
                <p class="text-2xl font-bold text-utgz-primary">2</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 flex items-center">
            <div class="w-12 h-12 rounded-full bg-orange-50 flex items-center justify-center text-utgz-warning">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm font-medium">Documentos Pendientes</h3>
                <p class="text-2xl font-bold text-utgz-primary">0</p>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-utgz-primary">Últimos Alumnos Registrados</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-utgz-primary text-white text-sm">
                        <th class="px-6 py-3 font-medium">Matrícula</th>
                        <th class="px-6 py-3 font-medium">Nombre</th>
                        <th class="px-6 py-3 font-medium">Asesor Asignado</th>
                        <th class="px-6 py-3 font-medium">Etapa Actual</th>
                        <th class="px-6 py-3 font-medium">Estado</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">UTGZ2841</td>
                        <td class="px-6 py-4 font-medium text-utgz-text">Alumno 1</td>
                        <td class="px-6 py-4 text-utgz-subtext">No asignado</td>
                        <td class="px-6 py-4">Carta de presentación</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium">Pendiente</span>
                        </td>
                    </tr>
                    <tr class="bg-gray-50 hover:bg-gray-100 transition-colors">
                        <td class="px-6 py-4">UTGZ9123</td>
                        <td class="px-6 py-4 font-medium text-utgz-text">Alumno 2</td>
                        <td class="px-6 py-4 text-utgz-subtext">No asignado</td>
                        <td class="px-6 py-4">Carta de presentación</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium">Pendiente</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
