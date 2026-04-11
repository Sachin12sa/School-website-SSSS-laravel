@extends('layouts.app')
@section('title', \App\Models\SiteSetting::get('school_name', 'Sathya Sai Shiksha Sadan'))
@section('page_title', \App\Models\SiteSetting::get('school_tagline', 'Education in Human Values'))

@push('styles')
    <style>
        /* ── Scroll reveal ──────────────────────────────────────────────────────── */
        .reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        .reveal.from-left {
            transform: translateX(-40px);
        }

        .reveal.from-right {
            transform: translateX(40px);
        }

        .reveal.visible {
            opacity: 1;
            transform: translate(0);
        }

        /* staggered children */
        .stagger>* {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity .6s ease, transform .6s ease;
        }

        .stagger.visible>*:nth-child(1) {
            opacity: 1;
            transform: none;
            transition-delay: .05s;
        }

        .stagger.visible>*:nth-child(2) {
            opacity: 1;
            transform: none;
            transition-delay: .15s;
        }

        .stagger.visible>*:nth-child(3) {
            opacity: 1;
            transform: none;
            transition-delay: .25s;
        }

        .stagger.visible>*:nth-child(4) {
            opacity: 1;
            transform: none;
            transition-delay: .35s;
        }

        .stagger.visible>*:nth-child(5) {
            opacity: 1;
            transform: none;
            transition-delay: .45s;
        }

        .stagger.visible>*:nth-child(6) {
            opacity: 1;
            transform: none;
            transition-delay: .55s;
        }

        /* ── Hero ───────────────────────────────────────────────────────────────── */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0)
            }

            50% {
                transform: translateY(-10px)
            }
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(1);
                opacity: .4
            }

            100% {
                transform: scale(1.5);
                opacity: 0
            }
        }

        @keyframes hero-text {
            from {
                opacity: 0;
                transform: translateY(24px)
            }

            to {
                opacity: 1;
                transform: none
            }
        }

        @keyframes shimmer {
            from {
                background-position: -200% 0
            }

            to {
                background-position: 200% 0
            }
        }

        @keyframes count-up {
            from {
                opacity: 0;
                transform: translateY(12px)
            }

            to {
                opacity: 1;
                transform: none
            }
        }

        .hero-text-1 {
            animation: hero-text .8s .2s both ease;
        }

        .hero-text-2 {
            animation: hero-text .8s .45s both ease;
        }

        .hero-text-3 {
            animation: hero-text .8s .65s both ease;
        }

        .hero-btn {
            animation: hero-text .8s .85s both ease;
        }

        .float-badge {
            animation: float 4s ease-in-out infinite;
        }

        /* Pulse ring around stat numbers */
        .stat-ring {
            position: relative;
        }

        .stat-ring::before {
            content: '';
            position: absolute;
            inset: -8px;
            border-radius: 50%;
            border: 2px solid #C9A227;
            animation: pulse-ring 2.5s ease-out infinite;
        }

        /* ── Card hover effects ──────────────────────────────────────────────────── */
        .prog-card {
            transition: transform .3s ease, box-shadow .3s ease;
            position: relative;
            overflow: hidden;
        }

        .prog-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #C9A227, #e0b830);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .3s ease;
        }

        .prog-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 24px 48px rgba(27, 42, 74, .13);
        }

        .prog-card:hover::after {
            transform: scaleX(1);
        }

        .news-card {
            transition: transform .3s ease, box-shadow .3s ease;
            position: relative;
            overflow: hidden;
        }

        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(27, 42, 74, .11);
        }

        .news-card .img-wrap img {
            transition: transform .5s ease;
        }

        .news-card:hover .img-wrap img {
            transform: scale(1.06);
        }

        .contact-card {
            transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
            border: 1px solid #e5e7eb;
        }

        .contact-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 32px rgba(27, 42, 74, .10);
            border-color: #C9A227;
        }

        /* ── Value list items ────────────────────────────────────────────────────── */
        .value-item {
            transition: transform .25s ease, background .25s ease;
            border-radius: 12px;
            padding: 10px 12px;
            cursor: default;
        }

        .value-item:hover {
            transform: translateX(6px);
            background: rgba(201, 162, 39, .06);
        }

        /* ── Timeline dot ────────────────────────────────────────────────────────── */
        .timeline-item {
            position: relative;
        }

        .timeline-item .dot {
            width: 12px;
            height: 12px;
            background: #C9A227;
            border-radius: 50%;
            flex-shrink: 0;
            margin-top: 4px;
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .timeline-item:hover .dot {
            transform: scale(1.4);
            box-shadow: 0 0 0 4px rgba(201, 162, 39, .25);
        }

        .timeline-item:hover p {
            color: #1B2A4A;
            font-weight: 500;
        }

        /* ── Gold shimmer on CTA heading ─────────────────────────────────────────── */
        .shimmer-text {
            background: linear-gradient(90deg, #fff 0%, #C9A227 40%, #fff 60%, #fff 100%);
            background-size: 200% 100%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 3.5s linear infinite;
        }

        /* ── Section heading gold underline animate ───────────────────────────────── */
        .gold-line {
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, #C9A227, #e0b830);
            border-radius: 2px;
            transition: width .6s .2s ease;
        }

        .reveal.visible .gold-line,
        .gold-line.visible {
            width: 52px;
        }

        /* ── Image hover zoom container ──────────────────────────────────────────── */
        .img-zoom {
            overflow: hidden;
        }

        .img-zoom img {
            transition: transform .5s ease;
        }

        .img-zoom:hover img {
            transform: scale(1.04);
        }

        /* Scroll hint bounce */
        @keyframes bounce-y {

            0%,
            100% {
                transform: translateY(0)
            }

            50% {
                transform: translateY(6px)
            }
        }

        .bounce {
            animation: bounce-y 1.6s ease-in-out infinite;
        }
    </style>
@endpush

@section('content')

    @php
        $hero = $blocks->firstWhere('type', 'hero');
        $stats = $blocks->firstWhere('type', 'stats');
        $about = $blocks->firstWhere('type', 'about_intro');
        $cta = $blocks->firstWhere('type', 'cta_banner');
        $sd = $stats ? $stats->extra ?? [] : [];
    @endphp

    {{-- ══════════════════════════════════════════════════
     HERO — full viewport, parallax bg, animated text
══════════════════════════════════════════════════ --}}
    <section class="relative min-h-screen flex items-center overflow-hidden" style="background:#0c1322">

        {{-- Background image --}}
        @if ($hero && $hero->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($hero->image_path))
            <div class="absolute inset-0" id="hero-bg"
                style="background-image:url('{{ \Illuminate\Support\Facades\Storage::url($hero->image_path) }}');
                background-size:cover; background-position:center;
                transform:scale(1.08); transition:transform 8s ease; opacity:.35;">
            </div>
        @else
            {{-- Animated gradient fallback --}}
            <div class="absolute inset-0"
                style="
        background: linear-gradient(135deg,
            rgba(26,35,126,0.98) 0%,
            rgba(74,20,140,0.85) 40%,
            rgba(183,28,28,0.70) 80%,
            rgba(201,162,39,0.25) 100%);">
            </div>
            {{-- Geometric decoration --}}
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-20 right-20 w-80 h-80 border border-white/8 rounded-full"
                    style="animation:float 6s ease-in-out infinite"></div>
                <div class="absolute top-40 right-40 w-48 h-48 border border-gold/15 rounded-full"
                    style="animation:float 8s 1s ease-in-out infinite"></div>
                <div class="absolute bottom-32 left-1/4 w-6 h-6 bg-gold/20 rounded-full"
                    style="animation:float 5s 2s ease-in-out infinite"></div>
                <div class="absolute top-1/3 left-16 w-3 h-3 bg-white/15 rounded-full"
                    style="animation:float 7s .5s ease-in-out infinite"></div>
            </div>
        @endif

        {{-- Overlay gradient --}}
        <div class="absolute inset-0"
            style="background:linear-gradient(135deg,rgba(12,19,34,0.92) 0%,rgba(27,42,74,0.82) 55%,rgba(201,162,39,0.18) 100%)">
        </div>

        {{-- Content --}}
        <div class="relative max-w-7xl mx-auto px-4 lg:px-8 w-full py-36">
            <div class="max-w-3xl mx-auto text-center">

                {{-- Badge --}}
                <div
                    class="hero-text-1 inline-flex items-center gap-2 bg-white/10 border border-white/20
                        text-white/90 text-xs font-semibold tracking-widest uppercase
                        px-5 py-2.5 rounded-full mb-8 backdrop-blur-sm">
                    <span class="w-1.5 h-1.5 bg-gold rounded-full" style="animation:pulse-ring 2s ease infinite"></span>
                    {{ \App\Models\SiteSetting::get('established_year') ? 'Est. ' . \App\Models\SiteSetting::get('established_year') : 'Grade 1 to +2 Level' }}
                </div>

                {{-- Main heading --}}
                <h1 class="hero-text-2 font-display font-bold leading-tight text-white mb-6"
                    style="font-size:clamp(2.4rem, 6vw, 4.5rem); line-height:1.15">
                    {{ $hero->title ?? \App\Models\SiteSetting::get('school_name', 'Education in Human Values') }}
                </h1>

                {{-- Subtitle --}}
                <p class="hero-text-3 text-white/70 leading-relaxed mb-10 mx-auto max-w-xl"
                    style="font-size:clamp(1rem, 2.5vw, 1.2rem)">
                    {{ $hero->subtitle ?? \App\Models\SiteSetting::get('hero_subtitle', 'Nurturing excellence and character from Grade 1 to +2 with dedicated focus on holistic development.') }}
                </p>

                {{-- Buttons --}}
                <div class="hero-btn flex flex-wrap gap-4 justify-center">
                    <a href="{{ route('admissions.index') }}"
                        class="group relative overflow-hidden bg-white text-navy font-bold px-8 py-4 rounded-xl
                          shadow-lg hover:shadow-white/20 transition-all duration-300 text-sm">
                        <span class="relative z-10 flex items-center gap-2">
                            Apply for Admission
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </span>
                        <div
                            class="absolute inset-0 bg-gold translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                        </div>
                        <span
                            class="absolute inset-0 flex items-center justify-center text-white font-bold text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20 gap-2">
                            Apply for Admission
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </span>
                    </a>
                    <a href="{{ $hero->button_url ?? route('page.show', 'about') }}"
                        class="border-2 border-white/40 hover:border-gold text-white hover:text-gold
                          font-semibold px-8 py-4 rounded-xl transition-all duration-300 text-sm">
                        {{ $hero->button_text ?? 'Learn More' }}
                    </a>
                </div>
            </div>
        </div>

        {{-- Scroll hint --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-white/30 bounce">
            <span class="text-[10px] tracking-widest uppercase">Scroll</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
     WELCOME / ABOUT INTRO
══════════════════════════════════════════════════ --}}
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">

                {{-- Text --}}
                <div class="reveal from-left">
                    <p class="text-gold font-bold text-xs tracking-widest uppercase mb-3">Welcome</p>
                    <h2 class="font-display font-bold text-navy mb-5 leading-tight"
                        style="font-size:clamp(1.8rem,4vw,2.8rem)">
                        Welcome to {{ \App\Models\SiteSetting::get('school_name', 'Sathya Sai Shiksha Sadan') }}
                    </h2>
                    <div class="gold-line mb-7"></div>
                    <div class="text-gray-600 leading-relaxed space-y-4 text-base mt-8">
                        {!! $about->content ??
                            \App\Models\SiteSetting::get(
                                'about_content',
                                '<p>At Sathya Sai Shiksha Sadan, we believe that education extends beyond textbooks. Our mission is to nurture young minds with a perfect blend of academic excellence and human values, creating responsible citizens and future leaders.</p>
                                            <p>From primary education through higher secondary (+2) levels, we provide a supportive environment where students develop intellectually, emotionally, and morally. Our dedicated faculty ensures every student receives personalised attention and guidance.</p>',
                            ) !!}
                    </div>
                    <a href="{{ route('page.show', 'about') }}"
                        class="group inline-flex items-center gap-2 mt-8 bg-navy hover:bg-gold text-white
                      font-bold px-7 py-3.5 rounded-xl transition-all duration-300 text-sm shadow-md hover:shadow-lg">
                        Learn More About Us
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>

                {{-- Image --}}
                <div class="reveal from-right relative">
                    <div class="img-zoom rounded-2xl overflow-hidden shadow-2xl aspect-[4/3]">
                        @if ($about && $about->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($about->image_path))
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($about->image_path) }}"
                                alt="{{ \App\Models\SiteSetting::get('school_name') }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=800" alt="Students"
                                class="w-full h-full object-cover">
                        @endif
                    </div>
                    {{-- Floating badge --}}
                    <div
                        class="float-badge absolute -bottom-5 -right-4 bg-gold text-white rounded-2xl px-6 py-4 shadow-xl text-center">
                        <div class="font-display font-bold text-3xl leading-none" id="years-count">26+</div>
                        <div class="text-white/80 text-xs mt-1">Years of Excellence</div>
                    </div>
                    {{-- Decorative accent --}}
                    <div class="absolute -bottom-8 -left-8 w-28 h-28 bg-navy/5 rounded-2xl -z-10"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
     ACADEMIC PROGRAMS — 3 cards matching screenshot
