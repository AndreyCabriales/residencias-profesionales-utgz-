<x-guest-layout>
    <div class="mb-10">
        <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Recuperar Contraseña</h2>
        <p class="text-base text-gray-500 mt-2 font-light">¿Olvidaste tu contraseña? No hay problema. Simplemente dinos tu dirección de correo electrónico institucional y te enviaremos un enlace para restablecerla que te permitirá elegir una nueva.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Correo Institucional</label>
            <input id="email" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-utgz-accent focus:border-transparent transition-all duration-200" type="email" name="email" :value="old('email')" required autofocus placeholder="ejemplo@utgz.mx">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-4 flex flex-col sm:flex-row justify-between items-center gap-4">
            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-utgz-primary transition-colors">
                ← Volver al Login
            </a>
            <button type="submit" class="w-full sm:w-auto flex justify-center items-center py-3.5 px-6 rounded-xl shadow-lg shadow-utgz-primary/20 text-base font-bold text-white bg-utgz-primary hover:bg-utgz-sidebar focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-utgz-primary transition-all duration-200 hover:-translate-y-0.5">
                Enviar enlace de recuperación
            </button>
        </div>
    </form>
</x-guest-layout>
