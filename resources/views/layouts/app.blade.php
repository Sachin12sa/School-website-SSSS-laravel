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
                            DEFAULT: '#1B2A4A',
                            50: '#f0f3f9',
                            100: '#d9e0ef',
                            200: '#b3c2df',
                            600: '#1B2A4A',
                            700: '#16223d',
                            800: '#0f1729',
                            900: '#0a1020'
                        },
                        gold: {
                            DEFAULT: '#C9A227',
                            light: '#e0b830',
                            dark: '#a8881f',
                            50: '#fdf8ec'
                        },
                    },
                    fontFamily: {
                        display: ['"Playfair Display"', 'Georgia', 'serif'],
                        body: ['"DM Sans"', 'system-ui', 'sans-serif'],
                    },
                    boxShadow: {
                        'nav': '0 4px 24px rgba(27,42,74,0.10)',
                        'drop': '0 20px 48px rgba(27,42,74,0.14)',
                    },
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap"
        rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* ── Base ─────────────────────────────────────────────────────── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', system-ui, sans-serif;
        }

        .font-display {
            font-family: 'Playfair Display', Georgia, serif;
        }

        [x-cloak] {
            display: none !important;
        }

        /* ── Scrollbar ────────────────────────────────────────────────── */
        * {
            scrollbar-width: thin;
            scrollbar-color: #C9A227 transparent;
        }

        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #C9A227;
            border-radius: 3px;
        }

        /* ── Nav items — gold underline grow animation ─────────────────── */
        .nav-item,
        .nav-item-light {
            position: relative;
        }

        .nav-item::after,
        .nav-item-light::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #C9A227, #e0b830);
            border-radius: 2px;
            transform: translateX(-50%);
            transition: width .28s cubic-bezier(.4, 0, .2, 1);
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

        /* ── Dropdown panels ──────────────────────────────────────────── */
        .drop-panel,
        .drop-panel-dark {
            position: absolute;
            top: calc(100% + 4px);
            left: 0;
            z-index: 300;
            min-width: 248px;
            border-top: 3px solid #C9A227;
            border-radius: 0 0 14px 14px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: opacity .22s ease, transform .22s ease, visibility .22s;
            pointer-events: none;
        }

        .drop-panel {
            background: #fff;
            box-shadow: 0 24px 48px rgba(27, 42, 74, 0.13), 0 2px 8px rgba(0, 0, 0, .04);
        }

        .drop-panel-dark {
            background: #1B2A4A;
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

        /* Drop item hover state */
        .drop-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 10px 16px;
            transition: background .15s ease, color .15s ease;
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

        /* ── Card lift ────────────────────────────────────────────────── */
        .card-lift {
            transition: transform .28s ease, box-shadow .28s ease;
        }

        .card-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 44px rgba(27, 42, 74, 0.13);
        }

        /* ── Heading accent ───────────────────────────────────────────── */
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
            background: linear-gradient(90deg, #C9A227, #e0b830);
            border-radius: 2px;
        }

        /* ── Logo: always show name beside logo image ─────────────────── */
        .logo-text-primary {
            font-family: 'Playfair Display', Georgia, serif;
            font-weight: 700;
            font-size: .875rem;
            color: #1B2A4A;
            line-height: 1.25;
            letter-spacing: -.01em;
        }

        .logo-text-tagline {
            font-size: .625rem;
            color: #C9A227;
            letter-spacing: .12em;
            text-transform: uppercase;
            font-weight: 600;
        }

        /* ── Smooth focus ring ────────────────────────────────────────── */
        button:focus-visible,
        a:focus-visible {
            outline: 2px solid #C9A227;
            outline-offset: 3px;
            border-radius: 6px;
        }

        /* ── Mobile menu fade ─────────────────────────────────────────── */
        .mobile-menu {
            max-height: 80vh;
            overflow-y: auto;
        }

        .snake-text {
            overflow: hidden;
            position: relative;
        }

        .snake-text::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.6), transparent);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            100% {
                left: 100%;
            }
        }

        /* Container */
        .nav-bg-flow {
            position: absolute;
            inset: 0;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }

        /* Flowing big text */
        .nav-bg-text {
            position: absolute;
            white-space: nowrap;
            font-size: 60px;
            /* BIG */
            font-weight: 800;
            font-family: 'Poppins', 'Inter', sans-serif;
            color: rgba(11, 28, 61, 0.08);
            /* very light navy */

            filter: blur(1px);
            /* blur effect */
            opacity: 0.9;

            animation: bgFlow 30s linear infinite;
        }

        /* Animation */
        @keyframes bgFlow {
            0% {
                transform: translateX(-50%);
            }

            100% {
                transform: translateX(50%);
            }
        }

        .nav-bg-flow::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, white, transparent, white);
            animation: bgFlow 60s linear infinite;
            transform: rotate(-3deg);
            color: rgba(201, 162, 39, 0.08);
        }

        .snake-text {
            display: inline-block;
            font-weight: 700;
            font-size: 16px;
            color: #0b1c3d;
            /* navy */
            white-space: nowrap;
        }

        .snake-text span {
            display: inline-block;
            animation: wave 2s infinite ease-in-out;
            animation-delay: calc(var(--i) * 0.08s);
        }



        /* Optional hover effect (premium feel) */
        .snake-text:hover span {
            animation-duration: 0.6s;
            color: #c9a227;
            /* gold */
        }
    </style>

    @stack('styles')
