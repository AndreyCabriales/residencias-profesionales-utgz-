<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-utgz-primary leading-tight">
                {{ __('Gestión de Alumnos') }}
            </h2>
            <a href="{{ route('coordinador.alumnos.create') }}" class="bg-utgz-accent hover:bg-utgz-primary text-white font-bold py-2 px-4 rounded shadow-sm transition-colors text-sm">
                + Registrar Nuevo Alumno
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden fade-in-up">
        
        @if(session('success'))
            <div class="m-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative text-sm" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-700">Listado General</h3>
            <span class="text-sm text-gray-500">Total: {{ $alumnos->total() }} alumnos</span>
        </div>

        @if($alumnos->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-sm border-b border-gray-200">
                        <th class="px-6 py-3 font-medium">Nombre Completo</th>
                        <th class="px-6 py-3 font-medium">Matrícula</th>
                        <th class="px-6 py-3 font-medium">Carrera</th>
                        <th class="px-6 py-3 font-medium">Correo Electrónico</th>
                        <th class="px-6 py-3 font-medium">Etapa Actual</th>
                        <th class="px-6 py-3 font-medium">Asesor Asignado</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100">
                    @foreach($alumnos as $alumno)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $alumno->user->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $alumno->matricula }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $alumno->carrera ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $alumno->user->email }}</td>
                        <td class="px-6 py-4 text-gray-600">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                Etapa {{ $alumno->etapa_id ?? '1' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $alumno->asignacion->asesor->user->name ?? 'Sin Asignar' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $alumnos->links() }}
        </div>
        @else
        <div class="p-8 text-center text-gray-500">
            No hay alumnos registrados en el sistema.
        </div>
        @endif
    </div>
</x-app-layout>
