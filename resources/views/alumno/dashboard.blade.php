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
        
        @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative text-sm" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative text-sm" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative text-sm text-left">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="w-20 h-20 mx-auto bg-blue-50 rounded-full flex items-center justify-center text-utgz-accent mb-4">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
        </div>
        <h3 class="text-2xl font-bold text-utgz-primary mb-2">Etapa {{ $alumno->etapa_id ?? '1' }}</h3>
        <p class="text-gray-500 mb-6">Sube tu documento correspondiente a la etapa actual en formato PDF para que tu asesor pueda revisarlo y aprobarlo.</p>
        
        <form action="{{ route('alumno.documentos.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center gap-4">
            @csrf
            
            <div class="w-full max-w-sm">
                <label class="block mb-2 text-sm font-medium text-gray-900" for="documento">Seleccionar PDF (Máx 5MB)</label>
                <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold file:bg-utgz-bg file:text-utgz-primary hover:file:bg-gray-200 transition-colors" aria-describedby="documento_help" id="documento" name="documento" type="file" accept=".pdf" required>
            </div>

            <button type="submit" class="bg-utgz-accent hover:bg-utgz-primary text-white font-medium py-2.5 px-6 rounded-md transition-colors shadow-sm">
                Subir Documento
            </button>
        </form>

        @if(count($documentos) > 0)
        <div class="mt-8 text-left border-t border-gray-100 pt-6">
            <h4 class="font-semibold text-gray-700 mb-3">Historial de esta etapa:</h4>
            <ul class="space-y-3 text-sm">
                @foreach($documentos as $doc)
                <li class="flex items-center justify-between p-3 bg-gray-50 rounded-md border border-gray-100">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path></svg>
                        <span class="font-medium text-gray-700">{{ $doc->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-{{ $doc->estado->color() }}-100 text-{{ $doc->estado->color() }}-800">
                            {{ $doc->estado->label() }}
                        </span>
                    </div>
                </li>
                @if($doc->retroalimentacion)
                <p class="text-xs text-gray-500 mt-1 italic pl-11">"{{ $doc->retroalimentacion }}"</p>
                @endif
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</x-app-layout>
