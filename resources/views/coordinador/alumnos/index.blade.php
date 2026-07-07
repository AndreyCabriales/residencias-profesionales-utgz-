<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Gestión de Alumnos') }}
            </h2>
            <a href="{{ route('coordinador.alumnos.create') }}" class="bg-utgz-primary hover:bg-emerald-700 text-white font-semibold py-2.5 px-5 rounded-xl shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 hover:-translate-y-0.5 transition-all duration-200 text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Registrar Nuevo Alumno
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/40 border border-gray-100 overflow-hidden fade-in-up">
        
        @if(session('success'))
            <div class="m-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl relative text-sm font-medium flex items-center gap-3" role="alert">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-white">
            <h3 class="text-lg font-bold text-slate-800">Listado General</h3>
            <span class="text-sm font-medium text-slate-500 bg-slate-50 px-3 py-1 rounded-full border border-slate-200">Total: {{ $alumnos->total() }} alumnos</span>
        </div>

        @if($alumnos->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 text-slate-400 text-xs uppercase tracking-wider border-b border-gray-100">
                        <th class="px-8 py-4 font-bold">Nombre Completo</th>
                        <th class="px-8 py-4 font-bold">Matrícula</th>
                        <th class="px-8 py-4 font-bold">Carrera</th>
                        <th class="px-8 py-4 font-bold">Correo Electrónico</th>
                        <th class="px-8 py-4 font-bold">Etapa Actual</th>
                        <th class="px-8 py-4 font-bold">Asesor Asignado</th>
                        <th class="px-8 py-4 font-bold text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-50">
                    @foreach($alumnos as $alumno)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-8 py-5 font-bold text-slate-800">{{ $alumno->user->name }}</td>
                        <td class="px-8 py-5 font-medium text-slate-500">{{ $alumno->matricula }}</td>
                        <td class="px-8 py-5 font-medium text-slate-500">{{ $alumno->carrera ?? 'N/A' }}</td>
                        <td class="px-8 py-5 font-medium text-slate-500">{{ $alumno->user->email }}</td>
                        <td class="px-8 py-5 font-medium text-slate-500">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200 shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2"></span>
                                Etapa {{ $alumno->etapa_id ?? '1' }}
                            </span>
                        </td>
                        <td class="px-8 py-5 font-medium text-slate-500">
                            @if($alumno->asignacion && $alumno->asignacion->asesor)
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold border border-emerald-200">
                                        {{ substr($alumno->asignacion->asesor->user->name, 0, 1) }}
                                    </div>
                                    <span class="font-semibold text-slate-700">{{ $alumno->asignacion->asesor->user->name }}</span>
                                </div>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-2 animate-pulse"></span>
                                    En espera
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-5 text-right">
                            <a href="{{ route('coordinador.alumnos.edit', $alumno) }}" class="inline-flex items-center justify-center p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors border border-transparent hover:border-emerald-200 shadow-sm opacity-0 group-hover:opacity-100 focus:opacity-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="px-8 py-5 border-t border-gray-100 bg-white">
            {{ $alumnos->links() }}
        </div>
        @else
        <div class="p-16 text-center">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-700 mb-1">Sin alumnos registrados</h3>
            <p class="text-slate-500">Comienza registrando un nuevo alumno en el sistema.</p>
        </div>
        @endif
    </div>
</x-app-layout>