══════════════════════════════════════════════════ --}}
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="text-center mb-14 reveal">
                <p class="text-gold font-bold text-xs tracking-widest uppercase mb-2">What We Offer</p>
                <h2 class="font-display font-bold text-3xl lg:text-4xl text-navy mb-2">Our Academic Programs</h2>
                <div class="gold-line mx-auto mb-4"></div>
                <p class="text-gray-500 text-sm max-w-xl mx-auto mt-5">
                    Comprehensive education from foundation to specialisation, designed to unlock every student's potential.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-7 stagger">
                @foreach ([
            [
                'title' => 'Primary Level (1–5)',
                'desc' => 'Building strong foundations in core subjects with focus on holistic development.',
                'badge' => 'Grades 1–5',
                'color' => '#e53e3e',
                'img' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=700',
                'url' => route('page.show', 'programs') . '#primary',
            ],
            [
                'title' => 'Secondary Level (6–10)',
                'desc' => 'Comprehensive education preparing students for higher secondary and beyond.',
                'badge' => 'Grades 6–10',
                'color' => '#1a237e',
                'img' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=700',
                'url' => route('page.show', 'programs') . '#secondary',
            ],
            [
                'title' => '+2 Science & Management',
                'desc' => 'Specialised courses in Science and Management streams for grades 11 and 12.',
                'badge' => 'Grades 11–12',
                'color' => '#d97706',
                'img' => 'https://images.unsplash.com/photo-1576319155264-99536e0be1ee?w=700',
                'url' => route('page.show', 'programs') . '#science',
            ],
        ] as $prog)
                    <div class="prog-card bg-white rounded-2xl overflow-hidden shadow-sm">
                        {{-- Image --}}
                        <div class="aspect-video overflow-hidden relative">
                            <img src="{{ $prog['img'] }}" alt="{{ $prog['title'] }}"
                                class="w-full h-full object-cover">
                            <div class="absolute top-3 left-3 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-md"
                                style="background:{{ $prog['color'] }}">
                                {{ $prog['badge'] }}
                            </div>
                        </div>
                        {{-- Body --}}
                        <div class="p-6">
                            <h3 class="font-display font-bold text-navy text-xl mb-2">{{ $prog['title'] }}</h3>
                            <p class="text-gray-500 text-sm leading-relaxed mb-5">{{ $prog['desc'] }}</p>
                            <a href="{{ $prog['url'] }}"
                                class="group inline-flex items-center gap-1 text-sm font-bold transition-colors"
                                style="color:{{ $prog['color'] }}">
                                Learn More
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
     FIVE HUMAN VALUES — left image, right numbered list
