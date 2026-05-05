@extends('layouts.app')
@section('title', 'Boarding Facility')
@section('meta_description', 'Residential boarding at ' . \App\Models\SiteSetting::get('school_name', 'Our School') . ' — a safe, nurturing home-away-from-home for students with structured daily routines and value-based living.')

@push('styles')
<style>
@keyframes page-enter  { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:none} }
@keyframes badge-drop  { from{opacity:0;transform:translateY(-10px) scale(.95)} to{opacity:1;transform:none} }
@keyframes float-badge { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }

.h-anim-1 { animation: badge-drop .6s .08s both cubic-bezier(0.23,1,0.32,1); }
.h-anim-2 { animation: page-enter .85s .2s  both cubic-bezier(0.23,1,0.32,1); }
.h-anim-3 { animation: page-enter .85s .38s both cubic-bezier(0.23,1,0.32,1); }
.h-anim-4 { animation: page-enter .85s .54s both cubic-bezier(0.23,1,0.32,1); }
.float-badge { animation: float-badge 4.5s ease-in-out infinite; }

/* ── Stats bar ────────────────────────────────────────────────── */
.stat-item {
    display: flex; align-items: flex-start; gap: 14px;
    transition: transform .22s var(--ease-spring);
}
@media (hover:hover) and (pointer:fine) { .stat-item:hover { transform: translateY(-2px); } }
.stat-icon { width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12); transition: background .18s ease; }
.stat-item:hover .stat-icon { background: rgba(201,162,39,0.2); }

/* ── Feature items (icon + text) ──────────────────────────────── */
.feat-item {
    display: flex; gap: 12px; align-items: flex-start;
    padding: 8px 8px; border-radius: 10px;
    transition: background .18s var(--ease-out);
}
@media (hover:hover) and (pointer:fine) { .feat-item:hover { background: rgba(201,162,39,0.05); } }

/* ── Facility card ────────────────────────────────────────────── */
.facility-card {
    border-radius: 20px;
    transition: transform .28s var(--ease-spring), box-shadow .28s ease, border-color .22s var(--ease-out);
}
@media (hover:hover) and (pointer:fine) {
    .facility-card:hover { transform: translateY(-5px); box-shadow: 0 24px 48px rgba(13,27,46,0.11); border-color: rgba(201,162,39,0.35) !important; }
    .facility-card:hover img { transform: scale(1.05); }
}
.facility-card img { transition: transform .55s var(--ease-out); }

/* ── Timeline rows ────────────────────────────────────────────── */
.timeline-row { display: flex; align-items: center; gap: 16px; }
.timeline-dot {
    width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0;
    transition: transform .22s var(--ease-spring), box-shadow .22s ease;
}
@media (hover:hover) and (pointer:fine) {
    .timeline-row:hover .timeline-dot { transform: scale(1.5); box-shadow: 0 0 0 5px rgba(201,162,39,0.2); }
}

/* ── Meal cards ───────────────────────────────────────────────── */
.meal-card {
    display: flex; gap: 16px; align-items: flex-start;
    border-radius: 14px; padding: 14px;
    border: 1px solid rgba(13,27,46,0.07);
    transition: border-color .2s var(--ease-out), box-shadow .2s ease, transform .22s var(--ease-spring);
}
@media (hover:hover) and (pointer:fine) {
    .meal-card:hover { border-color: rgba(201,162,39,0.3); box-shadow: 0 8px 24px rgba(13,27,46,0.07); transform: translateY(-2px); }
}

/* ── Welfare cards ────────────────────────────────────────────── */
.welfare-card {
    border-radius: 20px;
    transition: transform .28s var(--ease-spring), box-shadow .28s ease, border-color .22s var(--ease-out);
}
@media (hover:hover) and (pointer:fine) {
    .welfare-card:hover { transform: translateY(-5px); box-shadow: 0 20px 44px rgba(13,27,46,0.09); border-color: rgba(201,162,39,0.3) !important; }
}

