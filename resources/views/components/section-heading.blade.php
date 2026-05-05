@props(['section', 'isDark' => false, 'center' => false])

<div class="{{ $center ? 'text-center mb-16' : '' }} reveal">
    @if ($section->badge_text)
        <div class="section-label {{ $center ? 'justify-center' : '' }}" style="{{ $isDark ? 'color:rgba(201,162,39,0.8)' : '' }}">
            {{ $section->badge_text }}
        </div>
    @endif
    @if ($section->title)
        <h2 class="{{ $isDark ? 'font-display font-bold text-white' : 'section-title' }} {{ $center ? '' : 'mb-4' }}"
            style="{{ $isDark ? 'font-size:clamp(1.8rem,3.5vw,2.8rem);line-height:1.1;letter-spacing:-0.02em' : '' }}">
            {{ $section->title }}
        </h2>
    @endif
    <div class="gold-bar {{ $center ? 'mx-auto' : '' }} mt-4"></div>
    @if ($section->subtitle)
        <p class="{{ $isDark ? 'text-white/55' : 'text-gray-400' }} text-sm mt-6 max-w-2xl {{ $center ? 'mx-auto' : '' }} leading-relaxed"
            style="font-family:'Plus Jakarta Sans',sans-serif">
            {{ $section->subtitle }}
        </p>
    @endif
</div>