══════════════════════════════════════════════════ --}}
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">

                {{-- Image --}}
                <div class="reveal from-left order-2 lg:order-1">
                    <div class="img-zoom rounded-2xl overflow-hidden aspect-[4/3] shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1562774053-701939374585?w=800" alt="Campus"
                            class="w-full h-full object-cover">
                    </div>
                </div>

                {{-- Values list --}}
                <div class="reveal from-right order-1 lg:order-2">
                    <p class="text-gold font-bold text-xs tracking-widest uppercase mb-3">Our Philosophy</p>
                    <h2 class="font-display font-bold text-3xl lg:text-4xl text-navy mb-4">Five Human Values</h2>
                    <div class="gold-line mb-7"></div>
                    <p class="text-gray-500 text-sm leading-relaxed mb-8 mt-7">
                        Our educational philosophy is built on five pillars that shape character and guide our students:
                    </p>

                    <div class="space-y-3">
                        @foreach ([['1', 'Truth (Sathya)', 'Honesty and integrity in thought, word, and deed', '#C9A227'], ['2', 'Right Conduct (Dharma)', 'Moral and ethical behavior in all situations', '#C9A227'], ['3', 'Peace (Shanti)', 'Inner harmony and calm disposition', '#C9A227'], ['4', 'Love (Prema)', 'Compassion and selfless service to others', '#C9A227'], ['5', 'Non-Violence (Ahimsa)', 'Respect for all life and peaceful coexistence', '#C9A227']] as [$n, $title, $desc, $color])
                            <div class="value-item flex items-start gap-4">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold text-sm shrink-0 mt-0.5 shadow-md"
                                    style="background:{{ $color }}">{{ $n }}</div>
                                <div>
                                    <h4 class="font-semibold text-navy text-sm">{{ $title }}</h4>
                                    <p class="text-gray-500 text-xs mt-0.5 leading-relaxed">{{ $desc }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
     LEGACY — "Our Story" badge, timeline, building image
══════════════════════════════════════════════════ --}}
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">

                {{-- Timeline --}}
                <div class="reveal from-left">
                    <div
                        class="inline-flex items-center gap-2 bg-gold/10 text-gold text-xs font-bold px-3 py-1.5 rounded-full mb-5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Our Story
                    </div>
                    <h2 class="font-display font-bold text-3xl lg:text-4xl text-navy mb-4">A Legacy of Excellence</h2>
                    <div class="gold-line mb-7"></div>
                    <p class="text-gray-600 leading-relaxed mb-8 mt-7">
                        Since our founding in 2000, Sathya Sai Shiksha Sadan has been a beacon of value-based education.
                        What began as a small institution with a big vision has grown into a comprehensive school serving
                        hundreds of students from Grade 1 to +2.
                    </p>

                    {{-- Timeline entries --}}
                    <div class="space-y-4 relative">
                        {{-- Vertical line --}}
                        <div
                            class="absolute left-[5px] top-3 bottom-3 w-px bg-gradient-to-b from-gold via-gold/40 to-transparent">
                        </div>

                        @foreach ([['2000', 'Sathya Sai Shiksha Sadan established with a vision of value-based education'], ['2005', 'Expanded to secondary level — welcoming students up to Grade 10'], ['2010', '+2 Science stream introduced for Grades 11 & 12'], ['2015', '+2 Management stream launched to serve aspiring business leaders'], ['2026', '26 proud years of nurturing excellence and human values']] as [$year, $text])
                            <div class="timeline-item flex gap-5 items-start pl-1">
                                <div class="dot shrink-0"></div>
                                <div>
                                    <span
                                        class="text-xs font-bold text-gold block leading-none mb-1">{{ $year }}</span>
                                    <p class="text-gray-600 text-sm leading-relaxed transition-colors">{{ $text }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Building image --}}
                <div class="reveal from-right relative">
                    <div class="img-zoom rounded-2xl overflow-hidden aspect-[4/3] shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1607827448387-a67db1383b93?w=800"
                            alt="School building" class="w-full h-full object-cover">
                    </div>
                    {{-- Stat badge on image --}}
                    <div
                        class="float-badge absolute bottom-5 right-5 bg-navy/90 backdrop-blur-sm text-white rounded-xl px-5 py-3 text-center border border-white/10">
                        <div class="font-display font-bold text-3xl leading-none text-gold" id="counter-years">
                            {{ \App\Models\SiteSetting::get('established_year') ? date('Y') - intval(\App\Models\SiteSetting::get('established_year')) : '26' }}+
                        </div>
                        <div class="text-white/70 text-xs mt-1">Years of Educational Excellence</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
     LATEST NEWS — 3 cards with category badges
