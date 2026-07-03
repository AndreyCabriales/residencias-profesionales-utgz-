<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-utgz-primary leading-tight">
            <a href="{{ route('coordinador.alumnos.index') }}" class="text-gray-400 hover:text-utgz-primary">Alumnos</a> / Editar y Asignar
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-sm overflow-hidden fade-in-up">
        
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-700">Edición de Alumno</h3>
            @if(!$alumno->asignacion || !$alumno->asignacion->asesor_id)
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                    En espera (Sin asesor)
                </span>
            @endif
        </div>

        @if ($errors->any())
            <div class="m-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('coordinador.alumnos.update', $alumno) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Nombre -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $alumno->user->name) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-utgz-accent focus:ring focus:ring-utgz-accent focus:ring-opacity-50">
                </div>

                <!-- Matrícula -->
                <div>
                    <label for="matricula" class="block text-sm font-medium text-gray-700 mb-1">Matrícula <span class="text-red-500">*</span></label>
                    <input type="text" name="matricula" id="matricula" value="{{ old('matricula', $alumno->matricula) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-utgz-accent focus:ring focus:ring-utgz-accent focus:ring-opacity-50">
                </div>

                <!-- Correo Institucional -->
                <div class="md:col-span-2">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Institucional <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $alumno->user->email) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-utgz-accent focus:ring focus:ring-utgz-accent focus:ring-opacity-50">
                </div>

                <!-- Carrera -->
                <div>
                    <label for="carrera" class="block text-sm font-medium text-gray-700 mb-1">Carrera</label>
                    <input type="text" name="carrera" id="carrera" value="{{ old('carrera', $alumno->carrera) }}" placeholder="Ej. TSU en Tecnologías de la Información" class="w-full rounded-md border-gray-300 shadow-sm focus:border-utgz-accent focus:ring focus:ring-utgz-accent focus:ring-opacity-50">
                </div>

                <!-- Cuatrimestre -->
                <div>
                    <label for="cuatrimestre" class="block text-sm font-medium text-gray-700 mb-1">Cuatrimestre</label>
                    <select name="cuatrimestre" id="cuatrimestre" class="w-full rounded-md border-gray-300 shadow-sm focus:border-utgz-accent focus:ring focus:ring-utgz-accent focus:ring-opacity-50">
                        <option value="">-- Seleccionar --</option>
                        @for ($i = 1; $i <= 11; $i++)
                            <option value="{{ $i }}" {{ old('cuatrimestre', $alumno->cuatrimestre) == $i ? 'selected' : '' }}>{{ $i }}° Cuatrimestre</option>
                        @endfor
                    </select>
                </div>

                <!-- Asesor Asignado -->
                <div class="md:col-span-2 bg-blue-50/50 p-4 rounded-lg border border-blue-100">
                    <label for="asesor_id" class="block text-sm font-bold text-gray-700 mb-2">Asesor Académico</label>
                    <select name="asesor_id" id="asesor_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-utgz-accent focus:ring focus:ring-utgz-accent focus:ring-opacity-50">
                        <option value="">-- En espera / Sin asignar --</option>
                        @foreach($asesores as $asesor)
                            <option value="{{ $asesor->id }}" {{ old('asesor_id', $alumno->asignacion->asesor_id ?? '') == $asesor->id ? 'selected' : '' }}>
                                {{ $asesor->user->name }} ({{ $asesor->departamento }})
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-600 mt-2">
                        Al reasignar un asesor, el nuevo asesor tomará control inmediato de los documentos pendientes. Si seleccionas "En espera", el alumno no podrá ser evaluado hasta tener asesor, pero sus documentos se mantendrán intactos.
                    </p>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-200">
                <a href="{{ route('coordinador.alumnos.index') }}" class="bg-white text-gray-700 border border-gray-300 font-medium py-2 px-6 rounded-md hover:bg-gray-50 transition-colors mr-3">
                    Cancelar
                </a>
                <button type="submit" class="bg-utgz-primary hover:bg-utgz-sidebar text-white font-medium py-2 px-6 rounded-md shadow-sm transition-colors">
                    Actualizar Alumno
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
