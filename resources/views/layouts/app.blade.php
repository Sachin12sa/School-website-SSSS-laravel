<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', \App\Models\SiteSetting::get('school_name', 'Our School')) — @yield('page_title', \App\Models\SiteSetting::get('school_tagline', 'Excellence in Education'))</title>
    <meta name="description" content="@yield('meta_description', \App\Models\SiteSetting::get('meta_description', ''))">
    <link rel="icon" href="{{ \App\Models\SiteSetting::faviconUrl() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            DEFAULT: '#1E3A5F',
                            mid: '#27496F',
                            50: '#F2F5F9',
                            100: '#DCE5EF',
                            800: '#18304F',
                            900: '#10243D',
                        },
                        gold: {
                            DEFAULT: '#C8922E',
                            light: '#D8A84A',
                            dark: '#8C6239',
                            50: '#FBF4E8',
                        },
                        cream: {
                            DEFAULT: '#F1F5F9',
                            mid: '#E2E8F0',
                        }
                    },
                    fontFamily: {
                        display: ['"Cormorant Garamond"', '"Playfair Display"', 'Georgia', 'serif'],
                        body: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
                    },
                    boxShadow: {
                        'nav': '0 4px 24px rgba(13,27,46,0.10)',
                        'drop': '0 20px 48px rgba(13,27,46,0.14)',
                    },
                }
            }
        }
    </script>

    {{-- Fonts: Cormorant Garamond (display) + Plus Jakarta Sans (body) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* ══════════════════════════════════════════════════════════════
           DESIGN SYSTEM — Heritage + Minimal Modern Education
           Palette: Heritage Blue #1E3A5F · Soft Slate #F1F5F9 · Saffron Gold #C8922E · Lotus Red #B8423A
           Type: Cormorant Garamond (display) + Plus Jakarta Sans (body)
           Easing: Strong ease-out cubic-bezier(0.23, 1, 0.32, 1)
        ══════════════════════════════════════════════════════════════ */

        /* ── Tokens ──────────────────────────────────────────────── */
        :root {
            --navy: #1E3A5F;
            --navy-mid: #27496F;
            --gold: #C8922E;
            --gold-light: #D8A84A;
            --gold-dark: #8C6239;
            --lotus-red: #B8423A;
            --vivid-red: #D92D20;
            --vivid-red-dark: #B42318;
            --cream: #F1F5F9;
            --cream-mid: #E2E8F0;
            --charcoal: #2A2A2A;
            --text-muted: #5F6670;
            /* Emil-calibrated easing curves */
            --ease-out: cubic-bezier(0.23, 1, 0.32, 1);
            --ease-in-out: cubic-bezier(0.77, 0, 0.175, 1);
            --ease-spring: cubic-bezier(0.34, 1.56, 0.64, 1);
            --ease-drawer: cubic-bezier(0.32, 0.72, 0, 1);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            background: var(--cream);
            color: var(--charcoal);
            -webkit-font-smoothing: antialiased;
        }

        .font-display {
            font-family: 'Cormorant Garamond', Georgia, serif;
        }

        [x-cloak] {
            display: none !important;
        }

        /* ── Scrollbar ─────────────────────────────────────────── */
        * {
            scrollbar-width: thin;
            scrollbar-color: var(--gold) transparent;
        }

        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gold);
            border-radius: 3px;
        }

        /* ── Focus ring ────────────────────────────────────────── */
        button:focus-visible,
        a:focus-visible {
            outline: 2px solid var(--gold);
            outline-offset: 3px;
            border-radius: 6px;
        }

        /* ── Nav underline grow — left-anchored, fast ease-out ── */
        .nav-item,
        .nav-item-light {
            position: relative;
        }

        .nav-item::after,
        .nav-item-light::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--gold), var(--gold-light));
            border-radius: 2px;
            /* Strong ease-out: starts fast, settles smooth */
            transition: width 0.22s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .nav-item-light::after {
            bottom: 0;
        }

        .nav-item:hover::after,
        .nav-item.active::after,
        .nav-item-light:hover::after,
        .nav-item-light.active::after {
            width: 100%;
        }

        /* ── Dropdown panels ───────────────────────────────────── */
        .drop-panel,
        .drop-panel-dark {
            position: absolute;
            top: calc(100% + 4px);
            left: 0;
            z-index: 300;
            min-width: 248px;
            border-top: 2px solid var(--gold);
            border-radius: 0 0 14px 14px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(8px);
            /* ease-out: snappy reveal, not sluggish ease-in */
            transition: opacity 0.18s var(--ease-out),
                transform 0.18s var(--ease-out),
                visibility 0.18s;
            pointer-events: none;
        }

        .drop-panel {
            background: #fff;
            box-shadow: 0 24px 48px rgba(13, 27, 46, 0.13), 0 2px 8px rgba(0, 0, 0, .04);
        }

        .drop-panel-dark {
            background: var(--navy-mid);
            box-shadow: 0 24px 48px rgba(0, 0, 0, .28);
            top: 100%;
        }

        .drop-wrap:hover .drop-panel,
        .drop-wrap:hover .drop-panel-dark {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            pointer-events: auto;
        }

        .drop-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 10px 16px;
            transition: background 0.13s ease;
            border-bottom: 1px solid rgba(0, 0, 0, .04);
        }

        .drop-item:last-child {
            border-bottom: none;
        }

        .drop-item:hover {
            background: rgba(201, 162, 39, .06);
        }

        .drop-item-dark {
            border-bottom-color: rgba(255, 255, 255, .06);
        }

        .drop-item-dark:hover {
            background: rgba(255, 255, 255, .06);
        }

        /* ── Card lift — directional hover ────────────────────── */
        .card-lift {
            transition: transform 0.28s var(--ease-out), box-shadow 0.28s ease;
        }

        .card-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 44px rgba(13, 27, 46, 0.13);
        }

        /* Tactile active press */
        .card-lift:active {
            transform: translateY(-2px) scale(0.99);
        }

        .prog-card {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            cursor: pointer;
            transition: transform .35s var(--ease-spring), box-shadow .35s var(--ease-out);
        }

        .prog-card::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 20px;
            border: 1.5px solid transparent;
            transition: border-color .28s var(--ease-out), box-shadow .28s var(--ease-out);
            pointer-events: none;
        }

        @media (hover: hover) and (pointer: fine) {
            .prog-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 32px 64px rgba(30, 58, 95, 0.16);
            }

            .prog-card:hover::after {
                border-color: rgba(200, 146, 46, 0.5);
                box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1);
            }
        }

        .prog-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 30%, rgba(30, 58, 95, 0.94) 100%);
        }

        /* ── Buttons — primary ─────────────────────────────────── */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--vivid-red);
            color: var(--cream);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 700;
            padding: 11px 24px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 8px 24px rgba(217, 45, 32, 0.22);
            transition: background 0.18s ease,
                transform 0.16s var(--ease-spring),
                box-shadow 0.18s ease;
        }

        .btn-primary:hover {
            background: var(--vivid-red-dark);
            color: var(--cream);
            transform: translateY(-2px);
            box-shadow: 0 12px 34px rgba(217, 45, 32, 0.34);
        }

        .btn-primary:active {
            transform: scale(0.97) translateY(0);
        }

        /* ── Buttons — ghost white ─────────────────────────────── */
        .btn-ghost-white {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.07);
            color: rgba(255, 255, 255, 0.82);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            padding: 11px 24px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.14);
            cursor: pointer;
            text-decoration: none;
            transition: background 0.18s ease,
                border-color 0.18s ease,
                transform 0.16s var(--ease-spring);
        }

        .btn-ghost-white:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.24);
            transform: translateY(-2px);
        }

        .btn-ghost-white:active {
            transform: scale(0.97) translateY(0);
        }

        /* ── Buttons — ghost dark ──────────────────────────────── */
        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: transparent;
            color: var(--navy);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            padding: 10px 22px;
            border-radius: 10px;
            border: 1.5px solid rgba(13, 27, 46, 0.18);
            cursor: pointer;
            text-decoration: none;
            transition: background 0.18s ease,
                border-color 0.18s ease,
                transform 0.16s var(--ease-spring);
        }

        .btn-ghost:hover {
            background: rgba(13, 27, 46, 0.04);
            border-color: rgba(13, 27, 46, 0.35);
            transform: translateY(-2px);
        }

        .btn-ghost:active {
            transform: scale(0.97) translateY(0);
        }

        /* ── Heading accent ────────────────────────────────────── */
        .heading-underline {
            position: relative;
            display: inline-block;
        }

        .heading-underline::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 52px;
            height: 3px;
            background: linear-gradient(90deg, var(--gold), var(--gold-light));
            border-radius: 2px;
        }

        /* ── Logo text ─────────────────────────────────────────── */
        .logo-text-primary {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-weight: 700;
            font-size: .875rem;
            color: var(--navy);
            line-height: 1.25;
            letter-spacing: -.01em;
        }

        .logo-text-tagline {
            font-size: .625rem;
            color: var(--gold);
            letter-spacing: .12em;
            text-transform: uppercase;
            font-weight: 600;
        }

        /* ── Mobile menu ───────────────────────────────────────── */
        .mobile-menu {
            max-height: 80vh;
            overflow-y: auto;
        }

        /* ── Section label ─────────────────────────────────────── */
        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 1rem;
        }

        .section-label::before {
            content: '';
            display: block;
            width: 18px;
            height: 1.5px;
            background: linear-gradient(90deg, var(--gold), var(--gold-light));
            border-radius: 2px;
        }

        /* ── Section title ─────────────────────────────────────── */
        .section-title {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: clamp(2rem, 4vw, 3.2rem);
            font-weight: 700;
            line-height: 1.1;
            color: var(--navy);
            letter-spacing: -0.02em;
        }

        .section-title-light {
            color: #fff;
        }

        /* ── Gold bar — animated width ─────────────────────────── */
        .gold-bar {
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--gold), var(--gold-light));
            border-radius: 2px;
            transition: width 0.7s 0.25s var(--ease-out);
        }

        .reveal.visible .gold-bar,
        .gold-bar.visible {
            width: 48px;
        }

        /* ── Scroll reveal ─────────────────────────────────────── */
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.65s var(--ease-out), transform 0.65s var(--ease-out);
        }

        .reveal.from-left {
            transform: translateX(-32px);
        }

        .reveal.from-right {
            transform: translateX(32px);
        }

        .reveal.visible {
            opacity: 1;
            transform: none;
        }

        .stagger>* {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.55s var(--ease-out), transform 0.55s var(--ease-out);
        }

        .stagger.visible>*:nth-child(1) {
            opacity: 1;
            transform: none;
            transition-delay: .04s;
        }

        .stagger.visible>*:nth-child(2) {
            opacity: 1;
            transform: none;
            transition-delay: .10s;
        }

        .stagger.visible>*:nth-child(3) {
            opacity: 1;
            transform: none;
            transition-delay: .16s;
        }

        .stagger.visible>*:nth-child(4) {
            opacity: 1;
            transform: none;
            transition-delay: .22s;
        }

        .stagger.visible>*:nth-child(5) {
            opacity: 1;
            transform: none;
            transition-delay: .28s;
        }

        .stagger.visible>*:nth-child(6) {
            opacity: 1;
            transform: none;
            transition-delay: .34s;
        }

        /* ── Image zoom ────────────────────────────────────────── */
        .img-zoom {
            overflow: hidden;
        }

        .img-zoom img {
            transition: transform 0.55s var(--ease-out);
        }

        @media (hover: hover) and (pointer: fine) {
            .img-zoom:hover img {
                transform: scale(1.04);
            }
        }

        /* ── Reduced motion ────────────────────────────────────── */
        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body class="bg-white text-navy antialiased">

    @php
        $schoolName = \App\Models\SiteSetting::get('school_name', 'Our School');
        $schoolTag = \App\Models\SiteSetting::get('school_tagline', 'Excellence in Education');
        $logoUrl = \App\Models\SiteSetting::logoUrl();

        $navPages = \Illuminate\Support\Facades\Cache::remember(
            'nav_pages',
            1800,
            fn() => \App\Models\Page::published()
                ->orderBy('order')
                ->get(['id', 'title', 'slug']),
        );

        $programItems = [
            ['label' => 'All Programs', 'url' => route('page.show', 'programs'), 'sub' => null],
            [
                'label' => 'Primary Level (Gr 1–5)',
                'url' => route('page.show', 'programs') . '#primary',
                'sub' => 'Grades 1 to 5',
            ],
            [
                'label' => 'Secondary Level (Gr 6–10)',
                'url' => route('page.show', 'programs') . '#secondary',
                'sub' => 'Grades 6 to 10',
            ],
            ['label' => '+2 Science', 'url' => route('page.show', 'programs') . '#science', 'sub' => 'Grades 11 & 12'],
            [
                'label' => '+2 Management',
                'url' => route('page.show', 'programs') . '#management',
                'sub' => 'Grades 11 & 12',
            ],
        ];

        $boardingItems = [
            ['Overview', route('page.show', 'boarding'), 'Full residential facility details'],
            ['Boys Hostel', route('page.show', 'boarding') . '#boys-hostel', 'Hostel Block A — facilities & rules'],
            ['Girls Hostel', route('page.show', 'boarding') . '#girls-hostel', 'Hostel Block B — facilities & rules'],
            ['Daily Routine', route('page.show', 'boarding') . '#routine', 'Schedule from 5:30 AM to 9:30 PM'],
            ['Meals & Diet', route('page.show', 'boarding') . '#meals', 'Nutritious vegetarian meals daily'],
            ['Apply for Boarding', route('admissions.index'), 'Include request in application'],
        ];

        $admissionsItems = [
            ['Apply Online', route('admissions.index'), 'Submit your application now'],
            ['Admission Process', route('admissions.index') . '#process', '4-step admission guide'],
            ['Required Documents', route('admissions.index') . '#documents', 'Checklist for each level'],
            ['Important Dates', route('admissions.index') . '#dates', 'Deadlines and key dates'],
            ['Fee Structure', route('admissions.index') . '#fees', 'Annual fees & scholarships'],
            ['Contact Admissions', route('contact.index'), 'Speak to our admissions team'],
        ];
    @endphp

    {{-- ══════════════════════════════════════════════════════════
         TOP BAR — phone · email · socials
    ══════════════════════════════════════════════════════════ --}}
    <div class="bg-navy-900 border-b border-white/5 hidden md:block" style="background:var(--navy)">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 h-9 flex items-center justify-between">

            {{-- Left: contact --}}
            <div class="flex items-center gap-6 text-white/50 text-[11px]">
                @if (\App\Models\SiteSetting::get('phone'))
                    <a href="tel:{{ \App\Models\SiteSetting::get('phone') }}"
                        class="flex items-center gap-1.5 hover:text-gold transition-colors duration-200"
                        style="transition-timing-function: var(--ease-out)">
                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                        {{ \App\Models\SiteSetting::get('phone') }}
                    </a>
                @endif
                @if (\App\Models\SiteSetting::get('email'))
                    <a href="mailto:{{ \App\Models\SiteSetting::get('email') }}"
                        class="flex items-center gap-1.5 hover:text-gold transition-colors duration-200"
                        style="transition-timing-function: var(--ease-out)">
                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                        {{ \App\Models\SiteSetting::get('email') }}
                    </a>
                @endif
            </div>

            {{-- Right: socials --}}
            <div class="flex items-center gap-2.5">
                @foreach (['facebook', 'twitter', 'instagram', 'youtube'] as $s)
                    @if (\App\Models\SiteSetting::get($s))
                        <a href="{{ \App\Models\SiteSetting::get($s) }}" target="_blank" rel="noopener"
                            class="w-6 h-6 flex items-center justify-center text-white/30 hover:text-gold transition-colors duration-200">
                            @if ($s === 'facebook')
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z" />
                                </svg>
                            @elseif($s === 'twitter')
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z" />
                                </svg>
                            @elseif($s === 'instagram')
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                    <rect x="2" y="2" width="20" height="20" rx="5" />
                                    <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z" fill="none"
                                        stroke="currentColor" stroke-width="1.5" />
                                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"
                                        stroke="currentColor" stroke-width="2" />
                                </svg>
                            @elseif($s === 'youtube')
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 00-1.95 1.96A29 29 0 001 12a29 29 0 00.46 5.58a2.78 2.78 0 001.95 1.95C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58z" />
                                    <polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="white" />
                                </svg>
                            @endif
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════
         HEADER — sticky, two-row nav
    ══════════════════════════════════════════════════════════ --}}
    <header class="sticky top-0 z-50" x-data="{ mob: false }">

        {{-- ROW 1: White nav bar --}}
        <div class="bg-white border-b border-navy/6" style="box-shadow: 0 1px 0 rgba(13,27,46,0.06)">
            <div class="max-w-7xl mx-auto px-4 lg:px-8 h-16 flex items-center justify-between gap-4">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 flex-shrink-0">
                    @if ($logoUrl)
                        <div
                            class="w-10 h-10 rounded-xl overflow-hidden bg-navy/5 flex items-center justify-center border border-navy/8">
                            <img src="{{ $logoUrl }}" alt="{{ $schoolName }}"
                                class="w-full h-full object-contain p-0.5">
                        </div>
                    @else
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center border border-gold/30"
                            style="background:linear-gradient(135deg,var(--gold),var(--gold-light))">
                            <span
                                class="font-display font-bold text-navy text-xl">{{ strtoupper(substr($schoolName, 0, 1)) }}</span>
                        </div>
                    @endif
                    <div>
                        <div class="logo-text-primary">{{ $schoolName }}</div>
                        <div class="logo-text-tagline">{{ $schoolTag }}</div>
                    </div>
                </a>

                {{-- Desktop primary nav --}}
                <nav class="hidden lg:flex items-center gap-1">
                    <a href="{{ route('home') }}"
                        class="nav-item px-3.5 py-2 text-[13px] font-semibold text-navy hover:text-gold transition-colors {{ request()->is('/') || request()->routeIs('home') ? 'active text-gold' : '' }}"
                        style="transition-timing-function:var(--ease-out)">Home</a>
                    <a href="{{ route('about') }}"
                        class="nav-item px-3.5 py-2 text-[13px] font-semibold text-navy hover:text-gold transition-colors {{ request()->is('about*') ? 'active text-gold' : '' }}"
                        style="transition-timing-function:var(--ease-out)">About</a>

                    {{-- Pages mega drop --}}
                    <div class="drop-wrap relative">
                        <button
                            class="nav-item flex items-center gap-1 px-3.5 py-2 text-[13px] font-semibold text-navy hover:text-gold transition-colors"
                            style="transition-timing-function:var(--ease-out)">
                            Pages
                            <svg class="w-3 h-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="drop-panel">
                            <div class="px-4 pt-3 pb-1.5">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">News &
                                    Events</span>
                            </div>
                            @foreach ([['News & Updates', route('news.index'), 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z'], ['Events Calendar', route('events.index'), 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'], ['Testimonials', route('testimonials.index'), 'M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2l-4 4v-4H9a2 2 0 01-2-2v-1M7 8h6M7 12h4m-6 2H5a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2'], ['FAQ', route('faq.index'), 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z']] as [$label, $url, $path])
                                <a href="{{ $url }}" class="drop-item group">
                                    <svg class="w-3.5 h-3.5 text-gold shrink-0 mt-0.5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="{{ $path }}" />
                                    </svg>
                                    <span
                                        class="text-[13px] text-navy group-hover:text-gold transition-colors font-medium">{{ $label }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <a href="{{ route('gallery.index') }}"
                        class="nav-item px-3.5 py-2 text-[13px] font-semibold text-navy hover:text-gold transition-colors {{ request()->is('gallery*') ? 'active text-gold' : '' }}"
                        style="transition-timing-function:var(--ease-out)">Gallery</a>
                    <a href="{{ route('calendar.index') }}"
                        class="nav-item px-3.5 py-2 text-[13px] font-semibold text-navy hover:text-gold transition-colors {{ request()->is('calendar*') ? 'active text-gold' : '' }}"
                        style="transition-timing-function:var(--ease-out)">Calendar</a>
                    <a href="{{ route('contact.index') }}"
                        class="nav-item px-3.5 py-2 text-[13px] font-semibold text-navy hover:text-gold transition-colors {{ request()->is('contact*') ? 'active text-gold' : '' }}"
                        style="transition-timing-function:var(--ease-out)">Contact</a>
                </nav>

                <div class="hidden lg:flex items-center gap-3">
                    <a href="{{ route('teachers.index') }}"
                        class="flex items-center gap-1.5 text-navy/40 hover:text-gold text-[12px] font-medium transition-colors">


                    </a>
                    <a href="{{ route('admissions.index') }}" class="btn-primary">Apply Now</a>
                </div>

                {{-- Mobile hamburger --}}
                <button @click="mob=!mob"
                    class="lg:hidden p-2 text-navy hover:bg-gray-100 rounded-xl transition-colors">
                    <svg x-show="!mob" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mob" x-cloak class="w-6 h-6" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- ROW 2: Navy secondary nav --}}
        <div class="hidden lg:block border-b border-white/5" style="background:var(--navy)">
            <div class="max-w-7xl mx-auto px-4 lg:px-8 flex items-center justify-between h-11">
                <nav class="flex items-center">

                    {{-- Programs --}}
                    <div class="drop-wrap relative">
                        <button
                            class="nav-item-light flex items-center gap-2 px-5 h-11 text-[13px] font-semibold text-white/80 hover:text-gold transition-colors {{ request()->is('programs*') ? 'active !text-gold' : '' }}"
                            style="transition-timing-function:var(--ease-out)">
                            <svg class="w-3.5 h-3.5 opacity-60 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                            Programs
                            <svg class="w-3 h-3 opacity-40" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="drop-panel-dark">
                            <div class="px-4 pt-3 pb-1.5">
                                <span class="text-[10px] font-bold text-white/35 uppercase tracking-widest">Academic
                                    Programmes</span>
                            </div>
                            @foreach ($programItems as $prog)
                                <a href="{{ $prog['url'] }}"
                                    class="drop-item drop-item-dark group {{ $loop->last ? 'rounded-b-[11px]' : '' }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gold shrink-0 mt-1.5"></span>
                                    <div>
                                        <div
                                            class="text-[13px] font-medium text-white/85 group-hover:text-gold transition-colors">
                                            {{ $prog['label'] }}</div>
                                        @if ($prog['sub'])
                                            <div class="text-[11px] text-white/35 mt-0.5">{{ $prog['sub'] }}</div>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Life at SSSS --}}
                    <a href="{{ route('page.show', 'life-at-ssss') }}"
                        class="nav-item-light flex items-center gap-2 px-5 h-11 text-[13px] font-semibold text-white/80 hover:text-gold transition-colors {{ request()->is('life-at-ssss') ? 'active !text-gold' : '' }}"
                        style="transition-timing-function:var(--ease-out)">
                        <svg class="w-3.5 h-3.5 opacity-60 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        Life at SSSS
                    </a>

                    {{-- Boarding --}}
                    <div class="drop-wrap relative">
                        <button
                            class="nav-item-light flex items-center gap-2 px-5 h-11 text-[13px] font-semibold text-white/80 hover:text-gold transition-colors {{ request()->is('boarding') ? 'active !text-gold' : '' }}"
                            style="transition-timing-function:var(--ease-out)">
                            <svg class="w-3.5 h-3.5 opacity-60 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Boarding
                            <svg class="w-3 h-3 opacity-40" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="drop-panel-dark">
                            <div class="px-4 pt-3 pb-1.5">
                                <span class="text-[10px] font-bold text-white/35 uppercase tracking-widest">Boarding
                                    Facility</span>
                            </div>
                            @foreach ($boardingItems as [$lbl, $url, $sub])
                                <a href="{{ $url }}"
                                    class="drop-item drop-item-dark group {{ $loop->last ? 'rounded-b-[11px]' : '' }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gold shrink-0 mt-1.5"></span>
                                    <div>
                                        <div
                                            class="text-[13px] font-medium text-white/85 group-hover:text-gold transition-colors">
                                            {{ $lbl }}</div>
                                        <div class="text-[11px] text-white/35 mt-0.5">{{ $sub }}</div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Admissions --}}
                    <div class="drop-wrap relative">
                        <button
                            class="nav-item-light flex items-center gap-2 px-5 h-11 text-[13px] font-semibold text-white/80 hover:text-gold transition-colors {{ request()->is('admissions*') ? 'active !text-gold' : '' }}"
                            style="transition-timing-function:var(--ease-out)">
                            <svg class="w-3.5 h-3.5 opacity-60 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Admissions
                            <svg class="w-3 h-3 opacity-40" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="drop-panel-dark">
                            <div class="px-4 pt-3 pb-1.5">
                                <span class="text-[10px] font-bold text-white/35 uppercase tracking-widest">Admissions
                                    2026–27</span>
                            </div>
                            @foreach ($admissionsItems as [$lbl, $url, $sub])
                                <a href="{{ $url }}"
                                    class="drop-item drop-item-dark group {{ $loop->last ? 'rounded-b-[11px]' : '' }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gold shrink-0 mt-1.5"></span>
                                    <div>
                                        <div
                                            class="text-[13px] font-medium text-white/85 group-hover:text-gold transition-colors">
                                            {{ $lbl }}</div>
                                        <div class="text-[11px] text-white/35 mt-0.5">{{ $sub }}</div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Transportation --}}
                    <a href="{{ route('transport.index') }}"
                        class="nav-item-light flex items-center gap-2 px-5 h-11 text-[13px] font-semibold text-white/80 hover:text-gold transition-colors"
                        style="transition-timing-function:var(--ease-out)">
                        <svg class="w-3.5 h-3.5 opacity-60 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                        Transportation
                    </a>
                </nav>

                <a href="{{ route('teachers.index') }}"
                    class="flex items-center gap-1.5 text-white/35 hover:text-gold text-[12px] font-medium transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Faculty
                </a>
            </div>
        </div>

        {{-- MOBILE MENU --}}
        <div x-show="mob" x-cloak x-transition:enter="transition ease-out duration-180"
            x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-130" x-transition:leave-end="opacity-0 -translate-y-1"
            class="lg:hidden bg-white border-t border-gray-100 shadow-lg mobile-menu">
            <div class="px-4 py-3 space-y-0.5">
                <div class="flex items-center gap-2.5 px-3 py-3 mb-1 border-b border-gray-100">
                    @if ($logoUrl)
                        <img src="{{ $logoUrl }}" alt="{{ $schoolName }}"
                            class="h-8 w-8 object-contain rounded-lg border border-gray-100">
                    @else
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                            style="background:var(--navy)">
                            <span
                                class="text-gold font-display font-bold text-sm">{{ strtoupper(substr($schoolName, 0, 1)) }}</span>
                        </div>
                    @endif
                    <div>
                        <div class="font-display font-bold text-navy text-sm leading-tight">{{ $schoolName }}</div>
                        <div class="text-[9px] tracking-widest uppercase" style="color:var(--gold)">
                            {{ $schoolTag }}</div>
                    </div>
                </div>

                @foreach ([['Home', route('home')], ['About', route('about')], ['Gallery', route('gallery.index')], ['Testimonials', route('testimonials.index')], ['Contact', route('contact.index')]] as [$l, $u])
                    <a href="{{ $u }}"
                        class="block py-3 px-3 text-navy font-semibold border-b border-gray-100 hover:text-gold hover:bg-gold-50 rounded-xl text-sm transition-colors">{{ $l }}</a>
                @endforeach

                @foreach ([['Pages', [['title' => 'News & Updates', 'url' => route('news.index')], ['title' => 'Events', 'url' => route('events.index')], ['title' => 'Testimonials', 'url' => route('testimonials.index')], ['title' => 'FAQ', 'url' => route('faq.index')]]], ['Programs', array_map(fn($p) => ['title' => $p['label'], 'url' => $p['url']], $programItems)], ['Boarding', [['title' => 'Overview', 'url' => route('page.show', 'boarding')], ['title' => 'Boys Hostel', 'url' => route('page.show', 'boarding') . '#boys-hostel'], ['title' => 'Girls Hostel', 'url' => route('page.show', 'boarding') . '#girls-hostel'], ['title' => 'Apply for Boarding', 'url' => route('admissions.index')]]], ['Admissions', array_map(fn($a) => ['title' => $a[0], 'url' => $a[1]], $admissionsItems)]] as [$groupLabel, $items])
                    <div x-data="{ o: false }">
                        <button @click="o=!o"
                            class="flex items-center justify-between w-full py-3 px-3 text-navy font-semibold border-b border-gray-100 hover:text-gold hover:bg-gold-50 rounded-xl text-sm transition-colors">
                            {{ $groupLabel }}
                            <svg :class="o ? 'rotate-180' : ''"
                                class="w-4 h-4 text-gold transition-transform duration-200" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="o" x-cloak x-transition class="pl-4 py-1 space-y-0.5">
                            @foreach ($items as $item)
                                <a href="{{ $item['url'] }}"
                                    class="flex items-center gap-2 py-2.5 px-3 text-sm text-gray-600 hover:text-gold hover:bg-gold-50 rounded-lg transition-colors">
                                    <span class="w-1.5 h-1.5 rounded-full shrink-0"
                                        style="background:var(--gold);opacity:0.6"></span>
                                    {{ $item['title'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <a href="{{ route('page.show', 'life-at-ssss') }}"
                    class="block py-3 px-3 text-navy font-semibold border-b border-gray-100 hover:text-gold hover:bg-gold-50 rounded-xl text-sm transition-colors">Life
                    at SSSS</a>
                <a href="{{ route('teachers.index') }}"
                    class="block py-3 px-3 text-navy font-semibold hover:text-gold hover:bg-gold-50 rounded-xl text-sm transition-colors">Our
                    Faculty</a>

                <a href="{{ route('admissions.index') }}"
                    class="block mt-3 text-white text-center py-3.5 rounded-xl font-bold text-sm transition-colors shadow-md"
                    style="background:var(--gold)">
                    Apply Now
                </a>
            </div>
        </div>

    </header>

    {{-- ══════════════════════════════════════════════════════════
         PAGE CONTENT
    ══════════════════════════════════════════════════════════ --}}
    <main>@yield('content')</main>

    @php
        $defaultFooterLinks = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'About Us', 'url' => route('about')],
            ['label' => 'Programs', 'url' => route('page.show', 'programs')],
            ['label' => 'Life at SSSS', 'url' => route('page.show', 'life-at-ssss')],
            ['label' => 'Boarding', 'url' => route('page.show', 'boarding')],
            ['label' => 'Admissions', 'url' => route('admissions.index')],
            ['label' => 'News', 'url' => route('news.index')],
            ['label' => 'Testimonials', 'url' => route('testimonials.index')],
            ['label' => 'Gallery', 'url' => route('gallery.index')],
            ['label' => 'Contact', 'url' => route('contact.index')],
        ];
        $footerLinksRaw = \App\Models\SiteSetting::get('footer_links_json');
        $footerLinksDecoded = $footerLinksRaw ? json_decode($footerLinksRaw, true) : null;
        $footerLinks = is_array($footerLinksDecoded) ? $footerLinksDecoded : $defaultFooterLinks;
        $footerAbout = \App\Models\SiteSetting::get('footer_about', \App\Models\SiteSetting::get('about_short', 'Nurturing young minds with academic excellence and human values since our establishment.'));
        $footerQuickTitle = \App\Models\SiteSetting::get('footer_quick_title', 'Quick Links');
        $footerContactTitle = \App\Models\SiteSetting::get('footer_contact_title', 'Contact Us');
        $footerCredit = \App\Models\SiteSetting::get('footer_credit', 'Built with Laravel · PHP 8.4');
    @endphp

    {{-- ══════════════════════════════════════════════════════════
         FOOTER
    ══════════════════════════════════════════════════════════ --}}
    <footer class="relative overflow-hidden" style="background:#060e1c;color:#fff">

        {{-- Particle Animation Canvas --}}
        <canvas id="footer-particles" class="absolute inset-0 w-full h-full pointer-events-none opacity-70"></canvas>

        {{-- Added 'relative z-10' to ensure content sits above the particles --}}
        <div
            class="relative z-10 max-w-7xl mx-auto px-4 lg:px-8 pt-16 pb-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

            {{-- Brand --}}
            <div class="lg:col-span-2">
                <div class="flex items-center gap-3 mb-5">
                    @if ($logoUrl)
                        <div class="w-12 h-12 rounded-xl overflow-hidden flex items-center justify-center border border-white/10"
                            style="background:rgba(255,255,255,0.08)">
                            <img src="{{ $logoUrl }}" alt="{{ $schoolName }}"
                                class="w-full h-full object-contain p-1">
                        </div>
                    @else
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center border border-white/10"
                            style="background:rgba(255,255,255,0.08)">
                            <span class="font-display font-bold text-2xl"
                                style="color:var(--gold)">{{ strtoupper(substr($schoolName, 0, 1)) }}</span>
                        </div>
                    @endif
                    <div>
                        <div class="font-display font-bold text-white text-base leading-tight">{{ $schoolName }}
                        </div>
                        <div class="text-[10px] tracking-widest uppercase mt-0.5" style="color:var(--gold)">
                            {{ $schoolTag }}</div>
                    </div>
                </div>

                <div class="w-10 h-0.5 rounded-full mb-5" style="background:var(--gold)"></div>
                <p class="text-sm leading-relaxed mb-6 max-w-xs" style="color:rgba(255,255,255,0.45)">
                    {{ $footerAbout }}
                </p>

                {{-- Socials --}}
                <div class="flex gap-2">
                    @foreach (['facebook', 'twitter', 'instagram', 'youtube'] as $s)
                        @if (\App\Models\SiteSetting::get($s))
                            <a href="{{ \App\Models\SiteSetting::get($s) }}" target="_blank" rel="noopener"
                                class="w-9 h-9 rounded-xl flex items-center justify-center border border-white/8 transition-all duration-200"
                                style="background:rgba(255,255,255,0.06); transition-timing-function:var(--ease-spring)"
                                onmouseenter="this.style.background='var(--gold)';this.style.borderColor='var(--gold)';this.style.transform='scale(1.08)'"
                                onmouseleave="this.style.background='rgba(255,255,255,0.06)';this.style.borderColor='rgba(255,255,255,0.08)';this.style.transform='scale(1)'">
                                @if ($s === 'facebook')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z" />
                                    </svg>
                                @elseif($s === 'twitter')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z" />
                                    </svg>
                                @elseif($s === 'instagram')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <rect x="2" y="2" width="20" height="20" rx="5" />
                                        <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z" fill="none"
                                            stroke="currentColor" stroke-width="1.5" />
                                        <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"
                                            stroke="currentColor" stroke-width="2" />
                                    </svg>
                                @elseif($s === 'youtube')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 00-1.95 1.96A29 29 0 001 12a29 29 0 00.46 5.58a2.78 2.78 0 001.95 1.95C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58z" />
                                        <polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="white" />
                                    </svg>
                                @endif
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="font-display font-semibold text-sm text-white mb-4">{{ $footerQuickTitle }}</h4>
                <div class="w-8 h-0.5 rounded-full mb-4" style="background:var(--gold)"></div>
                <ul class="space-y-2.5">
                    @foreach ($footerLinks as $link)
                        @php
                            $l = data_get($link, 'label');
                            $u = data_get($link, 'url', '#');
                        @endphp
                        @continue(!filled($l))
                        <li>
                            <a href="{{ $u }}"
                                class="flex items-center gap-2 text-sm group transition-colors"
                                style="color:rgba(255,255,255,0.45);" onmouseenter="this.style.color='var(--gold)'"
                                onmouseleave="this.style.color='rgba(255,255,255,0.45)'">
                                <svg class="w-2.5 h-2.5 shrink-0" style="color:rgba(201,162,39,0.55)"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $l }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="font-display font-semibold text-sm text-white mb-4">{{ $footerContactTitle }}</h4>
                <div class="w-8 h-0.5 rounded-full mb-4" style="background:var(--gold)"></div>
                <ul class="space-y-4">
                    @if (\App\Models\SiteSetting::get('address'))
                        <li class="flex gap-3 items-start">
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0 mt-0.5"
                                style="background:rgba(255,255,255,0.05)">
                                <svg class="w-3.5 h-3.5" style="color:var(--gold)" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="text-sm leading-relaxed"
                                style="color:rgba(255,255,255,0.45)">{{ \App\Models\SiteSetting::get('address') }}</span>
                        </li>
                    @endif
                    @if (\App\Models\SiteSetting::get('phone'))
                        <li class="flex gap-3 items-center">
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0"
                                style="background:rgba(255,255,255,0.05)">
                                <svg class="w-3.5 h-3.5" style="color:var(--gold)" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                            </div>
                            <a href="tel:{{ \App\Models\SiteSetting::get('phone') }}"
                                class="text-sm transition-colors" style="color:rgba(255,255,255,0.45)"
                                onmouseenter="this.style.color='var(--gold)'"
                                onmouseleave="this.style.color='rgba(255,255,255,0.45)'">{{ \App\Models\SiteSetting::get('phone') }}</a>
                        </li>
                    @endif
                    @if (\App\Models\SiteSetting::get('email'))
                        <li class="flex gap-3 items-center">
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0"
                                style="background:rgba(255,255,255,0.05)">
                                <svg class="w-3.5 h-3.5" style="color:var(--gold)" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <a href="mailto:{{ \App\Models\SiteSetting::get('email') }}"
                                class="text-sm break-all transition-colors" style="color:rgba(255,255,255,0.45)"
                                onmouseenter="this.style.color='var(--gold)'"
                                onmouseleave="this.style.color='rgba(255,255,255,0.45)'">{{ \App\Models\SiteSetting::get('email') }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        {{-- Bottom bar (also set to relative z-10) --}}
        <div class="relative z-10 border-t" style="border-color:rgba(255,255,255,0.07)">
            <div class="max-w-7xl mx-auto px-4 lg:px-8 py-5 flex flex-col md:flex-row justify-between items-center gap-2 text-xs"
                style="color:rgba(255,255,255,0.28)">
                <p>© {{ date('Y') }} <span style="color:rgba(255,255,255,0.48)">{{ $schoolName }}</span>. All
                    rights reserved.</p>
                <p>{{ $footerCredit }}</p>
            </div>
        </div>
    </footer>

    {{-- Particle Animation Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('footer-particles');
            const ctx = canvas.getContext('2d');
            let width, height, particles = [];

            // Resize canvas to match the footer size
            function resize() {
                width = canvas.width = canvas.offsetWidth;
                height = canvas.height = canvas.offsetHeight;
            }
            window.addEventListener('resize', resize);
            resize();

            // Color Palette: Gold, Subtle Blue, Soft White
            const colors = [
                'rgba(201, 162, 39, 0.7)', // Gold
                'rgba(255, 255, 255, 0.3)', // White
                'rgba(100, 180, 255, 0.4)' // Soft Blue
            ];

            class Particle {
                constructor() {
                    this.x = Math.random() * width;
                    this.y = Math.random() * height;
                    this.size = Math.random() * 2 + 0.5; // Random size between 0.5 and 2.5px
                    this.speedX = Math.random() * 0.5 - 0.25; // Gentle horizontal drift
                    this.speedY = Math.random() * -0.5 - 0.1; // Gentle upward drift
                    this.color = colors[Math.floor(Math.random() * colors.length)];
                }
                update() {
                    this.x += this.speedX;
                    this.y += this.speedY;

                    // Infinite loop: if particle goes out of bounds, reset it to the opposite side
                    if (this.y < 0) {
                        this.y = height;
                        this.x = Math.random() * width;
                    }
                    if (this.x < 0) this.x = width;
                    if (this.x > width) this.x = 0;
                }
                draw() {
                    ctx.fillStyle = this.color;
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fill();
                }
            }

            // Initialize ~60 particles
            function init() {
                particles = [];
                for (let i = 0; i < 60; i++) {
                    particles.push(new Particle());
                }
            }

            // Animation Loop
            function animate() {
                ctx.clearRect(0, 0, width, height);
                for (let i = 0; i < particles.length; i++) {
                    particles[i].update();
                    particles[i].draw();
                }
                requestAnimationFrame(animate);
            }

            init();
            animate();
        });
    </script>

    @include('components.popup-banner')

    {{-- Global scroll reveal observer --}}
    <script>
        (function() {
            const obs = new IntersectionObserver(entries => {
                entries.forEach(e => {
                    if (e.isIntersecting) {
                        e.target.classList.add('visible');
                        // Animate gold bars inside revealed elements
                        e.target.querySelectorAll('.gold-bar').forEach(b => {
                            setTimeout(() => b.classList.add('visible'), 250);
                        });
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -40px 0px'
            });

            document.querySelectorAll('.reveal, .stagger, .gold-bar').forEach(el => obs.observe(el));
        })();
    </script>

    @stack('scripts')
</body>

</html>