══════════════════════════════════════════════════ --}}
    @if ($latestNews->count())
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">

                <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-14 reveal">
                    <div>
                        <p class="text-gold font-bold text-xs tracking-widest uppercase mb-2">Stay Informed</p>
                        <h2 class="font-display font-bold text-3xl lg:text-4xl text-navy mb-2">Latest News & Updates</h2>
                        <div class="gold-line"></div>
                        <p class="text-gray-500 text-sm mt-5">Stay informed about what's happening at SSSS</p>
                    </div>
                    <a href="{{ route('news.index') }}"
                        class="group mt-6 sm:mt-0 inline-flex items-center gap-2 border border-gray-200 hover:border-gold
                  text-navy hover:text-gold font-semibold text-sm px-5 py-2.5 rounded-xl transition-all">
                        View All
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>

                <div class="grid md:grid-cols-3 gap-7 stagger">
                    @foreach ($latestNews as $post)
                        @php
                            $catColors = [
                                'Achievement' => '#f59e0b',
                                'Campus News' => '#e53e3e',
                                'Student Success' => '#1a237e',
                            ];
                            $catColor = $catColors[$post->category] ?? '#6b7280';
                        @endphp
                        <article
                            class="news-card bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm flex flex-col">
                            {{-- Image --}}
                            <a href="{{ route('news.show', $post->slug) }}"
                                class="block aspect-video overflow-hidden img-wrap">
                                <img src="{{ $post->image_url }}" alt="{{ $post->title }}"
                                    class="w-full h-full object-cover">
                            </a>

                            <div class="p-6 flex flex-col flex-1">
                                {{-- Category badge --}}
                                @if ($post->category)
                                    <div class="flex items-center gap-2 mb-4">
                                        <div class="w-5 h-5 rounded flex items-center justify-center text-white text-[10px]"
                                            style="background:{{ $catColor }}">★</div>
                                        <span class="text-xs font-bold"
                                            style="color:{{ $catColor }}">{{ $post->category }}</span>
                                    </div>
                                @endif

                                {{-- Title --}}
                                <h3 class="font-display font-bold text-navy text-xl mb-3 leading-snug flex-1">
                                    <a href="{{ route('news.show', $post->slug) }}"
                                        class="hover:text-gold transition-colors duration-200">
                                        {{ $post->title }}
                                    </a>
                                </h3>

                                {{-- Date --}}
                                <div class="flex items-center gap-1.5 text-gray-400 text-xs mt-auto">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $post->published_at->format('M d, Y') }}
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

            </div>
        </section>
    @endif

    {{-- ══════════════════════════════════════════════════
     GET IN TOUCH — 3 contact cards + button
══════════════════════════════════════════════════ --}}
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 text-center">

            <div class="reveal">
                <p class="text-gold font-bold text-xs tracking-widest uppercase mb-2">Reach Out</p>
                <h2 class="font-display font-bold text-3xl lg:text-4xl text-navy mb-2">Get in Touch</h2>
                <div class="gold-line mx-auto mb-4"></div>
                <p class="text-gray-500 text-sm mt-5 mb-12 max-w-lg mx-auto">
                    We'd love to hear from you. Reach out to our team for admissions, enquiries, or campus visits.
                </p>
            </div>

            {{-- 3 cards --}}
            <div class="grid sm:grid-cols-3 gap-6 max-w-3xl mx-auto mb-10 stagger">
                @foreach ([['📞', 'Call Us', \App\Models\SiteSetting::get('phone', '+977-1-XXXXXXX'), 'Mon–Fri, 8 AM – 4 PM', 'tel:' . \App\Models\SiteSetting::get('phone', '')], ['📧', 'Email Us', \App\Models\SiteSetting::get('email', 'info@sathyasaishiksha.edu.np'), 'We reply within 24 hours', 'mailto:' . \App\Models\SiteSetting::get('email', '')], ['📍', 'Visit Us', \App\Models\SiteSetting::get('address', 'Sathya Sai Shiksha Sadan, Nepal'), '', null]] as [$icon, $title, $value, $sub, $href])
                    <div class="contact-card bg-white rounded-2xl p-8 text-center">
                        <div class="text-4xl mb-4">{{ $icon }}</div>
                        <h4 class="font-display font-bold text-navy text-lg mb-2">{{ $title }}</h4>
                        @if ($href)
                            <a href="{{ $href }}"
                                class="text-gray-500 text-sm hover:text-navy transition-colors block">{{ $value }}</a>
                        @else
                            <p class="text-gray-500 text-sm">{{ $value }}</p>
                        @endif
                        @if ($sub)
                            <p class="text-gray-400 text-xs mt-1">{{ $sub }}</p>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="reveal">
                <a href="{{ route('contact.index') }}"
                    class="group inline-flex items-center gap-2 bg-navy hover:bg-gold text-white
                  font-bold px-8 py-4 rounded-xl transition-all duration-300 text-sm shadow-md hover:shadow-lg">
                    Contact Us
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
     JOIN US CTA — matching "Join Our Learning Community"
