@props(['path' => null, 'color' => 'var(--gold)'])

@if ($path)
    <svg class="w-5 h-5" style="color:{{ $color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $path }}"/>
    </svg>
@else
    <span class="w-2.5 h-2.5 rounded-full" style="background:{{ $color }}"></span>
@endif
