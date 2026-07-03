<section class="md:grid md:grid-cols-3 md:gap-8">
    <header class="md:col-span-1">
        <h2 class="text-xl font-bold text-red-600 flex items-center gap-2">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            {{ __('Eliminar Cuenta') }}
        </h2>

        <p class="mt-3 text-sm text-red-700 leading-relaxed">
            {{ __('Una vez que se elimine tu cuenta, todos sus recursos y datos se eliminarán permanentemente. Antes de eliminarla, por favor descarga cualquier información que desees conservar.') }}
        </p>
    </header>

    <div class="mt-6 md:mt-0 md:col-span-2">
        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="inline-flex items-center px-6 py-2.5 bg-red-600 border border-transparent rounded-lg font-semibold text-white hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm hover:shadow-md hover:-translate-y-0.5">
            {{ __('Eliminar Cuenta Definitivamente') }}
        </button>

        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
            <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                @csrf
                @method('delete')

                <h2 class="text-lg font-bold text-gray-900">
                    {{ __('¿Estás seguro que deseas eliminar tu cuenta?') }}
                </h2>

                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Una vez que se elimine tu cuenta, todos sus recursos y datos se eliminarán permanentemente. Por favor, ingresa tu contraseña para confirmar que deseas eliminar tu cuenta de forma definitiva.') }}
                </p>

                <div class="mt-6">
                    <x-input-label for="password" value="{{ __('Contraseña') }}" class="sr-only" />
                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="mt-1 block w-3/4 border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm"
                        placeholder="{{ __('Contraseña') }}"
                    />
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" x-on:click="$dispatch('close')" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-utgz-accent focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('Cancelar') }}
                    </button>

                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                        {{ __('Eliminar Cuenta') }}
                    </button>
                </div>
            </form>
        </x-modal>
    </div>
</section>
