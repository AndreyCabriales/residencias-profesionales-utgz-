<x-guest-layout>
    <div class="mb-10">
        <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Establecer Nueva Contraseña</h2>
        <p class="text-base text-gray-500 mt-2 font-light">Crea una nueva contraseña segura para tu cuenta.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address (Hidden) -->
        <input type="hidden" name="email" value="{{ old('email', $request->email) }}">

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Nueva Contraseña</label>
            <input id="password" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-utgz-accent focus:border-transparent transition-all duration-200" type="password" name="password" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Confirmar Contraseña</label>
            <input id="password_confirmation" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-utgz-accent focus:border-transparent transition-all duration-200"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4 flex items-center justify-end">
            <button type="submit" class="w-full flex justify-center items-center py-3.5 px-4 rounded-xl shadow-lg shadow-utgz-primary/20 text-base font-bold text-white bg-utgz-primary hover:bg-utgz-sidebar focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-utgz-primary transition-all duration-200 hover:-translate-y-0.5">
                Restablecer Contraseña
            </button>
        </div>
    </form>
</x-guest-layout>
