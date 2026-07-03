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
    </div>

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
</x-app-layout>
