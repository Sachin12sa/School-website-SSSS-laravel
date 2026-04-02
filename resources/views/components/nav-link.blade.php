@props(['route', 'icon'])

@php
    $isActive = request()->routeIs($route);
@endphp

<a href="{{ route($route) }}"
    {{ $attributes->merge([
        'class' =>
            'flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all group ' .
            ($isActive ? 'active-nav-item text-white' : 'text-navy-300 hover:text-white hover:bg-white/5'),
    ]) }}>

    <svg class="w-5 h-5 {{ $isActive ? 'text-gold' : 'text-navy-400 group-hover:text-gold' }} transition-colors"
        fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}" />
    </svg>

    <span>{{ $slot }}</span>

    @if ($isActive)
        <div class="ml-auto w-1.5 h-1.5 bg-gold rounded-full shadow-[0_0_8px_rgba(201,162,39,0.8)]"></div>
    @endif
</a>
