@extends('layouts.app')
@section('title', 'School Transportation')
@section('meta_description', 'Safe, GPS-tracked school transportation at ' . \App\Models\SiteSetting::get('school_name',
    'Our School') . '. Every student accounted for, every journey monitored.')

    @push('styles')
        <style>
            /* ── Scroll reveal ─────────────────────────────────────────────────────── */
            .reveal {
                opacity: 0;
                transform: translateY(28px);
                transition: opacity .65s ease, transform .65s ease;
            }

            .reveal.from-left {
                transform: translateX(-36px);
            }

            .reveal.from-right {
                transform: translateX(36px);
            }

            .reveal.visible {
                opacity: 1;
                transform: translate(0);
            }

            .stagger>* {
                opacity: 0;
                transform: translateY(20px);
                transition: opacity .55s ease, transform .55s ease;
            }

            .stagger.visible>*:nth-child(1) {
                opacity: 1;
                transform: none;
                transition-delay: .05s
            }

            .stagger.visible>*:nth-child(2) {
                opacity: 1;
                transform: none;
                transition-delay: .13s
            }

            .stagger.visible>*:nth-child(3) {
                opacity: 1;
                transform: none;
                transition-delay: .21s
            }

            .stagger.visible>*:nth-child(4) {
                opacity: 1;
                transform: none;
                transition-delay: .29s
            }

            .stagger.visible>*:nth-child(5) {
                opacity: 1;
                transform: none;
                transition-delay: .37s
            }

            .stagger.visible>*:nth-child(6) {
                opacity: 1;
                transform: none;
                transition-delay: .45s
            }

            /* ── Hero gradient ─────────────────────────────────────────────────────── */
            .hero-transport {
                background: linear-gradient(135deg, #1a237e 0%, #283593 50%, #1565C0 100%);
                position: relative;
                overflow: hidden;
            }

            .hero-transport::before {
                content: '';
                position: absolute;
                inset: 0;
                background: radial-gradient(ellipse at 70% 50%, rgba(255, 255, 255, .04) 0%, transparent 60%),
                    radial-gradient(ellipse at 20% 80%, rgba(255, 193, 7, .05) 0%, transparent 50%);
            }

            /* ── Animated bus dot ──────────────────────────────────────────────────── */
            @keyframes bus-move {
                0% {
                    left: 10%
                }

                100% {
                    left: 85%
                }
            }

            .bus-dot {
                animation: bus-move 6s ease-in-out infinite alternate;
            }

            /* ── GPS map pulse ─────────────────────────────────────────────────────── */
            @keyframes gps-pulse {

                0%,
                100% {
                    transform: scale(1);
                    opacity: 1
                }

                50% {
                    transform: scale(1.4);
                    opacity: .6
                }
            }

            .gps-pulse {
                animation: gps-pulse 1.5s ease-in-out infinite;
            }

            /* ── Route card hover ──────────────────────────────────────────────────── */
            .route-card {
                transition: transform .25s ease, box-shadow .25s ease;
            }

            .route-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 20px 40px rgba(0, 0, 0, .08);
            }

            /* ── Safety card ───────────────────────────────────────────────────────── */
            .safety-card {
                transition: border-color .25s ease, box-shadow .25s ease;
            }

            .safety-card:hover {
                border-color: #C9A227;
                box-shadow: 0 8px 24px rgba(26, 35, 126, .06);
            }

            /* ── Commit feature chip ───────────────────────────────────────────────── */
            .commit-chip {
                transition: background .2s ease, border-color .2s ease;
            }

            .commit-chip:hover {
                background: rgba(255, 255, 255, .1);
                border-color: rgba(255, 255, 255, .2);
            }

            /* ── Step connector line ───────────────────────────────────────────────── */
            .step-line {
                flex: 1;
                height: 2px;
                background: linear-gradient(90deg, #1a237e, #1565C0, #FFC107);
            }

            /* ── Notification mock ─────────────────────────────────────────────────── */
            @keyframes slide-in {
                from {
                    transform: translateY(-12px);
                    opacity: 0
                }

                to {
                    transform: translateY(0);
                    opacity: 1
                }
            }

            .notif-mock {
                animation: slide-in .5s 1s ease both;
            }

            /* ── Float badge ───────────────────────────────────────────────────────── */
            @keyframes float-sm {

                0%,
                100% {
                    transform: translateY(0)
                }

                50% {
                    transform: translateY(-6px)
                }
            }

            .float-sm {
                animation: float-sm 3.5s ease-in-out infinite;
            }

            /* ── Counter ───────────────────────────────────────────────────────────── */
            .counter-num {
                font-variant-numeric: tabular-nums;
            }
        </style>
    @endpush

@section('content')

    @php $school = \App\Models\SiteSetting::get('school_name','SSSS'); @endphp

    {{-- ══════════════════════════════════════════════════════════════
     SECTION 1 — HERO
══════════════════════════════════════════════════════════════ --}}
    <section class="hero-transport py-20 lg:py-28 min-h-[540px] flex items-center">
        <div class="relative max-w-7xl mx-auto px-4 lg:px-8 w-full">
            <div class="grid lg:grid-cols-2 gap-14 items-center">

                {{-- Left --}}
                <div>
                    <div
                        class="inline-flex items-center gap-2 bg-white/10 border border-white/15 text-white/90 text-xs font-semibold px-4 py-2 rounded-full mb-7">
                        <span class="w-2 h-2 bg-emerald-400 rounded-full gps-pulse"></span>
                        GPS-Enabled & Actively Monitored
                    </div>
                    <h1 class="font-display font-bold text-white leading-tight mb-5" style="font-size:clamp(2rem,4.5vw,3rem)">
                        Safe, Smart &<br>
                        <span style="color:#FFC107">Monitored</span> School<br>
                        Transportation
                    </h1>
                    <p class="text-white/65 leading-relaxed mb-9 max-w-md text-sm lg:text-base">
                        Every journey is GPS-tracked, every student is accounted for, and every parent stays informed — in
                        real time. Because your child's safety is our highest priority.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="#routes"
                            class="inline-flex items-center gap-2 font-bold px-7 py-3.5 rounded-xl text-sm transition-all shadow-lg hover:shadow-yellow-400/30 hover:-translate-y-0.5"
                            style="background:#FFC107;color:#1a237e">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            View Routes
                        </a>
                        <a href="#register"
                            class="inline-flex items-center gap-2 border-2 border-white/35 hover:border-white text-white font-semibold px-7 py-3.5 rounded-xl text-sm transition-all">
                            Register Now
                        </a>
                    </div>

                    {{-- Stats strip --}}
                    <div class="flex gap-10 mt-12 pt-8 border-t border-white/10">
                        @foreach ([['8+', 'Buses'], ['200+', 'Students'], ['100%', 'GPS Covered']] as [$n, $l])
                            <div>
                                <div class="font-display font-bold text-white text-2xl leading-none counter-num">
                                    {{ $n }}</div>
                                <div class="text-white/50 text-xs mt-1">{{ $l }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Right — Bus image with floating chips --}}
                <div class="relative hidden lg:block">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl" style="aspect-ratio:4/3">
                        <img src="https://images.unsplash.com/photo-1570125909232-eb263c188f7e?w=900" alt="School bus"
                            class="w-full h-full object-cover">
                        <div class="absolute inset-0"
                            style="background:linear-gradient(180deg,rgba(26,35,126,.1),rgba(26,35,126,.3))"></div>
                    </div>

                    {{-- GPS chip top-right --}}
                    <div
                        class="float-sm absolute -top-3 right-3 bg-white rounded-2xl shadow-xl px-4 py-3 flex items-start gap-3 min-w-[185px]">
                        <div class="w-2.5 h-2.5 bg-emerald-400 rounded-full mt-1 gps-pulse shrink-0"></div>
                        <div>
                            <p class="font-bold text-slate-800 text-sm leading-tight">Bus {{ $school }}-04</p>
                            <p class="text-slate-400 text-xs mt-0.5">38 km/h · On Schedule</p>
                            <div class="h-0.5 bg-emerald-400 rounded-full mt-2 w-3/4"></div>
                        </div>
                    </div>

                    {{-- "All safe" chip bottom-left --}}
                    <div class="float-sm absolute -bottom-3 left-3 bg-white rounded-2xl shadow-xl px-4 py-3 flex items-center gap-3"
                        style="animation-delay:.8s">
                        <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-slate-800 text-sm leading-tight">All students safe</p>
                            <p class="text-slate-400 text-xs">Route B · 7:42 AM</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
     SECTION 2 — GPS TRACKING