/* ── Grand CTA ────────────────────────────────────────────────── */
.grand-cta { position: relative; overflow: hidden; z-index: 1; }
.cta-canvas { position: absolute; top:0; left:0; width:100%; height:100%; z-index:-1; pointer-events:none; }
</style>
@endpush

@section('content')

@php
    $sections = $sections ?? \App\Models\PageSection::forPageCached('boarding');
    $useDynamic = $sections->count() > 0;
@endphp

{{-- ══ HERO ══════════════════════════════════════════════════════════ --}}
@php $hero = \App\Models\PageHero::forPage('boarding'); @endphp
@if($hero)
<x-page-hero :hero="$hero">
    {{-- Floating stat badges --}}
    <div class="absolute bottom-10 right-10 hidden lg:flex gap-4">
        @foreach([['Boys','Hostel Block A'],['Girls','Hostel Block B'],['24/7','Supervision']] as $i => [$v,$l])
        <div class="float-badge text-white text-center rounded-2xl px-5 py-3 shadow-xl border border-white/10"
             style="background:rgba(13,27,46,0.85);backdrop-filter:blur(12px);box-shadow:inset 0 1px 0 rgba(255,255,255,0.08);animation-delay:{{ $i * 0.5 }}s">
            <div class="font-display font-bold text-xl leading-none" style="color:var(--gold)">{{ $v }}</div>
            <div class="text-white/50 text-[10px] mt-0.5 font-medium">{{ $l }}</div>
        </div>
        @endforeach
    </div>
</x-page-hero>
@endif

@if($useDynamic)
    @foreach($sections as $i => $section)
        @include('components.section-renderer', ['section' => $section, 'index' => $i])
    @endforeach
@else

{{-- ══ QUICK STATS ══════════════════════════════════════════════════════ --}}
<section class="py-10" style="background:var(--navy)">
<div class="max-w-7xl mx-auto px-6 lg:px-8 grid grid-cols-2 lg:grid-cols-4 gap-6">
    @foreach([
        ['M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', '2 Hostels',     'Separate boys & girls blocks'],
        ['M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0', '24/7 Staff',    'Trained housemasters on duty'],
        ['M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z',             '3 Meals/Day',   'Nutritious vegetarian food'],
        ['M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'Study Hours',   'Supervised every evening'],
    ] as [$iconPath, $title, $desc])
    <div class="stat-item text-white">
        <div class="stat-icon">
            <svg class="w-5 h-5" style="color:var(--gold)" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPath }}"/>
            </svg>
        </div>
        <div>
            <div class="font-semibold text-sm text-white">{{ $title }}</div>
            <div class="text-white/50 text-xs mt-0.5" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $desc }}</div>
        </div>
    </div>
    @endforeach
</div>
</section>

