<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            {{ __('Calendario de Asesorías') }}
        </h2>
    </x-slot>

    <!-- Cargamos el script de JS específico para el calendario -->
    @push('scripts')
        <script>
            window.calendarEventsUrl = '{{ route("api.v1.calendario.index") }}';
        </script>
        @vite(['resources/js/calendario.js'])
        <style>
            /* Customizing FullCalendar with Premium Modern Aesthetics */
            #calendario-container {
                font-family: 'Inter', sans-serif;
            }
            .fc {
                --fc-border-color: rgba(203, 213, 224, 0.4);
                --fc-button-bg-color: #10B981; /* Emerald 500 */
                --fc-button-border-color: #10B981;
                --fc-button-hover-bg-color: #059669; /* Emerald 600 */
                --fc-button-hover-border-color: #059669;
                --fc-button-active-bg-color: #047857; /* Emerald 700 */
                --fc-button-active-border-color: #047857;
                --fc-today-bg-color: rgba(16, 185, 129, 0.05);
                --fc-event-bg-color: #10B981;
                --fc-event-border-color: #10B981;
                --fc-page-bg-color: transparent;
                --fc-neutral-bg-color: rgba(243, 244, 246, 0.8);
            }
            
            /* Dark Mode Overrides */
            .dark .fc {
                --fc-border-color: rgba(55, 65, 81, 0.6);
                --fc-neutral-bg-color: rgba(17, 24, 39, 0.5);
                --fc-today-bg-color: rgba(16, 185, 129, 0.1);
                color: #f3f4f6;
            }

            /* Table Borders */
            .fc-theme-standard td, .fc-theme-standard th {
                border-color: var(--fc-border-color);
            }
            
            /* Headers (Mon, Tue, etc.) */
            .fc-col-header-cell-cushion {
                text-transform: uppercase;
                font-size: 0.75rem;
                letter-spacing: 0.05em;
                font-weight: 700;
                padding: 16px 8px !important;
                color: #94a3b8; /* Tailwind slate-400 */
            }
            .dark .fc-col-header-cell-cushion {
                color: #9ca3af;
            }

            /* Buttons */
            .fc .fc-button-primary {
                background: linear-gradient(135deg, #059669, #10B981); /* Emerald gradient */
                box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3), 0 2px 4px -1px rgba(16, 185, 129, 0.2);
                border: none;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                border-radius: 0.75rem; /* rounded-xl */
                padding: 0.6rem 1.2rem;
                font-weight: 600;
                text-transform: capitalize;
                letter-spacing: 0.025em;
            }
            .fc .fc-button-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.4), 0 4px 6px -2px rgba(16, 185, 129, 0.2);
            }
            .fc .fc-button-primary:active {
                transform: translateY(0);
            }
            .fc .fc-button-primary:not(:disabled).fc-button-active {
                background: linear-gradient(135deg, #047857, #059669);
            }

            /* Toolbar Title */
            .fc .fc-toolbar-title {
                font-size: 1.75rem;
                font-weight: 800;
                letter-spacing: -0.025em;
                text-transform: capitalize;
                color: #111827; /* Tailwind gray-900 */
                transition: color 0.3s ease;
            }
            .dark .fc .fc-toolbar-title {
                color: #f9fafb; /* Tailwind gray-50 */
            }

            /* Events */
            .fc-event {
                border-radius: 0.5rem;
                box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.05);
                border: none;
                padding: 3px 6px;
                margin: 1px 2px;
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
                cursor: pointer;
            }
            .fc-event:hover {
                transform: scale(1.03) translateY(-1px);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                z-index: 5;
            }
            
            /* Day Cells */
            .fc-daygrid-day {
                transition: background-color 0.2s ease;
            }
            .fc-daygrid-day:hover {
                background-color: rgba(243, 244, 246, 0.6);
            }
            .dark .fc-daygrid-day:hover {
                background-color: rgba(31, 41, 55, 0.6);
            }
            
            /* Today Cell */
            .fc-day-today {
                background: linear-gradient(135deg, rgba(79, 70, 229, 0.08) 0%, rgba(59, 130, 246, 0.08) 100%) !important;
            }
            .dark .fc-day-today {
                background: linear-gradient(135deg, rgba(79, 70, 229, 0.15) 0%, rgba(59, 130, 246, 0.15) 100%) !important;
            }
            
            /* Day numbers */
            .fc-daygrid-day-number {
                padding: 8px 12px !important;
                font-weight: 500;
            }
        </style>
    @endpush

    <div class="py-12" x-data="calendarModal()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Clean White Card Container -->
            <div class="bg-white overflow-hidden shadow-xl shadow-gray-200/40 sm:rounded-2xl border border-gray-100 p-8 relative fade-in-up">
                <div class="relative z-10" id="calendario-container"></div>
            </div>
            
        </div>

        <!-- Event Detail Modal (Alpine.js) -->
        <div x-show="showEventModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;" 
             aria-labelledby="modal-title" role="dialog" aria-modal="true">
             
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                
                <!-- Background overlay -->
                <div x-show="showEventModal" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" 
                     aria-hidden="true" 
                     @click="closeModal()"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal Panel -->
                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 ">
                    
                    <!-- Decorative header line -->
                    <div class="h-2 w-full" :style="`background-color: ${currentEvent.color || '#4f46e5'}`"></div>
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10"
                                 :class="getStatusBgClass(currentEvent.estado)">
                                <svg class="h-6 w-6" :class="getStatusIconClass(currentEvent.estado)" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-xl leading-6 font-bold text-gray-900 " id="modal-title" x-text="currentEvent.title"></h3>
                                
                                <div class="mt-4 space-y-3">
                                    <!-- Date and Time -->
                                    <div class="flex items-center text-sm text-gray-600 ">
                                        <svg class="mr-2 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span x-text="formatDate(currentEvent.start)"></span>
                                    </div>

                                    <!-- Modality and link -->
                                    <template x-if="currentEvent.modalidad === 'virtual'">
                                        <div class="flex items-center text-sm text-gray-600 ">
                                            <svg class="mr-2 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                            <span class="font-medium mr-2">Enlace Jitsi:</span>
                                            <a :href="currentEvent.enlace" 
                                               target="_blank" 
                                               class="text-indigo-600 hover:underline break-all"
                                               x-text="currentEvent.enlace"></a>
                                        </div>
                                    </template>
                                    
                                    <template x-if="currentEvent.modalidad === 'presencial'">
                                        <div class="flex items-center text-sm text-gray-600 ">
                                            <svg class="mr-2 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            <span class="font-medium mr-2">Presencial</span>
                                        </div>
                                    </template>

                                    <!-- Status badge -->
                                    <div class="flex items-center mt-2">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full"
                                              :class="getBadgeClass(currentEvent.estado)"
                                              x-text="currentEvent.estado ? currentEvent.estado.toUpperCase() : ''">
                                        </span>
                                    </div>
                                    
                                    <!-- Personas -->
                                    <template x-if="currentEvent.asesor || currentEvent.alumno">
                                        <div class="mt-4 bg-white p-3 rounded-lg border border-gray-200 ">
                                            <template x-if="currentEvent.asesor">
                                                <div class="flex items-center text-sm text-gray-700 mb-1">
                                                    <span class="font-bold w-16">Asesor:</span>
                                                    <span x-text="currentEvent.asesor"></span>
                                                </div>
                                            </template>
                                            <template x-if="currentEvent.alumno">
                                                <div class="flex items-center text-sm text-gray-700 ">
                                                    <span class="font-bold w-16">Alumno:</span>
                                                    <span x-text="currentEvent.alumno"></span>
                                                </div>
                                            </template>
                                        </div>
                                    </template>
                                    
                                    <!-- Observation (if any) -->
                                    <template x-if="currentEvent.observaciones">
                                        <div class="mt-4 bg-gray-50 p-3 rounded-lg border border-gray-100 ">
                                            <h4 class="text-sm font-semibold text-gray-700 mb-1">Observaciones:</h4>
                                            <p class="text-sm text-gray-600 " x-text="currentEvent.observaciones"></p>
                                        </div>
                                    </template>

                                    <!-- Interactive Tabs (Timeline & Chat) - Only for Asesorias -->
                                    <template x-if="currentEvent.tipo === 'Asesoria'">
                                        <div class="mt-6 border-t border-gray-200 pt-4" x-data="{ activeTab: 'chat' }">
                                            
                                            <!-- Loading State -->
                                            <div x-show="isLoadingDetails" class="flex justify-center py-4">
                                                <svg class="animate-spin h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </div>

                                            <div x-show="!isLoadingDetails">
                                                <!-- Tabs Navigation -->
                                                <div class="flex space-x-4 border-b border-gray-200 mb-4">
                                                    <button @click="activeTab = 'chat'" 
                                                            :class="activeTab === 'chat' ? 'border-indigo-500 text-indigo-600 ' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                                            class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors flex items-center gap-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                                        Chat Académico
                                                    </button>
                                                    <button @click="activeTab = 'timeline'"
                                                            :class="activeTab === 'timeline' ? 'border-indigo-500 text-indigo-600 ' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                                            class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors flex items-center gap-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                        Línea de Tiempo
                                                    </button>
                                                </div>

                                                <!-- Chat Tab -->
                                                <div x-show="activeTab === 'chat'" class="space-y-4">
                                                    <div class="max-h-48 overflow-y-auto space-y-3 pr-2 scrollbar-thin scrollbar-thumb-gray-300">
                                                        <template x-if="comentarios.length === 0">
                                                            <p class="text-sm text-gray-500 text-center py-2">No hay comentarios aún.</p>
                                                        </template>
                                                        <template x-for="comentario in comentarios" :key="comentario.id">
                                                            <div class="bg-gray-50 rounded-lg p-3 relative">
                                                                <div class="flex justify-between items-start mb-1">
                                                                    <span class="font-semibold text-sm text-gray-800 " x-text="comentario.user.name"></span>
                                                                    <span class="text-xs text-gray-400" x-text="formatDate(comentario.created_at)"></span>
                                                                </div>
                                                                <p class="text-sm text-gray-600 " x-text="comentario.cuerpo"></p>
                                                            </div>
                                                        </template>
                                                    </div>

                                                    <!-- Add Comment Input -->
                                                    <form @submit.prevent="enviarComentario" class="mt-4 flex gap-2">
                                                        <input type="text" x-model="nuevoComentario" placeholder="Escribe un comentario..." 
                                                               class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm "
                                                               :disabled="enviandoComentario">
                                                        <button type="submit" 
                                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                                :disabled="enviandoComentario">
                                                            <span x-show="!enviandoComentario">Enviar</span>
                                                            <span x-show="enviandoComentario">
                                                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                                </svg>
                                                            </span>
                                                        </button>
                                                    </form>
                                                </div>

                                                <!-- Timeline Tab -->
                                                <div x-show="activeTab === 'timeline'" class="max-h-60 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-gray-300">
                                                    <div class="relative border-l border-gray-200 ml-3 space-y-4 py-2">
                                                        <template x-if="logs.length === 0">
                                                            <p class="text-sm text-gray-500 text-center py-2">No hay actividad registrada.</p>
                                                        </template>
                                                        <template x-for="log in logs" :key="log.id">
                                                            <div class="relative pl-6">
                                                                <!-- Timeline Dot -->
                                                                <span class="absolute -left-1.5 top-1.5 w-3 h-3 rounded-full bg-indigo-500 ring-4 ring-white "></span>
                                                                
                                                                <div class="flex justify-between items-start mb-1">
                                                                    <span class="font-medium text-sm text-gray-900 " x-text="log.action"></span>
                                                                    <span class="text-xs text-gray-500" x-text="formatDate(log.created_at)"></span>
                                                                </div>
                                                                <p class="text-sm text-gray-600 " x-text="log.description"></p>
                                                                
                                                                <!-- Changed Properties (if any) -->
                                                                <template x-if="log.changes">
                                                                    <div class="mt-1 text-xs text-gray-500 bg-gray-50 p-2 rounded">
                                                                        <pre class="whitespace-pre-wrap font-mono text-xs" x-text="JSON.stringify(log.changes, null, 2)"></pre>
                                                                    </div>
                                                                </template>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100 ">
                        <button type="button" 
                                class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors" 
                                @click="closeModal()">
                            Cerrar
                        </button>
                        
                        <!-- Actions for Asesor (Only show if permitted) -->
                        @hasrole('asesor')
                        <button type="button" 
                                x-show="currentEvent.estado && (currentEvent.estado.toLowerCase() === 'programada' || currentEvent.estado.toLowerCase() === 'pendiente')"
                                class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm :bg-gray-700 transition-colors"
                                @click="cancelarAsesoria(currentEvent.id)">
                            Cancelar Asesoría
                        </button>
                        @endhasrole

                        <!-- Actions for Alumno -->
                        @hasrole('alumno')
                        <button type="button" 
                                x-show="currentEvent.estado && currentEvent.estado.toLowerCase() === 'pendiente'"
                                class="mt-3 w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors"
                                @click="confirmarAsesoria(currentEvent.id)">
                            Confirmar Asistencia
                        </button>
                        @endhasrole
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Event Modal (Alpine.js) - Only for Asesores -->
        @if(auth()->user()->hasRole('asesor'))
        <div x-show="showCreateModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;" 
             aria-labelledby="modal-title" role="dialog" aria-modal="true">
             
             <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showCreateModal" 
                     class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" 
                     @click="closeCreateModal()"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 ">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-indigo-600 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-xl leading-6 font-bold text-gray-900 ">Programar Nueva Asesoría</h3>
                                <div class="mt-4">
                                    <p class="text-sm text-gray-500 ">
                                        Has seleccionado la fecha: <span class="font-bold text-gray-700 " x-text="formatDate(newEvent.start)"></span>
                                    </p>
                                    <form @submit.prevent="crearAsesoria" class="mt-5 space-y-4">
                                        <!-- Alumno -->
                                        <div>
                                            <label for="alumno_id" class="block text-sm font-medium text-gray-700">Alumno a Asesorar <span class="text-red-500">*</span></label>
                                            <select id="alumno_id" x-model="newEvent.alumno_id" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg">
                                                <option value="" disabled>Seleccione un alumno...</option>
                                                @foreach($alumnos as $alumno)
                                                    <option value="{{ $alumno->id }}">{{ $alumno->user->name }} ({{ $alumno->matricula }})</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Título -->
                                        <div>
                                            <label for="titulo" class="block text-sm font-medium text-gray-700">Título de Asesoría <span class="text-red-500">*</span></label>
                                            <input type="text" id="titulo" x-model="newEvent.titulo" required placeholder="Ej. Revisión Capítulo 1" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        </div>

                                        <!-- Hora -->
                                        <div>
                                            <label for="hora" class="block text-sm font-medium text-gray-700">Hora <span class="text-red-500">*</span></label>
                                            <input type="time" id="hora" x-model="newEvent.hora" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        </div>

                                        <!-- Duración y Modalidad -->
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label for="duracion" class="block text-sm font-medium text-gray-700">Duración (min) <span class="text-red-500">*</span></label>
                                                <input type="number" id="duracion" x-model="newEvent.duracion" required min="15" step="15" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            </div>
                                            <div>
                                                <label for="modalidad" class="block text-sm font-medium text-gray-700">Modalidad <span class="text-red-500">*</span></label>
                                                <select id="modalidad" x-model="newEvent.catalogo_modalidad_id" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    <option value="" disabled>Seleccione...</option>
                                                    @foreach($modalidades as $mod)
                                                        <option value="{{ $mod->id }}">{{ ucfirst($mod->valor) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Descripción -->
                                        <div>
                                            <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción (Opcional)</label>
                                            <textarea id="descripcion" x-model="newEvent.descripcion" rows="2" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Temas a tratar..."></textarea>
                                        </div>

                                        <!-- Modal Actions -->
                                        <div class="mt-5 sm:mt-6 sm:flex sm:flex-row-reverse">
                                            <button type="submit" 
                                                    class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors"
                                                    :disabled="guardandoAsesoria">
                                                <span x-show="!guardandoAsesoria">Programar Asesoría</span>
                                                <span x-show="guardandoAsesoria">Guardando...</span>
                                            </button>
                                            <button type="button" 
                                                    class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm transition-colors"
                                                    @click="closeCreateModal()">
                                                Cancelar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100 ">
                        <button type="button" 
                                class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm :bg-gray-700"
                                @click="closeCreateModal()">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('calendarModal', () => ({
                showEventModal: false,
                showCreateModal: false,
                currentEvent: {},
                newEvent: {},
                isLoadingDetails: false,
                comentarios: [],
                logs: [],
                nuevoComentario: '',
                enviandoComentario: false,
                guardandoAsesoria: false,
                
                init() {
                    window.addEventListener('open-event-modal', async (e) => {
                        this.currentEvent = {
                            id: e.detail.id,
                            title: e.detail.title,
                            start: e.detail.start,
                            end: e.detail.end,
                            estado: e.detail.extendedProps.estado,
                            modalidad: e.detail.extendedProps.modalidad,
                            enlace: e.detail.extendedProps.enlace,
                            asesor: e.detail.extendedProps.asesor,
                            alumno: e.detail.extendedProps.alumno,
                            observaciones: e.detail.extendedProps.observaciones,
                            color: e.detail.extendedProps.color,
                            tipo: e.detail.extendedProps.tipo
                        };
                        
                        this.comentarios = [];
                        this.logs = [];
                        this.showEventModal = true;
                        
                        if (this.currentEvent.tipo === 'Asesoria') {
                            await this.fetchDetalles(this.currentEvent.id.replace('ase_', ''));
                        }
                    });

                    window.addEventListener('open-create-modal', (e) => {
                        this.newEvent = {
                            start: e.detail.start,
                            end: e.detail.end
                        };
                        this.showCreateModal = true;
                    });
                },
                
                async fetchDetalles(id) {
                    this.isLoadingDetails = true;
                    try {
                        const url = '{{ route("api.v1.asesorias.show", ":id") }}'.replace(':id', id);
                        const response = await fetch(url);
                        if (response.ok) {
                            const data = await response.json();
                            this.comentarios = data.comentarios || [];
                            this.logs = data.activity_logs || [];
                        }
                    } catch (error) {
                        console.error('Error fetching details:', error);
                    } finally {
                        this.isLoadingDetails = false;
                    }
                },
                
                async enviarComentario() {
                    if (!this.nuevoComentario.trim()) return;
                    
                    this.enviandoComentario = true;
                    const id = this.currentEvent.id.replace('ase_', '');
                    
                    try {
                        const url = '{{ route("api.v1.asesorias.comentarios.store", ":id") }}'.replace(':id', id);
                        const response = await fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ cuerpo: this.nuevoComentario })
                        });
                        
                        if (response.ok) {
                            const data = await response.json();
                            this.comentarios.push(data.comentario);
                            this.nuevoComentario = '';
                        }
                    } catch (error) {
                        console.error('Error sending comment:', error);
                    } finally {
                        this.enviandoComentario = false;
                    }
                },

                closeModal() {
                    this.showEventModal = false;
                },
                
                closeCreateModal() {
                    this.showCreateModal = false;
                },
                
                formatDate(dateString) {
                    if (!dateString) return '';
                    const date = new Date(dateString);
                    return date.toLocaleDateString('es-ES', { 
                        weekday: 'long', 
                        year: 'numeric', 
                        month: 'long', 
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                },
                
                getStatusBgClass(status) {
                    if (!status) return 'bg-gray-100 ';
                    const s = status.toLowerCase();
                    switch(s) {
                        case 'programada': return 'bg-blue-100 ';
                        case 'completada': return 'bg-green-100 ';
                        case 'cancelada': return 'bg-red-100 ';
                        case 'reprogramacion': return 'bg-orange-100 ';
                        default: return 'bg-yellow-100 ';
                    }
                },
                
                getStatusIconClass(status) {
                    if (!status) return 'text-gray-600 ';
                    const s = status.toLowerCase();
                    switch(s) {
                        case 'programada': return 'text-blue-600 ';
                        case 'completada': return 'text-green-600 ';
                        case 'cancelada': return 'text-red-600 ';
                        case 'reprogramacion': return 'text-orange-600 ';
                        default: return 'text-yellow-600 ';
                    }
                },
                
                async confirmarAsesoria(id) {
                    try {
                        const cleanId = id.replace('ase_', '');
                        const url = '{{ route("api.v1.asesorias.confirmar", ":id") }}'.replace(':id', cleanId);
                        
                        const response = await fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });

                        if (response.ok) {
                            Swal.fire('¡Confirmada!', 'Has confirmado tu asistencia a la asesoría.', 'success');
                            this.closeModal();
                            setTimeout(() => window.location.reload(), 1500);
                        } else {
                            const err = await response.json();
                            Swal.fire('Error', err.error || err.message || 'No se pudo confirmar.', 'error');
                        }
                    } catch (error) {
                        Swal.fire('Error', 'Problema de conexión.', 'error');
                    }
                },

                getBadgeClass(status) {
                    if (!status) return 'bg-gray-100 text-gray-800 ';
                    const s = status.toLowerCase();
                    switch(s) {
                        case 'programada': return 'bg-blue-100 text-blue-800 ';
                        case 'completada': return 'bg-green-100 text-green-800 ';
                        case 'cancelada': return 'bg-red-100 text-red-800 ';
                        case 'reprogramacion': return 'bg-orange-100 text-orange-800 ';
                        default: return 'bg-yellow-100 text-yellow-800 ';
                    }
                },
                
                async crearAsesoria() {
                    if (!this.newEvent.alumno_id || !this.newEvent.titulo || !this.newEvent.hora || !this.newEvent.duracion || !this.newEvent.catalogo_modalidad_id) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Por favor completa todos los campos requeridos.'
                        });
                        return;
                    }
                    
                    this.guardandoAsesoria = true;
                    
                    try {
                        const payload = {
                            alumno_id: this.newEvent.alumno_id,
                            titulo: this.newEvent.titulo,
                            fecha_hora: this.newEvent.start + ' ' + this.newEvent.hora + ':00',
                            duracion: this.newEvent.duracion,
                            catalogo_modalidad_id: this.newEvent.catalogo_modalidad_id,
                            descripcion: this.newEvent.descripcion
                        };

                        const response = await fetch('{{ route("api.v1.asesorias.store") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(payload)
                        });
                        
                        if (response.ok) {
                            const data = await response.json();
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: 'La asesoría se ha programado correctamente.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            this.closeCreateModal();
                            // Recargar el calendario (refetch events)
                            // Un approach rápido es recargar la página o disparar evento al fullcalendar
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        } else {
                            const err = await response.json();
                            let errorMessage = err.message || err.error || 'Ocurrió un error al programar la asesoría.';
                            if (err.errors) {
                                errorMessage = Object.values(err.errors).flat().join('\n');
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: errorMessage
                            });
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al comunicarse con el servidor.'
                        });
                    } finally {
                        this.guardandoAsesoria = false;
                    }
                },
                
                cancelarAsesoria(id) {
                    alert('Funcionalidad de cancelar asesoría (Sprint 3)');
                }
            }));
        });
    </script>
    @endpush
</x-app-layout>
