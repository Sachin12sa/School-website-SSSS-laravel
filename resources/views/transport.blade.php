@extends('layouts.app')
@section('title', 'School Transportation')
@section('meta_description', 'Safe, GPS-tracked school transportation at ' . \App\Models\SiteSetting::get('school_name', 'Our School') . '. Every student accounted for, every journey monitored.')

@push('styles')
<style>
@keyframes page-enter  { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:none} }
@keyframes badge-drop  { from{opacity:0;transform:translateY(-10px) scale(.95)} to{opacity:1;transform:none} }
@keyframes gps-pulse   { 0%,100%{transform:scale(1);opacity:1} 50%{transform:scale(1.45);opacity:.55} }
@keyframes bus-move    { 0%{left:8%} 100%{left:84%} }
@keyframes float-chip  { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-7px)} }
@keyframes notif-in    { from{transform:translateY(-12px);opacity:0} to{transform:translateY(0);opacity:1} }

.h-anim-1 { animation: badge-drop .6s .08s both cubic-bezier(0.23,1,0.32,1); }
.h-anim-2 { animation: page-enter .85s .2s  both cubic-bezier(0.23,1,0.32,1); }
.h-anim-3 { animation: page-enter .85s .38s both cubic-bezier(0.23,1,0.32,1); }
.h-anim-4 { animation: page-enter .85s .52s both cubic-bezier(0.23,1,0.32,1); }
.h-anim-5 { animation: page-enter .9s .68s  both cubic-bezier(0.23,1,0.32,1); }

.gps-dot  { animation: gps-pulse 1.5s ease-in-out infinite; }
.float-chip { animation: float-chip 3.5s ease-in-out infinite; }
.notif-mock { animation: notif-in .5s 1s var(--ease-out) both; }
.bus-dot { animation: bus-move 6s ease-in-out infinite alternate; }

/* ── Hero (navy gradient, matches site palette) ──────────────── */
.hero-transport {
    background: linear-gradient(140deg, #0D1B2E 0%, #111d35 40%, #1a1035 70%, #0D1B2E 100%);
    position: relative;
    overflow: hidden;
}
.hero-transport::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 70% 50%, rgba(255,255,255,.03) 0%, transparent 60%),
                radial-gradient(ellipse at 20% 80%, rgba(201,162,39,.06) 0%, transparent 50%);
    pointer-events: none;
}

/* ── Safety card ──────────────────────────────────────────────── */
.safety-card {
    border-radius: 20px;
    transition: transform .28s var(--ease-spring),
                box-shadow .28s ease,
                border-color .22s var(--ease-out);
}
@media (hover:hover) and (pointer:fine) {
    .safety-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 44px rgba(13,27,46,0.09);
        border-color: rgba(201,162,39,0.3) !important;
    }
}

/* ── Stat metric card ─────────────────────────────────────────── */
.metric-card {
    border-radius: 20px;
    transition: transform .25s var(--ease-spring), box-shadow .25s ease;
}
@media (hover:hover) and (pointer:fine) {
    .metric-card:hover { transform: translateY(-4px); box-shadow: 0 16px 36px rgba(13,27,46,0.08); }
}

/* ── Route card ───────────────────────────────────────────────── */
.route-card {
    border-radius: 20px;
    transition: transform .28s var(--ease-spring), box-shadow .28s ease;
}
@media (hover:hover) and (pointer:fine) {
    .route-card:hover { transform: translateY(-5px); box-shadow: 0 24px 48px rgba(13,27,46,0.10); }
}

/* ── Commitment chip ──────────────────────────────────────────── */
.commit-chip {
    display: flex; align-items: center; gap: 12px;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 14px;
    padding: 12px 16px;
    transition: background .18s var(--ease-out), border-color .18s var(--ease-out);
}
@media (hover:hover) and (pointer:fine) {
    .commit-chip:hover { background: rgba(255,255,255,0.1); border-color: rgba(201,162,39,0.3); }
}

/* ── Step connector ───────────────────────────────────────────── */
.step-line {
    flex: 1; height: 2px;
    background: linear-gradient(90deg, var(--navy), var(--gold));
}

/* ── Testimonial card ─────────────────────────────────────────── */
.testimonial-card {
    border-radius: 20px;
    transition: transform .28s var(--ease-spring), box-shadow .28s ease;
}
@media (hover:hover) and (pointer:fine) {
    .testimonial-card:hover { transform: translateY(-4px); box-shadow: 0 20px 44px rgba(13,27,46,0.08); }
}