{{-- ══ WHY BOARDING ══════════════════════════════════════════════════════ --}}
<section class="py-28" style="background:#fff" id="boarding">
<div class="max-w-7xl mx-auto px-6 lg:px-8">
<div class="grid lg:grid-cols-2 gap-20 items-center">

    <div class="reveal from-left">
        <div class="section-label">Why Choose SSSS Boarding?</div>
        <h2 class="section-title mb-4">A Home Away<br>From Home</h2>
        <div class="gold-bar mb-8"></div>
        <p class="text-gray-500 leading-[1.85] mt-8 mb-5" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:14.5px">
            Our boarding programme is designed to provide a structured, value-based residential experience.
            Students benefit from disciplined routines, peer learning, and the constant guidance of our
            dedicated housemaster staff who embody the school's values.
        </p>
        <p class="text-gray-400 text-sm leading-[1.85] mb-8" style="font-family:'Plus Jakarta Sans',sans-serif">
            Whether from near or far, boarders become a close-knit family — supporting each other
            academically and personally in an environment built on trust, care, and mutual respect.
        </p>
        <div class="grid sm:grid-cols-2 gap-2">
            @foreach([
                ['M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',                       'Comfortable Dormitories','Spacious, ventilated rooms for 2–4 students with study desks and secure storage.'],
                ['M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z',                    'Nutritious Meals',       'Freshly prepared vegetarian meals — breakfast, lunch, snack, and dinner daily.'],
                ['M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'Study Facilities',       'Quiet study halls with supervised study hours every evening.'],
                ['M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', '24/7 Supervision',       'Round-the-clock care by trained housemasters and resident staff.'],
                ['M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',                                            'Value-Based Living',      'Morning prayer, meditation, and evening satsaang for spiritual growth.'],
                ['M13 10V3L4 14h7v7l9-11h-7z',                                                                                                                                                'Weekend Activities',      'Cultural events, recreational activities, and nature walks on campus.'],
            ] as [$iconPath, $title, $desc])
            <div class="feat-item">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(201,162,39,0.09);border:1px solid rgba(201,162,39,0.18)">
                    <svg class="w-4 h-4" style="color:var(--gold)" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPath }}"/></svg>
                </div>
                <div>
                    <h4 class="font-semibold text-navy text-sm" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $title }}</h4>
                    <p class="text-gray-400 text-xs mt-0.5 leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="reveal from-right relative" id="boys">
        <div class="img-zoom rounded-[24px] overflow-hidden shadow-[0_32px_80px_rgba(13,27,46,0.14)]" style="aspect-ratio:4/3">
            <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=900" alt="Boarding facility" class="w-full h-full object-cover">
        </div>
        <div class="float-badge absolute -bottom-5 -left-4 text-white rounded-2xl px-6 py-4 shadow-xl text-center" style="background:var(--gold)">
            <div class="font-display font-bold text-3xl leading-none text-white">2</div>
            <div class="text-white/80 text-xs mt-1" style="font-family:'Plus Jakarta Sans',sans-serif">Hostel Blocks</div>
        </div>
        <div class="float-badge absolute -top-4 -right-4 text-white rounded-2xl px-5 py-3 shadow-xl text-center border border-white/10" style="background:var(--navy);animation-delay:.6s">
            <div class="font-display font-bold text-2xl leading-none" style="color:var(--gold)">24/7</div>
            <div class="text-white/60 text-[10px] mt-0.5" style="font-family:'Plus Jakarta Sans',sans-serif">Supervision</div>
        </div>
    </div>

</div>
</div>
</section>

{{-- ══ HOSTEL BLOCKS ════════════════════════════════════════════════════ --}}
<section class="py-28" style="background:var(--cream)">
<div class="max-w-7xl mx-auto px-6 lg:px-8">
    <div class="text-center mb-16 reveal">
        <div class="section-label justify-center">Our Facilities</div>
        <h2 class="section-title">Hostel Blocks</h2>
        <div class="gold-bar mx-auto mt-4"></div>
        <p class="text-gray-400 text-sm mt-6 max-w-xl mx-auto" style="font-family:'Plus Jakarta Sans',sans-serif">
            Separate, purpose-built accommodation blocks for boys and girls, each with dedicated housemasters and all necessary facilities.
        </p>
    </div>

    <div class="grid md:grid-cols-2 gap-8 stagger">
        @foreach([
            ['Boys Hostel', 'Hostel Block A', 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=700', 'boys-hostel',
             'A structured, disciplined residential block designed to foster brotherhood, academic focus, and character development among our male students.',
             ['Rooms for 2–4 boys with individual study desks','Dedicated housemaster and assistant housemaster','Separate washroom and bathing facilities','Secure lockers for personal belongings','Common room with indoor games','Weekly room inspections for cleanliness']],
            ['Girls Hostel','Hostel Block B','https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=700','girls-hostel',
             'A warm, supportive residential environment for our female students — safe, comfortable, and guided by experienced female staff who prioritise every student\'s wellbeing.',
             ['Rooms for 2–4 girls with individual study desks','Female housemaster and supporting staff on duty','Secure access control — visitors only during visiting hours','Separate washroom and bathing facilities','Common room for reading and socialising','Regular security and safety checks']],
        ] as [$title, $block, $img, $id, $desc, $features])
        <div class="facility-card bg-white overflow-hidden shadow-sm border border-gray-100" id="{{ $id }}">
            <div class="aspect-video overflow-hidden">
                <img src="{{ $img }}" alt="{{ $title }}" class="w-full h-full object-cover">
            </div>
            <div class="p-7">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:var(--navy)">
                        <svg class="w-5 h-5" style="color:var(--gold)" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                    <div>
                        <h3 class="font-display font-bold text-navy text-xl">{{ $title }}</h3>
                        <p class="text-xs font-semibold" style="color:var(--gold)">{{ $block }}</p>
                    </div>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed mb-5" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $desc }}</p>
                <div class="space-y-2">
                    @foreach($features as $feat)
                    <div class="flex items-center gap-2 text-sm" style="color:#4B5563;font-family:'Plus Jakarta Sans',sans-serif">
                        <svg class="w-4 h-4 shrink-0" style="color:var(--gold)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        {{ $feat }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
