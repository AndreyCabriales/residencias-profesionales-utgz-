@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-xs font-medium text-red-500 space-y-1 mt-1.5 flex flex-col gap-1']) }}>
        @foreach ((array) $messages as $message)
            <li class="flex items-center gap-1.5 bg-red-500/10 px-2.5 py-1.5 rounded-md border border-red-500/20 w-fit">
                <svg class="w-3.5 h-3.5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ $message }}</span>
            </li>
        @endforeach
    </ul>
@endif