/* ── Report concern features ──────────────────────────────────── */
.concern-feat {
    display: flex; align-items: flex-start; gap: 12px;
    transition: transform .18s var(--ease-out);
}
@media (hover:hover) and (pointer:fine) { .concern-feat:hover { transform: translateX(4px); } }

/* ── Form inputs ──────────────────────────────────────────────── */
.form-label {
    display: block;
    font-size: 10px; font-weight: 700;
    color: #6B7A8D;
    letter-spacing: 0.12em; text-transform: uppercase;
    margin-bottom: 8px;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.form-input {
    width: 100%;
    border: 1.5px solid rgba(13,27,46,0.12);
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 13.5px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--navy); background: #fff;
    outline: none;
    transition: border-color .18s var(--ease-out), box-shadow .18s ease;
}
.form-input:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(201,162,39,0.12); }
.form-input.error { border-color: #EF4444; }
.form-error { color: #EF4444; font-size: 11px; margin-top: 4px; font-family: 'Plus Jakarta Sans',sans-serif; }

/* ── Trust strip avatars ──────────────────────────────────────── */
.trust-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    border: 2px solid #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 10px; font-weight: 700; color: #fff;
    margin-left: -10px; first:margin-left:0;
}

/* ── Grand CTA ────────────────────────────────────────────────── */
.grand-cta { position: relative; overflow: hidden; z-index: 1; }
.cta-canvas { position: absolute; top:0; left:0; width:100%; height:100%; z-index:-1; pointer-events:none; }
</style>
@endpush

@section('content')

@php $school = \App\Models\SiteSetting::get('school_name','SSSS'); @endphp

{{-- ══ HERO ══════════════════════════════════════════════════════════ --}}
@php $hero = $hero ?? \App\Models\PageHero::forPage('transport'); @endphp
@if($hero)
<x-page-hero :hero="$hero">
    {{-- Right — Bus image with floating chips --}}
    <div class="absolute inset-0 pointer-events-none hidden lg:block">
        <div class="relative w-full h-full max-w-7xl mx-auto">
            {{-- GPS chip --}}
            <div class="float-chip absolute top-32 right-10 bg-white rounded-2xl shadow-xl px-4 py-3 flex items-start gap-3 min-w-[185px] pointer-events-auto">
                <div class="w-2.5 h-2.5 rounded-full mt-1 shrink-0 gps-dot" style="background:#34D399"></div>
                <div>
                    <p class="font-bold text-navy text-sm leading-tight" style="font-family:'Plus Jakarta Sans',sans-serif">Bus {{ $school }}-04</p>
                    <p class="text-gray-400 text-xs mt-0.5" style="font-family:'Plus Jakarta Sans',sans-serif">38 km/h · On Schedule</p>
                    <div class="h-0.5 rounded-full mt-2 w-3/4" style="background:#34D399"></div>
                </div>
            </div>

            {{-- All safe chip --}}
            <div class="float-chip absolute bottom-32 right-[45%] bg-white rounded-2xl shadow-xl px-4 py-3 flex items-center gap-3 pointer-events-auto" style="animation-delay:.8s">
                <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0" style="background:#D1FAE5">
                    <svg class="w-4 h-4" style="color:#059669" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <p class="font-bold text-navy text-sm" style="font-family:'Plus Jakarta Sans',sans-serif">All Students Accounted</p>
                    <p class="text-gray-400 text-xs" style="font-family:'Plus Jakarta Sans',sans-serif">38/38 students on board</p>
                </div>
            </div>
        </div>
    </div>
</x-page-hero>
@endif

@if(($sections ?? collect())->isNotEmpty())
    @foreach($sections as $i => $section)
        @include('components.section-renderer', ['section' => $section, 'index' => $i])
    @endforeach
@else

{{-- ══ QUICK STATS ══════════════════════════════════════════════════════ --}}
<section class="py-10" style="background:var(--navy)">
<div class="max-w-7xl mx-auto px-6 lg:px-8 grid grid-cols-2 md:grid-cols-4 gap-6">
    @foreach([
        ['M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', '8+', 'Buses in Fleet'],
        ['M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z', '12', 'Active Routes'],
        ['M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', '200+', 'Students Covered'],
        ['M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7', '15 km', 'Max Coverage'],
    ] as [$iconPath, $val, $label])
    <div class="flex items-center gap-3 text-white">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.12)">
            <svg class="w-5 h-5" style="color:var(--gold)" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPath }}"/></svg>
        </div>
        <div>
            <div class="font-display font-bold text-white text-xl leading-none">{{ $val }}</div>
            <div class="text-white/45 text-xs mt-0.5" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $label }}</div>
        </div>
    </div>
    @endforeach
