@props(['item', 'accent' => 'var(--gold)'])

<div class="feat-item">
    <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
        style="background:rgba(201,162,39,0.09);border:1px solid rgba(201,162,39,0.18)">
        @include('components.section-icon', ['path' => data_get($item, 'icon'), 'color' => $accent])
    </div>
    <div>
        <h4 class="font-semibold text-navy text-sm" style="font-family:'Plus Jakarta Sans',sans-serif">{{ data_get($item, 'title') }}</h4>
        <p class="text-gray-400 text-xs mt-0.5 leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif">{{ data_get($item, 'description') }}</p>
    </div>
</div>