══════════════════════════════════════════════════════════════ --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">

                {{-- Left --}}
                <div class="reveal from-left">
                    <div
                        class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 text-blue-600 text-xs font-bold px-3.5 py-2 rounded-full mb-6">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Real-Time GPS Tracking
                    </div>
                    <h2 class="font-display font-bold text-slate-900 text-3xl lg:text-4xl mb-4 leading-tight">
                        Know Where Your Child Is —<br><span class="text-blue-600">Every Minute</span>
                    </h2>
                    <p class="text-slate-500 leading-relaxed mb-7 text-sm">
                        All {{ $school }} buses are equipped with advanced GPS modules that broadcast live location
                        data every 10 seconds. Track your child's bus in real-time — from home, from work, from anywhere.
                    </p>

                    <div class="space-y-3.5 mb-7">
                        @foreach ([['#3B82F6', 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z', 'Live location updates every 10 seconds'], ['#F59E0B', 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9', 'Push notifications at each bus stop'], ['#EF4444', 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'Speed alerts when limit is exceeded'], ['#10B981', 'M13 10V3L4 14h7v7l9-11h-7z', 'Route deviation detection & alerts']] as [$color, $path, $text])
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0"
                                    style="background:{{ $color }}20">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        style="color:{{ $color }}">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="{{ $path }}" />
                                    </svg>
                                </div>
                                <span class="text-slate-600 text-sm">{{ $text }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-start gap-3">
                        <svg class="w-4 h-4 text-blue-500 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        <p class="text-blue-700 text-sm"><strong>School App Integration:</strong> Download the
                            {{ $school }} Parent App to access live GPS tracking, receive alerts, and communicate with
                            the transport team directly.</p>
                    </div>
                </div>

                {{-- Right — mock map --}}
                <div class="reveal from-right">
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl overflow-hidden shadow-lg">
                        {{-- Map header --}}
                        <div class="relative" style="height:220px; background:linear-gradient(180deg,#e8f0fe,#f0f4ff)">
                            {{-- Grid lines --}}
                            <svg class="absolute inset-0 w-full h-full opacity-30" preserveAspectRatio="none">
                                <defs>
                                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="#93c5fd" stroke-width=".5" />
                                    </pattern>
                                </defs>
                                <rect width="100%" height="100%" fill="url(#grid)" />
                            </svg>

                            {{-- Zoom controls --}}
                            <div class="absolute top-3 left-3 bg-white rounded-lg shadow-md flex flex-col">
                                <button
                                    class="w-7 h-7 flex items-center justify-center text-slate-600 hover:bg-slate-50 text-lg font-light border-b border-slate-100 rounded-t-lg">+</button>
                                <button
                                    class="w-7 h-7 flex items-center justify-center text-slate-600 hover:bg-slate-50 text-lg font-light rounded-b-lg">−</button>
                            </div>

                            {{-- LIVE badge --}}
                            <div
                                class="absolute top-3 right-3 flex items-center gap-1.5 bg-white rounded-full px-2.5 py-1 shadow-md">
                                <span class="w-2 h-2 bg-red-500 rounded-full gps-pulse"></span>
                                <span class="text-xs font-bold text-slate-700">LIVE</span>
                            </div>

                            {{-- Route path SVG --}}
                            <svg class="absolute inset-0 w-full h-full" viewBox="0 0 400 220" preserveAspectRatio="none">
                                <path d="M 30 180 Q 80 160 120 140 Q 160 120 200 110 Q 240 100 280 90 Q 320 80 360 60"
                                    fill="none" stroke="#93c5fd" stroke-width="2.5" stroke-dasharray="6,4"
                                    opacity=".7" />
                                <path d="M 30 180 Q 80 160 120 140 Q 160 120 200 110 Q 240 100 260 95" fill="none"
                                    stroke="#3B82F6" stroke-width="3" />
                            </svg>

                            {{-- Stop dots --}}
                            @foreach ([[20, 85, 'Zone 3'], [32, 72, 'Zone 2'], [43, 63, 'Sector B']] as [$x, $y, $lbl])
                                <div class="absolute"
                                    style="left:{{ $x }}%;top:{{ $y }}%;transform:translate(-50%,-50%)">
                                    <div class="w-3 h-3 bg-white border-2 border-blue-400 rounded-full shadow-sm"></div>
                                    <span
                                        class="absolute top-4 left-1/2 -translate-x-1/2 text-[9px] text-slate-500 whitespace-nowrap font-medium">{{ $lbl }}</span>
                                </div>
                            @endforeach

                            {{-- Bus marker --}}
                            <div class="absolute" style="left:66%;top:42%;transform:translate(-50%,-50%)">
                                <div class="w-5 h-5 rounded-full flex items-center justify-center shadow-lg"
                                    style="background:#FFC107">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                        <path
                                            d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z" />
                                    </svg>
                                </div>
                                <div
                                    class="absolute -top-5 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-[9px] px-1.5 py-0.5 rounded whitespace-nowrap font-bold">
                                    38 km/h</div>
                            </div>

                            {{-- Sector A label --}}
                            <div class="absolute" style="left:76%;top:30%">
                                <span class="text-[10px] text-slate-500 font-medium">Sector A</span>
                            </div>
                        </div>

                        {{-- Bus info bar --}}
                        <div class="px-5 py-4 flex items-center justify-between bg-white border-t border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                                    style="background:#FFF3CD">
                                    <svg class="w-4 h-4" style="color:#FFC107" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                        <path
                                            d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 text-sm">Bus {{ $school }}-04 · Route B</p>
                                    <p class="text-slate-400 text-xs">En route to campus · ETA 12 min</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 text-xs text-slate-500">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    24 students
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    38 km/h
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
     SECTION 3 — HOW IT WORKS (4 steps)
══════════════════════════════════════════════════════════════ --}}
    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">

            <div class="text-center mb-14 reveal">
                <div
                    class="inline-flex items-center gap-2 bg-amber-50 border border-amber-200 text-amber-700 text-xs font-bold px-4 py-2 rounded-full mb-5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    Smart Attendance & Notifications
                </div>
                <h2 class="font-display font-bold text-slate-900 text-3xl lg:text-4xl mb-3">How Our System Works</h2>
                <p class="text-slate-500 text-sm max-w-xl mx-auto leading-relaxed">
                    From the moment your child boards the bus to safe drop-off — every step is tracked, logged, and
                    communicated to you instantly.
                </p>
            </div>

            {{-- Steps --}}
            <div class="flex items-start gap-0 mb-14 stagger">
                @foreach ([['#1a237e', 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', '01', 'Student Boards Bus', 'Student taps their ID card on the bus scanner upon boarding.'], ['#3B82F6', 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', '02', 'Attendance Marked', 'Attendance is automatically logged in the school system in real-time.'], ['#FFC107', 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z', '03', 'Parent Notified', 'Parents receive an instant push notification on the school app.'], ['#10B981', 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', '04', 'Safely Dropped Off', 'Confirmation sent to parents upon safe drop-off at destination.']] as $i => [$color, $icon, $step, $title, $desc])
                    <div class="flex-1 flex flex-col items-center text-center px-2">
                        <div class="relative mb-4">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg mx-auto"
                                style="background:{{ $color }}">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $icon }}" />
                                </svg>
                            </div>
                            @if ($i < 3)
                                <div class="absolute top-7 left-full w-full h-px step-line -translate-y-px"
                                    style="width:calc(100% - 56px); left:56px; top:28px"></div>
                            @endif
                        </div>
                        <p class="text-xs font-black tracking-widest mb-1" style="color:{{ $color }}">STEP
                            {{ $step }}</p>
                        <h4 class="font-display font-bold text-slate-800 text-sm mb-2">{{ $title }}</h4>
                        <p class="text-slate-400 text-xs leading-relaxed">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Notification demo --}}
            <div class="grid lg:grid-cols-2 gap-12 items-center reveal">
                <div class="rounded-2xl overflow-hidden shadow-lg aspect-video">
                    <img src="https://images.unsplash.com/photo-1588702547919-26089e690ecc?w=800"
                        alt="Parent receiving notification" class="w-full h-full object-cover">
                </div>
                <div>
                    <h3 class="font-display font-bold text-slate-900 text-2xl mb-3">Instant Notifications, Always</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">
                        Parents receive a push notification the moment their child boards or exits the bus. No more
                        wondering — just confidence.
                    </p>
                    {{-- Mock phone notification --}}
                    <div
                        class="notif-mock bg-slate-900 rounded-2xl px-4 py-3.5 shadow-2xl max-w-sm flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 mt-0.5"
                            style="background:#1a237e">
                            <svg class="w-5 h-5" style="color:#FFC107" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                <path
                                    d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <p class="text-white text-xs font-bold">{{ $school }} Transport</p>
                                <p class="text-slate-400 text-[10px]">Now</p>
                            </div>
                            <p class="text-slate-300 text-xs leading-relaxed">
                                ✅ <strong class="text-white">Anish Sharma</strong> has boarded Bus {{ $school }}-04
                                at <strong class="text-white">Zone 2 Stop</strong>.
                            </p>
                            <p class="text-emerald-400 text-[11px] mt-1.5 font-semibold">ETA to school: 14 minutes</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
     SECTION 4 — SAFETY FEATURES
══════════════════════════════════════════════════════════════ --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">

            <div class="text-center mb-14 reveal">
                <div
                    class="inline-flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold px-4 py-2 rounded-full mb-5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Comprehensive Safety System
                </div>
                <h2 class="font-display font-bold text-slate-900 text-3xl lg:text-4xl mb-3">Safety is Never Optional</h2>
                <p class="text-slate-500 text-sm max-w-xl mx-auto leading-relaxed">
                    We have built a multi-layered safety ecosystem to ensure every student travels in a secure, monitored,
                    and comfortable environment.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-14 stagger">
                @foreach ([
            ['#3B82F6', 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'Verified Drivers', 'All drivers undergo thorough background checks, license verification, and safe-driving assessments before joining.'],
            ['#EF4444', 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'Speed Monitoring', 'Real-time GPS speed tracking with instant alerts when a vehicle exceeds the designated speed limit.'],
            ['#9333EA', 'M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z M15 13a3 3 0 11-6 0 3 3 0 016 0z', 'CCTV Surveillance', 'HD cameras installed inside all buses, with recordings available for review by school administration.'],
            ['#F59E0B', 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z', 'Emergency Support', 'Dedicated 24/7 emergency helpline for parents, drivers, and students. Rapid response protocol in place.'],
            ['#10B981', 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'Trained Staff', 'Drivers and bus monitors receive regular safety training, first aid certification, and conduct refreshers.'],
            ['#6366F1', 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'Child Safety Locks', 'All doors equipped with child-proof safety locks, seat belts, and fire safety equipment on every vehicle.'],
        ] as [$color, $path, $title, $desc])
                    <div class="safety-card bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-4"
                            style="background:{{ $color }}15">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                style="color:{{ $color }}">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="{{ $path }}" />
                            </svg>
                        </div>
                        <h4 class="font-display font-bold text-slate-800 text-base mb-2">{{ $title }}</h4>
                        <p class="text-slate-500 text-sm leading-relaxed">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Stats strip --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 stagger">
                @foreach ([['M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', '8', 'Buses in Fleet'], ['M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z', '12', 'Active Routes'], ['M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', '200+', 'Students Covered'], ['M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10', '15 km', 'Max Coverage']] as [$icon, $val, $label])
                    <div class="bg-white border border-slate-100 rounded-2xl p-6 text-center shadow-sm">
                        <svg class="w-7 h-7 mx-auto mb-3 text-slate-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="{{ $icon }}" />
                        </svg>
                        <div class="font-display font-bold text-slate-800 text-2xl counter-num">{{ $val }}</div>
                        <div class="text-slate-400 text-xs mt-1">{{ $label }}</div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
     SECTION 5 — ROUTES & COVERAGE
══════════════════════════════════════════════════════════════ --}}
    <section class="py-20 bg-slate-50" id="routes">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">

            <div class="text-center mb-12 reveal">
                <h2 class="font-display font-bold text-slate-900 text-3xl lg:text-4xl mb-3">Routes & Coverage</h2>
                <p class="text-slate-500 text-sm max-w-xl mx-auto">
                    Organised routes covering all major zones with dedicated bus assignments and fixed timings.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 stagger">
                @foreach ([['Route A', 'North Sector', '#3B82F6', '#DBEAFE', 'SSSS-01 & 02', '7 stops', 42, '7:15 AM'], ['Route B', 'East Zone', '#10B981', '#D1FAE5', 'SSSS-03 & 04', '9 stops', 54, '7:20 AM'], ['Route C', 'West & South', '#9333EA', '#EDE9FE', 'SSSS-05 & 06', '8 stops', 48, '7:10 AM']] as [$route, $area, $color, $bg, $buses, $stops, $students, $departure])
                    <div class="route-card bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                            <h4 class="font-display font-bold text-slate-800 text-lg">{{ $route }}</h4>
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full"
                                style="background:{{ $bg }};color:{{ $color }}">{{ $buses }}</span>
                        </div>
                        <div class="px-5 py-4 space-y-2.5">
                            @foreach ([['M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z', 'Coverage Area', $area], ['M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z', 'Stops', $stops], ['M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'Students', $students], ['M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'Departure', $departure]] as [$icon, $lbl, $val])
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2 text-slate-400 text-xs">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="{{ $icon }}" />
                                        </svg>
                                        {{ $lbl }}
                                    </div>
                                    <span class="text-slate-800 text-sm font-bold">{{ $val }}</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="px-5 pb-2">
                            <div class="h-1 rounded-full mb-3" style="background:{{ $bg }}">
                                <div class="h-full rounded-full"
                                    style="background:{{ $color }};width:{{ rand(60, 90) }}%"></div>
                            </div>
                        </div>
                        <div class="px-5 pb-5">
                            <a href="{{ route('contact.index') }}"
                                class="flex items-center justify-center gap-2 w-full border border-slate-200 hover:border-slate-400 text-slate-600 font-semibold py-2.5 rounded-xl text-sm transition-colors">
                                View Route Map
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

    {{-- ══════════════════════════════════════════════════════════════
     SECTION 6 — TRANSPARENCY / COMMITMENT (dark)
══════════════════════════════════════════════════════════════ --}}
    <section class="py-20 hero-transport">
        <div class="relative max-w-7xl mx-auto px-4 lg:px-8">

            <div class="text-center mb-12 reveal">
                <div
                    class="inline-flex items-center gap-2 bg-white/10 border border-white/15 text-white/80 text-xs font-bold px-4 py-2 rounded-full mb-5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Our Commitment to You
                </div>
                <h2 class="font-display font-bold text-white text-3xl lg:text-4xl mb-3">Transparency You Can Trust</h2>
                <p class="text-white/60 text-sm max-w-xl mx-auto">
                    We hold ourselves to the highest standards of accountability and openness — because your trust is
                    earned, not assumed.
                </p>
            </div>

            {{-- Feature chips --}}
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3 mb-10 stagger">
                @foreach ([['M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', '100% GPS Enabled Fleet'], ['M13 10V3L4 14h7v7l9-11h-7z', 'Live Speed Monitoring'], ['M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z', 'Regular Vehicle Inspection'], ['M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.14 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0', 'Real-time Parent Alerts'], ['M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'Background-Checked Drivers'], ['M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'Child Safety Protocols']] as [$icon, $label])
                    <div
                        class="commit-chip flex items-center gap-3 bg-white/8 border border-white/10 rounded-xl px-4 py-3">
                        <svg class="w-4 h-4 shrink-0" style="color:#FFC107" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="{{ $icon }}" />
                        </svg>
                        <span class="text-white text-sm font-medium">{{ $label }}</span>
                    </div>
                @endforeach
            </div>

            {{-- Stats footer --}}
            <div
                class="flex flex-wrap items-center justify-center gap-1 bg-white/8 border border-white/10 rounded-2xl px-8 py-5 max-w-lg mx-auto">
                @foreach ([['100%', 'GPS Fleet Coverage'], ['Monthly', 'Vehicle Inspections'], ['24/7', 'Emergency Line']] as $i => [$val, $lbl])
                    @if ($i > 0)
                        <div class="w-px h-8 bg-white/15"></div>
                    @endif
                    <div class="text-center px-6">
                        <div class="font-display font-bold text-white text-xl" style="color:#FFC107">{{ $val }}
                        </div>
                        <div class="text-white/55 text-xs mt-0.5">{{ $lbl }}</div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
     SECTION 7 — REPORT A CONCERN