</div>
</section>

{{-- ══ HOW IT WORKS ═════════════════════════════════════════════════════ --}}
<section class="py-28" style="background:var(--cream)">
<div class="max-w-7xl mx-auto px-6 lg:px-8">
    <div class="text-center mb-16 reveal">
        <div class="section-label justify-center">Smart Attendance &amp; Notifications</div>
        <h2 class="section-title">How Our System Works</h2>
        <div class="gold-bar mx-auto mt-4"></div>
        <p class="text-gray-400 text-sm mt-6 max-w-xl mx-auto leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif">
            From the moment your child boards the bus to safe drop-off — every step is tracked, logged, and communicated to you instantly.
        </p>
    </div>

    {{-- Steps --}}
    <div class="flex items-start gap-0 mb-20 stagger">
        @foreach([
            ['var(--navy)',  'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', '01', 'Student Boards Bus',    'Student taps ID card on the bus scanner upon boarding.'],
            ['var(--gold)',  'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',                                                                                                         '02', 'Attendance Marked',    'Attendance is automatically logged in the school system.'],
            ['#059669',     'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z',                                                                           '03', 'Parent Notified',      'Parents receive an instant push notification on the app.'],
            ['#3B82F6',     'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', '04', 'Safely Dropped Off',  'Confirmation sent to parents upon safe arrival.'],
        ] as $i => [$color, $icon, $step, $title, $desc])
        <div class="flex-1 flex flex-col items-center text-center px-2">
            <div class="relative mb-5">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg mx-auto border-4 border-white" style="background:{{ $color }}">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/></svg>
                </div>
                @if($i < 3)
                <div class="step-line absolute" style="top:28px;left:56px;width:calc(100% - 56px)"></div>
                @endif
            </div>
            <p class="text-xs font-black tracking-widest mb-1.5" style="color:{{ $color }};font-family:'Plus Jakarta Sans',sans-serif">STEP {{ $step }}</p>
            <h4 class="font-display font-bold text-navy text-sm mb-1.5">{{ $title }}</h4>
            <p class="text-gray-400 text-xs leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $desc }}</p>
        </div>
        @endforeach
    </div>

    {{-- Notification demo --}}
    <div class="grid lg:grid-cols-2 gap-16 items-center reveal">
        <div class="img-zoom rounded-[24px] overflow-hidden shadow-[0_24px_64px_rgba(13,27,46,0.12)]" style="aspect-ratio:16/9">
            <img src="https://images.unsplash.com/photo-1588702547919-26089e690ecc?w=800" alt="Parent receiving notification" class="w-full h-full object-cover">
        </div>
        <div>
            <div class="section-label">Always Connected</div>
            <h3 class="font-display font-bold text-navy text-2xl mb-4" style="letter-spacing:-0.02em">Instant Notifications, Always</h3>
            <p class="text-gray-500 text-sm leading-[1.85] mb-7" style="font-family:'Plus Jakarta Sans',sans-serif">
                Parents receive a push notification the moment their child boards or exits the bus. No more wondering — just confidence.
            </p>
            {{-- Mock notification --}}
            <div class="notif-mock rounded-2xl px-4 py-4 shadow-2xl max-w-sm flex items-start gap-3" style="background:#1a2030">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 mt-0.5" style="background:var(--navy)">
                    <svg class="w-5 h-5" style="color:var(--gold)" fill="currentColor" viewBox="0 0 20 20"><path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/><path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3z"/></svg>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <p class="text-white text-xs font-bold" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $school }} Transport</p>
                        <p class="text-white/30 text-[10px]" style="font-family:'Plus Jakarta Sans',sans-serif">Now</p>
                    </div>
                    <p class="text-white/65 text-xs leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif">
                        <strong class="text-white">Anish Sharma</strong> has boarded Bus {{ $school }}-04 at <strong class="text-white">Zone 2 Stop</strong>.
                    </p>
                    <p class="text-xs mt-1.5 font-semibold" style="color:#34D399;font-family:'Plus Jakarta Sans',sans-serif">ETA to school: 14 minutes</p>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

