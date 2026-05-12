<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — {{ \App\Models\SiteSetting::get('school_name', 'Admin') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            50: '#f4f6fa',
                            100: '#e9edf5',
                            200: '#c8d3e6',
                            300: '#a7b8d6',
                            400: '#6583b8',
                            500: '#234d99',
                            600: '#1f458a',
                            700: '#1b3a73',
                            800: '#152d59',
                            900: '#1B2A4A',
                            950: '#0d1525'
                        },
                        gold: {
                            50: '#fefbea',
                            100: '#fdf7c9',
                            200: '#fbed94',
                            300: '#f8dd5f',
                            400: '#f6ca2a',
                            500: '#C9A227',
                            600: '#b59223',
                            700: '#977a1d',
                            800: '#796217',
                            900: '#635013'
                        }
                    },
                    fontFamily: {
                        sans: ['DM Sans', 'sans-serif'],
                        display: ['Outfit', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Outfit:wght@600;700&display=swap"
        rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, .1);
            border-radius: 10px
        }

        .glass-header {
            background: rgba(255, 255, 255, .85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px)
        }

        .active-nav-item {
            background: linear-gradient(90deg, rgba(201, 162, 39, .15) 0%, rgba(201, 162, 39, 0) 100%);
            border-left: 3px solid #C9A227
        }

        @keyframes fade-up {
            from {
                opacity: 0;
                transform: translateY(10px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .animate-in {
            animation: fade-up .45s ease both
        }
    </style>
    @stack('styles')
</head>

<body class="bg-[#F8FAFC] text-slate-900 antialiased h-full" x-data="{ sidebarOpen: false }">

    <div x-show="sidebarOpen" x-transition:enter="transition ease-linear duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-linear duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click="sidebarOpen=false"
        class="fixed inset-0 bg-navy-950/60 z-40 lg:hidden" x-cloak></div>

    {{-- ── SIDEBAR ── --}}
    <aside
        class="fixed inset-y-0 left-0 w-64 bg-navy-900 text-white z-50 transform transition-transform duration-300 ease-in-out lg:translate-x-0 shadow-2xl"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

        <div class="h-20 flex items-center px-6 border-b border-white/5 bg-navy-950/30">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-lg" style="background:#C9A227">
                    <span
                        class="font-display font-bold text-white text-xl uppercase">{{ substr(\App\Models\SiteSetting::get('school_name', 'S'), 0, 1) }}</span>
                </div>
                <div class="overflow-hidden">
                    <h2 class="font-display font-bold text-sm tracking-tight truncate leading-tight">
                        {{ \App\Models\SiteSetting::get('school_name', 'School') }}</h2>
                    <span class="flex items-center gap-1 text-[10px] font-bold uppercase tracking-widest opacity-80"
                        style="color:#C9A227">
                        <span class="w-1 h-1 rounded-full animate-pulse" style="background:#C9A227"></span> Control
                        Center
                    </span>
                </div>
            </div>
        </div>

        <nav class="p-4 space-y-6 overflow-y-auto custom-scrollbar" style="height:calc(100vh - 80px)">

            @php
                $navItem = function (string $route, string $label, string $icon) {
                    $active = request()->routeIs($route) || request()->routeIs(rtrim($route, 'index') . '*');
                    $classes = $active
                        ? 'active-nav-item text-white'
                        : 'text-navy-300 hover:text-white hover:bg-white/5';
                    $iconColor = $active ? 'color:#C9A227' : '';
                    return <<<HTML
                    <a href="{{ route('{$route}') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all group {$classes}">
                        <svg class="w-5 h-5 text-navy-400 group-hover:text-gold-500 shrink-0" style="{$iconColor}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{$icon}"/>
                        </svg>{$label}
                    </a>
                    HTML;
                };
            @endphp

            {{-- Core --}}
            <div>
                <p class="px-4 text-[11px] font-bold text-navy-400 uppercase tracking-widest mb-3">Core</p>
                @php $navItems = [['admin.dashboard','Dashboard','M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6']]; @endphp
                @foreach ($navItems as [$r, $l, $i])
                    @php $active = request()->routeIs($r); @endphp
                    <a href="{{ route($r) }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all group {{ $active ? 'active-nav-item text-white' : 'text-navy-300 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-5 h-5 shrink-0 {{ $active ? '' : 'text-navy-400 group-hover:text-yellow-400' }}"
                            @if ($active) style="color:#C9A227" @endif fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="{{ $i }}" />
                        </svg>
                        {{ $l }}
                    </a>
                @endforeach
            </div>

            {{-- Content --}}
            <div>
                <p class="px-4 text-[11px] font-bold text-navy-400 uppercase tracking-widest mb-3">Content</p>
                <div class="space-y-0.5">
                    @foreach ([
        ['admin.heroes.index', 'Page Heroes', 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
        ['admin.blocks.index', 'Homepage Blocks', 'M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z'],

        ['admin.news.index', 'News & Updates', 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z'],
        ['admin.events.index', 'Events', 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
        ['admin.teachers.index', 'Faculty Members', 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
        ['admin.gallery.index', 'Gallery', 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
        ['admin.testimonials.index', 'Testimonials', 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z'],
        ['admin.faqs.index', 'FAQs', 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
    ] as [$r, $l, $i])
                        @php $active = request()->routeIs($r) || str_starts_with(request()->route()?->getName() ?? '', rtrim($r,'.index')); @endphp
                        <a href="{{ route($r) }}"
                            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all group {{ $active ? 'active-nav-item text-white' : 'text-navy-300 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-5 h-5 shrink-0 {{ $active ? '' : 'text-navy-400 group-hover:text-yellow-400' }}"
                                @if ($active) style="color:#C9A227" @endif fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $i }}" />
                            </svg>
                            {{ $l }}
                        </a>
                    @endforeach
                    @foreach ([
                        ['home', 'Home Page'],
                        ['about', 'About Us'],
                        ['programs', 'Programs'],
                        ['life-at-ssss', 'Life at SSSS'],
                        ['boarding', 'Boarding'],
                        ['transport', 'Transportation'],
                        ['admissions', 'Admissions'],
                        ['contact', 'Contact'],
                    ] as [$key, $label])
                        @php $active = request()->routeIs('admin.sections.*') && request()->route('pageKey') === $key; @endphp
                        <a href="{{ route('admin.sections.index', $key) }}"
                            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all group {{ $active ? 'active-nav-item text-white' : 'text-navy-300 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-5 h-5 shrink-0 {{ $active ? '' : 'text-navy-400 group-hover:text-yellow-400' }}"
                                @if ($active) style="color:#C9A227" @endif fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 5a1 1 0 011-1h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM8 8h8M8 12h8M8 16h5" />
                            </svg>
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Interactions --}}
            <div>
                <p class="px-4 text-[11px] font-bold text-navy-400 uppercase tracking-widest mb-3">Interactions</p>
                <div class="space-y-0.5">
                    @php
                        $aActive = request()->routeIs('admin.admissions*');
                        $cActive = request()->routeIs('admin.contacts*');
                    @endphp
                    <a href="{{ route('admin.admissions.index') }}"
                        class="flex items-center justify-between px-4 py-2.5 rounded-xl text-sm font-medium transition-all group {{ $aActive ? 'active-nav-item text-white' : 'text-navy-300 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 {{ $aActive ? '' : 'text-navy-400 group-hover:text-yellow-400' }}"
                                @if ($aActive) style="color:#C9A227" @endif fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Admissions
                        </div>
                        @php $na = \App\Models\Admission::where('status','new')->count(); @endphp
                        @if ($na)
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full"
                                style="background:#C9A227;color:#0d1525">{{ $na }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.contacts.index') }}"
                        class="flex items-center justify-between px-4 py-2.5 rounded-xl text-sm font-medium transition-all group {{ $cActive ? 'active-nav-item text-white' : 'text-navy-300 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 {{ $cActive ? '' : 'text-navy-400 group-hover:text-yellow-400' }}"
                                @if ($cActive) style="color:#C9A227" @endif fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Messages
                        </div>
                        @php $nu = \App\Models\Contact::where('is_read',false)->count(); @endphp
                        @if ($nu)
                            <span
                                class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $nu }}</span>
                        @endif
                    </a>
                </div>
            </div>

            {{-- System --}}
            <div>
                <p class="px-4 text-[11px] font-bold text-navy-400 uppercase tracking-widest mb-3">System</p>
                <div class="space-y-0.5">
                    @foreach ([['admin.settings.index', 'Site Settings', 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'], ['admin.menus.index', 'Navigation Menus', 'M4 6h16M4 12h16M4 18h7']] as [$r, $l, $i])
                        @php $active = request()->routeIs($r) || str_starts_with(request()->route()?->getName() ?? '', rtrim($r,'.index')); @endphp
                        <a href="{{ route($r) }}"
                            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all group {{ $active ? 'active-nav-item text-white' : 'text-navy-300 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-5 h-5 shrink-0 {{ $active ? '' : 'text-navy-400 group-hover:text-yellow-400' }}"
                                @if ($active) style="color:#C9A227" @endif fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $i }}" />
                            </svg>
                            {{ $l }}
                        </a>
                    @endforeach
                    @if (auth()->user()?->role === 'admin')
                        @php $active = request()->routeIs('admin.users*'); @endphp
                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all group {{ $active ? 'active-nav-item text-white' : 'text-navy-300 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-5 h-5 shrink-0 {{ $active ? '' : 'text-navy-400 group-hover:text-yellow-400' }}"
                                @if ($active) style="color:#C9A227" @endif fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>Users
                        </a>
                    @endif
                </div>
            </div>



            <div class="pt-4 border-t border-white/5">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-3 w-full px-4 py-2.5 rounded-xl text-sm font-medium text-red-400 hover:bg-red-500/10 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Sign Out
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    {{-- ── MAIN ── --}}
    <div class="lg:ml-64 flex flex-col min-h-screen">
        <header
            class="h-20 glass-header border-b border-slate-200 px-8 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen=true" class="lg:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div>
                    <h1 class="text-xl font-display font-bold text-navy-900 leading-tight">@yield('title', 'Overview')</h1>
                    <div class="flex items-center gap-2 text-xs text-slate-400 font-medium">
                        <span>Admin</span>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <span style="color:#C9A227">@yield('title', 'Dashboard')</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-6">
                <a href="{{ route('home') }}" target="_blank"
                    class="hidden md:flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-navy-900 transition-colors uppercase tracking-wider">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    Live Site
                </a>
                <div class="flex items-center gap-3 pl-6 border-l border-slate-200">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-navy-900 leading-none">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter mt-0.5">
                            {{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                    <div
                        class="w-10 h-10 bg-navy-100 border-2 border-white rounded-full flex items-center justify-center text-navy-700 font-bold shadow-sm ring-1 ring-slate-200">
                        {{ substr(auth()->user()->name, 0, 1) }}</div>
                </div>
            </div>
        </header>

        <main class="flex-1 p-8">
            <div class="max-w-6xl mx-auto">
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                        class="mb-6 flex items-center justify-between bg-emerald-50 border border-emerald-100 p-4 rounded-2xl shadow-sm">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center text-white shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                        </div>
                        <button @click="show=false" class="text-emerald-400 hover:text-emerald-600 ml-4 shrink-0"><svg
                                class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg></button>
                    </div>
                @endif
                @if (session('error'))
                    <div
                        class="mb-6 bg-red-50 border border-red-100 text-red-700 p-4 rounded-2xl text-sm flex items-center gap-3">
                        <svg class="w-5 h-5 shrink-0 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif
                <div class="animate-in">@yield('content')</div>
            </div>
        </main>

        <footer class="px-8 py-5 text-center border-t border-slate-200">
            <p class="text-xs text-slate-400 font-medium tracking-wide">&copy; {{ date('Y') }}
                {{ \App\Models\SiteSetting::get('school_name', 'School') }} &bull; Built by Sachin Adhikari</p>
        </footer>
    </div>
    @stack('scripts')
</body>

</html>
