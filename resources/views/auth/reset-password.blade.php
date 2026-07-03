<x-guest-layout>
    <div class="mb-10">
        <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Establecer Nueva Contraseña</h2>
        <p class="text-base text-gray-500 mt-2 font-light">Crea una nueva contraseña segura para tu cuenta.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Correo Institucional</label>
            <input id="email" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-utgz-accent focus:border-transparent transition-all duration-200" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" readonly>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

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