{{-- ══ SAFETY FEATURES ══════════════════════════════════════════════════ --}}
<section class="py-28" style="background:#fff">
<div class="max-w-7xl mx-auto px-6 lg:px-8">
    <div class="text-center mb-16 reveal">
        <div class="section-label justify-center">Comprehensive Safety System</div>
        <h2 class="section-title">Safety is Never Optional</h2>
        <div class="gold-bar mx-auto mt-4"></div>
        <p class="text-gray-400 text-sm mt-6 max-w-xl mx-auto leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif">
            We have built a multi-layered safety ecosystem to ensure every student travels in a secure, monitored, and comfortable environment.
        </p>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-16 stagger">
        @foreach([
            ['#3B82F6', 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'Verified Drivers',    'All drivers undergo thorough background checks, license verification, and safe-driving assessments before joining.'],
            ['#EF4444', 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',                                                                                                                                                                                                                                                                                             'Speed Monitoring',    'Real-time GPS speed tracking with instant alerts when a vehicle exceeds the designated speed limit.'],
            ['#9333EA', 'M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z M15 13a3 3 0 11-6 0 3 3 0 016 0z',                                                                                                                                         'CCTV Surveillance',   'HD cameras installed inside all buses, with recordings available for review by school administration.'],
            ['#F59E0B', 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z',                                                                                                                      'Emergency Support',   'Dedicated 24/7 emergency helpline for parents, drivers, and students. Rapid response protocol in place.'],
            ['#059669', 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',                                                                                                                                              'Trained Staff',       'Drivers and bus monitors receive regular safety training, first aid certification, and conduct refreshers.'],
            ['#6366F1', 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z',                                                                                                                                                                                                                                        'Child Safety Locks',  'All doors equipped with child-proof safety locks, seat belts, and fire safety equipment on every vehicle.'],
        ] as [$color, $path, $title, $desc])
        <div class="safety-card bg-white border border-gray-100 p-6 shadow-sm">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-5" style="background:{{ $color }}18">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" style="color:{{ $color }}"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $path }}"/></svg>
            </div>
            <h4 class="font-display font-bold text-navy text-base mb-2">{{ $title }}</h4>
            <p class="text-gray-400 text-sm leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $desc }}</p>
        </div>
        @endforeach
    </div>

    {{-- Metrics --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 stagger">
        @foreach([
            ['M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',                                                                                                                                                                                                                                                                  '8',    'Buses in Fleet'],
            ['M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z',                                                                                                                                                                                                                                      '12',   'Active Routes'],
            ['M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', '200+', 'Students Covered'],
            ['M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',                                                                                                                                                                                                '15 km','Max Coverage'],
        ] as [$icon, $val, $label])
        <div class="metric-card bg-white border border-gray-100 p-6 text-center shadow-sm">
            <svg class="w-7 h-7 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/></svg>
            <div class="font-display font-bold text-navy text-2xl" style="font-variant-numeric:tabular-nums">{{ $val }}</div>
            <div class="text-gray-400 text-xs mt-1" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $label }}</div>
        </div>
        @endforeach
    </div>
</div>
</section>

{{-- ══ ROUTES & COVERAGE ════════════════════════════════════════════════ --}}
<section class="py-28" style="background:var(--cream)" id="routes">
<div class="max-w-7xl mx-auto px-6 lg:px-8">
    <div class="text-center mb-16 reveal">
        <div class="section-label justify-center">Where We Go</div>
        <h2 class="section-title">Routes &amp; Coverage</h2>
        <div class="gold-bar mx-auto mt-4"></div>
        <p class="text-gray-400 text-sm mt-6 max-w-xl mx-auto" style="font-family:'Plus Jakarta Sans',sans-serif">
            Organised routes covering all major zones with dedicated bus assignments and fixed timings.
        </p>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 stagger">
        @foreach([
            ['Route A','North Sector', '#3B82F6','#DBEAFE','SSSS-01 & 02','7 stops',42,'7:15 AM'],
            ['Route B','East Zone',   '#059669','#D1FAE5','SSSS-03 & 04','9 stops',54,'7:20 AM'],
            ['Route C','West & South','#9333EA','#EDE9FE','SSSS-05 & 06','8 stops',48,'7:10 AM'],
        ] as [$route,$area,$color,$bg,$buses,$stops,$students,$departure])
        <div class="route-card bg-white border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h4 class="font-display font-bold text-navy text-lg">{{ $route }}</h4>
                <span class="text-xs font-bold px-3 py-1 rounded-full" style="background:{{ $bg }};color:{{ $color }}">{{ $buses }}</span>
            </div>
            <div class="px-6 py-4 space-y-3">
                @foreach([['M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z','Coverage Area',$area],['M3 12l2-2m0 0l7-7 7 7','Stops',$stops],['M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z','Students',$students],['M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z','Departure',$departure]] as [$icon,$lbl,$val])
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2 text-gray-400 text-xs" style="font-family:'Plus Jakarta Sans',sans-serif">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>
                        {{ $lbl }}
                    </div>
                    <span class="text-navy text-sm font-bold" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $val }}</span>
                </div>
                @endforeach
            </div>
            <div class="px-6 pb-2">
                <div class="h-1 rounded-full mb-3" style="background:{{ $bg }}">
                    <div class="h-full rounded-full" style="background:{{ $color }};width:{{ rand(65,88) }}%"></div>
                </div>
            </div>
            <div class="px-6 pb-6">
                <a href="{{ route('contact.index') }}" class="flex items-center justify-center gap-2 w-full border border-gray-200 hover:border-gray-400 text-gray-500 font-semibold py-2.5 rounded-xl text-sm transition-colors" style="font-family:'Plus Jakarta Sans',sans-serif;transition-timing-function:var(--ease-out)">
                    View Route Map
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
</section>

