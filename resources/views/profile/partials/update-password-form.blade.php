<section class="md:grid md:grid-cols-3 md:gap-8">
    <header class="md:col-span-1">
        <h2 class="text-xl font-bold text-utgz-primary flex items-center gap-2">
            <svg class="w-6 h-6 text-utgz-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            {{ __('Actualizar Contraseña') }}
        </h2>

        <p class="mt-3 text-sm text-gray-500 leading-relaxed">
            {{ __('Asegúrate de que tu cuenta use una contraseña larga y aleatoria para mantenerse segura.') }}
        </p>
    </header>

    <div class="mt-6 md:mt-0 md:col-span-2 bg-gray-50/50 p-6 rounded-xl border border-gray-100">
        <form method="post" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            @method('put')

            <div>
                <x-input-label for="update_password_current_password" :value="__('Contraseña Actual')" class="text-gray-700 font-medium" />
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full border-gray-300 focus:border-utgz-accent focus:ring-utgz-accent rounded-lg shadow-sm transition-colors" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="update_password_password" :value="__('Nueva Contraseña')" class="text-gray-700 font-medium" />
                <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full border-gray-300 focus:border-utgz-accent focus:ring-utgz-accent rounded-lg shadow-sm transition-colors" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="update_password_password_confirmation" :value="__('Confirmar Contraseña')" class="text-gray-700 font-medium" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full border-gray-300 focus:border-utgz-accent focus:ring-utgz-accent rounded-lg shadow-sm transition-colors" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-gray-800 border border-transparent rounded-lg font-semibold text-white hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm hover:shadow-md hover:-translate-y-0.5">
                    {{ __('Guardar Contraseña') }}
                </button>

                @if (session('status') === 'password-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition.opacity.duration.500ms
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-green-600 font-medium flex items-center gap-1 bg-green-50 px-3 py-1.5 rounded-md border border-green-100"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ __('Guardada.') }}
                    </p>
                @endif
            </div>
        </form>
    </div>
</section>