</section>

{{-- ══ DAILY ROUTINE ════════════════════════════════════════════════════ --}}
<section class="py-28" style="background:#fff" id="routine">
<div class="max-w-4xl mx-auto px-6 lg:px-8">
    <div class="text-center mb-16 reveal">
        <div class="section-label justify-center">Structure & Discipline</div>
        <h2 class="section-title">Boarding Daily Routine</h2>
        <div class="gold-bar mx-auto mt-4"></div>
        <p class="text-gray-400 text-sm mt-6 max-w-xl mx-auto" style="font-family:'Plus Jakarta Sans',sans-serif">
            A well-structured day that balances academics, physical activity, spiritual practice, and rest — building healthy lifelong habits.
        </p>
    </div>

    <div class="bg-white border border-gray-100 rounded-[24px] shadow-sm overflow-hidden reveal">
        <div class="grid sm:grid-cols-2 divide-y sm:divide-y-0 sm:divide-x divide-gray-100">
            <div class="p-7 lg:p-8">
                <div class="flex items-center gap-3 mb-7">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:rgba(201,162,39,0.1);border:1px solid rgba(201,162,39,0.2)">
                        <svg class="w-4.5 h-4.5" style="color:var(--gold);width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1M4.22 4.22l.707.707m12.728 12.728l.707.707M1 12h1m18 0h1M4.22 19.78l.707-.707M18.95 5.05l.707-.707"/></svg>
                    </div>
                    <h3 class="font-display font-bold text-navy text-lg">Morning Routine</h3>
                </div>
                <div class="space-y-0">
                    @foreach([['5:30 AM','Wake Up & Personal Care','var(--gold)'],['6:00 AM','Morning Prayer & Meditation','var(--gold)'],['6:30 AM','Yoga / Exercise','var(--gold)'],['7:30 AM','Breakfast','var(--gold)'],['8:00 AM','School Classes Begin','var(--gold)'],['10:30 AM','Short Break & Refreshments','#6b7280'],['1:00 PM','Lunch Break','#6b7280']] as [$time,$activity,$color])
                    <div class="timeline-row py-3 border-b border-gray-50 last:border-0">
                        <div class="timeline-dot" style="background:{{ $color }}"></div>
                        <span class="font-bold text-sm shrink-0 w-24" style="color:{{ $color }};font-family:'Plus Jakarta Sans',sans-serif">{{ $time }}</span>
                        <span class="text-gray-500 text-sm" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $activity }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="p-7 lg:p-8">
                <div class="flex items-center gap-3 mb-7">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:rgba(13,27,46,0.07);border:1px solid rgba(13,27,46,0.12)">
                        <svg class="w-4.5 h-4.5" style="color:var(--navy);width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </div>
                    <h3 class="font-display font-bold text-navy text-lg">Evening Routine</h3>
                </div>
                <div class="space-y-0">
                    @foreach([['1:45 PM','Co-curricular Activities & Sports','var(--navy)'],['3:30 PM','School Ends / Free Time','var(--navy)'],['5:30 PM','Evening Snack','var(--navy)'],['6:00 PM','Supervised Study Hour','var(--navy)'],['7:00 PM','Evening Satsaang / Prayer','var(--navy)'],['8:00 PM','Dinner','var(--navy)'],['9:30 PM','Lights Out','#6b7280']] as [$time,$activity,$color])
                    <div class="timeline-row py-3 border-b border-gray-50 last:border-0">
                        <div class="timeline-dot" style="background:{{ $color }}"></div>
                        <span class="font-bold text-sm shrink-0 w-24" style="color:{{ $color }};font-family:'Plus Jakarta Sans',sans-serif">{{ $time }}</span>
                        <span class="text-gray-500 text-sm" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $activity }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