{{-- ══ TRANSPARENCY / COMMITMENT ════════════════════════════════════════ --}}
<section class="py-28 hero-transport">
<div class="relative max-w-7xl mx-auto px-6 lg:px-8">
    <div class="text-center mb-14 reveal">
        <div class="section-label justify-center" style="color:rgba(201,162,39,0.8)">Our Commitment to You</div>
        <h2 class="font-display font-bold text-white mb-3" style="font-size:clamp(1.8rem,3.5vw,2.8rem);line-height:1.1;letter-spacing:-0.02em">Transparency You Can Trust</h2>
        <div class="mx-auto mt-4 mb-3" style="width:48px;height:2px;background:linear-gradient(90deg,var(--gold),var(--gold-light));border-radius:2px"></div>
        <p class="text-white/55 text-sm mt-6 max-w-xl mx-auto" style="font-family:'Plus Jakarta Sans',sans-serif">
            We hold ourselves to the highest standards of accountability — because your trust is earned, not assumed.
        </p>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3 mb-10 stagger">
        @foreach([
            ['M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',                                                                                                                                                                                                                          '100% GPS Enabled Fleet'],
            ['M13 10V3L4 14h7v7l9-11h-7z',                                                                                                                                                                                                                                              'Live Speed Monitoring'],
            ['M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z',             'Regular Vehicle Inspection'],
            ['M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.14 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0',                                'Real-time Parent Alerts'],
            ['M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'Background-Checked Drivers'],
            ['M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z',                                                                 'Child Safety Protocols'],
        ] as [$icon,$label])
        <div class="commit-chip">
            <svg class="w-4 h-4 shrink-0" style="color:var(--gold)" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/></svg>
            <span class="text-white text-sm font-medium" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $label }}</span>
        </div>
        @endforeach
    </div>

    {{-- Stats strip --}}
    <div class="flex flex-wrap items-center justify-center gap-1 rounded-2xl px-8 py-5 max-w-lg mx-auto border" style="background:rgba(255,255,255,0.07);border-color:rgba(255,255,255,0.1)">
        @foreach([['100%','GPS Fleet Coverage'],['Monthly','Vehicle Inspections'],['24/7','Emergency Line']] as $i => [$val,$lbl])
        @if($i > 0)<div class="w-px h-8" style="background:rgba(255,255,255,0.14)"></div>@endif
        <div class="text-center px-6">
            <div class="font-display font-bold text-xl" style="color:var(--gold)">{{ $val }}</div>
            <div class="text-white/50 text-xs mt-0.5" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $lbl }}</div>
        </div>
        @endforeach
    </div>
</div>
</section>

