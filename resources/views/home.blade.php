@extends('layouts.app')
@section('title', \App\Models\SiteSetting::get('school_name', 'Sathya Sai Shiksha Sadan'))
@section('page_title', \App\Models\SiteSetting::get('school_tagline', 'Education in Human Values'))

@push('styles')
    <style>
        /* ══════════════════════════════════════════════════════════════
           HOME PAGE — Luxury Editorial
           Inherits design tokens from layouts/app.blade.php
        ══════════════════════════════════════════════════════════════ */

        /* ── Hero animations ─────────────────────────────────────────── */
        @keyframes hero-enter {
            from { opacity: 0; transform: translateY(22px) }
            to   { opacity: 1; transform: none }
        }
        @keyframes hero-badge {
            from { opacity: 0; transform: translateY(-10px) scale(.95) }
            to   { opacity: 1; transform: none }
        }
        @keyframes float-gentle {
            0%, 100% { transform: translateY(0) }
            50%       { transform: translateY(-8px) }
        }
        @keyframes shimmer-gold {
            from { background-position: -200% 0 }
            to   { background-position:  200% 0 }
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1) }
            50%       { opacity: .5; transform: scale(1.4) }
        }
        @keyframes bounce-y {
            0%, 100% { transform: translateY(0) }
            50%       { transform: translateY(7px) }
        }
        @keyframes shimmer {
            to { background-position: 200% center; }
        }
        @keyframes fade-up {
            from { opacity: 0; transform: translateY(20px) }
            to   { opacity: 1; transform: none }
        }
        @keyframes count-in {
            from { opacity: 0; transform: scale(0.8) }
            to   { opacity: 1; transform: scale(1) }
        }

        /* Staggered hero sequence */
        .h-anim-1 { animation: hero-badge .6s .05s both cubic-bezier(0.23, 1, 0.32, 1); }
        .h-anim-2 { animation: hero-enter .9s .15s both cubic-bezier(0.23, 1, 0.32, 1); }
        .h-anim-3 { animation: hero-enter .9s .32s both cubic-bezier(0.23, 1, 0.32, 1); }
        .h-anim-4 { animation: hero-enter .9s .48s both cubic-bezier(0.23, 1, 0.32, 1); }
        .h-anim-5 { animation: hero-enter .9s .64s both cubic-bezier(0.23, 1, 0.32, 1); }

        .float-badge { animation: float-gentle 4.5s ease-in-out infinite; }
        .float-card  { animation: float-gentle 5.5s 1.2s ease-in-out infinite; }
        .bounce      { animation: bounce-y 1.8s linear infinite; }

        /* ── Shimmer gold text ────────────────────────────────────────── */
        .text-shimmer {
            background: linear-gradient(90deg, #fff 0%, #C9A227 35%, #E2B93B 50%, #fff 65%, #fff 100%);
            background-size: 250% 100%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer-gold 4s linear infinite;
        }

        /* ── Hero pill ────────────────────────────────────────────────── */
        .hero-pill {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.14);
            backdrop-filter: blur(12px);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.88);
            font-size: 10.5px; font-weight: 700;
            letter-spacing: 0.13em; text-transform: uppercase;
            padding: 8px 18px; border-radius: 50px; margin-bottom: 2rem;
        }

        /* ── Stat card ────────────────────────────────────────────────── */
        .stat-card {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.09);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.08);
            backdrop-filter: blur(12px);
            border-radius: 16px; padding: 20px 24px;
            transition: background 0.22s var(--ease-out), border-color 0.22s var(--ease-out), transform 0.22s var(--ease-spring);
        }
        @media (hover: hover) and (pointer: fine) {
            .stat-card:hover { background: rgba(255,255,255,0.10); border-color: rgba(201,162,39,0.3); transform: translateY(-3px); }
        }
        .stat-num {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 2.5rem; font-weight: 700;
            color: var(--gold-light); line-height: 1;
        }

        /* ── Program cards ────────────────────────────────────────────── */
        .prog-card {
            position: relative; overflow: hidden; border-radius: 20px; cursor: pointer;
            transition: transform .35s var(--ease-spring), box-shadow .35s var(--ease-out);
        }
        .prog-card::after {
            content: ''; position: absolute; inset: 0; border-radius: 20px;
            border: 1.5px solid transparent;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0);
            transition: border-color .28s var(--ease-out), box-shadow .28s var(--ease-out);
            pointer-events: none;
        }
        @media (hover: hover) and (pointer: fine) {
            .prog-card:hover { transform: translateY(-8px); box-shadow: 0 32px 64px rgba(13,27,46,0.16); }
            .prog-card:hover::after { border-color: rgba(201,162,39,0.5); box-shadow: inset 0 1px 0 rgba(255,255,255,0.1); }
        }
        .prog-card:active { transform: translateY(-4px) scale(0.99); }
        .prog-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(180deg, transparent 30%, rgba(13,27,46,0.92) 100%);
        }

        /* ── Value items ──────────────────────────────────────────────── */
        .value-item {
            display: flex; align-items: flex-start; gap: 16px;
            padding: 14px 12px; border-radius: 14px; border: 1px solid transparent;
            transition: background .22s var(--ease-out), border-color .22s var(--ease-out), transform .22s var(--ease-out);
            cursor: default;
        }
        @media (hover: hover) and (pointer: fine) {
            .value-item:hover { background: rgba(201,162,39,0.05); border-color: rgba(201,162,39,0.15); transform: translateX(6px); }
            .value-item:hover .value-num { background: rgba(201,162,39,0.15); border-color: rgba(201,162,39,0.5); }
        }
        .value-num {
            width: 36px; height: 36px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Cormorant Garamond', serif; font-size: 1.1rem; font-weight: 700;
            color: var(--gold); flex-shrink: 0; margin-top: 1px;
            border: 1.5px solid rgba(201,162,39,0.3);
            background: rgba(201,162,39,0.07);
            transition: background .22s var(--ease-out), border-color .22s var(--ease-out);
        }

        /* ── Timeline ─────────────────────────────────────────────────── */
        .timeline-row { display: flex; gap: 20px; align-items: flex-start; }
        .timeline-dot {
            width: 11px; height: 11px; border-radius: 50%; background: var(--gold);
            flex-shrink: 0; margin-top: 5px;
            transition: transform .25s var(--ease-spring), box-shadow .25s ease;
        }
        @media (hover: hover) and (pointer: fine) {
            .timeline-row:hover .timeline-dot { transform: scale(1.5); box-shadow: 0 0 0 5px rgba(201,162,39,0.2); }
            .timeline-row:hover .timeline-text { color: var(--navy); }
        }
        .timeline-year { font-size: 11px; font-weight: 700; color: var(--gold); letter-spacing: 0.06em; font-family: 'Plus Jakarta Sans', sans-serif; }
        .timeline-text { font-size: 13.5px; color: var(--text-muted); line-height: 1.65; transition: color .18s var(--ease-out); }

        /* ── News cards ───────────────────────────────────────────────── */
        .news-card { overflow: hidden; border-radius: 20px; transition: transform .28s var(--ease-out), box-shadow .28s ease; }
        @media (hover: hover) and (pointer: fine) {
            .news-card:hover { transform: translateY(-6px); box-shadow: 0 24px 56px rgba(13,27,46,0.11); }
            .news-card:hover .img-wrap img { transform: scale(1.06); }
            .news-card:hover .news-title { color: var(--gold); }
        }
        .news-card:active { transform: translateY(-3px) scale(0.99); }
        .news-card .img-wrap { overflow: hidden; }
        .news-card .img-wrap img { transition: transform .55s var(--ease-out); }
        .news-title { transition: color .18s var(--ease-out); }

        /* ── Contact card ─────────────────────────────────────────────── */
        .contact-card {
            border: 1px solid rgba(13,27,46,0.08); border-radius: 20px;
            transition: transform .28s var(--ease-spring), box-shadow .28s ease, border-color .25s var(--ease-out);
        }
        @media (hover: hover) and (pointer: fine) {
            .contact-card:hover { transform: translateY(-5px); box-shadow: 0 20px 44px rgba(13,27,46,0.09); border-color: rgba(201,162,39,0.35); }
            .contact-card:hover .contact-icon { background: rgba(201,162,39,0.14); border-color: rgba(201,162,39,0.4); }
        }
        .contact-card:active { transform: translateY(-2px) scale(0.99); }
        .contact-icon {
            width: 44px; height: 44px; border-radius: 12px;
            background: rgba(201,162,39,0.08); border: 1px solid rgba(201,162,39,0.18);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 14px;
            transition: background .2s var(--ease-out), border-color .2s var(--ease-out);
        }

        /* ── CTA / Grand Banner ───────────────────────────────────────── */
        .grand-cta { position: relative; overflow: hidden; z-index: 1; }
        .cta-canvas { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; pointer-events: none; }

        /* ── Reveal on scroll ─────────────────────────────────────────── */
        .reveal {
            opacity: 0; transform: translateY(30px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }
        .reveal.active { opacity: 1; transform: translateY(0); }

        /* ── Gallery grid ─────────────────────────────────────────────── */
        .gallery-item {
            position: relative; overflow: hidden; border-radius: 16px; cursor: pointer;
            transition: transform .32s var(--ease-spring), box-shadow .32s var(--ease-out);
        }
        .gallery-item::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(180deg, transparent 50%, rgba(13,27,46,0.75) 100%);
            opacity: 0; transition: opacity .28s var(--ease-out);
        }
        @media (hover: hover) and (pointer: fine) {
            .gallery-item:hover { transform: translateY(-6px) scale(1.01); box-shadow: 0 28px 56px rgba(13,27,46,0.18); }
            .gallery-item:hover::after { opacity: 1; }
            .gallery-item:hover .gallery-overlay-text { opacity: 1; transform: translateY(0); }
            .gallery-item:hover img { transform: scale(1.08); }
        }
        .gallery-item img { transition: transform .55s var(--ease-out); width: 100%; height: 100%; object-fit: cover; }
        .gallery-overlay-text {
            position: absolute; bottom: 0; left: 0; right: 0; z-index: 2;
            padding: 16px 18px;
            opacity: 0; transform: translateY(8px);
            transition: opacity .28s var(--ease-out), transform .28s var(--ease-out);
        }

        /* ── Testimonial cards ────────────────────────────────────────── */
        .testi-card {
            border-radius: 20px; padding: 28px;
            border: 1px solid rgba(13,27,46,0.07);
            transition: transform .28s var(--ease-spring), box-shadow .28s ease, border-color .25s var(--ease-out);
        }
        @media (hover: hover) and (pointer: fine) {
            .testi-card:hover { transform: translateY(-6px); box-shadow: 0 24px 52px rgba(13,27,46,0.10); border-color: rgba(201,162,39,0.25); }
        }
        .testi-stars { color: var(--gold); font-size: 13px; letter-spacing: 1px; }
        .testi-quote {
            font-size: 28px; line-height: 1; color: var(--gold); opacity: 0.25;
            font-family: 'Cormorant Garamond', serif; font-weight: 700;
        }

        /* ── Events feed ──────────────────────────────────────────────── */
        .event-row {
            display: flex; gap: 20px; align-items: flex-start; padding: 18px 0;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            transition: background .2s var(--ease-out), padding-left .2s var(--ease-out);
            border-radius: 10px;
        }
        @media (hover: hover) and (pointer: fine) {
            .event-row:hover { background: rgba(255,255,255,0.04); padding-left: 10px; }
        }
        .event-date-box {
            min-width: 52px; text-align: center; border-radius: 12px; padding: 8px 6px;
            background: rgba(201,162,39,0.15); border: 1px solid rgba(201,162,39,0.25); flex-shrink: 0;
        }

        /* ── Admin-selected homepage templates ───────────────────────── */
        .home-template-compact { padding-top: 4rem !important; padding-bottom: 4rem !important; }
        .home-template-editorial .section-title { font-style: italic; }
        .home-template-editorial .gold-bar { width: 72px; }
        .home-template-feature { position: relative; isolation: isolate; }
        .home-template-feature::before {
            content: '';
            position: absolute;
            inset: 26px;
            border: 1px solid rgba(201,162,39,0.18);
            border-radius: 28px;
            pointer-events: none;
            z-index: -1;
        }
        .home-template-feature::after {
            content: '';
            position: absolute;
            right: 8%;
            bottom: -80px;
            width: 260px;
            height: 260px;
            border-radius: 999px;
            background: radial-gradient(circle, rgba(201,162,39,0.14), transparent 70%);
            pointer-events: none;
            z-index: -1;
        }
    </style>
