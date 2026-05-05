{{--
    <x-page-hero :hero="$hero" />

    Legacy include usage is also supported:
    @include('components.page-hero', ['title' => 'News', 'subtitle' => '...', 'breadcrumb' => 'News'])

    $hero  — optional PageHero model from PageHero::forPage('slug')
    $slot  — optional extra content (floating badges, scroll hint, etc.)
--}}

@props([
    'hero' => null,
    'title' => null,
    'subtitle' => null,
    'breadcrumb' => null,
    'badge' => null,
    'minHeight' => '56vh',
])

@php
    $isCentre = ($hero?->text_align ?? 'center') === 'center';
    $hasStats = $hero && !empty($hero->stats) && count($hero->stats) > 0;
    $hasPrimary = $hero && filled($hero->primary_button_text);
    $hasSecondary = $hero && filled($hero->secondary_button_text);
    $heading = $hero?->heading ?? $title ?? '';
    $subheading = $hero?->subheading ?? $subtitle ?? null;
    $badgeText = $hero?->badge_text ?? $badge ?? $breadcrumb ?? null;
    $height = $hero?->min_height ?? $minHeight;

    // Safe opacity accessor guards against buggy stored values > 1.
    $opacity = $hero?->safe_opacity ?? 0.22;
@endphp

<section class="relative flex items-center overflow-hidden" style="min-height:{{ $height }};background:#060e1c">

    {{-- ── Background image ──────────────────────────────────────────── --}}
    @if ($hero?->bg_image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($hero->bg_image_path))
        <div class="absolute inset-0">
            <img src="{{ $hero->bgImageUrl() }}" class="w-full h-full object-cover"
                style="opacity:{{ $opacity }}" alt="">
        </div>
    @else
        {{-- Fallback: animated orbs + grid --}}
        <div class="absolute inset-0">
            <div class="absolute inset-0" style="background:linear-gradient(150deg,#070e1d 0%,#0d1b35 30%,#060a14 100%)">
            </div>
            <div class="absolute pointer-events-none"
                style="top:22%;right:20%;width:340px;height:340px;border-radius:50%;
                    background:radial-gradient(circle,rgba(201,162,39,0.22) 0%,transparent 70%);
                    animation:float-gentle 9s ease-in-out infinite">
            </div>
            <div class="absolute pointer-events-none"
                style="bottom:25%;left:12%;width:200px;height:200px;border-radius:50%;
                    background:radial-gradient(circle,rgba(80,100,220,0.14) 0%,transparent 70%);
                    animation:float-gentle 13s 2s ease-in-out infinite">
            </div>
            <div class="absolute inset-0 pointer-events-none"
                style="opacity:.025;
                    background-image:linear-gradient(rgba(201,162,39,1) 1px,transparent 1px),
                                     linear-gradient(90deg,rgba(201,162,39,1) 1px,transparent 1px);
                    background-size:70px 70px">
            </div>
        </div>
    @endif

    {{-- ── Overlay ─────────────────────────────────────────────────────── --}}
    <div class="absolute inset-0" style="{{ $hero ? $hero->overlayGradient() : 'linear-gradient(135deg,rgba(6,14,28,0.96) 0%,rgba(13,27,46,0.86) 55%,rgba(201,162,39,0.07) 100%)' }}"></div>

    {{-- ── Decorative rings ────────────────────────────────────────────── --}}
    @if ($hero?->show_rings ?? true)
        <div class="absolute top-12 right-16 w-64 h-64 border rounded-full pointer-events-none hidden xl:block"
            style="border-color:rgba(255,255,255,0.04)"></div>
        <div class="absolute top-28 right-28 w-40 h-40 border rounded-full pointer-events-none hidden xl:block"
            style="border-color:rgba(201,162,39,0.08)"></div>
    @endif

    {{-- ── Content ───────────────────────────────────────────────────────── --}}
    <div class="relative max-w-7xl mx-auto px-6 lg:px-10 w-full py-32">
        <div class="{{ $isCentre ? 'max-w-3xl mx-auto text-center' : 'max-w-3xl' }}">

            {{-- Badge --}}
            @if (filled($badgeText))
                <div class="h-anim-1"
                    style="display:inline-flex;align-items:center;gap:8px;
                        {{ $hero ? $hero->badgeStyle() : 'background:rgba(201,162,39,0.12);border:1px solid rgba(201,162,39,0.28);color:var(--gold)' }};
                        box-shadow:inset 0 1px 0 rgba(255,255,255,0.09);
                        font-size:10.5px;font-weight:700;letter-spacing:0.13em;text-transform:uppercase;
                        padding:8px 18px;border-radius:50px;margin-bottom:1.75rem;
                        backdrop-filter:blur(10px)">
                    <span class="w-1.5 h-1.5 rounded-full" style="background:var(--gold)"></span>
                    {{ $badgeText }}
                </div>
            @endif

            {{-- Heading --}}
            <h1 class="h-anim-2 font-display font-bold text-white mb-5"
                style="font-size:clamp(2.6rem,5.5vw,4.5rem);line-height:1.06;letter-spacing:-0.025em">
                {!! nl2br(e($heading)) !!}
            </h1>

            {{-- Subheading --}}
            @if (filled($subheading))
                <p class="h-anim-3 text-white/60 leading-relaxed mb-10 {{ $isCentre ? 'mx-auto' : '' }}"
                    style="font-size:clamp(0.95rem,1.8vw,1.1rem);font-family:'Plus Jakarta Sans',sans-serif;max-width:520px">
                    {{ $subheading }}
                </p>
            @endif

            {{-- CTA Buttons --}}
            @if ($hasPrimary || $hasSecondary)
                <div
                    class="h-anim-4 flex flex-wrap gap-4 mb-14
                        {{ $isCentre ? 'justify-center' : '' }}">
                    @if ($hasPrimary)
                        <a href="{{ $hero->primary_button_url ?? '#' }}" class="btn-primary">
                            {{ $hero->primary_button_text }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    @endif
                    @if ($hasSecondary)
                        <a href="{{ $hero->secondary_button_url ?? '#' }}" class="btn-ghost-white">
                            {{ $hero->secondary_button_text }}
                        </a>
                    @endif
                </div>
            @endif

            {{-- Stats strip --}}
            @if ($hasStats)
                <div
                    class="h-anim-5 flex flex-wrap gap-3
                        {{ $isCentre ? 'justify-center' : '' }}">
                    @foreach ($hero->stats as $stat)
                        <div class="stat-card text-center min-w-[100px]">
                            <div class="stat-num">{{ $stat['value'] }}</div>
                            <div class="text-[10px] font-semibold uppercase tracking-wide mt-1.5"
                                style="color:rgba(255,255,255,0.45);font-family:'Plus Jakarta Sans',sans-serif">
                                {{ $stat['label'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>

    {{-- ── Slot for page-specific extras ─────────────────────────────── --}}
    {{ $slot ?? '' }}

</section>