{{-- ══ REPORT A CONCERN ═════════════════════════════════════════════════ --}}
<section class="py-28" style="background:#fff">
<div class="max-w-7xl mx-auto px-6 lg:px-8">
<div class="grid lg:grid-cols-2 gap-16 items-start">

    {{-- Left --}}
    <div class="reveal from-left">
        <div class="inline-flex items-center gap-2 rounded-full px-4 py-2 mb-6 border" style="background:rgba(239,68,68,0.07);border-color:rgba(239,68,68,0.2);color:#DC2626;font-size:10.5px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;font-family:'Plus Jakarta Sans',sans-serif">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            Safety Reporting
        </div>
        <h2 class="font-display font-bold text-navy mb-4" style="font-size:clamp(1.8rem,3vw,2.4rem);letter-spacing:-0.02em">Report a Concern</h2>
        <p class="text-gray-500 text-sm leading-[1.85] mb-8" style="font-family:'Plus Jakarta Sans',sans-serif">
            Witnessed unsafe driving, a delay, or have any concern about our transport service? We take every report seriously.
        </p>

        <div class="space-y-4 mb-8">
            @foreach([
                ['#3B82F6','Fast Response', 'All reports are reviewed within 24 hours by our safety coordinator.'],
                ['#9333EA','Confidential',  'Your identity is protected. Reports are handled with full discretion.'],
                ['#059669','Action Taken',  'Every valid concern results in documented corrective action.'],
            ] as [$color,$title,$desc])
            <div class="concern-feat">
                <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 mt-0.5" style="background:{{ $color }}18">
                    <div class="w-3 h-3 rounded-full" style="background:{{ $color }}"></div>
                </div>
                <div>
                    <p class="font-semibold text-navy text-sm" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $title }}</p>
                    <p class="text-gray-400 text-xs mt-0.5 leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="img-zoom rounded-[20px] overflow-hidden shadow-md" style="aspect-ratio:16/9">
            <img src="https://images.unsplash.com/photo-1594608661623-aa0bd3a69d98?w=700" alt="Students boarding safely" class="w-full h-full object-cover">
            <div class="absolute inset-0 flex items-end p-5" style="background:linear-gradient(to top,rgba(0,0,0,.6),transparent)">
                <p class="text-white text-sm italic font-medium" style="font-family:'Plus Jakarta Sans',sans-serif">"Your feedback helps us keep every child safe on every journey."</p>
            </div>
        </div>
    </div>

    {{-- Right — Report Form --}}
    <div class="reveal from-right">
        <div class="bg-white border border-gray-100 rounded-[24px] shadow-md overflow-hidden">
            <div class="h-1.5" style="background:linear-gradient(90deg,#EF4444,var(--gold),var(--navy))"></div>
            <div class="p-7 lg:p-8">
                @if(session('report_success'))
                <div class="flex items-start gap-3 rounded-xl p-4 mb-5 border" style="background:rgba(5,150,105,0.06);border-color:rgba(5,150,105,0.2)">
                    <svg class="w-5 h-5 shrink-0" style="color:#059669" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <p class="text-sm" style="color:#047857;font-family:'Plus Jakarta Sans',sans-serif">Report submitted. Our team will review it within 24 hours.</p>
                </div>
                @endif

                <form action="{{ route('transport.report') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Issue Type <span class="text-red-400">*</span></label>
                            <select name="issue_type" required class="form-input {{ $errors->has('issue_type') ? 'error' : '' }}">
                                <option value="">Select issue type</option>
                                @foreach(['Unsafe Driving','Delay / Late','Missing Student','Bus Condition','Driver Behaviour','Route Issue','Other'] as $opt)
                                <option value="{{ $opt }}" {{ old('issue_type')===$opt?'selected':'' }}>{{ $opt }}</option>
                                @endforeach
                            </select>
                            @error('issue_type')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label">Bus Number <span class="text-gray-300 font-normal">(optional)</span></label>
                            <input type="text" name="bus_number" value="{{ old('bus_number') }}" class="form-input" placeholder="e.g. SSSS-04">
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Location / Area <span class="text-red-400">*</span></label>
                        <input type="text" name="location" value="{{ old('location') }}" required class="form-input {{ $errors->has('location') ? 'error' : '' }}" placeholder="e.g. Near City Park, Sector 3 junction">
                        @error('location')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">Your Name &amp; Phone <span class="text-gray-300 font-normal">(optional — kept confidential)</span></label>
                        <input type="text" name="reporter_name" value="{{ old('reporter_name') }}" class="form-input" placeholder="Name (optional)">
                    </div>
                    <div>
                        <label class="form-label">Description <span class="text-red-400">*</span></label>
                        <textarea name="description" rows="4" required class="form-input {{ $errors->has('description') ? 'error' : '' }}" style="resize:none" placeholder="Please describe the incident in detail — time, what happened, any other relevant information…">{{ old('description') }}</textarea>
                        @error('description')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">Upload Image / Video <span class="text-gray-300 font-normal">(optional)</span></label>
                        <div class="border-2 border-dashed rounded-xl p-5 text-center cursor-pointer border-gray-200 hover:border-gold transition-colors" onclick="document.getElementById('report-file').click()">
                            <svg class="w-7 h-7 mx-auto mb-1.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            <p class="text-gray-400 text-xs font-semibold" style="font-family:'Plus Jakarta Sans',sans-serif">Click to upload</p>
                            <p class="text-gray-300 text-[10px] mt-0.5" style="font-family:'Plus Jakarta Sans',sans-serif">PNG, JPG, MP4 up to 20MB</p>
                            <input type="file" id="report-file" name="attachment" accept="image/*,video/mp4" class="sr-only">
                        </div>
                    </div>
                    <button type="submit" class="w-full font-bold py-3.5 rounded-xl text-sm text-white flex items-center justify-center gap-2 shadow-md transition-all hover:-translate-y-0.5" style="background:#EF4444;transition-timing-function:var(--ease-spring)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        Submit Report
                    </button>
                    <p class="text-center text-gray-400 text-xs flex items-center justify-center gap-1.5 mt-1" style="font-family:'Plus Jakarta Sans',sans-serif">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        All reports are reviewed and handled seriously by our safety team
                    </p>
                </form>
            </div>
        </div>
    </div>