@endpush

@section('content')

    @php
        // ── Block shortcuts (controller already passes these, but also resolve from $blocks for safety) ──
        $heroBlock     = $hero  ?? $blocks->firstWhere('type', 'hero');
        $aboutBlock    = $about ?? $blocks->firstWhere('type', 'about_intro');
        $statsBlock    = $stats ?? $blocks->firstWhere('type', 'stats');
        $ctaBlock      = $cta   ?? $blocks->firstWhere('type', 'cta_banner');
        $programsBlock = $blocks->firstWhere('type', 'programs');
        $valuesBlock   = $blocks->firstWhere('type', 'values');
        $legacyBlock   = $blocks->firstWhere('type', 'legacy');
        $newsBlock     = $blocks->firstWhere('type', 'news_feed');
        $eventsBlock   = $blocks->firstWhere('type', 'events_feed');
        $galleryBlock  = $blocks->firstWhere('type', 'gallery_preview');
        $testiBlock    = $blocks->firstWhere('type', 'testimonial_slider');
        $contactBlock  = $blocks->firstWhere('type', 'contact_strip');

        // Stats extra data
        $sd = $statsBlock ? ($statsBlock->extra ?? []) : [];
        $blockExtra = fn ($block, $key, $default = null) => data_get($block?->extra, $key, $default);
        $validCards = function ($value) {
            if (! is_array($value) || $value === []) return null;
            return collect($value)->every(fn ($item) => is_array($item) && data_get($item, 'title') && data_get($item, 'image'))
                ? $value
                : null;
        };
        $validValueItems = function ($value) {
            if (! is_array($value) || $value === []) return null;
            return collect($value)->every(fn ($item) => is_array($item) && data_get($item, 'title') && data_get($item, 'description'))
                ? $value
                : null;
        };
        $blockTemplateClass = function ($block) use ($blockExtra) {
            $template = preg_replace('/[^a-z0-9-]/', '', strtolower((string) $blockExtra($block, 'template', 'default')));
            return 'home-template-' . ($template ?: 'default');
        };
        $blockPadding = fn ($block) => match ($blockExtra($block, 'template', 'default')) {
            'compact' => 'py-16',
            'feature' => 'py-32',
            'editorial' => 'py-24',
            default => 'py-28',
        };

        // Years of excellence from settings or fallback
        $yearsOfExcellence = \App\Models\SiteSetting::get('established_year')
            ? date('Y') - intval(\App\Models\SiteSetting::get('established_year'))
            : '26';
        $statItems = [
            ['value' => $sd['students'] ?? '500+', 'label' => 'Students'],
            ['value' => $sd['teachers'] ?? '40+', 'label' => 'Teachers'],
            ['value' => $sd['years'] ?? $yearsOfExcellence . '+', 'label' => 'Years'],
            ['value' => $sd['programmes'] ?? '3', 'label' => 'Programmes'],
        ];
        if ($heroBlock) {
            $heroBlock->stats = ($statsBlock && $statsBlock->is_visible) ? $statItems : [];
        }

        $programCards = $validCards($blockExtra($programsBlock, 'cards')) ?: [
            ['title' => 'Primary Level', 'badge' => 'Grades 1-5', 'description' => 'Building strong foundations in core subjects with focus on holistic development.', 'color' => 'var(--gold)', 'image' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=700', 'url' => route('page.show','programs').'#primary'],
            ['title' => 'Middle School', 'badge' => 'Grades 6-8', 'description' => 'Guided transition years that strengthen confidence, curiosity, and independent study habits.', 'color' => 'var(--navy)', 'image' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=700', 'url' => route('page.show','programs').'#middle'],
            ['title' => 'Secondary Level', 'badge' => 'Grades 9-10', 'description' => 'Focused academic preparation with values, discipline, and examination readiness.', 'color' => 'var(--lotus-red)', 'image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=700', 'url' => route('page.show','programs').'#secondary'],
            ['title' => '+2 Science & Mgmt', 'badge' => 'Grades 11-12', 'description' => 'Specialised streams in Science and Management for confident future pathways.', 'color' => 'var(--gold-dark)', 'image' => 'https://images.unsplash.com/photo-1576319155264-99536e0be1ee?w=700', 'url' => route('page.show','programs').'#science'],
        ];
        $valueItems = $validValueItems($blockExtra($valuesBlock, 'items')) ?: [
            ['number' => '1', 'title' => 'Truth (Sathya)', 'description' => 'Honesty and integrity in thought, word, and deed'],
            ['number' => '2', 'title' => 'Right Conduct (Dharma)', 'description' => 'Moral and ethical behavior in all situations'],
            ['number' => '3', 'title' => 'Peace (Shanti)', 'description' => 'Inner harmony and calm disposition'],
            ['number' => '4', 'title' => 'Love (Prema)', 'description' => 'Compassion and selfless service to others'],
            ['number' => '5', 'title' => 'Non-Violence (Ahimsa)', 'description' => 'Respect for all life and peaceful coexistence'],
        ];
    @endphp

    {{-- ══════════════════════════════════════════════════════════════
     § 1 — HERO — handled by x-page-hero component (unchanged)
    ══════════════════════════════════════════════════════════════ --}}
    @if ($heroBlock)
        <x-page-hero :hero="$heroBlock">
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 bounce" aria-hidden="true">
                <svg class="w-5 h-5 text-white/25" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </x-page-hero>
    @endif

    @if (($homeSections ?? collect())->isNotEmpty())
        @foreach ($homeSections as $i => $section)
            @include('components.section-renderer', ['section' => $section, 'index' => $i])
        @endforeach
    @else

    {{-- ══════════════════════════════════════════════════════════════
     § 2 — ABOUT INTRO
    ══════════════════════════════════════════════════════════════ --}}
    @if ($aboutBlock && $aboutBlock->is_visible)
        <section class="{{ $blockPadding($aboutBlock) }} {{ $blockTemplateClass($aboutBlock) }}" style="background:{{ $blockExtra($aboutBlock, 'background', 'var(--cream)') }}">
            <div class="max-w-7xl mx-auto px-6 lg:px-10">
                <div class="grid lg:grid-cols-2 gap-20 items-center">

                    {{-- Text --}}
                    <div class="reveal from-left">
                        <div class="section-label" style="color:{{ $blockExtra($aboutBlock, 'accent', 'var(--gold)') }}">{{ $blockExtra($aboutBlock, 'section_label', 'Who We Are') }}</div>
                        <h2 class="section-title" style="color:{{ $blockExtra($aboutBlock, 'text_color', 'var(--navy)') }}">{{ $aboutBlock->title ?? 'About Our School' }}</h2>
                        <div class="gold-bar mt-4 mb-8" style="background:{{ $blockExtra($aboutBlock, 'accent', 'var(--gold)') }}"></div>
                        <div class="text-gray-500 text-[14.5px] leading-[1.85] space-y-4 mt-8"
                            style="font-family:'Plus Jakarta Sans',sans-serif">
                            {!! $aboutBlock->content ??
                                '<p>At Sathya Sai Shiksha Sadan, we believe that education extends beyond textbooks. Our mission is to nurture young minds with a perfect blend of academic excellence and human values, creating responsible citizens and future leaders.</p><br><p>From primary education through higher secondary (+2) levels, we provide a supportive environment where students develop intellectually, emotionally, and morally. Our dedicated faculty ensures every student receives personalized attention and guidance.</p>'
                            !!}
                        </div>
                        <div class="flex flex-wrap gap-4 mt-10">
                            <a href="{{ $aboutBlock->button_url ?: route('about') }}" class="btn-primary" style="background:{{ $blockExtra($aboutBlock, 'button_bg', 'var(--vivid-red)') }};color:{{ $blockExtra($aboutBlock, 'button_text_color', '#fff') }}">
                                {{ $aboutBlock->button_text ?: 'Our Story' }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                            <a href="{{ $blockExtra($aboutBlock, 'secondary_button_url', route('page.show', 'programs')) }}" class="btn-ghost">{{ $blockExtra($aboutBlock, 'secondary_button_text', 'View Programs') }}</a>
                        </div>
                    </div>

                    {{-- Image + floating badge --}}
                    <div class="reveal from-right relative">
                        <div class="img-zoom rounded-[24px] overflow-hidden shadow-[0_32px_80px_rgba(13,27,46,0.15)]" style="aspect-ratio:4/3">
                            @if ($aboutBlock->image_exists)
                                <img src="{{ $aboutBlock->image_url }}" alt="{{ \App\Models\SiteSetting::get('school_name') }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=800" alt="Students" class="w-full h-full object-cover">
                            @endif
                        </div>

                        <div class="float-badge absolute -bottom-6 -right-5 rounded-[20px] px-7 py-5 shadow-[0_20px_48px_rgba(201,162,39,0.35)] text-center"
                            style="background:linear-gradient(135deg,#C9A227,#A8841F)">
                            <div class="font-display font-bold text-white text-4xl leading-none" style="font-family:'Cormorant Garamond',serif">{{ $yearsOfExcellence }}+</div>
                            <div class="text-white/80 text-[11px] font-medium mt-1.5 tracking-wide uppercase" style="font-family:'Plus Jakarta Sans',sans-serif">Years of Excellence</div>
                        </div>

                        <div class="absolute -bottom-10 -left-10 w-32 h-32 rounded-2xl -z-10 opacity-50" style="background:var(--cream-mid)"></div>
                    </div>

                </div>
            </div>
        </section>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
     § 3 — ACADEMIC PROGRAMS
    ══════════════════════════════════════════════════════════════ --}}
    @if (!$programsBlock || $programsBlock->is_visible)
        <section class="{{ $blockPadding($programsBlock) }} {{ $blockTemplateClass($programsBlock) }}" style="background:{{ $blockExtra($programsBlock, 'background', '#fff') }}">
            <div class="max-w-7xl mx-auto px-6 lg:px-10">

                <div class="text-center mb-16 reveal">
                    <div class="section-label justify-center" style="color:{{ $blockExtra($programsBlock, 'accent', 'var(--gold)') }}">{{ $blockExtra($programsBlock, 'section_label', 'What We Offer') }}</div>
                    <h2 class="section-title" style="color:{{ $blockExtra($programsBlock, 'text_color', 'var(--navy)') }}">{{ $programsBlock?->title ?? 'Our Academic Programs' }}</h2>
                    <p class="text-sm mt-5 max-w-lg mx-auto leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif;color:{{ $blockExtra($programsBlock, 'muted_color', '#9CA3AF') }}">
                        {{ $programsBlock?->subtitle ?? 'Comprehensive education from foundation to specialisation, designed to unlock every student\'s potential.' }}
                    </p>
                </div>

                <div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-6 stagger">
                    @foreach ($programCards as $card)
                        @php
                            $title = data_get($card, 'title');
                            $badge = data_get($card, 'badge');
                            $desc = data_get($card, 'description');
                            $color = data_get($card, 'color', $blockExtra($programsBlock, 'accent', 'var(--gold)'));
                            $img = data_get($card, 'image');
                            $url = data_get($card, 'url', route('page.show', 'programs'));
                        @endphp
                        <a href="{{ $url }}" class="prog-card block group">
                            <div class="relative" style="aspect-ratio:3/4">
                                <img src="{{ $img }}" alt="{{ $title }}" class="absolute inset-0 w-full h-full object-cover">
                                <div class="prog-overlay"></div>
                                <div class="absolute top-5 left-5 text-[10.5px] font-bold px-3.5 py-1.5 rounded-full tracking-wide uppercase"
                                    style="background:{{ $color }};font-family:'Plus Jakarta Sans',sans-serif;color:{{ $color === 'var(--navy)' ? 'var(--gold)' : 'var(--navy)' }}">
                                    {{ $badge }}
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 p-7">
                                    <h3 class="font-display font-bold text-white text-2xl mb-2 leading-tight">{{ $title }}</h3>
                                    <p class="text-white/65 text-sm leading-relaxed mb-5" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $desc }}</p>
                                    <div class="flex items-center gap-2 font-semibold text-sm" style="color:var(--gold);font-family:'Plus Jakarta Sans',sans-serif">
                                        Explore
                                        <svg class="w-4 h-4 group-hover:translate-x-1.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

            </div>
        </section>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
     § 4 — FIVE HUMAN VALUES
    ══════════════════════════════════════════════════════════════ --}}
    @if (!$valuesBlock || $valuesBlock->is_visible)
        <section class="{{ $blockPadding($valuesBlock) }} {{ $blockTemplateClass($valuesBlock) }}" style="background:{{ $blockExtra($valuesBlock, 'background', 'var(--cream)') }}">
            <div class="max-w-7xl mx-auto px-6 lg:px-10">
                <div class="grid lg:grid-cols-2 gap-20 items-center">

                    <div class="reveal from-left order-2 lg:order-1">
                        <div class="img-zoom rounded-[24px] overflow-hidden shadow-[0_32px_80px_rgba(13,27,46,0.13)]" style="aspect-ratio:4/3">
                            @if ($valuesBlock?->image_exists)
                                <img src="{{ $valuesBlock->image_url }}" alt="Campus" class="w-full h-full object-cover">
                            @else
                                <img src="https://images.unsplash.com/photo-1562774053-701939374585?w=800" alt="Campus" class="w-full h-full object-cover">
                            @endif
                        </div>
                    </div>

                    <div class="reveal from-right order-1 lg:order-2">
                        <div class="section-label" style="color:{{ $blockExtra($valuesBlock, 'accent', 'var(--gold)') }}">{{ $blockExtra($valuesBlock, 'section_label', 'Our Philosophy') }}</div>
                        <h2 class="section-title mb-4" style="color:{{ $blockExtra($valuesBlock, 'text_color', 'var(--navy)') }}">{{ $valuesBlock?->title ?? 'Five Human Values' }}</h2>
                        <div class="gold-bar mb-8"></div>
                        <p class="text-sm leading-[1.85] mb-8 max-w-md mt-8" style="font-family:'Plus Jakarta Sans',sans-serif;color:{{ $blockExtra($valuesBlock, 'muted_color', '#6B7280') }}">
                            {{ $valuesBlock?->subtitle ?? 'Our educational philosophy is built on five pillars that shape character and guide every student\'s growth:' }}
                        </p>

                        <div class="space-y-1">
                            @foreach ($valueItems as $item)
                                <div class="value-item">
                                    <div class="value-num" style="color:{{ $blockExtra($valuesBlock, 'accent', 'var(--gold)') }}">{{ data_get($item, 'number') }}</div>
                                    <div>
                                        <h4 class="font-semibold text-[14.5px]" style="color:{{ $blockExtra($valuesBlock, 'text_color', 'var(--navy)') }};font-family:'Plus Jakarta Sans',sans-serif">{{ data_get($item, 'title') }}</h4>
                                        <p class="text-gray-400 text-[12.5px] mt-0.5 leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif">{{ data_get($item, 'description') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </section>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
     § 5 — LEGACY / TIMELINE
    ══════════════════════════════════════════════════════════════ --}}
    @if (!$legacyBlock || $legacyBlock->is_visible)
        @php
            $timelineEntries = $legacyBlock?->extra['timeline'] ?? [
                ['year' => '2000', 'text' => 'Sathya Sai Shiksha Sadan established with a vision of value-based education'],
                ['year' => '2005', 'text' => 'Expanded to secondary level — welcoming students up to Grade 10'],
                ['year' => '2010', 'text' => '+2 Science stream introduced for Grades 11 & 12'],
                ['year' => '2015', 'text' => '+2 Management stream launched to serve aspiring business leaders'],
                ['year' => '2026', 'text' => '26 proud years of nurturing excellence and human values'],
            ];
        @endphp
        <section class="{{ $blockPadding($legacyBlock) }} {{ $blockTemplateClass($legacyBlock) }}" style="background:{{ $blockExtra($legacyBlock, 'background', '#fff') }}">
            <div class="max-w-7xl mx-auto px-6 lg:px-10">
                <div class="grid lg:grid-cols-2 gap-20 items-center">

                    <div class="reveal from-left">
                        <div class="inline-flex items-center gap-2 text-[11px] font-bold px-4 py-2 rounded-full mb-7 tracking-wide uppercase border"
                            style="background:rgba(201,162,39,0.08);color:{{ $blockExtra($legacyBlock, 'accent', 'var(--gold)') }};border-color:rgba(201,162,39,0.22);font-family:'Plus Jakarta Sans',sans-serif">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $blockExtra($legacyBlock, 'section_label', 'Our Story') }}
                        </div>
                        <h2 class="section-title mb-4" style="color:{{ $blockExtra($legacyBlock, 'text_color', 'var(--navy)') }}">{{ $legacyBlock?->title ?? 'A Legacy of Excellence' }}</h2>
                        <div class="gold-bar mb-8"></div>
                        <p class="text-gray-500 leading-[1.85] mb-10 text-[14.5px] mt-8 max-w-md" style="font-family:'Plus Jakarta Sans',sans-serif">
                            {{ $legacyBlock?->content ?? 'Since our founding in 2000, Sathya Sai Shiksha Sadan has been a beacon of value-based education. What began as a small institution with a big vision has grown into a comprehensive school serving hundreds of students from Grade 1 to +2.' }}
                        </p>

                        <div class="relative space-y-5">
                            <div class="absolute left-[4.5px] top-3 bottom-3 w-px"
                                style="background:linear-gradient(180deg,var(--gold) 0%,rgba(201,162,39,0.2) 85%,transparent 100%)">
                            </div>
                            @foreach ($timelineEntries as $entry)
                                <div class="timeline-row pl-1.5 group cursor-default">
                                    <div class="timeline-dot"></div>
                                    <div>
                                        <span class="timeline-year block mb-1">{{ $entry['year'] }}</span>
                                        <p class="timeline-text">{{ $entry['text'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="reveal from-right relative">
                        <div class="img-zoom rounded-[24px] overflow-hidden shadow-[0_32px_80px_rgba(13,27,46,0.14)]" style="aspect-ratio:4/3">
                            @if ($legacyBlock?->image_exists)
                                <img src="{{ $legacyBlock->image_url }}" alt="School building" class="w-full h-full object-cover">
                            @elseif ($aboutBlock?->image_exists)
                                <img src="{{ $aboutBlock->image_url }}" alt="{{ \App\Models\SiteSetting::get('school_name') }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://images.unsplash.com/photo-1607827448387-a67db1383b93?w=800" alt="School building" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="float-card absolute bottom-6 right-6 rounded-[18px] px-6 py-4 text-center border border-white/10"
                            style="background:rgba(13,27,46,0.88);backdrop-filter:blur(14px);box-shadow:inset 0 1px 0 rgba(255,255,255,0.08)">
                            <div class="font-display font-bold text-4xl leading-none" style="color:var(--gold-light);font-family:'Cormorant Garamond',serif">{{ $yearsOfExcellence }}+</div>
                            <div class="text-white/50 text-[11px] mt-1.5 tracking-wide uppercase" style="font-family:'Plus Jakarta Sans',sans-serif">Years of Excellence</div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
     § 6 — GALLERY PREVIEW
    ══════════════════════════════════════════════════════════════ --}}
    @if ((!$galleryBlock || $galleryBlock->is_visible) && isset($galleryAlbums) && $galleryAlbums->count())
        <section class="{{ $blockPadding($galleryBlock) }} {{ $blockTemplateClass($galleryBlock) }}" style="background:{{ $blockExtra($galleryBlock, 'background', 'var(--cream)') }}">
            <div class="max-w-7xl mx-auto px-6 lg:px-10">

                <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-14 reveal">
                    <div>
                        <div class="section-label" style="color:{{ $blockExtra($galleryBlock, 'accent', 'var(--gold)') }}">{{ $blockExtra($galleryBlock, 'section_label', 'Campus Life') }}</div>
                        <h2 class="section-title mt-1" style="color:{{ $blockExtra($galleryBlock, 'text_color', 'var(--navy)') }}">{{ $galleryBlock?->title ?? 'Our Gallery' }}</h2>
                        <div class="gold-bar mt-4"></div>
                    </div>
                    <a href="{{ route('gallery.index') }}"
                        class="group mt-6 sm:mt-0 flex items-center gap-2 text-sm font-bold hover:text-navy transition-colors"
                        style="color:var(--navy);opacity:.6;transition-timing-function:var(--ease-out)">
                        {{ $galleryBlock?->button_text ?? 'View Gallery' }}
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>

                {{-- Masonry-style 4-up grid --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 stagger">
                    @foreach ($galleryAlbums->take(4) as $album)
                        <a href="{{ route('gallery.show', $album->id) }}"
                            class="gallery-item {{ $loop->first ? 'row-span-2 md:col-span-2' : '' }}"
                            style="{{ $loop->first ? 'aspect-ratio:1/1' : 'aspect-ratio:4/3' }}">
                            @if ($album->cover_url ?? null)
                                <img src="{{ $album->cover_url }}" alt="{{ $album->name }}">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-navy/20 to-navy/5 flex items-center justify-center">
                                    <svg class="w-10 h-10 text-navy/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="gallery-overlay-text">
                                <p class="text-white font-bold text-sm leading-tight" style="font-family:'Plus Jakarta Sans',sans-serif">
                                    {{ $album->name }}
                                </p>
                                @if ($album->images_count)
                                    <p class="text-white/60 text-[11px] mt-0.5">{{ $album->images_count }} photos</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>

            </div>
        </section>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
     § 7 — TESTIMONIALS
    ══════════════════════════════════════════════════════════════ --}}
    @if ((!$testiBlock || $testiBlock->is_visible) && isset($testimonials) && $testimonials->count())
        <section class="{{ $blockPadding($testiBlock) }} {{ $blockTemplateClass($testiBlock) }}" style="background:{{ $blockExtra($testiBlock, 'background', '#fff') }}">
            <div class="max-w-7xl mx-auto px-6 lg:px-10">

                <div class="text-center mb-16 reveal">
                    <div class="section-label justify-center" style="color:{{ $blockExtra($testiBlock, 'accent', 'var(--gold)') }}">{{ $blockExtra($testiBlock, 'section_label', 'Voices') }}</div>
                    <h2 class="section-title" style="color:{{ $blockExtra($testiBlock, 'text_color', 'var(--navy)') }}">{{ $testiBlock?->title ?? 'What Parents & Alumni Say' }}</h2>
                    <div class="gold-bar mx-auto mt-4"></div>
                </div>

                <div class="grid md:grid-cols-3 gap-6 stagger">
                    @foreach ($testimonials->take(3) as $t)
                        <div class="testi-card" style="background:{{ $blockExtra($testiBlock, 'card_bg', 'var(--cream)') }}">
                            <div class="testi-quote mb-3">"</div>
                            <p class="text-gray-500 text-[13.5px] leading-[1.85] mb-6" style="font-family:'Plus Jakarta Sans',sans-serif">
                                {{ $t->content ?? $t->message ?? $t->body }}
                            </p>
                            <div class="testi-stars mb-4">
                                @for ($s = 0; $s < ($t->rating ?? 5); $s++) ★ @endfor
                            </div>
                            <div class="flex items-center gap-3 pt-4 border-t border-navy/6">
                                @if ($t->avatar_url ?? $t->image_url ?? null)
                                    <img src="{{ $t->avatar_url ?? $t->image_url }}" alt="{{ $t->name }}"
                                        class="w-10 h-10 rounded-full object-cover border-2 border-gold/20">
                                @else
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white text-sm shrink-0"
                                        style="background:var(--gold)">
                                        {{ strtoupper(substr($t->name ?? 'P', 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="font-bold text-[13px]" style="color:var(--navy);font-family:'Plus Jakarta Sans',sans-serif">{{ $t->name }}</p>
                                    @if ($t->role ?? $t->designation ?? null)
                                        <p class="text-[11px] text-gray-400" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $t->role ?? $t->designation }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
     § 8 — UPCOMING EVENTS
    ══════════════════════════════════════════════════════════════ --}}
    @if ((!$eventsBlock || $eventsBlock->is_visible) && isset($upcomingEvents) && $upcomingEvents->count())
        <section class="{{ $blockPadding($eventsBlock) }} {{ $blockTemplateClass($eventsBlock) }}" style="background:{{ $blockExtra($eventsBlock, 'background', '#0d1b2e') }}">
            <div class="max-w-7xl mx-auto px-6 lg:px-10">
                <div class="grid lg:grid-cols-2 gap-16 items-start">

                    <div class="reveal from-left">
                        <div class="inline-flex items-center gap-2 text-[11px] font-bold px-4 py-2 rounded-full mb-7 tracking-wide uppercase border"
                            style="background:rgba(201,162,39,0.1);color:{{ $blockExtra($eventsBlock, 'accent', 'var(--gold)') }};border-color:rgba(201,162,39,0.25);font-family:'Plus Jakarta Sans',sans-serif">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zM4 8h12v8H4V8z"/>
                            </svg>
                            {{ $blockExtra($eventsBlock, 'section_label', "What's Coming") }}
                        </div>
                        <h2 class="section-title mb-4" style="color:#fff">{{ $eventsBlock?->title ?? 'Upcoming Events' }}</h2>
                        <div class="gold-bar mb-8"></div>
                        <p class="text-[14px] leading-relaxed mt-8 mb-10 max-w-sm" style="font-family:'Plus Jakarta Sans',sans-serif;color:{{ $blockExtra($eventsBlock, 'muted_color', 'rgba(255,255,255,0.4)') }}">
                            {{ $eventsBlock?->subtitle ?: 'Stay connected with school life. Join us for these upcoming events and activities.' }}
                        </p>
                        <a href="{{ $eventsBlock?->button_url ?: route('events.index') }}" class="btn-primary" style="background:{{ $blockExtra($eventsBlock, 'button_bg', 'var(--vivid-red)') }};color:{{ $blockExtra($eventsBlock, 'button_text_color', '#fff') }}">
                            {{ $eventsBlock?->button_text ?? 'View All Events' }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>

                    <div class="reveal from-right">
                        <div class="space-y-0">
                            @foreach ($upcomingEvents->take(4) as $event)
                                <div class="event-row">
                                    <div class="event-date-box">
                                        <div class="text-[11px] font-bold uppercase tracking-wide" style="color:var(--gold);font-family:'Plus Jakarta Sans',sans-serif">
                                            {{ $event->start_date->format('M') }}
                                        </div>
                                        <div class="font-display font-bold text-2xl leading-tight text-white" style="font-family:'Cormorant Garamond',serif">
                                            {{ $event->start_date->format('d') }}
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-bold text-white text-[14px] leading-snug mb-1" style="font-family:'Plus Jakarta Sans',sans-serif">
                                            <a href="{{ route('events.show', $event->slug ?? $event->id) }}" class="hover:text-gold transition-colors" style="transition-timing-function:var(--ease-out)">
                                                {{ $event->title }}
                                            </a>
                                        </h4>
                                        @if ($event->location ?? null)
                                            <p class="text-white/40 text-[12px] flex items-center gap-1.5" style="font-family:'Plus Jakarta Sans',sans-serif">
                                                <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                </svg>
                                                {{ $event->location }}
                                            </p>
                                        @endif
                                        @if ($event->excerpt ?? $event->description ?? null)
                                            <p class="text-white/30 text-[12px] mt-1 leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif">
                                                {{ Str::limit($event->excerpt ?? $event->description, 80) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </section>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
     § 9 — LATEST NEWS
    ══════════════════════════════════════════════════════════════ --}}
    @if ((!$newsBlock || $newsBlock->is_visible) && isset($latestNews) && $latestNews->count())
        <section class="{{ $blockPadding($newsBlock) }} {{ $blockTemplateClass($newsBlock) }}" style="background:{{ $blockExtra($newsBlock, 'background', 'var(--cream)') }}">
            <div class="max-w-7xl mx-auto px-6 lg:px-10">

                <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-16 reveal">
                    <div>
                        <div class="section-label" style="color:{{ $blockExtra($newsBlock, 'accent', 'var(--gold)') }}">{{ $blockExtra($newsBlock, 'section_label', $newsBlock?->subtitle ?? 'Stay Informed') }}</div>
                        <h2 class="section-title mt-1" style="color:{{ $blockExtra($newsBlock, 'text_color', 'var(--navy)') }}">{{ $newsBlock?->title ?? 'Latest News & Updates' }}</h2>
                        <div class="gold-bar mt-4"></div>
                    </div>
                    <a href="{{ $newsBlock?->button_url ?: route('news.index') }}"
                        class="group mt-6 sm:mt-0 flex items-center gap-2 text-sm font-bold text-navy/60 hover:text-navy transition-colors"
                        style="transition-timing-function:var(--ease-out)">
                        {{ $newsBlock?->button_text ?? 'View All' }}
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>

                <div class="grid md:grid-cols-3 gap-7 stagger">
                    @foreach ($latestNews as $post)
                        @php
                            $catColors = ['Achievement' => '#D97706', 'Campus News' => '#1a237e', 'Student Success' => '#DC2626'];
                            $catColor  = $catColors[$post->category] ?? '#6B7A8D';
                        @endphp
                        <article class="news-card bg-white flex flex-col shadow-[0_4px_24px_rgba(13,27,46,0.06)] border border-navy/6">
                            <a href="{{ route('news.show', $post->slug) }}" class="block aspect-video img-wrap">
                                <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                            </a>
                            <div class="p-6 flex flex-col flex-1">
                                @if ($post->category)
                                    <div class="flex items-center gap-2 mb-4">
                                        <span class="w-2 h-2 rounded-full" style="background:{{ $catColor }}"></span>
                                        <span class="text-[11px] font-bold tracking-wide uppercase"
                                            style="color:{{ $catColor }};font-family:'Plus Jakarta Sans',sans-serif">{{ $post->category }}</span>
                                    </div>
                                @endif
                                <h3 class="news-title font-display font-bold text-navy text-xl mb-3 leading-snug flex-1">
                                    <a href="{{ route('news.show', $post->slug) }}">{{ $post->title }}</a>
                                </h3>
                                @if ($post->excerpt)
                                    <p class="text-gray-400 text-[13px] leading-relaxed mb-4" style="font-family:'Plus Jakarta Sans',sans-serif">
                                        {{ Str::limit($post->excerpt, 100) }}
                                    </p>
                                @endif
                                <div class="flex items-center justify-between pt-4 mt-auto border-t border-navy/5">
                                    <span class="text-[11.5px] text-gray-400" style="font-family:'Plus Jakarta Sans',sans-serif">
                                        {{ $post->published_at->format('d M Y') }}
                                    </span>
                                    <a href="{{ route('news.show', $post->slug) }}"
                                        class="flex items-center gap-1 text-[12.5px] font-semibold hover:underline"
                                        style="color:var(--gold);font-family:'Plus Jakarta Sans',sans-serif">
                                        Read
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

            </div>
        </section>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
     § 10 — GET IN TOUCH
    ══════════════════════════════════════════════════════════════ --}}
    @if (!$contactBlock || $contactBlock->is_visible)
        @php
            $contactCards = $blockExtra($contactBlock, 'cards', [
                ['title' => 'Call Us', 'value' => \App\Models\SiteSetting::get('phone', '+977-1-XXXXXXX'), 'sub' => 'Mon-Fri, 8 AM - 4 PM', 'href' => 'tel:' . \App\Models\SiteSetting::get('phone', '')],
                ['title' => 'Email Us', 'value' => \App\Models\SiteSetting::get('email', 'info@school.edu'), 'sub' => 'We reply within 24 hours', 'href' => 'mailto:' . \App\Models\SiteSetting::get('email', '')],
                ['title' => 'Visit Us', 'value' => \App\Models\SiteSetting::get('address', 'Nepal'), 'sub' => '', 'href' => null],
            ]);
        @endphp
        <section class="{{ $blockPadding($contactBlock) }} {{ $blockTemplateClass($contactBlock) }}" style="background:{{ $blockExtra($contactBlock, 'background', '#fff') }}">
            <div class="max-w-7xl mx-auto px-6 lg:px-10 text-center">

                <div class="reveal">
                    <div class="section-label justify-center" style="color:{{ $blockExtra($contactBlock, 'accent', 'var(--gold)') }}">{{ $blockExtra($contactBlock, 'section_label', 'Reach Out') }}</div>
                    <h2 class="section-title" style="color:{{ $blockExtra($contactBlock, 'text_color', 'var(--navy)') }}">{{ $contactBlock?->title ?? 'Get in Touch' }}</h2>
                    <div class="gold-bar mx-auto mt-4 mb-5"></div>
                    <p class="text-sm mt-7 mb-14 max-w-md mx-auto leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif;color:{{ $blockExtra($contactBlock, 'muted_color', '#9CA3AF') }}">
                        {{ $contactBlock?->subtitle ?? 'We\'d love to hear from you. Reach out to our team for admissions, enquiries, or campus visits.' }}
                    </p>
                </div>

                <div class="grid sm:grid-cols-3 gap-5 max-w-3xl mx-auto mb-12 stagger">
                    @foreach ($contactCards as $contact)
                        <div class="contact-card p-8 text-center" style="background:{{ $blockExtra($contactBlock, 'card_bg', 'var(--cream)') }}">
                            <div class="contact-icon" style="color:{{ $blockExtra($contactBlock, 'accent', 'var(--gold)') }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <h4 class="font-display font-bold text-navy text-lg mb-2">{{ data_get($contact, 'title') }}</h4>
                            @if (data_get($contact, 'href'))
                                <a href="{{ data_get($contact, 'href') }}" class="text-gray-400 text-[13px] hover:text-navy transition-colors block"
                                    style="font-family:'Plus Jakarta Sans',sans-serif">{{ data_get($contact, 'value') }}</a>
                            @else
                                <p class="text-gray-400 text-[13px]" style="font-family:'Plus Jakarta Sans',sans-serif">{{ data_get($contact, 'value') }}</p>
                            @endif
                            @if (data_get($contact, 'sub'))
                                <p class="text-gray-300 text-[11.5px] mt-1" style="font-family:'Plus Jakarta Sans',sans-serif">{{ data_get($contact, 'sub') }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="reveal">
                    <a href="{{ $contactBlock?->button_url ?: route('contact.index') }}" class="btn-primary" style="background:{{ $blockExtra($contactBlock, 'button_bg', 'var(--vivid-red)') }};color:{{ $blockExtra($contactBlock, 'button_text_color', '#fff') }}">
                        {{ $contactBlock?->button_text ?? 'Contact Us' }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>

            </div>
        </section>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
     § 11 — JOIN US CTA BANNER (unchanged design)
    ══════════════════════════════════════════════════════════════ --}}
    @if (!$ctaBlock || $ctaBlock->is_visible)
        <section class="grand-cta {{ $blockPadding($ctaBlock) }} {{ $blockTemplateClass($ctaBlock) }} text-center"
            data-particle-1="{{ $blockExtra($ctaBlock, 'particle_1', 'rgba(255,255,255,0.1)') }}"
            data-particle-2="{{ $blockExtra($ctaBlock, 'particle_2', 'rgba(201,162,39,0.4)') }}"
            style="background:{{ $blockExtra($ctaBlock, 'background', '#111a30') }}">
            {{-- Decorative rings --}}
            <div class="absolute -top-24 -left-24 w-96 h-96 border rounded-full pointer-events-none" style="border-color:rgba(255,255,255,0.04)"></div>
            <div class="absolute -bottom-24 -right-24 w-[500px] h-[500px] border rounded-full pointer-events-none" style="border-color:rgba(201,162,39,0.07)"></div>

            <div class="relative max-w-2xl mx-auto px-4 reveal">
                <div class="section-label justify-center" style="color:{{ $blockExtra($ctaBlock, 'accent', 'rgba(201,162,39,0.8)') }}">{{ $blockExtra($ctaBlock, 'section_label', 'Join Our Community') }}</div>
                <h2 class="font-display font-bold leading-tight mb-3 mt-2" style="font-size:clamp(2.2rem,5vw,4rem)">
                    <span class="text-shimmer">{{ $ctaBlock?->title ?? 'Join Our Learning Community' }}</span>
                </h2>
                <p class="mb-12 leading-relaxed text-[15px]" style="font-family:'Plus Jakarta Sans',sans-serif;color:{{ $blockExtra($ctaBlock, 'muted_color', 'rgba(255,255,255,0.5)') }}">
                    {{ $ctaBlock?->subtitle ?? 'Give your child the gift of quality education grounded in human values. Admissions are now open!' }}
                </p>
                <div class="flex flex-wrap gap-4 justify-center">
                    <a href="{{ $ctaBlock?->button_url ?? route('admissions.index') }}" class="btn-primary" style="background:{{ $blockExtra($ctaBlock, 'button_bg', 'var(--vivid-red)') }};color:{{ $blockExtra($ctaBlock, 'button_text_color', '#fff') }}">
                        {{ $ctaBlock?->button_text ?? 'Apply Now' }}
                    </a>
                    <a href="{{ $blockExtra($ctaBlock, 'secondary_button_url', route('contact.index')) }}" class="btn-ghost-white">{{ $blockExtra($ctaBlock, 'secondary_button_text', 'Learn More') }}</a>
                </div>
            </div>
        </section>
    @endif

    @endif

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // ── Page fade-in ────────────────────────────────────────────
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.35s cubic-bezier(0.23,1,0.32,1)';
            requestAnimationFrame(() => requestAnimationFrame(() => { document.body.style.opacity = '1'; }));

            // ── Tactile press feedback ──────────────────────────────────
            document.querySelectorAll('.prog-card, .news-card, .contact-card, .stat-card, .testi-card, .gallery-item').forEach(el => {
                el.addEventListener('mousedown', () => el.style.transition = 'transform 0.1s var(--ease-out)');
                el.addEventListener('mouseup',   () => el.style.transition = '');
            });

            // ── Scroll reveal (IntersectionObserver) ────────────────────
            const revealObs = new IntersectionObserver((entries) => {
                entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('active'); revealObs.unobserve(e.target); } });
            }, { threshold: 0.1 });
            document.querySelectorAll('.reveal').forEach(el => revealObs.observe(el));

            // ── Stagger children of .stagger containers ─────────────────
            document.querySelectorAll('.stagger').forEach(container => {
                Array.from(container.children).forEach((child, i) => {
                    child.style.opacity    = '0';
                    child.style.transform  = 'translateY(24px)';
                    child.style.transition = `opacity 0.6s ${i * 0.1}s ease-out, transform 0.6s ${i * 0.1}s ease-out`;
                });
                const staggerObs = new IntersectionObserver((entries) => {
                    entries.forEach(e => {
                        if (e.isIntersecting) {
                            Array.from(e.target.children).forEach(child => {
                                child.style.opacity   = '1';
                                child.style.transform = 'none';
                            });
                            staggerObs.unobserve(e.target);
                        }
                    });
                }, { threshold: 0.1 });
                staggerObs.observe(container);
            });

            // ── CTA particle canvas ─────────────────────────────────────
            document.querySelectorAll('.grand-cta').forEach(section => {
                const canvas = document.createElement('canvas');
                canvas.className = 'cta-canvas';
                section.prepend(canvas);
                const ctx = canvas.getContext('2d');
                const primaryColor   = section.getAttribute('data-particle-1') || 'rgba(255,255,255,0.2)';
                const secondaryColor = section.getAttribute('data-particle-2') || 'rgba(201,162,39,0.3)';

                const resize = () => { canvas.width = section.offsetWidth; canvas.height = section.offsetHeight; };
                window.addEventListener('resize', resize);
                resize();

                const particles = Array.from({ length: 40 }, () => {
                    const p = {};
                    const init = () => {
                        p.x      = Math.random() * canvas.width;
                        p.y      = Math.random() * canvas.height;
                        p.size   = Math.random() * 3 + 1;
                        p.speedX = (Math.random() - 0.5) * 0.5;
                        p.speedY = (Math.random() - 0.5) * 0.5;
                        p.color  = Math.random() > 0.5 ? primaryColor : secondaryColor;
                    };
                    p.update = () => {
                        p.x += p.speedX; p.y += p.speedY;
                        if (p.x < 0 || p.x > canvas.width || p.y < 0 || p.y > canvas.height) init();
                    };
                    p.draw = () => { ctx.fillStyle = p.color; ctx.beginPath(); ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2); ctx.fill(); };
                    init();
                    return p;
                });

                const animate = () => {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    particles.forEach(p => { p.update(); p.draw(); });
                    requestAnimationFrame(animate);
                };
                animate();
            });

            // ── Stat counters (animate numbers up) ─────────────────────
            const counterEls = document.querySelectorAll('[data-count]');
            if (counterEls.length) {
                const countObs = new IntersectionObserver((entries) => {
                    entries.forEach(e => {
                        if (!e.isIntersecting) return;
                        const el     = e.target;
                        const target = parseFloat(el.getAttribute('data-count'));
                        const suffix = el.getAttribute('data-suffix') || '';
                        const dur    = 1400;
                        const start  = performance.now();
                        const tick   = (now) => {
                            const progress = Math.min((now - start) / dur, 1);
                            const eased    = 1 - Math.pow(1 - progress, 3);
                            el.textContent = Math.round(target * eased) + suffix;
                            if (progress < 1) requestAnimationFrame(tick);
                        };
                        requestAnimationFrame(tick);
                        countObs.unobserve(el);
                    });
                }, { threshold: 0.5 });
                counterEls.forEach(el => countObs.observe(el));
            }
        });
    </script>
@endpush
