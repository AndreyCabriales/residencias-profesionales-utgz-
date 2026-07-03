<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-utgz-primary leading-tight">
            {{ __('Mi Perfil') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/30">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12 relative z-10">
            <!-- Decorative background elements -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-utgz-accent/5 blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-blue-400/5 blur-3xl pointer-events-none"></div>

            <div class="relative group fade-in-up" style="animation-delay: 0.1s;">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-utgz-primary to-utgz-accent rounded-2xl blur opacity-0 group-hover:opacity-10 transition duration-500"></div>
                <div class="relative bg-white shadow-sm sm:rounded-2xl border border-gray-100 overflow-hidden transition-all duration-300 group-hover:shadow-xl group-hover:border-utgz-accent/20">
                    <div class="h-1 w-full bg-gradient-to-r from-utgz-primary to-utgz-accent"></div>
                    <div class="p-6 sm:p-10">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="relative group fade-in-up" style="animation-delay: 0.2s;">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-gray-500 to-gray-700 rounded-2xl blur opacity-0 group-hover:opacity-10 transition duration-500"></div>
                <div class="relative bg-white shadow-sm sm:rounded-2xl border border-gray-100 overflow-hidden transition-all duration-300 group-hover:shadow-xl group-hover:border-gray-300/50">
                    <div class="h-1 w-full bg-gradient-to-r from-gray-500 to-gray-700"></div>
                    <div class="p-6 sm:p-10">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="relative group fade-in-up" style="animation-delay: 0.3s;">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-red-500 to-red-700 rounded-2xl blur opacity-0 group-hover:opacity-15 transition duration-500"></div>
                <div class="relative bg-red-50/30 shadow-sm sm:rounded-2xl border border-red-100 overflow-hidden transition-all duration-300 group-hover:shadow-xl group-hover:border-red-300/50 group-hover:bg-white">
                    <div class="h-1 w-full bg-gradient-to-r from-red-500 to-red-600"></div>
                    <div class="p-6 sm:p-10">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