══════════════════════════════════════════════════ --}}
    <section class="relative py-24 text-white text-center overflow-hidden"
        style="background:linear-gradient(135deg,#1B2A4A 0%,#16223d 50%,#4a148c 100%)">

        {{-- Decorative rings --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-20 -left-20 w-80 h-80 border border-white/5 rounded-full"></div>
            <div class="absolute -bottom-20 -right-20 w-96 h-96 border border-gold/10 rounded-full"></div>
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] border border-white/5 rounded-full">
            </div>
        </div>

        <div class="relative max-w-2xl mx-auto px-4 reveal">
            <h2 class="font-display font-bold mb-4 shimmer-text" style="font-size:clamp(1.8rem,4vw,3rem)">
                {{ $cta->title ?? 'Join Our Learning Community' }}
            </h2>
            <p class="text-white/65 mb-10 leading-relaxed">
                {{ $cta->subtitle ?? 'Give your child the gift of quality education grounded in human values. Admissions are now open!' }}
            </p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('admissions.index') }}"
                    class="group relative overflow-hidden bg-white text-navy font-bold px-10 py-4 rounded-xl shadow-lg text-sm">
                    <span class="relative z-10 group-hover:text-white transition-colors duration-300">Apply Now</span>
                    <div
                        class="absolute inset-0 bg-gold translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                    </div>
                </a>
                <a href="{{ route('contact.index') }}"
                    class="border-2 border-white/30 hover:border-gold text-white hover:text-gold
                      font-semibold px-10 py-4 rounded-xl transition-all duration-300 text-sm">
                    Learn More
                </a>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // ── Scroll reveal with IntersectionObserver ─────────────────────────────
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        // Don't unobserve — allow re-animation if user scrolls back (optional)
                    }
                });
            }, {
                threshold: 0.12,
                rootMargin: '0px 0px -40px 0px'
            });

            document.querySelectorAll('.reveal, .stagger, .gold-line').forEach(el => {
                observer.observe(el);
            });

            // ── Hero background subtle pan on load ──────────────────────────────────
            const heroBg = document.getElementById('hero-bg');
            if (heroBg) {
                setTimeout(() => {
                    heroBg.style.transform = 'scale(1)';
                }, 100);
            }

            // ── Animated number counters ────────────────────────────────────────────
            function animateCounter(el, target, suffix = '+', duration = 1600) {
                let start = 0;
                const startTime = performance.now();
                const update = (now) => {
                    const elapsed = now - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    // Ease out quart
                    const eased = 1 - Math.pow(1 - progress, 4);
                    el.textContent = Math.round(eased * target) + suffix;
                    if (progress < 1) requestAnimationFrame(update);
                };
                requestAnimationFrame(update);
            }

            // Counter observer
            const counterObs = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        const raw = el.dataset.count;
                        if (raw) animateCounter(el, parseInt(raw), el.dataset.suffix || '+');
                        counterObs.unobserve(el);
                    }
                });
            }, {
                threshold: 0.5
            });

            document.querySelectorAll('[data-count]').forEach(el => counterObs.observe(el));

            // ── Smooth page entry ───────────────────────────────────────────────────
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity .4s ease';
            requestAnimationFrame(() => {
                document.body.style.opacity = '1';
            });
        });
    </script>
@endpush