</section>

{{-- ══ MEALS ════════════════════════════════════════════════════════════ --}}
<section class="py-28" style="background:var(--cream)" id="meals">
<div class="max-w-7xl mx-auto px-6 lg:px-8">
<div class="grid lg:grid-cols-2 gap-20 items-center">

    <div class="reveal from-right">
        <div class="img-zoom rounded-[24px] overflow-hidden shadow-[0_32px_80px_rgba(13,27,46,0.13)]" style="aspect-ratio:4/3">
            <img src="https://images.unsplash.com/photo-1567521464027-f127ff144326?w=800" alt="Meals" class="w-full h-full object-cover">
        </div>
    </div>

    <div class="reveal from-left">
        <div class="section-label">Healthy & Nutritious</div>
        <h2 class="section-title mb-4">Meals &amp; Diet</h2>
        <div class="gold-bar mb-8"></div>
        <p class="text-gray-500 leading-[1.85] mt-8 mb-6" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:14.5px">
            We believe that nutrition is the foundation of academic performance. Our kitchen team prepares
            balanced, wholesome vegetarian meals using fresh, locally-sourced ingredients — every single day.
        </p>
        <div class="space-y-3">
            @foreach([
                ['M12 3v1m0 16v1M4.22 4.22l.707.707m12.728 12.728l.707.707M1 12h1m18 0h1M4.22 19.78l.707-.707M18.95 5.05l.707-.707', 'Breakfast (7:30 AM)', 'Hot nutritious breakfast including porridge, bread, eggs or dal, with tea/milk.'],
                ['M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z', 'Lunch (1:00 PM)', 'Full cooked meal with rice, lentils, vegetables, salad, and seasonal fruits.'],
                ['M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'Evening Snack (5:30 PM)', 'Light snack — biscuits, fruits, tea, or milk to re-energise after activities.'],
                ['M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z', 'Dinner (8:00 PM)', 'Hot, well-balanced dinner with dal, vegetables, roti or rice, and dessert.'],
            ] as [$iconPath, $meal, $desc])
            <div class="meal-card bg-white">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(201,162,39,0.09);border:1px solid rgba(201,162,39,0.18)">
                    <svg class="w-4 h-4" style="color:var(--gold)" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPath }}"/></svg>
                </div>
                <div>
                    <h4 class="font-semibold text-navy text-sm" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $meal }}</h4>
                    <p class="text-gray-400 text-xs mt-0.5 leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-6 rounded-xl p-4 text-sm border" style="background:rgba(201,162,39,0.07);border-color:rgba(201,162,39,0.2);font-family:'Plus Jakarta Sans',sans-serif;color:#4B5563">
            <strong style="color:var(--gold)">Special dietary requirements?</strong> We accommodate medical dietary needs and allergies with prior notice. Please mention in your application.
        </div>
    </div>

