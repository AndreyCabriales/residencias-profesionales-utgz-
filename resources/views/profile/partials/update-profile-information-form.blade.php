<section class="md:grid md:grid-cols-3 md:gap-8">
    <header class="md:col-span-1">
        <h2 class="text-xl font-bold text-utgz-primary flex items-center gap-2">
            <svg class="w-6 h-6 text-utgz-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            {{ __('Información del Perfil') }}
        </h2>

        <p class="mt-3 text-sm text-gray-500 leading-relaxed">
            {{ __("Actualiza la información de tu cuenta y tu dirección de correo electrónico. Es importante mantener estos datos al día para no perder comunicaciones importantes del proceso de residencias.") }}
        </p>
    </header>

    <div class="mt-6 md:mt-0 md:col-span-2">
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf
            @method('patch')

            <div>
                <x-input-label for="name" :value="__('Nombre Completo')" class="text-gray-700 font-medium" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full border-gray-300 focus:border-utgz-accent focus:ring-utgz-accent rounded-lg shadow-sm transition-colors" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Correo Institucional')" class="text-gray-700 font-medium" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full border-gray-300 focus:border-utgz-accent focus:ring-utgz-accent rounded-lg shadow-sm transition-colors" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2 bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                        <p class="text-sm text-yellow-800 font-medium flex items-center gap-2">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            {{ __('Tu dirección de correo no está verificada.') }}
                        </p>
                        <button form="send-verification" class="mt-2 inline-flex items-center text-sm text-utgz-accent hover:text-utgz-primary font-medium underline focus:outline-none transition-colors">
                            {{ __('Haz clic aquí para reenviar el correo de verificación.') }}
                        </button>
                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 text-sm text-green-600 font-medium">
                                {{ __('Un nuevo enlace de verificación ha sido enviado a tu correo.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-utgz-accent border border-transparent rounded-lg font-semibold text-white hover:bg-utgz-primary focus:bg-utgz-primary active:bg-utgz-primary focus:outline-none focus:ring-2 focus:ring-utgz-accent focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm hover:shadow-md hover:-translate-y-0.5">
                    {{ __('Guardar Cambios') }}
                </button>

                @if (session('status') === 'profile-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition.opacity.duration.500ms
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-green-600 font-medium flex items-center gap-1 bg-green-50 px-3 py-1.5 rounded-md border border-green-100"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ __('Guardado correctamente.') }}
                    </p>
                @endif
            </div>
        </form>
    </div>
</section>
