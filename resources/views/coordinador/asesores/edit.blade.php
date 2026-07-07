<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            <a href="{{ route('coordinador.asesores.index') }}" class="text-slate-400 hover:text-emerald-600 transition-colors">Asesores</a> <span class="text-slate-300">/</span> Editar Asesor
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl shadow-gray-200/40 border border-gray-100 overflow-hidden fade-in-up">
        
        <div class="px-8 py-6 border-b border-gray-100 bg-white flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-800">Edición de Asesor</h3>
        </div>

        @if ($errors->any())
            <div class="m-8 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl relative text-sm font-medium">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('coordinador.asesores.update', $asesor) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 mb-8">
                <!-- Nombre -->
                <div>
                    <label for="name" class="block text-sm font-bold text-slate-700 mb-1">Nombre Completo <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $asesor->user->name) }}" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/20 text-slate-800">
                </div>

                <!-- Correo Institucional -->
                <div>
                    <label for="email" class="block text-sm font-bold text-slate-700 mb-1">Correo Institucional <span class="text-rose-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $asesor->user->email) }}" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/20 text-slate-800">
                </div>

                <!-- Departamento / Especialidad -->
                <div>
                    <label for="departamento" class="block text-sm font-bold text-slate-700 mb-1">Departamento / Especialidad</label>
                    <input type="text" name="departamento" id="departamento" value="{{ old('departamento', $asesor->departamento) }}" placeholder="Ej. Academia de TIC" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/20 text-slate-800">
                </div>
            </div>

            <div class="flex justify-end pt-6 border-t border-gray-100">
                <a href="{{ route('coordinador.asesores.index') }}" class="bg-white text-slate-600 border border-slate-200 font-bold py-2.5 px-6 rounded-xl hover:bg-slate-50 transition-colors mr-3 shadow-sm hover:-translate-y-0.5">
                    Cancelar
                </a>
                <button type="submit" class="bg-utgz-primary hover:bg-emerald-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 transition-all duration-200 hover:-translate-y-0.5">
                    Actualizar Asesor
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
