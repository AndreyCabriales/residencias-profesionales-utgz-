<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-utgz-primary leading-tight">
            {{ __('Dashboard Coordinador') }}
        </h2>
    </x-slot>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 fade-in-up">
        <a href="{{ route('coordinador.alumnos.index') }}" class="block">
            <div class="bg-white rounded-xl shadow-sm p-6 flex items-center transition-transform hover:scale-105 border border-transparent hover:border-utgz-accent cursor-pointer">
                <div class="w-12 h-12 rounded-full bg-utgz-bg flex items-center justify-center text-utgz-accent">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm font-medium">Total Alumnos</h3>
                    <p class="text-2xl font-bold text-utgz-primary">{{ $totalAlumnos }}</p>
                </div>
            </div>
        </a>

        <a href="{{ route('coordinador.asesores.index') }}" class="block">
            <div class="bg-white rounded-xl shadow-sm p-6 flex items-center transition-transform hover:scale-105 border border-transparent hover:border-utgz-accent cursor-pointer">
                <div class="w-12 h-12 rounded-full bg-utgz-bg flex items-center justify-center text-utgz-accent">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm font-medium">Asesores Activos</h3>
                    <p class="text-2xl font-bold text-utgz-primary">{{ $totalAsesores }}</p>
                </div>
            </div>
        </a>

        <div class="bg-white rounded-xl shadow-sm p-6 flex items-center transition-transform hover:scale-105">
            <div class="w-12 h-12 rounded-full bg-orange-50 flex items-center justify-center text-utgz-warning">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm font-medium">Documentos Pendientes</h3>
                <p class="text-2xl font-bold text-utgz-primary">{{ $documentosPendientes }}</p>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden fade-in-up delay-100">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-utgz-primary">Últimos Alumnos Registrados</h3>
            <a href="{{ route('coordinador.alumnos.create') }}" class="text-sm font-medium text-utgz-accent hover:text-utgz-primary">
                + Nuevo Alumno
            </a>
        </div>
        
        @if(count($ultimosAlumnos) > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-sm border-b border-gray-200">
                        <th class="px-6 py-3 font-medium">Matrícula</th>
                        <th class="px-6 py-3 font-medium">Nombre</th>
                        <th class="px-6 py-3 font-medium">Asesor Asignado</th>
                        <th class="px-6 py-3 font-medium">Etapa Actual</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100">
                    @foreach($ultimosAlumnos as $alumno)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">{{ $alumno->matricula }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $alumno->user->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $alumno->asignacion->asesor->user->name ?? 'No asignado' }}</td>
                        <td class="px-6 py-4">Etapa {{ $alumno->etapa_id ?? '1' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="p-8 text-center text-gray-500">
            Aún no hay alumnos registrados. Comienza añadiendo uno.
        </div>
        @endif
    </div>
</x-app-layout>