</div>
</div>
</section>

{{-- ══ TESTIMONIALS ═════════════════════════════════════════════════════ --}}
<section class="py-28" style="background:var(--cream)">
<div class="max-w-7xl mx-auto px-6 lg:px-8">
    <div class="text-center mb-14 reveal">
        <div class="section-label justify-center">Parent Testimonials</div>
        <h2 class="section-title">Trusted by Our School Community</h2>
        <div class="gold-bar mx-auto mt-4"></div>
        <p class="text-gray-400 text-sm mt-5" style="font-family:'Plus Jakarta Sans',sans-serif">Hear from parents who rely on our transport service every school day.</p>
    </div>

    <div class="grid md:grid-cols-3 gap-6 mb-10 stagger">
        @foreach([
            ['SS','Sunita Sharma',   'Parent of Grade 7 Student',  'The GPS tracking gives me real peace of mind. I can see exactly where my daughter\'s bus is every morning. The notification when she boards is fantastic!',                                                                    'var(--navy)'],
            ['RK','Ramesh Karki',    'Parent of Grade 10 Student', 'I love the instant notifications. The moment my son boards the bus I get an alert. It\'s transformed our morning routine — no more anxiety about whether he made it.',                                                     '#3B82F6'],
            ['PT','Priya Thapa',     'Parent of two students',     'Both my children travel daily by school bus. The CCTV and verified drivers give me complete confidence. The staff is punctual, professional, and caring.',                                                                   '#059669'],
        ] as [$initials,$name,$role,$quote,$color])
        <div class="testimonial-card bg-white border border-gray-100 shadow-sm p-7">
            <div class="flex gap-0.5 mb-5">
                @for($s = 0; $s < 5; $s++)
                <svg class="w-4 h-4" style="color:var(--gold)" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                @endfor
            </div>
            <p class="text-gray-500 text-sm leading-[1.85] mb-5" style="font-family:'Plus Jakarta Sans',sans-serif">"{{ $quote }}"</p>
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0" style="background:{{ $color }}">{{ $initials }}</div>
                <div>
                    <p class="font-semibold text-navy text-sm" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $name }}</p>
                    <p class="text-gray-400 text-xs" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $role }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Trust strip --}}
    <div class="flex items-center justify-center gap-3 text-center">
        <div class="flex -space-x-2">
            @foreach(['#0D1B2E','#3B82F6','#059669','#9333EA','#EF4444','#F59E0B'] as $c)
            <div class="trust-avatar" style="background:{{ $c }}">
                {{ ['SS','RK','PT','AM','NK','BT'][array_search($c,['#0D1B2E','#3B82F6','#059669','#9333EA','#EF4444','#F59E0B'])] }}
            </div>
            @endforeach
        </div>
        <p class="text-gray-500 text-sm" style="font-family:'Plus Jakarta Sans',sans-serif"><strong>200+ families</strong> trust {{ $school }} transport daily</p>
    </div>
</div>
</section>