══════════════════════════════════════════════════════════════ --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-14 items-start">

                {{-- Left --}}
                <div class="reveal from-left">
                    <div
                        class="inline-flex items-center gap-2 bg-red-50 border border-red-100 text-red-600 text-xs font-bold px-3.5 py-2 rounded-full mb-5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        Safety Reporting
                    </div>
                    <h2 class="font-display font-bold text-slate-900 text-3xl mb-4">Report a Concern</h2>
                    <p class="text-slate-500 text-sm leading-relaxed mb-7">
                        Witnessed unsafe driving, a delay, or have any concern about our transport service? We take every
                        report seriously. Use this form to let us know and our safety team will respond promptly.
                    </p>

                    <div class="space-y-4 mb-8">
                        @foreach ([['#3B82F6', 'Fast Response', 'All reports are reviewed within 24 hours by our safety coordinator.'], ['#9333EA', 'Confidential', 'Your identity is protected. Reports are handled with full discretion.'], ['#10B981', 'Action Taken', 'Every valid concern results in documented corrective action.']] as [$color, $title, $desc])
                            <div class="flex items-start gap-3">
                                <div class="w-7 h-7 rounded-full flex items-center justify-center shrink-0 mt-0.5"
                                    style="background:{{ $color }}15">
                                    <div class="w-2.5 h-2.5 rounded-full" style="background:{{ $color }}"></div>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800 text-sm">{{ $title }}</p>
                                    <p class="text-slate-400 text-xs mt-0.5 leading-relaxed">{{ $desc }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="rounded-2xl overflow-hidden shadow-md aspect-video relative">
                        <img src="https://images.unsplash.com/photo-1594608661623-aa0bd3a69d98?w=700"
                            alt="Students boarding safely" class="w-full h-full object-cover">
                        <div class="absolute inset-0 flex items-end p-5"
                            style="background:linear-gradient(to top,rgba(0,0,0,.6),transparent)">
                            <p class="text-white font-semibold text-sm italic">"Your feedback helps us keep every child
                                safe on every journey."</p>
                        </div>
                    </div>
                </div>

                {{-- Right — Report form --}}
                <div class="reveal from-right">
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-md overflow-hidden">
                        {{-- Coloured top accent --}}
                        <div class="h-1.5" style="background:linear-gradient(90deg,#EF4444,#FFC107,#1a237e)"></div>

                        <div class="p-7">
                            @if (session('report_success'))
                                <div
                                    class="bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl p-4 mb-5 text-sm flex items-center gap-2">
                                    <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Report submitted. Our team will review it within 24 hours.
                                </div>
                            @endif

                            <form action="{{ route('transport.report') }}" method="POST" enctype="multipart/form-data"
                                class="space-y-4">
                                @csrf

                                <div class="grid sm:grid-cols-2 gap-4">
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Issue
                                            Type <span class="text-red-400">*</span></label>
                                        <select name="issue_type" required
                                            class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 @error('issue_type') border-red-300 @enderror">
                                            <option value="">Select issue type</option>
                                            <option value="Unsafe Driving"
                                                {{ old('issue_type') === 'Unsafe Driving' ? 'selected' : '' }}>Unsafe Driving
                                            </option>
                                            <option value="Delay / Late"
                                                {{ old('issue_type') === 'Delay / Late' ? 'selected' : '' }}>Delay / Late
                                            </option>
                                            <option value="Missing Student"
                                                {{ old('issue_type') === 'Missing Student' ? 'selected' : '' }}>Missing Student
                                            </option>
                                            <option value="Bus Condition"
                                                {{ old('issue_type') === 'Bus Condition' ? 'selected' : '' }}>Bus Condition
                                            </option>
                                            <option value="Driver Behaviour"
                                                {{ old('issue_type') === 'Driver Behaviour' ? 'selected' : '' }}>Driver
                                                Behaviour</option>
                                            <option value="Route Issue"
                                                {{ old('issue_type') === 'Route Issue' ? 'selected' : '' }}>Route Issue
                                            </option>
                                            <option value="Other" {{ old('issue_type') === 'Other' ? 'selected' : '' }}>Other
                                            </option>
                                        </select>
                                        @error('issue_type')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Bus
                                            Number <span class="text-slate-400 font-normal">(optional)</span></label>
                                        <input type="text" name="bus_number" value="{{ old('bus_number') }}"
                                            class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400"
                                            placeholder="e.g. SSSS-04">
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Location
                                        / Area <span class="text-red-400">*</span></label>
                                    <input type="text" name="location" value="{{ old('location') }}" required
                                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 @error('location') border-red-300 @enderror"
                                        placeholder="e.g. Near City Park, Sector 3 junction">
                                    @error('location')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Your
                                        Name & Phone <span class="text-slate-400 font-normal">(optional — kept
                                            confidential)</span></label>
                                    <input type="text" name="reporter_name" value="{{ old('reporter_name') }}"
                                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400"
                                        placeholder="Name (optional)">
                                </div>

                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Description
                                        <span class="text-red-400">*</span></label>
                                    <textarea name="description" rows="4" required
                                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 @error('description') border-red-300 @enderror"
                                        placeholder="Please describe the incident in detail — time, what happened, any other relevant information…">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Upload
                                        Image / Video <span class="text-slate-400 font-normal">(optional)</span></label>
                                    <div class="border-2 border-dashed border-slate-200 hover:border-blue-400 rounded-xl p-5 text-center transition-colors cursor-pointer"
                                        onclick="document.getElementById('report-file').click()">
                                        <svg class="w-7 h-7 text-slate-300 mx-auto mb-1.5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                        <p class="text-slate-500 text-xs font-semibold">Click to upload</p>
                                        <p class="text-slate-400 text-[10px] mt-0.5">PNG, JPG, MP4 up to 20MB</p>
                                        <input type="file" id="report-file" name="attachment"
                                            accept="image/*,video/mp4" class="sr-only">
                                    </div>
                                </div>

                                <button type="submit"
                                    class="w-full font-bold py-3.5 rounded-xl text-sm text-white transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 flex items-center justify-center gap-2"
                                    style="background:#EF4444">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    Submit Report
                                </button>
                                <p
                                    class="text-center text-slate-400 text-xs flex items-center justify-center gap-1.5 mt-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    All reports are reviewed and handled seriously by our safety team
                                </p>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
     SECTION 8 — TESTIMONIALS
══════════════════════════════════════════════════════════════ --}}
    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">

            <div class="text-center mb-12 reveal">
                <div
                    class="inline-flex items-center gap-2 bg-amber-50 border border-amber-200 text-amber-700 text-xs font-bold px-4 py-2 rounded-full mb-5">
                    ⭐ Parent Testimonials
                </div>
                <h2 class="font-display font-bold text-slate-900 text-3xl lg:text-4xl mb-3">Trusted by Our School Community
                </h2>
                <p class="text-slate-500 text-sm">Hear from parents who rely on our transport service every school day.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6 mb-10 stagger">
                @foreach ([['SS', 'Sunita Sharma', 'Parent of Grade 7 Student', 'The GPS tracking gives me real peace of mind. I can see exactly where my daughter\'s bus is every morning. The notification when she boards is fantastic!'], ['RK', 'Ramesh Karki', 'Parent of Grade 10 Student', 'I love the instant notifications. The moment my son boards the bus I get an alert. It\'s transformed our morning routine — no more anxiety about whether he made it.'], ['PT', 'Priya Thapa', 'Parent of two students', 'Both my children travel daily by school bus. The CCTV and verified drivers give me complete confidence. The staff is punctual, professional, and caring.']] as [$initials, $name, $role, $quote])
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                        {{-- Stars --}}
                        <div class="flex gap-0.5 mb-4">
                            @for ($s = 0; $s < 5; $s++)
                                <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed mb-5 flex-1">"{{ $quote }}"</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0"
                                    style="background:#1a237e">{{ $initials }}</div>
                                <div>
                                    <p class="font-semibold text-slate-800 text-sm">{{ $name }}</p>
                                    <p class="text-slate-400 text-xs">{{ $role }}</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-blue-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Families trust strip --}}
            <div class="flex items-center justify-center gap-3 text-center">
                <div class="flex -space-x-2">
                    @foreach (['#1a237e', '#3B82F6', '#10B981', '#9333EA', '#EF4444', '#F59E0B'] as $c)
                        <div class="w-8 h-8 rounded-full border-2 border-white flex items-center justify-center text-white text-[10px] font-bold"
                            style="background:{{ $c }}">
                            {{ ['SS', 'RK', 'PT', 'AM', 'NK', 'BT'][array_search($c, ['#1a237e', '#3B82F6', '#10B981', '#9333EA', '#EF4444', '#F59E0B'])] }}
                        </div>
                    @endforeach
                </div>
                <p class="text-slate-600 text-sm"><strong>200+ families</strong> trust {{ $school }} transport daily
                </p>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
     SECTION 9 — REGISTER CTA