</div>
</div>
</section>

{{-- ══ RULES & WELFARE ══════════════════════════════════════════════════ --}}
<section class="py-28" style="background:#fff">
<div class="max-w-7xl mx-auto px-6 lg:px-8">
    <div class="text-center mb-16 reveal">
        <div class="section-label justify-center">Student Welfare</div>
        <h2 class="section-title">Boarding Rules &amp; Welfare</h2>
        <div class="gold-bar mx-auto mt-4"></div>
        <p class="text-gray-400 text-sm mt-6 max-w-xl mx-auto" style="font-family:'Plus Jakarta Sans',sans-serif">
            Clear boundaries build trust and safety. Our boarding rules are fair, consistent, and focused on creating a respectful community.
        </p>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5 stagger">
        @foreach([
            ['M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'Visiting Hours',    'Parents may visit on Sundays, 10 AM – 4 PM. Prior notice required for weekday visits.'],
            ['M12 18h.01M8 21l4-4 4 4M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z',                                                              'Device Policy',     'Mobile phones are not permitted in dormitories. Devices may be used in designated areas only.'],
            ['M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13',                                                                 'Study Rules',       'All boarders must participate in supervised study hour from 6–7 PM every day.'],
            ['M20.354 15.354A9 9 0 018.646 3.646',                                                                                                   'Lights Out',        'Lights out at 9:30 PM. A quiet, rested mind is essential for the next day\'s learning.'],
            ['M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944',                                                                                'Room Cleanliness',  'Students are responsible for keeping their rooms tidy. Inspections held every Friday.'],
            ['M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'Health & Safety', 'First aid kit on every floor. Any illness reported immediately to the housemaster.'],
        ] as [$iconPath, $title, $desc])
        <div class="welfare-card bg-gray-50 border border-gray-100 p-6">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-5" style="background:rgba(201,162,39,0.09);border:1px solid rgba(201,162,39,0.18)">
                <svg class="w-5 h-5" style="color:var(--gold)" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPath }}"/></svg>
            </div>
            <h4 class="font-display font-bold text-navy text-lg mb-2">{{ $title }}</h4>
            <p class="text-gray-400 text-sm leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $desc }}</p>
        </div>
        @endforeach
    </div>
</div>
</section>

{{-- ══ FEES & APPLY ═════════════════════════════════════════════════════ --}}
<section class="py-28" style="background:var(--cream)" id="fees">
<div class="max-w-4xl mx-auto px-6 lg:px-8">
    <div class="text-center mb-16 reveal">
        <div class="section-label justify-center">Costs & Application</div>
        <h2 class="section-title">Boarding Fees</h2>
        <div class="gold-bar mx-auto mt-4"></div>
    </div>

    <div class="bg-white rounded-[24px] shadow-sm border border-gray-100 p-8 reveal">
        <p class="text-gray-500 text-sm leading-[1.85] mb-7" style="font-family:'Plus Jakarta Sans',sans-serif">
            Our boarding fees cover accommodation, all meals (3 meals + snack), supervision, and access to all
            boarding facilities. Fees are charged per academic term. Tuition fees are billed separately.
        </p>
        <div class="space-y-0 mb-7">
            @foreach(['Grades 1–5 (Primary)','Grades 6–10 (Secondary)','+2 Level (Science & Management)'] as $level)
            <div class="flex justify-between items-center py-4 border-b border-gray-100 last:border-0">
                <div>
                    <span class="font-semibold text-navy text-sm" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $level }}</span>
                    <span class="text-gray-400 text-xs block mt-0.5" style="font-family:'Plus Jakarta Sans',sans-serif">Accommodation + all meals + supervision</span>
                </div>
                <a href="{{ route('contact.index') }}" class="text-sm font-bold text-navy hover:text-gold transition-colors" style="transition-timing-function:var(--ease-out)">Contact Office →</a>
            </div>
            @endforeach
        </div>
        <div class="rounded-xl p-4 text-sm border" style="background:rgba(201,162,39,0.07);border-color:rgba(201,162,39,0.2);font-family:'Plus Jakarta Sans',sans-serif;color:#4B5563">
            <strong style="color:var(--gold)">Fee concessions available</strong> for siblings and students with financial need. Speak to our admissions office for details.
        </div>
    </div>
