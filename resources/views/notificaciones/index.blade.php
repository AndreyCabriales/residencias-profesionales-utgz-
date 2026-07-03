<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-utgz-primary leading-tight">
                {{ __('Centro de Notificaciones') }}
            </h2>
            @if($notificaciones->contains('leida', false))
            <form action="{{ route('notificaciones.leer_todas') }}" method="POST">
                @csrf
                <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded text-sm transition-colors">
                    Marcar todas como leídas
                </button>
            </form>
            @endif
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm overflow-hidden fade-in-up">
        
        @if(session('success'))
            <div class="m-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative text-sm" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if($notificaciones->count() > 0)
        <div class="divide-y divide-gray-100">
            @foreach($notificaciones as $notificacion)
            <div class="p-6 transition-colors {{ $notificacion->leida ? 'bg-white' : 'bg-blue-50/50 border-l-4 border-utgz-accent' }}">
                <div class="flex justify-between items-start">
                    <div class="flex items-start gap-4">
                        <!-- Icono -->
                        <div class="mt-1">
                            @if($notificacion->leida)
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            </div>
                            @else
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-utgz-accent">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Contenido -->
                        <div>
                            <h4 class="text-base font-semibold {{ $notificacion->leida ? 'text-gray-700' : 'text-gray-900' }}">
                                {{ $notificacion->titulo }}
                            </h4>
                            <p class="text-sm mt-1 {{ $notificacion->leida ? 'text-gray-500' : 'text-gray-700 font-medium' }}">
                                {{ $notificacion->mensaje }}
                            </p>
                            <span class="text-xs text-gray-400 mt-2 block">
                                {{ $notificacion->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Botón de acción -->
                    @if(!$notificacion->leida)
                    <div>
                        <a href="{{ route('notificaciones.leer', $notificacion->id) }}" class="text-xs font-medium text-utgz-accent hover:text-utgz-primary bg-white px-3 py-1.5 rounded border border-blue-100 hover:bg-blue-50 transition-colors">
                            Marcar leída
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $notificaciones->links() }}
        </div>
        @else
        <div class="p-12 text-center text-gray-500">
            <div class="w-16 h-16 mx-auto bg-gray-50 rounded-full flex items-center justify-center text-gray-300 mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            </div>
            <p class="text-lg font-medium text-gray-600">No tienes notificaciones</p>
            <p class="text-sm mt-1">Aquí aparecerán los avisos sobre tus documentos o asignaciones.</p>
        </div>
        @endif
    </div>
</x-app-layout>