══════════════════════════════════════════════════════════════ --}}
    <section class="py-20 bg-white text-center" id="register">
        <div class="max-w-2xl mx-auto px-4 reveal">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg"
                style="background:#1a237e">
                <svg class="w-8 h-8" style="color:#FFC107" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                    <path
                        d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z" />
                </svg>
            </div>
            <h2 class="font-display font-bold text-slate-900 text-3xl lg:text-4xl mb-3">Register for School Transportation
            </h2>
            <p class="text-slate-500 text-sm leading-relaxed mb-10 max-w-lg mx-auto">
                Ensure your child travels safely every day. Register for {{ $school }} transport service for the
                2026–27 academic year. Limited seats available per route.
            </p>
            <div class="flex flex-wrap gap-4 justify-center mb-10">
                <a href="{{ route('admissions.index') }}"
                    class="inline-flex items-center gap-2 font-bold px-8 py-4 rounded-xl text-white text-sm shadow-lg hover:shadow-xl transition-all hover:-translate-y-0.5"
                    style="background:#1a237e">
                    Apply for Transportation
                </a>
                <a href="{{ route('contact.index') }}"
                    class="inline-flex items-center gap-2 font-semibold px-8 py-4 rounded-xl text-slate-700 text-sm border-2 border-slate-200 hover:border-slate-400 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    Contact Transport Office
                </a>
            </div>
            <div class="border-t border-slate-100 pt-8 flex flex-wrap gap-8 justify-center text-center">
                @foreach ([['M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'Safety First'], ['M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z', 'GPS Tracked'], ['M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9', 'Instant Alerts']] as [$icon, $label])
                    <div class="flex flex-col items-center gap-1.5">
                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="{{ $icon }}" />
                        </svg>
                        <span class="text-slate-500 text-xs font-medium">{{ $label }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const obs = new IntersectionObserver(e => {
                e.forEach(entry => {
                    if (entry.isIntersecting) entry.target.classList.add('visible');
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -40px 0px'
            });
            document.querySelectorAll('.reveal, .stagger').forEach(el => obs.observe(el));
        });
    </script>
@endpush
