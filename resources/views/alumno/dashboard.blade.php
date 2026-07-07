<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-utgz-primary leading-tight">
            {{ __('Mi Progreso - Residencias') }}
        </h2>
    </x-slot>

    <!-- Timeline Progress (Oculto si está finalizada) -->
    @if($alumno->estado_residencia !== \App\Enums\ResidenciaEstado::Finalizada)
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8 fade-in-up" x-data="progresoDashboard()">
            <h3 class="text-lg font-semibold text-utgz-primary mb-6">Etapas del Proceso</h3>
            <div class="relative">
                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-200">
                    <div :style="`width: ${progreso.porcentaje}%`" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-utgz-accent transition-all duration-1000"></div>
                </div>
                <div class="flex justify-between text-xs font-medium text-gray-500">
                    <span :class="{ 'text-utgz-accent font-bold': progreso.fase_actual >= 1 }">Inicio</span>
                    <span :class="{ 'text-utgz-accent font-bold': progreso.fase_actual >= 2 }">Seguimiento</span>
                    <span :class="{ 'text-utgz-accent font-bold': progreso.fase_actual >= 3 }">Cierre</span>
                    <span :class="{ 'text-utgz-accent font-bold': progreso.fase_actual >= 4 }">Liberación</span>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('progresoDashboard', () => ({
                    progreso: {
                        fase_actual: 1,
                        porcentaje: 0,
                        documentos_aprobados: 0,
                        documentos_totales: 0,
                        etapas_disponibles: []
                    },
                    async init() {
                        try {
                            const res = await fetch('/api/v1/dashboard/progreso');
                            if (res.ok) {
                                this.progreso = await res.json();
                                // Dispatch event so the form can use the etapas
                                window.dispatchEvent(new CustomEvent('progreso-cargado', { detail: this.progreso }));
                            }
                        } catch (e) {
                            console.error("Error fetching progress:", e);
                        }
                    }
                }));
            });
        </script>
    @endif

    <!-- Header and Greeting -->
    <div class="mb-8 fade-in-up">
        <h2 class="text-2xl font-bold text-gray-800">Hola, {{ Auth::user()->name }} 👋</h2>
        @if($alumno->estado_residencia === \App\Enums\ResidenciaEstado::Finalizada)
            <p class="text-green-600 mt-1 font-semibold">¡Felicidades! Has concluido tu proceso de residencias profesionales.</p>
        @else
            <p class="text-gray-500 mt-1">Actualmente estás en: <span class="font-semibold text-utgz-primary">{{ $alumno->etapa->nombre ?? 'Sin etapa' }} ({{ $alumno->etapa->codigo ?? 'N/A' }})</span></p>
        @endif
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-10 fade-in-up delay-100">
        <!-- Estado -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-lg shadow-gray-200/40 hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 group">
            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3 group-hover:text-emerald-500 transition-colors">Estado Actual</h4>
            @if($alumno->estado_residencia === \App\Enums\ResidenciaEstado::Finalizada)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    Finalizado
                </span>
            @elseif($tienePendiente)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                    En revisión
                </span>
            @elseif(count($documentos) > 0 && $documentos->first()->estado === \App\Enums\DocumentoEstado::Aprobado)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                    Aprobado
                </span>
            @elseif(count($documentos) > 0 && $documentos->first()->estado === \App\Enums\DocumentoEstado::Rechazado)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                    Corrección
                </span>
            @else
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                    Pendiente
                </span>
            @endif
        </div>

        <!-- Asesor Académico -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-lg shadow-gray-200/40 hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 group">
            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 group-hover:text-emerald-500 transition-colors">Académico</h4>
            <p class="font-bold text-slate-800 text-lg truncate" title="{{ $alumno->asignacion->asesor->user->name ?? 'No asignado' }}">{{ $alumno->asignacion->asesor->user->name ?? 'No asignado' }}</p>
        </div>

        <!-- Asesor Organizacional -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-lg shadow-gray-200/40 hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 group">
            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 group-hover:text-emerald-500 transition-colors">Organizacional</h4>
            <p class="font-bold text-slate-800 text-lg truncate" title="{{ $alumno->companyAdvisor->nombre ?? 'Pendiente' }}">{{ $alumno->companyAdvisor->nombre ?? 'Pendiente' }}</p>
        </div>

        <!-- Asesorías -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-lg shadow-gray-200/40 hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 relative group">
            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 group-hover:text-emerald-500 transition-colors">Asesorías</h4>
            <p class="font-bold text-slate-800 text-lg truncate">
                @if(isset($asesoriasPendientes) && $asesoriasPendientes->count() > 0)
                    <span class="text-amber-600">{{ $asesoriasPendientes->count() }} por confirmar</span>
                    <span class="absolute top-6 right-6 flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
                    </span>
                @else
                    Al día
                @endif
            </p>
        </div>

        <!-- Última Actualización -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-lg shadow-gray-200/40 hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 group">
            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 group-hover:text-emerald-500 transition-colors">Actualización</h4>
            <p class="font-bold text-slate-800 text-lg">
                @if(count($documentos) > 0)
                    {{ $documentos->first()->updated_at->diffForHumans() }}
                @else
                    Sin actividad
                @endif
            </p>
        </div>
    </div>

    <!-- Main Action Card -->
    <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 p-8 md:p-10 text-center max-w-3xl mx-auto border-t-4 border-utgz-accent fade-in-up delay-200 relative overflow-hidden">
        <!-- Abstract Decoration for the main card -->
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>
        
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
        
        @if($alumno->estado_residencia === \App\Enums\ResidenciaEstado::Finalizada)
            <div class="mb-6 p-8 bg-green-50 border border-green-200 rounded-xl text-center">
                <svg class="h-16 w-16 text-green-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="text-2xl font-bold text-green-800 mb-2">¡Proceso Concluido!</h3>
                <p class="text-green-700">Tu residencia profesional ha finalizado satisfactoriamente.</p>
                <p class="text-green-600 mt-2 text-sm font-medium">Fecha de liberación: {{ $alumno->fecha_finalizacion->format('d/m/Y H:i') }}</p>
            </div>
        @else
            @if(!$alumno->asignacion || !$alumno->asignacion->asesor_id)
                <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-lg text-left">
                    <div class="flex items-start">
                        <svg class="h-6 w-6 text-amber-600 mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="text-amber-800 font-bold">Asesor en proceso de asignación</p>
                            <p class="text-amber-700 mt-1 text-sm">Tu asesor académico está siendo asignado por el Coordinador. Mientras tanto puedes continuar subiendo y gestionando tus documentos con normalidad. Una vez asignado el nuevo asesor, tus documentos aparecerán automáticamente para su revisión.</p>
                        </div>
                    </div>
                </div>
            @endif

            @if($tienePendiente)
                <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg text-left">
                    <div class="flex items-start">
                        <svg class="h-6 w-6 text-yellow-600 mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="text-yellow-800 font-bold">Documento en revisión</p>
                            <p class="text-yellow-700 mt-1 text-sm">Por favor espera a que tu asesor académico califique tu envío actual. Recibirás una notificación cuando esto suceda.</p>
                        </div>
                    </div>
                </div>
            @else
                @if(count($documentos) > 0 && $documentos->first()->estado === \App\Enums\DocumentoEstado::Rechazado)
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-left">
                        <div class="flex items-start">
                            <svg class="h-6 w-6 text-red-600 mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-red-800 font-bold">Documento Rechazado</p>
                                <p class="text-red-700 mt-1 text-sm">Tu asesor ha solicitado correcciones. Por favor atiende la siguiente observación antes de volver a subir tu documento:</p>
                                <div class="mt-3 p-3 bg-white rounded border border-red-100 text-red-800 text-sm font-medium">
                                    "{{ $documentos->first()->retroalimentacion }}"
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(isset($asesoriasPendientes) && $asesoriasPendientes->count() > 0)
                    <div class="mb-6 p-4 bg-orange-50 border border-orange-200 rounded-lg text-left">
                        <div class="flex items-start">
                            <svg class="h-6 w-6 text-orange-600 mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <p class="text-orange-800 font-bold">Tienes Asesorías Pendientes de Confirmar</p>
                                <p class="text-orange-700 mt-1 text-sm">Tu asesor te ha agendado una o más asesorías. Por favor ingresa al calendario para confirmarlas o solicitar reprogramación.</p>
                                <div class="mt-3">
                                    <a href="{{ route('calendario.index') }}" class="inline-block px-4 py-2 bg-white text-orange-600 border border-orange-300 rounded hover:bg-orange-100 text-sm font-semibold transition-colors">
                                        Ir al Calendario
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="text-left mb-6">
                    <h3 class="text-lg font-bold text-utgz-primary">Subir Documento</h3>
                    <p class="text-gray-500 text-sm mt-1">Sube tu formato correspondiente a la etapa actual en formato PDF.</p>
                </div>
                
                <form x-data="{ uploading: false }" x-on:submit="uploading = true" action="{{ route('alumno.documentos.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-5 text-left">
                    @csrf
                    
                    @if($alumno->etapa && $alumno->etapa->codigo === 'FOR-06-12')
                        <!-- Datos del Asesor Organizacional -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 space-y-4 mb-2" x-data="geocodingComponent()">
                            <h4 class="font-semibold text-gray-700 text-sm uppercase tracking-wide">Datos de la Empresa y Asesor Organizacional</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="col-span-1 md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="company_empresa">Empresa <span class="text-red-500">*</span></label>
                                    <div class="flex gap-2">
                                        <input type="text" id="company_empresa" x-model="empresa" name="company_empresa" value="{{ old('company_empresa', $alumno->companyAdvisor->empresa ?? '') }}" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-utgz-accent focus:border-utgz-accent sm:text-sm">
                                        <button type="button" @click="buscarUbicacion()" :disabled="cargando || !empresa" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50">
                                            <span x-show="!cargando">Ver Ubicación</span>
                                            <span x-show="cargando" class="flex items-center" style="display: none;">
                                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                Buscando...
                                            </span>
                                        </button>
                                    </div>
                                    <!-- Resultado de API Externa -->
                                    <div x-show="resultado" x-transition class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-md text-sm text-blue-800" style="display: none;">
                                        <div class="flex items-start gap-2">
                                            <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            <div>
                                                <p class="font-bold">Ubicación encontrada mediante Nominatim API (OpenStreetMap):</p>
                                                <p x-text="resultado.display_name" class="mt-1 text-xs text-blue-700"></p>
                                                
                                                <div class="mt-3 w-full h-48 bg-gray-200 rounded-md overflow-hidden border border-blue-200 shadow-inner">
                                                    <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" 
                                                        :src="`https://www.openstreetmap.org/export/embed.html?bbox=${parseFloat(resultado.lon)-0.005}%2C${parseFloat(resultado.lat)-0.005}%2C${parseFloat(resultado.lon)+0.005}%2C${parseFloat(resultado.lat)+0.005}&layer=mapnik&marker=${resultado.lat}%2C${resultado.lon}`">
                                                    </iframe>
                                                </div>
                                                <div class="mt-2 text-right">
                                                    <a :href="`https://www.openstreetmap.org/?mlat=${resultado.lat}&mlon=${resultado.lon}#map=17/${resultado.lat}/${resultado.lon}`" target="_blank" class="text-xs font-semibold text-blue-600 hover:text-blue-800 hover:underline flex items-center justify-end gap-1">
                                                        Abrir mapa completo
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div x-show="errorMsg" x-transition class="mt-2 p-3 bg-red-50 border border-red-200 rounded-md text-sm text-red-800" style="display: none;" x-text="errorMsg"></div>
                                </div>
                                <div class="col-span-1 md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="nombre_proyecto">Nombre del Proyecto <span class="text-red-500">*</span></label>
                                    <input type="text" id="nombre_proyecto" name="nombre_proyecto" value="{{ old('nombre_proyecto', $alumno->nombre_proyecto ?? '') }}" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-utgz-accent focus:border-utgz-accent sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="company_nombre">Nombre del Asesor <span class="text-red-500">*</span></label>
                                    <input type="text" id="company_nombre" name="company_nombre" value="{{ old('company_nombre', $alumno->companyAdvisor->nombre ?? '') }}" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-utgz-accent focus:border-utgz-accent sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="company_puesto">Puesto del Asesor <span class="text-red-500">*</span></label>
                                    <input type="text" id="company_puesto" name="company_puesto" value="{{ old('company_puesto', $alumno->companyAdvisor->puesto ?? '') }}" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-utgz-accent focus:border-utgz-accent sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="company_telefono">Teléfono (Opcional)</label>
                                    <input type="text" id="company_telefono" name="company_telefono" value="{{ old('company_telefono', $alumno->companyAdvisor->telefono ?? '') }}" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-utgz-accent focus:border-utgz-accent sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Script para consumir API Externa y API Propia usando Fetch/Asincronía -->
                        <script>
                            document.addEventListener('alpine:init', () => {
                                Alpine.data('geocodingComponent', () => ({
                                    empresa: '{{ old('company_empresa', $alumno->companyAdvisor->empresa ?? '') }}',
                                    cargando: false,
                                    resultado: null,
                                    errorMsg: null,
                                    
                                    async buscarUbicacion() {
                                        if (!this.empresa) return;
                                        
                                        this.cargando = true;
                                        this.resultado = null;
                                        this.errorMsg = null;
                                        
                                        try {
                                            // 1. Consumir API Externa (OpenStreetMap/Nominatim)
                                            const nominatimUrl = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(this.empresa)}&format=json&limit=1`;
                                            const responseExterna = await fetch(nominatimUrl, {
                                                headers: { 'Accept-Language': 'es' }
                                            });
                                            
                                            if (!responseExterna.ok) throw new Error('Error en la API externa');
                                            const dataExterna = await responseExterna.json();
                                            
                                            if (dataExterna.length > 0) {
                                                this.resultado = dataExterna[0];
                                            } else {
                                                this.errorMsg = 'No se encontró la ubicación de la empresa especificada.';
                                            }

                                            // 2. Consumir API Propia simultáneamente para demostrar integración REST
                                            // Registramos que la búsqueda se realizó mediante una API propia (ejemplo de stats)
                                            const apiPropiaUrl = '/api/alumnos/stats';
                                            const responsePropia = await fetch(apiPropiaUrl);
                                            const dataPropia = await responsePropia.json();
                                            console.log('Estadísticas de la API propia obtenidas asíncronamente:', dataPropia);
                                            
                                        } catch (error) {
                                            console.error('Error fetching APIs:', error);
                                            this.errorMsg = 'Hubo un error de red al consultar los servicios externos.';
                                        } finally {
                                            this.cargando = false;
                                        }
                                    }
                                }));
                            });
                        </script>
                    @endif
                    
                    <!-- Select para Etapa -->
                    <div x-data="{ etapas: [] }" @progreso-cargado.window="etapas = $event.detail.etapas_disponibles">
                        <label class="block mb-2 text-sm font-medium text-gray-900" for="etapa_id">Documento a subir <span class="text-red-500">*</span></label>
                        <select id="etapa_id" name="etapa_id" required class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-utgz-accent focus:border-utgz-accent mb-4">
                            <option value="">Selecciona un documento</option>
                            <template x-for="etapa in etapas" :key="etapa.id">
                                <option :value="etapa.id" x-text="etapa.nombre + ' (' + etapa.codigo + ')'"></option>
                            </template>
                        </select>
                        
                        <label class="block mb-2 text-sm font-medium text-gray-900" for="documento">Seleccionar PDF (Máx 5MB) <span class="text-red-500">*</span></label>
                        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-utgz-primary file:text-white hover:file:bg-utgz-primary/90 transition-colors" id="documento" name="documento" type="file" accept=".pdf" required>
                    </div>

                    <div class="flex justify-end mt-2">
                        <button type="submit" x-bind:disabled="uploading" class="bg-utgz-accent hover:bg-utgz-primary hover:-translate-y-1 hover:shadow-md transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed text-white font-medium py-2 px-6 rounded-md shadow-sm flex items-center justify-center">
                            <span x-show="!uploading">Enviar Documento</span>
                            <span x-show="uploading" class="flex items-center gap-2" style="display: none;">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Enviando...
                            </span>
                        </button>
                    </div>
                </form>
            @endif
        @endif

        @if(count($documentos) > 0)
        <div class="mt-8 text-left border-t border-gray-100 pt-6">
            <h4 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Historial de entregas
            </h4>
            <ul class="space-y-4 text-sm">
                @foreach($documentos as $doc)
                <li class="p-4 bg-gray-50 rounded-lg border border-gray-100 transition-all duration-200 hover:shadow-sm">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <span class="font-medium text-gray-800">{{ $doc->created_at->format('d/m/Y H:i') }}</span>
                            <span class="text-xs text-gray-500">({{ $doc->created_at->diffForHumans() }})</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-{{ $doc->estado->color() }}-100 text-{{ $doc->estado->color() }}-800">
                                {{ $doc->estado->label() }}
                            </span>
                            
                            <!-- El botón de cancelar ha sido eliminado del nuevo flujo -->
                        </div>
                    </div>
                    @if($doc->retroalimentacion)
                    <div class="mt-3 p-3 bg-white border border-gray-100 rounded text-gray-600 italic text-xs">
                        <span class="font-semibold block text-gray-700 mb-1">Retroalimentación del asesor:</span>
                        "{{ $doc->retroalimentacion }}"
                    </div>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</x-app-layout>
