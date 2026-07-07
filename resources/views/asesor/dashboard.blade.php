<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-utgz-primary leading-tight">
            {{ __('Dashboard Asesor') }}
        </h2>
    </x-slot>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 fade-in-up">
        <div class="bg-white rounded-xl shadow-sm p-6 flex items-center transition-transform hover:scale-105">
            <div class="w-12 h-12 rounded-full bg-utgz-bg flex items-center justify-center text-utgz-accent">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm font-medium">Mis Alumnos Asignados</h3>
                <p class="text-2xl font-bold text-utgz-primary">{{ $totalAlumnosAsignados ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 flex items-center transition-transform hover:scale-105">
            <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-utgz-accent">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm font-medium">Documentos por Revisar</h3>
                <p class="text-2xl font-bold text-utgz-primary">{{ $totalDocumentosPorRevisar ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 flex items-center transition-transform hover:scale-105">
            <div class="w-12 h-12 rounded-full bg-orange-50 flex items-center justify-center text-orange-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm font-medium">Asesorías Pendientes</h3>
                <p class="text-2xl font-bold text-utgz-primary">{{ $totalAsesoriasPendientes ?? 0 }}</p>
            </div>
        </div>
    </div>

    @if(isset($asesoriasPendientes) && $totalAsesoriasPendientes > 0)
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8 fade-in-up delay-75">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-orange-600 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Asesorías Pendientes de Confirmación
            </h3>
            <a href="{{ route('calendario.index') }}" class="text-sm font-medium text-utgz-accent hover:underline">Ver Calendario →</a>
        </div>
        <div class="divide-y divide-gray-100">
            @foreach($asesoriasPendientes as $ase)
            <div class="p-6 hover:bg-orange-50/30 transition-colors flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h4 class="font-bold text-gray-800">{{ $ase->titulo }}</h4>
                    <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Alumno: <span class="font-medium text-gray-700">{{ $ase->alumno->user->name ?? 'Desconocido' }}</span>
                    </p>
                    <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Fecha: <span class="font-medium text-gray-700">{{ $ase->fecha_hora->format('d/m/Y h:i A') }} ({{ $ase->duracion }} min)</span>
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('calendario.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        Ir al Calendario
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden fade-in-up delay-100">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-utgz-primary">Documentos Pendientes de Revisión</h3>
        </div>
        
        @if(session('success'))
            <div class="m-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative text-sm" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="m-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative text-sm" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="m-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative text-sm" role="alert">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(isset($documentosPendientes) && count($documentosPendientes) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-sm border-b border-gray-200">
                            <th class="px-6 py-3 font-medium">Alumno</th>
                            <th class="px-6 py-3 font-medium">Etapa</th>
                            <th class="px-6 py-3 font-medium">Fecha de Envío</th>
                            <th class="px-6 py-3 font-medium text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100">
                        @foreach($documentosPendientes as $doc)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $doc->alumno->user->name ?? 'Alumno Desconocido' }}</td>
                            <td class="px-6 py-4 text-gray-600">Etapa {{ $doc->etapa_id }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $doc->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 text-right flex justify-end gap-2">
                                <!-- Botón Descargar -->
                                <a href="{{ route('asesor.documentos.descargar', $doc->id) }}" target="_blank" class="px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-md font-medium transition-colors text-xs inline-flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Ver PDF
                                </a>
                                
                                <!-- Formulario Aprobar -->
                                <form action="{{ route('asesor.documentos.revisar', $doc->id) }}" method="POST" class="inline confirm-action" data-confirm-title="¿Aprobar documento?" data-confirm-text="El documento será aprobado y el alumno avanzará a la siguiente etapa." data-confirm-button-text="Sí, aprobar" data-confirm-button-color="#10B981" data-confirm-icon="success">
                                    @csrf
                                    <input type="hidden" name="accion" value="aprobar">
                                    <button type="submit" class="px-3 py-1.5 bg-green-50 text-green-600 hover:bg-green-100 rounded-md font-medium transition-colors text-xs inline-flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Aprobar
                                    </button>
                                </form>

                                <!-- Botón Rechazar (Abre modal SweetAlert2) -->
                                <form action="{{ route('asesor.documentos.revisar', $doc->id) }}" method="POST" class="inline reject-action">
                                    @csrf
                                    <input type="hidden" name="accion" value="rechazar">
                                    <!-- Retroalimentación llenada por SweetAlert2 -->
                                    <input type="hidden" name="retroalimentacion" value="">
                                    <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-md font-medium transition-colors text-xs inline-flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        Rechazar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-8 text-center text-gray-500">
                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <p class="text-lg">No tienes documentos pendientes por revisar en este momento.</p>
                <p class="text-sm mt-1">Cuando tus alumnos suban sus reportes, aparecerán aquí.</p>
            </div>
        @endif
    </div>
    <!-- Table: Mis Alumnos Asignados -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden fade-in-up delay-200 mt-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-utgz-primary">Mis Alumnos Asignados</h3>
        </div>
        @if(isset($alumnosAsignadosList) && count($alumnosAsignadosList) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse" x-data="{ finalizarSeguimiento(id) { 
                    if(confirm('¿Estás seguro de finalizar el seguimiento (Fase 2) de este alumno?')) {
                        fetch('/api/v1/dashboard/finalizar-seguimiento', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ alumno_id: id })
                        }).then(res => res.json()).then(data => {
                            if(data.error) alert(data.error);
                            else { alert(data.message); window.location.reload(); }
                        });
                    }
                } }">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-sm border-b border-gray-200">
                            <th class="px-6 py-3 font-medium">Alumno</th>
                            <th class="px-6 py-3 font-medium">Matrícula</th>
                            <th class="px-6 py-3 font-medium">Estado</th>
                            <th class="px-6 py-3 font-medium text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100">
                        @foreach($alumnosAsignadosList as $alumnoList)
                        @php
                            $faseActual = app(\App\Services\ProcesoEstadiaService::class)->getFaseActual($alumnoList);
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $alumnoList->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $alumnoList->matricula ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-gray-600">
                                @if($alumnoList->estado_residencia === \App\Enums\ResidenciaEstado::Finalizada)
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Finalizada</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Fase {{ $faseActual }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($faseActual === 2 && !$alumnoList->seguimiento_finalizado)
                                    <button @click="finalizarSeguimiento({{ $alumnoList->id }})" class="px-3 py-1.5 bg-utgz-accent text-white hover:bg-utgz-primary rounded-md font-medium transition-colors text-xs inline-flex items-center">
                                        Finalizar Seguimiento
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-8 text-center text-gray-500">
                <p class="text-lg">No tienes alumnos asignados actualmente.</p>
            </div>
        @endif
    </div>
</x-app-layout>