</head>

<body class="bg-white text-gray-800 antialiased">

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

    {{-- ═══════════════════════════════════════════
     TOP BAR — phone · email · social
═══════════════════════════════════════════ --}}
    <div class="bg-navy-800 border-b border-white/5 hidden md:block">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 h-9 flex items-center justify-between">

            {{-- Left: contact --}}
            <div class="flex items-center gap-6 text-white/55 text-[11px]">
                @if (\App\Models\SiteSetting::get('phone'))
                    <a href="tel:{{ \App\Models\SiteSetting::get('phone') }}"
                        class="flex items-center gap-1.5 hover:text-gold transition-colors duration-200">
                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                        {{ \App\Models\SiteSetting::get('phone') }}
                    </a>
                @endif
                @if (\App\Models\SiteSetting::get('email'))
                    <a href="mailto:{{ \App\Models\SiteSetting::get('email') }}"
                        class="flex items-center gap-1.5 hover:text-gold transition-colors duration-200">
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
                            class="w-6 h-6 flex items-center justify-center text-white/35 hover:text-gold transition-colors duration-200">
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

    {{-- ═══════════════════════════════════════════
     MAIN HEADER (sticky)
═══════════════════════════════════════════ --}}
    <header class="sticky top-0 z-50 shadow-nav" x-data="{ mob: false }">

        {{-- ── ROW 1: Logo + main nav + CTA ───────────────────────────────── --}}
        <div class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 lg:px-8 flex items-center justify-between h-[68px] relative z-10">
                <div class="nav-bg-flow">
                    <div class="nav-bg-text">
                        {{ $schoolName }} {{ $schoolName }}
                    </div>
                </div>

                {{-- ════ LOGO FIX: always shows BOTH the image AND the school name ════
                 The bug: when a logo was uploaded, only <img> was rendered.
                 The fix: show the image (if exists) PLUS the text in a flex row.
                 Admin can upload a logo and the name still appears beside it.
            ══════════════════════════════════════════════════════════════════════ --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 flex-shrink-0 group">

                    {{-- Logo image or initial circle --}}
                    @if ($logoUrl)
                        {{-- Logo uploaded in admin —— keep it small, show name beside it --}}
                        <div
                            class="h-11 w-11 rounded-xl overflow-hidden bg-navy-50 flex items-center justify-center shrink-0 shadow-sm border border-gray-100">
                            <img src="{{ $logoUrl }}" alt="{{ $schoolName }} logo"
                                class="w-full h-full object-contain p-0.5">
                        </div>
                    @else
                        {{-- No logo yet — show a styled initial circle --}}
                        <div class="w-11 h-11 rounded-xl bg-navy flex items-center justify-center shrink-0 shadow-md">
                            <span class="text-gold font-display font-bold text-xl leading-none">
                                {{ strtoupper(substr($schoolName, 0, 1)) }}
                            </span>
                        </div>
                    @endif

                    {{-- School name + tagline — ALWAYS shown whether logo exists or not --}}
                    <div class="hidden sm:block">
                        <div class="snake-text">
                            @foreach (str_split($schoolName) as $i => $char)
                                <span style="--i: {{ $i }}">{{ $char === ' ' ? ' ' : $char }}</span>
                            @endforeach
                        </div>
                        <div class="logo-text-tagline mt-0.5">{{ $schoolTag }}</div>
                    </div>
                </a>

                {{-- Desktop nav --}}
                <nav class="hidden lg:flex items-center gap-0.5">

                    <a href="{{ route('home') }}"
                        class="nav-item px-3.5 py-2 text-[13px] font-semibold text-navy hover:text-gold transition-colors {{ request()->is('/') ? 'active text-gold' : '' }}">
                        Home
                    </a>

                    <a href="{{ route('about') }}"
                        class="nav-item px-3.5 py-2 text-[13px] font-semibold text-navy hover:text-gold transition-colors {{ request()->is('about') ? 'active text-gold' : '' }}">
                        About
                    </a>

                    {{-- Pages dropdown --}}
                    <div class="drop-wrap relative">
                        <button
                            class="nav-item flex items-center gap-1.5 px-3.5 py-2 text-[13px] font-semibold text-navy hover:text-gold transition-colors">
                            Pages
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="drop-panel" style="min-width:260px">
                            {{-- Dynamic CMS pages --}}
                            {{-- @if ($navPages->count())
                                <div class="px-4 pt-3 pb-1.5">
                                    <span
                                        class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Pages</span>
                                </div>
                                @foreach ($navPages as $pg)
                                    <a href="{{ route('page.show', $pg->slug) }}" class="drop-item group">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gold shrink-0 mt-1.5"></span>
                                        <span
                                            class="text-[13px] text-navy group-hover:text-gold transition-colors font-medium">{{ $pg->title }}</span>
                                    </a>
                                @endforeach
                                <div class="my-1 mx-3 border-t border-gray-100"></div>
                            @endif --}}

                            {{-- News & Events always visible --}}
                            <div class="px-4 pt-2 pb-1.5">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">News &
                                    Events</span>
                            </div>
                            @foreach ([['News & Updates', route('news.index'), 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z'], ['Events Calendar', route('events.index'), 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'], ['FAQ', route('faq.index'), 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z']] as [$label, $url, $path])
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
                        class="nav-item px-3.5 py-2 text-[13px] font-semibold text-navy hover:text-gold transition-colors {{ request()->is('gallery*') ? 'active text-gold' : '' }}">
                        Gallery
                    </a>

                    <a href="{{ route('calendar.index') }}"
                        class="nav-item px-3.5 py-2 text-[13px] font-semibold text-navy hover:text-gold transition-colors {{ request()->is('calendar*') ? 'active text-gold' : '' }}">
                        Calendar
                    </a>

                    <a href="{{ route('contact.index') }}"
                        class="nav-item px-3.5 py-2 text-[13px] font-semibold text-navy hover:text-gold transition-colors {{ request()->is('contact*') ? 'active text-gold' : '' }}">
                        Contact
                    </a>
                </nav>

                <div class="hidden lg:flex items-center gap-3">
                    <a href="{{ route('admissions.index') }}"
                        class="relative overflow-hidden group bg-gold hover:bg-gold-dark text-white text-[13px] font-bold px-5 py-2.5 rounded-xl transition-colors shadow-sm hover:shadow-md">
                        Apply Now
                        <span
                            class="absolute inset-0 bg-white/10 scale-x-0 group-hover:scale-x-100 origin-left transition-transform duration-300"></span>
                    </a>
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

        {{-- ── ROW 2: navy secondary nav ────────────────────────────────────── --}}
        <div class="bg-navy-900 hidden lg:block border-b border-white/5">
            <div class="max-w-7xl mx-auto px-4 lg:px-8 flex items-center justify-between h-11">
                <nav class="flex items-center">

                    {{-- Programs --}}
                    <div class="drop-wrap relative">
                        <button
                            class="nav-item-light flex items-center gap-2 px-5 h-11 text-[13px] font-semibold text-white/80 hover:text-gold transition-colors {{ request()->is('programs*') ? 'active !text-gold' : '' }}">
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
                        class="nav-item-light flex items-center gap-2 px-5 h-11 text-[13px] font-semibold text-white/80 hover:text-gold transition-colors {{ request()->is('life-at-ssss') ? 'active !text-gold' : '' }}">
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
                            class="nav-item-light flex items-center gap-2 px-5 h-11 text-[13px] font-semibold text-white/80 hover:text-gold transition-colors {{ request()->is('boarding') ? 'active !text-gold' : '' }}">
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
                            class="nav-item-light flex items-center gap-2 px-5 h-11 text-[13px] font-semibold text-white/80 hover:text-gold transition-colors {{ request()->is('admissions*') ? 'active !text-gold' : '' }}">
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
                    {{-- Life at SSSS --}}
                    <a href="{{ route('transport.index') }}"
                        class="nav-item-light flex items-center gap-2 px-5 h-11 text-[13px] font-semibold text-white/80 hover:text-gold transition-colors {{ request()->is('transport.index') ? 'active !text-gold' : '' }}">
                        <svg class="w-3.5 h-3.5 opacity-60 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        Transportation
                    </a>
                </nav>


                {{-- Faculty link --}}
                <a href="{{ route('teachers.index') }}"
                    class="flex items-center gap-1.5 text-white/40 hover:text-gold text-[12px] font-medium transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Our Faculty
                </a>
            </div>
        </div>

        {{-- ── MOBILE MENU ──────────────────────────────────────────────────── --}}
        <div x-show="mob" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-end="opacity-0 -translate-y-1"
            class="lg:hidden bg-white border-t border-gray-100 shadow-lg mobile-menu">
            <div class="px-4 py-3 space-y-0.5">

                {{-- School name visible on mobile nav too --}}
                <div class="flex items-center gap-2.5 px-3 py-3 mb-1 border-b border-gray-100">
                    @if ($logoUrl)
                        <img src="{{ $logoUrl }}" alt="{{ $schoolName }}"
                            class="h-8 w-8 object-contain rounded-lg border border-gray-100">
                    @else
                        <div class="w-8 h-8 bg-navy rounded-lg flex items-center justify-center">
                            <span
                                class="text-gold font-display font-bold text-sm">{{ strtoupper(substr($schoolName, 0, 1)) }}</span>
                        </div>
                    @endif
                    <div>
                        <div class="font-display font-bold text-navy text-sm leading-tight">{{ $schoolName }}</div>
                        <div class="text-gold text-[9px] tracking-widest uppercase">{{ $schoolTag }}</div>
                    </div>
                </div>

                <a href="{{ route('home') }}"
                    class="block py-3 px-3 text-navy font-semibold border-b border-gray-100 hover:text-gold hover:bg-gold-50 rounded-xl text-sm transition-colors">Home</a>
                <a href="{{ route('about') }}"
                    class="block py-3 px-3 text-navy font-semibold border-b border-gray-100 hover:text-gold hover:bg-gold-50 rounded-xl text-sm transition-colors">About</a>
                <a href="{{ route('gallery.index') }}"
                    class="block py-3 px-3 text-navy font-semibold border-b border-gray-100 hover:text-gold hover:bg-gold-50 rounded-xl text-sm transition-colors">Gallery</a>
                <a href="{{ route('contact.index') }}"
                    class="block py-3 px-3 text-navy font-semibold border-b border-gray-100 hover:text-gold hover:bg-gold-50 rounded-xl text-sm transition-colors">Contact</a>

                {{-- Accordions --}}
                @foreach ([['Pages', [...$navPages->map(fn($p) => ['title' => $p->title, 'url' => route('page.show', $p->slug)])->toArray(), ['title' => 'News', 'url' => route('news.index')], ['title' => 'Events', 'url' => route('events.index')], ['title' => 'FAQ', 'url' => route('faq.index')]]], ['Programs', array_map(fn($p) => ['title' => $p['label'], 'url' => $p['url']], $programItems)], ['Boarding', [['title' => 'Overview', 'url' => route('page.show', 'boarding')], ['title' => 'Boys Hostel', 'url' => route('page.show', 'boarding') . '#boys-hostel'], ['title' => 'Girls Hostel', 'url' => route('page.show', 'boarding') . '#girls-hostel'], ['title' => 'Daily Routine', 'url' => route('page.show', 'boarding') . '#routine'], ['title' => 'Apply for Boarding', 'url' => route('admissions.index')]]], ['Admissions', array_map(fn($a) => ['title' => $a[0], 'url' => $a[1]], $admissionsItems)]] as [$groupLabel, $items])
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
                                    <span class="w-1.5 h-1.5 rounded-full bg-gold/60 shrink-0"></span>
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
                    class="block mt-3 bg-gold hover:bg-gold-dark text-white text-center py-3.5 rounded-xl font-bold text-sm transition-colors shadow-md">
                    Apply Now →
                </a>
            </div>
        </div>

    </header>

    {{-- ═══════════════════════════════════════════ PAGE CONTENT ═══════════════════════════════════════════ --}}
    <main>@yield('content')</main>

    {{-- ═══════════════════════════════════════════ FOOTER ═══════════════════════════════════════════ --}}
    <footer class="bg-navy-900 text-white">

        {{-- Top section --}}
        <div class="max-w-7xl mx-auto px-4 lg:px-8 pt-16 pb-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

            {{-- Brand --}}
            <div class="lg:col-span-2">
                {{-- Footer logo: same fix — image beside name ──────────────────────── --}}
                <div class="flex items-center gap-3 mb-5">
                    @if ($logoUrl)
                        <div
                            class="w-12 h-12 rounded-xl overflow-hidden bg-white/10 flex items-center justify-center border border-white/10">
                            <img src="{{ $logoUrl }}" alt="{{ $schoolName }}"
                                class="w-full h-full object-contain p-1">
                        </div>
                    @else
                        <div
                            class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center border border-white/10">
                            <span
                                class="text-gold font-display font-bold text-2xl">{{ strtoupper(substr($schoolName, 0, 1)) }}</span>
                        </div>
                    @endif
                    <div>
                        <div class="font-display font-bold text-white text-base leading-tight">{{ $schoolName }}
                        </div>
                        <div class="text-gold text-[10px] tracking-widest uppercase mt-0.5">{{ $schoolTag }}</div>
                    </div>
                </div>

                <div class="w-10 h-0.5 bg-gold mb-5 rounded-full"></div>
                <p class="text-white/50 text-sm leading-relaxed mb-6 max-w-xs">
                    {{ \App\Models\SiteSetting::get('about_short', 'Nurturing young minds with academic excellence and human values since our establishment.') }}
                </p>

                {{-- Socials --}}
                <div class="flex gap-2">
                    @foreach (['facebook', 'twitter', 'instagram', 'youtube'] as $s)
                        @if (\App\Models\SiteSetting::get($s))
                            <a href="{{ \App\Models\SiteSetting::get($s) }}" target="_blank"
                                class="w-9 h-9 bg-white/8 hover:bg-gold rounded-xl flex items-center justify-center transition-all duration-200 hover:scale-105">
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
                <h4 class="font-display font-semibold text-sm text-white mb-4">Quick Links</h4>
                <div class="w-8 h-0.5 bg-gold mb-4 rounded-full"></div>
                <ul class="space-y-2.5">
                    @foreach ([['Home', route('home')], ['About Us', route('about')], ['Programs', route('page.show', 'programs')], ['Life at SSSS', route('page.show', 'life-at-ssss')], ['Boarding', route('page.show', 'boarding')], ['Admissions', route('admissions.index')], ['News', route('news.index')], ['Gallery', route('gallery.index')], ['Contact', route('contact.index')]] as [$l, $u])
                        <li>
                            <a href="{{ $u }}"
                                class="flex items-center gap-2 text-white/50 hover:text-gold transition-colors text-sm group">
                                <svg class="w-2.5 h-2.5 text-gold/60 group-hover:text-gold transition-colors shrink-0"
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
                <h4 class="font-display font-semibold text-sm text-white mb-4">Contact Us</h4>
                <div class="w-8 h-0.5 bg-gold mb-4 rounded-full"></div>
                <ul class="space-y-4">
                    @if (\App\Models\SiteSetting::get('address'))
                        <li class="flex gap-3 items-start">
                            <div
                                class="w-7 h-7 bg-white/5 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-3.5 h-3.5 text-gold" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span
                                class="text-white/50 text-sm leading-relaxed">{{ \App\Models\SiteSetting::get('address') }}</span>
                        </li>
                    @endif
                    @if (\App\Models\SiteSetting::get('phone'))
                        <li class="flex gap-3 items-center">
                            <div class="w-7 h-7 bg-white/5 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5 text-gold" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                            </div>
                            <a href="tel:{{ \App\Models\SiteSetting::get('phone') }}"
                                class="text-white/50 hover:text-gold transition-colors text-sm">{{ \App\Models\SiteSetting::get('phone') }}</a>
                        </li>
                    @endif
                    @if (\App\Models\SiteSetting::get('email'))
                        <li class="flex gap-3 items-center">
                            <div class="w-7 h-7 bg-white/5 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5 text-gold" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <a href="mailto:{{ \App\Models\SiteSetting::get('email') }}"
                                class="text-white/50 hover:text-gold transition-colors text-sm break-all">{{ \App\Models\SiteSetting::get('email') }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="border-t border-white/8">
            <div
                class="max-w-7xl mx-auto px-4 lg:px-8 py-5 flex flex-col md:flex-row justify-between items-center gap-2 text-xs text-white/30">
                <p>© {{ date('Y') }} <span class="text-white/50">{{ $schoolName }}</span>. All rights reserved.
                </p>
                <p>Built with <span class="text-gold/60">♥</span> using Laravel · PHP 8.4</p>
            </div>
        </div>
    </footer>
    @include('components.popup-banner')
    @stack('scripts')
</body>

</html>