</div>
</section>

@endif {{-- end static fallback --}}

{{-- ══ CTA ═══════════════════════════════════════════════════════════════ --}}
<section class="grand-cta py-28 text-white text-center"
    style="background:linear-gradient(135deg,#1B2A4A 0%,#16223d 50%,#1a1035 100%)"
    data-particle-1="rgba(255,255,255,0.15)" data-particle-2="rgba(201,162,39,0.25)">
    <canvas class="cta-canvas"></canvas>

    <div class="absolute -top-24 -left-24 w-80 h-80 border rounded-full pointer-events-none" style="border-color:rgba(255,255,255,0.04)"></div>
    <div class="absolute -bottom-16 -right-16 w-96 h-96 border rounded-full pointer-events-none" style="border-color:rgba(201,162,39,0.07)"></div>

    <div class="relative max-w-2xl mx-auto px-6 reveal">
        <div class="section-label justify-center" style="color:rgba(201,162,39,0.8)">Limited Spaces</div>
        <h2 class="font-display font-bold leading-tight mb-5 mt-2" style="font-size:clamp(2.2rem,5vw,3.8rem)">Apply for Boarding</h2>
        <p class="text-white/55 mb-12 leading-relaxed" style="font-size:15px;font-family:'Plus Jakarta Sans',sans-serif">
            Give your child the full SSSS experience. Boarding spaces are limited — applications are reviewed on a first-come, first-served basis.
        </p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('admissions.index') }}" class="btn-primary">Apply Now</a>
            <a href="{{ route('contact.index') }}" class="btn-ghost-white">Ask a Question</a>
        </div>
        <p class="text-white/30 text-xs mt-8" style="font-family:'Plus Jakarta Sans',sans-serif">
            Questions? Call us on {{ \App\Models\SiteSetting::get('phone', '+977-1-XXXXXXX') }} or email {{ \App\Models\SiteSetting::get('email', 'info@school.edu.np') }}
        </p>
    </div>
</section>

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

    // Particle CTA engine — preserved exactly as your original
    document.querySelectorAll('.grand-cta').forEach(section => {
        const canvas = section.querySelector('.cta-canvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        const c1 = section.dataset.particle1 || 'rgba(255,255,255,0.15)';
        const c2 = section.dataset.particle2 || 'rgba(201,162,39,0.25)';
        let particles = [];
        function resize() { canvas.width = section.offsetWidth; canvas.height = section.offsetHeight; }
        window.addEventListener('resize', resize); resize();
        class Particle {
            constructor() { this.init(); }
            init() {
                this.x = Math.random() * canvas.width; this.y = Math.random() * canvas.height;
                this.size = Math.random() * 2 + 0.5;
                this.speedX = (Math.random() - .5) * .4; this.speedY = (Math.random() - .5) * .4;
                this.color = Math.random() > .5 ? c1 : c2;
            }
            update() {
                this.x += this.speedX; this.y += this.speedY;
                if (this.x < 0 || this.x > canvas.width || this.y < 0 || this.y > canvas.height) this.init();
            }
            draw() { ctx.fillStyle = this.color; ctx.beginPath(); ctx.arc(this.x, this.y, this.size, 0, Math.PI*2); ctx.fill(); }
        }
        for (let i = 0; i < 55; i++) particles.push(new Particle());
        (function animate() { ctx.clearRect(0,0,canvas.width,canvas.height); particles.forEach(p=>{p.update();p.draw();}); requestAnimationFrame(animate); })();
    });
});
</script>
@endpush
