<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', \App\Models\SiteSetting::get('school_name', 'Our School')) — @yield('page_title', \App\Models\SiteSetting::get('school_name', 'Excellence in Education'))</title>
    <meta name="description" content="@yield('meta_description', \App\Models\SiteSetting::get('meta_description', ''))">
    <link rel="icon"
        href="{{ \App\Models\SiteSetting::get('favicon') ? asset('storage/' . \App\Models\SiteSetting::get('favicon')) : asset('favicon.ico') }}">
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
                            300: '#7d95c3',
                            400: '#4e6da6',
                            500: '#2e4d8a',
                            600: '#1B2A4A',
                            700: '#16223d',
                            800: '#111a30',
                            900: '#0c1322'
                        },
                        gold: {
                            DEFAULT: '#C9A227',
                            50: '#fdf9ec',
                            100: '#faf0cc',
                            200: '#f4de91',
                            300: '#ecc84a',
                            400: '#C9A227',
                            500: '#b8911f',
                            600: '#9a7618',
                            700: '#7b5d14',
                            800: '#624a10',
                            900: '#503c0d'
                        },
                    },
                    fontFamily: {
                        display: ['"Playfair Display"', 'Georgia', 'serif'],
                        body: ['"DM Sans"', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'DM Sans', system-ui, sans-serif;
        }

        .font-display {
            font-family: 'Playfair Display', Georgia, serif;
        }

        .hero-gradient {
            background: linear-gradient(135deg, rgba(27, 42, 74, 0.92) 0%, rgba(27, 42, 74, 0.7) 60%, rgba(201, 162, 39, 0.3) 100%);
        }

        .gold-underline {
            position: relative;
        }

        .gold-underline::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 60px;
            height: 3px;
            background: #C9A227;
        }

        .nav-link {
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #C9A227;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(27, 42, 74, 0.15);
        }

        .section-divider {
            background: linear-gradient(90deg, transparent, #C9A227, transparent);
            height: 1px;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-white text-gray-800 antialiased">

    {{-- TOP BAR --}}
    <div class="bg-navy-600 text-white text-sm py-2 hidden md:block">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center gap-6 text-navy-100">
                @if (\App\Models\SiteSetting::get('phone'))
                    <a href="tel:{{ \App\Models\SiteSetting::get('phone') }}"
                        class="flex items-center gap-1.5 hover:text-gold transition-colors">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                        {{ \App\Models\SiteSetting::get('phone') }}
                    </a>
                @endif
                @if (\App\Models\SiteSetting::get('email'))
                    <a href="mailto:{{ \App\Models\SiteSetting::get('email') }}"
                        class="flex items-center gap-1.5 hover:text-gold transition-colors">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                        {{ \App\Models\SiteSetting::get('email') }}
                    </a>
                @endif
            </div>
            <div class="flex items-center gap-4">
                @foreach (['facebook', 'twitter', 'instagram', 'youtube'] as $social)
                    @if (\App\Models\SiteSetting::get($social))
                        <a href="{{ \App\Models\SiteSetting::get($social) }}" target="_blank"
                            class="hover:text-gold transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                @if ($social === 'facebook')
                                    <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z" />
                                @elseif($social === 'twitter')
                                    <path
                                        d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z" />
                                @elseif($social === 'instagram')
                                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
                                    <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z" fill="none"
                                        stroke="currentColor" stroke-width="1.5" />
                                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"
                                        stroke="currentColor" stroke-width="2" />
                                @elseif($social === 'youtube')
                                    <path
                                        d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 00-1.95 1.96A29 29 0 001 12a29 29 0 00.46 5.58a2.78 2.78 0 001.95 1.95C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58z" />
                                    <polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="#1B2A4A" />
                                @endif
                            </svg>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    {{-- MAIN NAV --}}
    <nav x-data="{ open: false, scrolled: false }" @scroll.window="scrolled = window.scrollY > 50"
        :class="scrolled || !{{ request()->is('/') ? 'true' : 'false' }} ? 'bg-white shadow-md' : 'bg-transparent'"
        class="sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-20">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    @if (\App\Models\SiteSetting::get('logo'))
                        <img src="{{ asset('storage/' . \App\Models\SiteSetting::get('logo')) }}"
                            alt="{{ \App\Models\SiteSetting::get('school_name') }}" class="h-14 w-auto">
                    @else
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-navy rounded-full flex items-center justify-center">
                                <span
                                    class="text-gold font-display font-bold text-lg">{{ substr(\App\Models\SiteSetting::get('school_name', 'S'), 0, 1) }}</span>
                            </div>
                            <div>
                                <div class="font-display font-bold text-navy text-lg leading-tight">
                                    {{ \App\Models\SiteSetting::get('school_name', 'Our School') }}</div>
                                <div class="text-xs text-gold tracking-widest uppercase">
                                    {{ \App\Models\SiteSetting::get('school_tagline', 'Excellence in Education') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden lg:flex items-center gap-1">
                    @php
                        $headerMenu = \App\Models\Menu::where('location', 'header')->with('items.children')->first();
                    @endphp
                    @if ($headerMenu)
                        @foreach ($headerMenu->items as $item)
                            <div class="relative" x-data="{ dropdown: false }">
                                @if ($item->children->count())
                                    <button @click="dropdown = !dropdown" @click.away="dropdown = false"
                                        class="nav-link flex items-center gap-1 px-3 py-2 text-navy font-medium hover:text-gold transition-colors text-sm">
                                        {{ $item->title }}
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div x-show="dropdown" x-cloak x-transition:enter="transition ease-out duration-150"
                                        x-transition:enter-start="opacity-0 translate-y-1"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        class="absolute top-full left-0 mt-1 w-52 bg-white shadow-xl border-t-2 border-gold rounded-b-lg py-1 z-50">
                                        @foreach ($item->children as $child)
                                            <a href="{{ $child->href }}"
                                                class="block px-4 py-2.5 text-sm text-navy hover:bg-navy-50 hover:text-gold transition-colors">{{ $child->title }}</a>
                                        @endforeach
                                    </div>
                                @else
                                    <a href="{{ $item->href }}"
                                        class="nav-link px-3 py-2 text-navy font-medium hover:text-gold transition-colors text-sm block">{{ $item->title }}</a>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <a href="{{ route('home') }}"
                            class="nav-link px-3 py-2 text-navy font-medium hover:text-gold transition-colors text-sm">Home</a>
                        <a href="{{ route('news.index') }}"
                            class="nav-link px-3 py-2 text-navy font-medium hover:text-gold transition-colors text-sm">News</a>
                        <a href="{{ route('events.index') }}"
                            class="nav-link px-3 py-2 text-navy font-medium hover:text-gold transition-colors text-sm">Events</a>
                        <a href="{{ route('teachers.index') }}"
                            class="nav-link px-3 py-2 text-navy font-medium hover:text-gold transition-colors text-sm">Faculty</a>
                        <a href="{{ route('gallery.index') }}"
                            class="nav-link px-3 py-2 text-navy font-medium hover:text-gold transition-colors text-sm">Gallery</a>
                        <a href="{{ route('faq.index') }}"
                            class="nav-link px-3 py-2 text-navy font-medium hover:text-gold transition-colors text-sm">FAQ</a>
                        <a href="{{ route('contact.index') }}"
                            class="nav-link px-3 py-2 text-navy font-medium hover:text-gold transition-colors text-sm">Contact</a>
                    @endif
                    <a href="{{ route('admissions.index') }}"
                        class="ml-3 bg-gold hover:bg-gold-500 text-white text-sm font-semibold px-5 py-2.5 rounded transition-colors shadow-sm">
                        Apply Now
                    </a>
                </div>

                {{-- Mobile toggle --}}
                <button @click="open = !open" class="lg:hidden p-2 text-navy">
                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="open" x-cloak class="w-6 h-6" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div x-show="open" x-cloak x-transition class="lg:hidden bg-white border-t border-gray-100 shadow-lg">
            <div class="px-4 py-4 space-y-1">
                <a href="{{ route('home') }}"
                    class="block py-2 text-navy font-medium border-b border-gray-100">Home</a>
                <a href="{{ route('news.index') }}"
                    class="block py-2 text-navy font-medium border-b border-gray-100">News</a>
                <a href="{{ route('events.index') }}"
                    class="block py-2 text-navy font-medium border-b border-gray-100">Events</a>
                <a href="{{ route('teachers.index') }}"
                    class="block py-2 text-navy font-medium border-b border-gray-100">Faculty</a>
                <a href="{{ route('gallery.index') }}"
                    class="block py-2 text-navy font-medium border-b border-gray-100">Gallery</a>
                <a href="{{ route('faq.index') }}"
                    class="block py-2 text-navy font-medium border-b border-gray-100">FAQ</a>
                <a href="{{ route('contact.index') }}"
                    class="block py-2 text-navy font-medium border-b border-gray-100">Contact</a>
                <a href="{{ route('admissions.index') }}"
                    class="block mt-3 bg-gold text-white text-center py-2.5 rounded font-semibold">Apply Now</a>
            </div>
        </div>
    </nav>

    {{-- PAGE CONTENT --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-navy text-white">
        <div class="max-w-7xl mx-auto px-4 py-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
            {{-- Brand --}}
            <div class="lg:col-span-2">
                <div class="font-display font-bold text-2xl mb-2">
                    {{ \App\Models\SiteSetting::get('school_name', 'Our School') }}</div>
                <div class="w-12 h-0.5 bg-gold mb-4"></div>
                <p class="text-navy-200 text-sm leading-relaxed mb-6">
                    {{ \App\Models\SiteSetting::get('about_short', 'Committed to excellence in education, nurturing every student to achieve their highest potential in a vibrant and supportive community.') }}
                </p>
                <div class="flex gap-3">
                    @foreach (['facebook', 'twitter', 'instagram', 'youtube'] as $social)
                        @if (\App\Models\SiteSetting::get($social))
                            <a href="{{ \App\Models\SiteSetting::get($social) }}" target="_blank"
                                class="w-9 h-9 bg-white/10 hover:bg-gold rounded flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    @if ($social === 'facebook')
                                        <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z" />
                                    @elseif($social === 'twitter')
                                        <path
                                            d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z" />
                                    @elseif($social === 'instagram')
                                        <rect x="2" y="2" width="20" height="20" rx="5"
                                            ry="5" fill="none" stroke="currentColor" stroke-width="2" />
                                        <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z" fill="none"
                                            stroke="currentColor" stroke-width="1.5" />
                                    @elseif($social === 'youtube')
                                        <path
                                            d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 00-1.95 1.96A29 29 0 001 12a29 29 0 00.46 5.58a2.78 2.78 0 001.95 1.95C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58z" />
                                        <polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="white" />
                                    @endif
                                </svg>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="font-display font-semibold text-lg mb-4">Quick Links</h4>
                <div class="w-8 h-0.5 bg-gold mb-4"></div>
                <ul class="space-y-2 text-sm text-navy-200">
                    <li><a href="{{ route('home') }}" class="hover:text-gold transition-colors">Home</a></li>
                    <li><a href="{{ route('news.index') }}" class="hover:text-gold transition-colors">Latest News</a>
                    </li>
                    <li><a href="{{ route('events.index') }}" class="hover:text-gold transition-colors">Events</a>
                    </li>
                    <li><a href="{{ route('teachers.index') }}" class="hover:text-gold transition-colors">Our
                            Faculty</a></li>
                    <li><a href="{{ route('gallery.index') }}" class="hover:text-gold transition-colors">Gallery</a>
                    </li>
                    <li><a href="{{ route('admissions.index') }}"
                            class="hover:text-gold transition-colors">Admissions</a></li>
                    <li><a href="{{ route('contact.index') }}" class="hover:text-gold transition-colors">Contact
                            Us</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="font-display font-semibold text-lg mb-4">Contact Us</h4>
                <div class="w-8 h-0.5 bg-gold mb-4"></div>
                <ul class="space-y-3 text-sm text-navy-200">
                    @if (\App\Models\SiteSetting::get('address'))
                        <li class="flex gap-2.5">
                            <svg class="w-4 h-4 mt-0.5 text-gold shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ \App\Models\SiteSetting::get('address') }}
                        </li>
                    @endif
                    @if (\App\Models\SiteSetting::get('phone'))
                        <li class="flex gap-2.5">
                            <svg class="w-4 h-4 mt-0.5 text-gold shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                            </svg>
                            {{ \App\Models\SiteSetting::get('phone') }}
                        </li>
                    @endif
                    @if (\App\Models\SiteSetting::get('email'))
                        <li class="flex gap-2.5">
                            <svg class="w-4 h-4 mt-0.5 text-gold shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                            {{ \App\Models\SiteSetting::get('email') }}
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10">
            <div
                class="max-w-7xl mx-auto px-4 py-5 flex flex-col md:flex-row justify-between items-center gap-2 text-navy-300 text-xs">
                <p>© {{ date('Y') }} {{ \App\Models\SiteSetting::get('school_name', 'Our School') }}. All rights
                    reserved.</p>
                <p>Built with Laravel 12 · PHP 8.4</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>
