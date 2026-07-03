<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-10">
        <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Iniciar Sesión</h2>
        <p class="text-base text-gray-500 mt-2 font-light">Ingresa tus credenciales para acceder a tu panel.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6" novalidate>
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Correo Electrónico</label>
            <input id="email" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-utgz-accent focus:border-transparent transition-all duration-200" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="ejemplo@utgz.mx">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-1">
                <label for="password" class="block text-sm font-semibold text-gray-700">Contraseña</label>
                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-utgz-accent hover:text-utgz-primary transition-colors" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>
            <input id="password" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-utgz-accent focus:border-transparent transition-all duration-200" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center pt-2">
            <input id="remember_me" type="checkbox" class="h-5 w-5 text-utgz-primary focus:ring-utgz-primary border-gray-300 rounded cursor-pointer transition-colors">
            <label for="remember_me" class="ml-3 block text-sm text-gray-700 cursor-pointer select-none">
                Mantener sesión iniciada
            </label>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full flex justify-center items-center py-3.5 px-4 rounded-xl shadow-lg shadow-utgz-primary/20 text-base font-bold text-white bg-utgz-primary hover:bg-utgz-sidebar focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-utgz-primary transition-all duration-200 hover:-translate-y-0.5">
                Ingresar al Sistema
                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>
    </form>
</x-guest-layout>
