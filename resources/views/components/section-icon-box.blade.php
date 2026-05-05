@props(['item', 'accent' => 'var(--gold)'])

@if (data_get($item, 'icon'))
    <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-5"
        style="background:{{ $accent }}18;border:1px solid {{ $accent }}33">
        @include('components.section-icon', ['path' => data_get($item, 'icon'), 'color' => $accent])
    </div>
@endif