{{-- ══ CTA — REGISTER ════════════════════════════════════════════════════ --}}
<section class="grand-cta py-28 text-center" style="background:#fff"
    data-particle-type="geometric"
    data-particle-1="rgba(13,27,46,0.22)" data-particle-2="rgba(201,162,39,0.35)" id="register">
    <canvas class="cta-canvas"></canvas>

    <div class="max-w-2xl mx-auto px-6 reveal" style="position:relative">
        <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg" style="background:var(--navy)">
            <svg class="w-7 h-7" style="color:var(--gold)" fill="currentColor" viewBox="0 0 20 20"><path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/><path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/></svg>
        </div>

        <div class="section-label justify-center">2026–27 Registration</div>
        <h2 class="font-display font-bold text-navy mb-3 mt-2" style="font-size:clamp(2rem,4.5vw,3.2rem);line-height:1.1">Register for School Transportation</h2>
        <div class="mx-auto mb-6" style="width:48px;height:2px;background:linear-gradient(90deg,var(--gold),var(--gold-light));border-radius:2px"></div>
        <p class="text-gray-400 mb-10 leading-relaxed" style="font-size:14px;font-family:'Plus Jakarta Sans',sans-serif;max-width:440px;margin-left:auto;margin-right:auto">
            Ensure your child travels safely every day. Limited seats available per route — register early for the 2026–27 academic year.
        </p>

        <div class="flex flex-wrap gap-4 justify-center mb-10">
            <a href="{{ route('admissions.index') }}" class="btn-primary">Apply for Transportation</a>
            <a href="{{ route('contact.index') }}" class="btn-ghost">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                Contact Transport Office
            </a>
        </div>

        <div class="border-t border-gray-100 pt-8 flex flex-wrap gap-8 justify-center text-center">
            @foreach([['M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z','Safety First'],['M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z','GPS Tracked'],['M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9','Instant Alerts']] as [$icon,$label])
            <div class="flex flex-col items-center gap-1.5">
                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/></svg>
                <span class="text-gray-400 text-xs font-medium" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $label }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                e.target.querySelectorAll('.gold-bar').forEach(b => setTimeout(() => b.classList.add('visible'), 250));
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
    document.querySelectorAll('.reveal, .stagger').forEach(el => obs.observe(el));

    // Particle CTA — geometric shapes for white background CTAs
    document.querySelectorAll('.grand-cta').forEach(section => {
        const canvas = section.querySelector('.cta-canvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        const c1 = section.dataset.particle1 || 'rgba(13,27,46,0.2)';
        const c2 = section.dataset.particle2 || 'rgba(201,162,39,0.3)';
        const type = section.dataset.particleType || 'geometric';
        let particles = [];
        function resize() { canvas.width = section.offsetWidth; canvas.height = section.offsetHeight; }
        window.addEventListener('resize', resize); resize();
        class Particle {
            constructor() { this.init(); }
            init() {
                this.x = Math.random() * canvas.width; this.y = Math.random() * canvas.height;
                this.size = type === 'geometric' ? Math.random() * 6 + 3 : Math.random() * 2 + 0.5;
                this.speedX = (Math.random() - .5) * .28; this.speedY = (Math.random() - .5) * .28;
                this.color = Math.random() > .5 ? c1 : c2;
                this.rotation = Math.random() * Math.PI * 2; this.rotSpeed = (Math.random() - .5) * .015;
                this.shape = Math.floor(Math.random() * 3);
            }
            update() {
                this.x += this.speedX; this.y += this.speedY; this.rotation += this.rotSpeed;
                if (this.x < 0 || this.x > canvas.width || this.y < 0 || this.y > canvas.height) this.init();
            }
            draw() {
                ctx.save(); ctx.translate(this.x, this.y); ctx.rotate(this.rotation);
                ctx.fillStyle = this.color;
                if (type === 'geometric') {
                    ctx.shadowBlur = 2; ctx.shadowColor = this.color;
                    if (this.shape === 0) { ctx.beginPath(); ctx.arc(0,0,this.size/2,0,Math.PI*2); ctx.fill(); }
                    else if (this.shape === 1) { ctx.fillRect(-this.size/2,-this.size/2,this.size,this.size); }
                    else { ctx.beginPath(); ctx.moveTo(0,-this.size/2); ctx.lineTo(this.size/2,this.size/2); ctx.lineTo(-this.size/2,this.size/2); ctx.closePath(); ctx.fill(); }
                } else { ctx.beginPath(); ctx.arc(0,0,this.size/2,0,Math.PI*2); ctx.fill(); }
                ctx.restore();
            }
        }
        const count = Math.min(60, Math.floor((canvas.width * canvas.height) / 14000));
        for (let i = 0; i < count; i++) particles.push(new Particle());
        (function animate() { ctx.clearRect(0,0,canvas.width,canvas.height); particles.forEach(p=>{p.update();p.draw();}); requestAnimationFrame(animate); })();
    });
});
</script>
@endpush
