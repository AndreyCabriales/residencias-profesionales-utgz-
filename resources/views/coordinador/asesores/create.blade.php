<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-utgz-primary leading-tight">
            <a href="{{ route('coordinador.asesores.index') }}" class="text-gray-400 hover:text-utgz-primary">Asesores</a> / Registrar Nuevo
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-sm overflow-hidden fade-in-up">
        
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-700">Datos del Asesor</h3>
            <p class="text-sm text-gray-500">Al registrar un asesor, se le generará automáticamente una cuenta con la contraseña por defecto <code class="bg-gray-200 px-1 rounded">password</code>.</p>
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

        <form action="{{ route('coordinador.asesores.store') }}" method="POST" class="p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Nombre -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-utgz-accent focus:ring focus:ring-utgz-accent focus:ring-opacity-50">
                </div>

                <!-- Correo Institucional -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Institucional <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="ejemplo@utgz.mx" class="w-full rounded-md border-gray-300 shadow-sm focus:border-utgz-accent focus:ring focus:ring-utgz-accent focus:ring-opacity-50">
                </div>

                <!-- Departamento -->
                <div>
                    <label for="departamento" class="block text-sm font-medium text-gray-700 mb-1">Departamento / Especialidad</label>
                    <input type="text" name="departamento" id="departamento" value="{{ old('departamento') }}" placeholder="Ej. Sistemas Informáticos" class="w-full rounded-md border-gray-300 shadow-sm focus:border-utgz-accent focus:ring focus:ring-utgz-accent focus:ring-opacity-50">
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-200">
                <a href="{{ route('coordinador.asesores.index') }}" class="bg-white text-gray-700 border border-gray-300 font-medium py-2 px-6 rounded-md hover:bg-gray-50 transition-colors mr-3">
                    Cancelar
                </a>
                <button type="submit" class="bg-utgz-primary hover:bg-utgz-sidebar text-white font-medium py-2 px-6 rounded-md shadow-sm transition-colors">
                    Registrar Asesor
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
