@extends('layouts.app')
@section('title', 'Boarding Facility')
@section('meta_description', 'Residential boarding at ' . \App\Models\SiteSetting::get('school_name', 'Our School') . '
    — a safe, nurturing home-away-from-home for students with structured daily routines and value-based living.')

    @push('styles')
        <style>
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
                transition-delay: .14s
            }

            .stagger.visible>*:nth-child(3) {
                opacity: 1;
                transform: none;
                transition-delay: .23s
            }

            .stagger.visible>*:nth-child(4) {
                opacity: 1;
                transform: none;
                transition-delay: .32s
            }

            .stagger.visible>*:nth-child(5) {
                opacity: 1;
                transform: none;
                transition-delay: .41s
            }

            .stagger.visible>*:nth-child(6) {
                opacity: 1;
                transform: none;
                transition-delay: .50s
            }

            .gold-line {
                width: 0;
                height: 3px;
                background: linear-gradient(90deg, #C9A227, #e0b830);
                border-radius: 2px;
                transition: width .6s .2s ease
            }

            .reveal.visible .gold-line,
            .gold-line.visible {
                width: 52px
            }

            .img-zoom {
                overflow: hidden
            }

            .img-zoom img {
                transition: transform .5s ease
            }

            .img-zoom:hover img {
                transform: scale(1.04)
            }

            .facility-card {
                transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease
            }

            .facility-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 20px 40px rgba(27, 42, 74, .10);
                border-color: #C9A227
            }

            .timeline-dot {
                transition: transform .25s ease, box-shadow .25s ease
            }

            .timeline-row:hover .timeline-dot {
                transform: scale(1.35);
                box-shadow: 0 0 0 5px rgba(201, 162, 39, .2)
            }

            @keyframes float {

                0%,
                100% {
                    transform: translateY(0)
                }

                50% {
                    transform: translateY(-8px)
                }
            }

            .float {
                animation: float 4s ease-in-out infinite
            }
        </style>
    @endpush

@section('content')

    @php
        // Try to load dynamic sections from admin
        $sections = \App\Models\PageSection::forPageCached('boarding');
        $useDynamic = $sections->count() > 0;
    @endphp

    {{-- ══════════════════ HERO ══════════════════ --}}
    <section class="relative min-h-[70vh] flex items-center overflow-hidden" style="background:#0c1322">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=1600" alt="Boarding"
                class="w-full h-full object-cover opacity-35">
        </div>
        <div class="absolute inset-0"
            style="background:linear-gradient(135deg,rgba(12,19,34,0.95) 0%,rgba(27,42,74,0.85) 55%,rgba(201,162,39,0.15) 100%)">
        </div>

        {{-- Decorative rings --}}
        <div class="absolute top-16 right-20 w-72 h-72 border border-white/6 rounded-full hidden xl:block"></div>
        <div class="absolute top-36 right-36 w-44 h-44 border border-gold/12 rounded-full hidden xl:block"></div>

        <div class="relative max-w-7xl mx-auto px-4 lg:px-8 py-32">
            <div class="max-w-3xl">
                {{-- Badge --}}
                <div
                    class="inline-flex items-center gap-2 bg-gold/15 border border-gold/30 text-gold
                        text-xs font-bold tracking-widest uppercase px-5 py-2.5 rounded-full mb-8">
                    <span class="w-1.5 h-1.5 bg-gold rounded-full"></span>
                    Residential Facility
                </div>

                <h1 class="font-display font-bold text-white leading-tight mb-6" style="font-size:clamp(2.4rem,5.5vw,4rem)">
                    Boarding at<br>
                    <span style="color:#C9A227">{{ \App\Models\SiteSetting::get('school_name', 'SSSS') }}</span>
                </h1>

                <p class="text-white/70 text-lg leading-relaxed mb-10 max-w-xl">
                    A safe, nurturing home-away-from-home where students grow academically, spiritually, and personally —
                    guided by our dedicated housemaster team.
                </p>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('admissions.index') }}"
                        class="group relative overflow-hidden bg-gold text-white font-bold px-8 py-4 rounded-xl shadow-lg text-sm transition-all hover:shadow-gold/30">
                        Apply for Boarding
                        <svg class="inline-block w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                    <a href="{{ route('contact.index') }}"
                        class="border-2 border-white/35 hover:border-gold text-white hover:text-gold font-semibold px-8 py-4 rounded-xl transition-all text-sm">
                        Contact Boarding Office
                    </a>
                </div>
            </div>
        </div>

        {{-- Floating stat badges --}}
        <div class="absolute bottom-10 right-10 hidden lg:flex gap-4">
            @foreach ([['Boys', 'Hostel Block A'], ['Girls', 'Hostel Block B'], ['24/7', 'Supervision']] as [$v, $l])
                <div class="float bg-navy/80 backdrop-blur-sm border border-white/10 text-white text-center rounded-2xl px-4 py-3 shadow-xl"
                    style="animation-delay:{{ $loop->index * 0.4 }}s">
                    <div class="font-display font-bold text-xl text-gold leading-none">{{ $v }}</div>
                    <div class="text-white/55 text-[10px] mt-0.5">{{ $l }}</div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ══════════════════ QUICK STATS ══════════════════ --}}
    <section class="bg-navy py-10">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 grid grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ([['🛏️', '2 Hostels', 'Separate boys & girls blocks'], ['👨‍🏫', '24/7 Staff', 'Trained housemasters on duty'], ['🍽️', '3 Meals/Day', 'Nutritious vegetarian food'], ['📚', 'Study Hours', 'Supervised every evening']] as [$icon, $title, $desc])
                <div class="flex items-start gap-3 text-white">
                    <span class="text-2xl shrink-0 mt-0.5">{{ $icon }}</span>
                    <div>
                        <div class="font-semibold text-sm text-white">{{ $title }}</div>
                        <div class="text-white/50 text-xs mt-0.5">{{ $desc }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ══════════════════ DYNAMIC SECTIONS (if admin has added any) ══════════════════ --}}
    @if ($useDynamic)
        @foreach ($sections as $i => $section)
            <section class="py-20 {{ $i % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}">
                <div class="max-w-7xl mx-auto px-4 lg:px-8">
                    @include('components.section-renderer', ['section' => $section])
                </div>
            </section>
        @endforeach

        {{-- ══════════════════ STATIC CONTENT (shown when no dynamic sections yet) ══════════════════ --}}
    @else
        {{-- WHY CHOOSE BOARDING --}}
        <section class="py-24 bg-white" id="boarding">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div class="reveal from-left">
                        <p class="text-gold font-bold text-xs tracking-widest uppercase mb-3">Why Choose SSSS Boarding?</p>
                        <h2 class="font-display font-bold text-4xl text-navy mb-5 leading-tight">A Home Away<br>From Home
                        </h2>
                        <div class="gold-line mb-8"></div>
                        <p class="text-gray-600 leading-relaxed mb-5 mt-8">
                            Our boarding programme is designed to provide a structured, value-based residential experience.
                            Students benefit from disciplined routines, peer learning, and the constant guidance of our
                            dedicated housemaster staff who embody the school's values.
                        </p>
                        <p class="text-gray-500 text-sm leading-relaxed mb-8">
                            Whether from near or far, boarders become a close-knit family — supporting each other
                            academically and personally in an environment built on trust, care, and mutual respect.
                        </p>
                        <div class="grid sm:grid-cols-2 gap-4">
                            @foreach ([['🛏️', 'Comfortable Dormitories', 'Spacious, ventilated rooms for 2–4 students with study desks and secure storage.'], ['🍽️', 'Nutritious Meals', 'Freshly prepared vegetarian meals — breakfast, lunch, snack, and dinner daily.'], ['📚', 'Study Facilities', 'Quiet study halls with supervised study hours every evening.'], ['🔒', '24/7 Supervision', 'Round-the-clock care by trained housemasters and resident staff.'], ['🌿', 'Value-Based Living', 'Morning prayer, meditation, and evening satsaang for spiritual growth.'], ['⚽', 'Weekend Activities', 'Cultural events, recreational activities, and nature walks on campus.']] as [$icon, $title, $desc])
                                <div class="flex gap-3 items-start">
                                    <span class="text-2xl shrink-0">{{ $icon }}</span>
                                    <div>
                                        <h4 class="font-semibold text-navy text-sm">{{ $title }}</h4>
                                        <p class="text-gray-500 text-xs mt-0.5 leading-relaxed">{{ $desc }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="reveal from-right relative" id="boys">
                        <div class="img-zoom rounded-2xl overflow-hidden aspect-[4/3] shadow-2xl">
                            <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=900"
                                alt="Boarding facility" class="w-full h-full object-cover">
                        </div>
                        <div
                            class="absolute -bottom-5 -left-4 bg-gold text-white rounded-2xl px-6 py-4 shadow-xl text-center float">
                            <div class="font-display font-bold text-3xl leading-none">2</div>
                            <div class="text-white/80 text-xs mt-1">Hostel Blocks</div>
                        </div>
                        <div class="absolute -top-4 -right-4 bg-navy text-white rounded-2xl px-5 py-3 shadow-xl text-center float"
                            style="animation-delay:.6s">
                            <div class="font-display font-bold text-2xl text-gold leading-none">24/7</div>
                            <div class="text-white/70 text-[10px] mt-0.5">Supervision</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- HOSTEL BLOCKS --}}
        <section class="py-24 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
                <div class="text-center mb-14 reveal">
                    <p class="text-gold font-bold text-xs tracking-widest uppercase mb-2">Our Facilities</p>
                    <h2 class="font-display font-bold text-4xl text-navy mb-2">Hostel Blocks</h2>
                    <div class="gold-line mx-auto mb-3"></div>
                    <p class="text-gray-500 text-sm mt-6 max-w-xl mx-auto">
                        Separate, purpose-built accommodation blocks for boys and girls, each with dedicated housemasters
                        and all necessary facilities.
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-8 stagger">
                    {{-- Boys Hostel --}}
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm facility-card border border-gray-100"
                        id="boys-hostel">
                        <div class="aspect-video overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=700" alt="Boys Hostel"
                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-7">
                            <div class="flex items-center gap-3 mb-4">
                                <div
                                    class="w-10 h-10 bg-navy rounded-xl flex items-center justify-center text-white text-xl">
                                    🏠</div>
                                <div>
                                    <h3 class="font-display font-bold text-navy text-xl">Boys Hostel</h3>
                                    <p class="text-gold text-xs font-semibold">Hostel Block A</p>
                                </div>
                            </div>
                            <p class="text-gray-500 text-sm leading-relaxed mb-5">
                                A structured, disciplined residential block designed to foster brotherhood, academic focus,
                                and character development among our male students.
                            </p>
                            <div class="space-y-2">
                                @foreach (['Rooms for 2–4 boys with individual study desks', 'Dedicated housemaster and assistant housemaster', 'Separate washroom and bathing facilities', 'Secure lockers for personal belongings', 'Common room with indoor games', 'Weekly room inspections for cleanliness'] as $feat)
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <svg class="w-4 h-4 text-gold shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ $feat }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Girls Hostel --}}
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm facility-card border border-gray-100"
                        id="girls-hostel">
                        <div class="aspect-video overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=700"
                                alt="Girls Hostel"
                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-7">
                            <div class="flex items-center gap-3 mb-4">
                                <div
                                    class="w-10 h-10 bg-navy rounded-xl flex items-center justify-center text-white text-xl">
                                    🏡</div>
                                <div>
                                    <h3 class="font-display font-bold text-navy text-xl">Girls Hostel</h3>
                                    <p class="text-gold text-xs font-semibold">Hostel Block B</p>
                                </div>
                            </div>
                            <p class="text-gray-500 text-sm leading-relaxed mb-5">
                                A warm, supportive residential environment for our female students — safe, comfortable, and
                                guided by experienced female staff who prioritise every student's wellbeing.
                            </p>
                            <div class="space-y-2">
                                @foreach (['Rooms for 2–4 girls with individual study desks', 'Female housemaster and supporting staff on duty', 'Secure access control — visitors only during visiting hours', 'Separate washroom and bathing facilities', 'Common room for reading and socialising', 'Regular security and safety checks'] as $feat)
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <svg class="w-4 h-4 text-gold shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ $feat }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- DAILY ROUTINE --}}
        <section class="py-24 bg-white" id="routine">
            <div class="max-w-4xl mx-auto px-4 lg:px-8">
                <div class="text-center mb-14 reveal">
                    <p class="text-gold font-bold text-xs tracking-widest uppercase mb-2">Structure & Discipline</p>
                    <h2 class="font-display font-bold text-4xl text-navy mb-2">Boarding Daily Routine</h2>
                    <div class="gold-line mx-auto mb-3"></div>
                    <p class="text-gray-500 text-sm mt-6 max-w-xl mx-auto">
                        A well-structured day that balances academics, physical activity, spiritual practice, and rest —
                        building healthy lifelong habits.
                    </p>
                </div>

                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden reveal">
                    <div class="grid sm:grid-cols-2 divide-y sm:divide-y-0 sm:divide-x divide-gray-100">

                        {{-- Morning --}}
                        <div class="p-6 lg:p-8">
                            <div class="flex items-center gap-2 mb-6">
                                <div class="w-8 h-8 bg-amber-50 rounded-xl flex items-center justify-center text-lg">🌅
                                </div>
                                <h3 class="font-display font-bold text-navy text-lg">Morning Routine</h3>
                            </div>
                            <div class="space-y-0">
                                @foreach ([['5:30 AM', 'Wake Up & Personal Care', '#C9A227'], ['6:00 AM', 'Morning Prayer & Meditation', '#C9A227'], ['6:30 AM', 'Yoga / Exercise', '#C9A227'], ['7:30 AM', 'Breakfast', '#C9A227'], ['8:00 AM', 'School Classes Begin', '#C9A227'], ['10:30 AM', 'Short Break & Refreshments', '#6b7280'], ['1:00 PM', 'Lunch Break', '#6b7280']] as [$time, $activity, $color])
                                    <div
                                        class="timeline-row flex items-center gap-4 py-3 border-b border-gray-50 last:border-0">
                                        <div class="timeline-dot w-2.5 h-2.5 rounded-full shrink-0"
                                            style="background:{{ $color }}"></div>
                                        <span class="font-bold text-sm shrink-0 w-24"
                                            style="color:{{ $color }}">{{ $time }}</span>
                                        <span class="text-gray-600 text-sm">{{ $activity }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Evening --}}
                        <div class="p-6 lg:p-8">
                            <div class="flex items-center gap-2 mb-6">
                                <div class="w-8 h-8 bg-indigo-50 rounded-xl flex items-center justify-center text-lg">🌙
                                </div>
                                <h3 class="font-display font-bold text-navy text-lg">Evening Routine</h3>
                            </div>
                            <div class="space-y-0">
                                @foreach ([['1:45 PM', 'Co-curricular Activities & Sports', '#1a237e'], ['3:30 PM', 'School Ends / Free Time', '#1a237e'], ['5:30 PM', 'Evening Snack', '#1a237e'], ['6:00 PM', 'Supervised Study Hour', '#1a237e'], ['7:00 PM', 'Evening Satsaang / Prayer', '#1a237e'], ['8:00 PM', 'Dinner', '#1a237e'], ['9:30 PM', 'Lights Out', '#6b7280']] as [$time, $activity, $color])
                                    <div
                                        class="timeline-row flex items-center gap-4 py-3 border-b border-gray-50 last:border-0">
                                        <div class="timeline-dot w-2.5 h-2.5 rounded-full shrink-0"
                                            style="background:{{ $color }}"></div>
                                        <span class="font-bold text-sm shrink-0 w-24"
                                            style="color:{{ $color }}">{{ $time }}</span>
                                        <span class="text-gray-600 text-sm">{{ $activity }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- MEALS --}}
        <section class="py-24 bg-gray-50" id="meals">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div class="reveal from-right">
                        <div class="img-zoom rounded-2xl overflow-hidden aspect-[4/3] shadow-2xl">
                            <img src="https://images.unsplash.com/photo-1567521464027-f127ff144326?w=800" alt="Meals"
                                class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="reveal from-left">
                        <p class="text-gold font-bold text-xs tracking-widest uppercase mb-3">Healthy & Nutritious</p>
                        <h2 class="font-display font-bold text-4xl text-navy mb-5 leading-tight">Meals & Diet</h2>
                        <div class="gold-line mb-8"></div>
                        <p class="text-gray-600 leading-relaxed mb-6 mt-8">
                            We believe that nutrition is the foundation of academic performance. Our kitchen team prepares
                            balanced, wholesome vegetarian meals using fresh, locally-sourced ingredients — every single
                            day.
                        </p>
                        <div class="space-y-4">
                            @foreach ([['🌅', 'Breakfast (7:30 AM)', 'Hot nutritious breakfast including porridge, bread, eggs or dal, with tea/milk.'], ['☀️', 'Lunch (1:00 PM)', 'Full cooked meal with rice, lentils, vegetables, salad, and seasonal fruits.'], ['🌤️', 'Evening Snack (5:30 PM)', 'Light snack — biscuits, fruits, tea, or milk to re-energise after activities.'], ['🌙', 'Dinner (8:00 PM)', 'Hot, well-balanced dinner with dal, vegetables, roti or rice, and dessert.']] as [$icon, $meal, $desc])
                                <div
                                    class="flex gap-4 items-start bg-white rounded-xl p-4 border border-gray-100 hover:border-gold/30 transition-colors hover:shadow-sm">
                                    <span class="text-2xl shrink-0">{{ $icon }}</span>
                                    <div>
                                        <h4 class="font-semibold text-navy text-sm">{{ $meal }}</h4>
                                        <p class="text-gray-500 text-xs mt-0.5 leading-relaxed">{{ $desc }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6 bg-gold/8 border border-gold/20 rounded-xl p-4 text-sm text-gray-600">
                            <strong class="text-gold">Special dietary requirements?</strong> We accommodate medical dietary
                            needs and allergies with prior notice. Please mention in your application.
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- RULES & WELFARE --}}
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
                <div class="text-center mb-14 reveal">
                    <p class="text-gold font-bold text-xs tracking-widest uppercase mb-2">Student Welfare</p>
                    <h2 class="font-display font-bold text-4xl text-navy mb-2">Boarding Rules & Welfare</h2>
                    <div class="gold-line mx-auto mb-3"></div>
                    <p class="text-gray-500 text-sm mt-6 max-w-xl mx-auto">Clear boundaries build trust and safety. Our
                        boarding rules are fair, consistent, and focused on creating a respectful community.</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5 stagger">
                    @foreach ([['🏠', 'Visiting Hours', 'Parents may visit on Sundays, 10 AM – 4 PM. Prior notice required for weekday visits.'], ['📱', 'Device Policy', 'Mobile phones are not permitted in dormitories. Devices may be used in designated areas only.'], ['📚', 'Study Rules', 'All boarders must participate in supervised study hour from 6–7 PM every day.'], ['💡', 'Lights Out', 'Lights out at 9:30 PM. A quiet, rested mind is essential for the next day\'s learning.'], ['🧹', 'Room Cleanliness', 'Students are responsible for keeping their rooms tidy. Inspections held every Friday.'], ['🆘', 'Health & Safety', 'First aid kit on every floor. Any illness reported immediately to the housemaster.']] as [$icon, $title, $desc])
                        <div class="facility-card bg-gray-50 border border-gray-100 rounded-2xl p-6">
                            <div class="text-3xl mb-3">{{ $icon }}</div>
                            <h4 class="font-display font-bold text-navy text-lg mb-2">{{ $title }}</h4>
                            <p class="text-gray-500 text-sm leading-relaxed">{{ $desc }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- FEES & APPLY --}}
        <section class="py-24 bg-gray-50" id="fees">
            <div class="max-w-4xl mx-auto px-4 lg:px-8">
                <div class="text-center mb-14 reveal">
                    <p class="text-gold font-bold text-xs tracking-widest uppercase mb-2">Costs & Application</p>
                    <h2 class="font-display font-bold text-4xl text-navy mb-2">Boarding Fees</h2>
                    <div class="gold-line mx-auto mb-3"></div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 reveal">
                    <p class="text-gray-600 text-sm leading-relaxed mb-6">
                        Our boarding fees cover accommodation, all meals (3 meals + snack), supervision, and access to all
                        boarding facilities. Fees are charged per academic term. Tuition fees are billed separately.
                    </p>
                    <div class="space-y-3 mb-6">
                        @foreach (['Grades 1–5 (Primary)', 'Grades 6–10 (Secondary)', '+2 Level (Science & Management)'] as $level)
                            <div class="flex justify-between items-center py-4 border-b border-gray-100 last:border-0">
                                <div>
                                    <span class="font-semibold text-navy text-sm">{{ $level }}</span>
                                    <span class="text-gray-400 text-xs block mt-0.5">Accommodation + all meals +
                                        supervision</span>
                                </div>
                                <a href="{{ route('contact.index') }}"
                                    class="text-sm font-bold text-navy hover:text-gold transition-colors">Contact Office
                                    →</a>
                            </div>
                        @endforeach
                    </div>
                    <div class="bg-gold/8 border border-gold/20 rounded-xl p-4 text-sm text-gray-600">
                        <strong class="text-gold">Fee concessions available</strong> for siblings and students with
                        financial need. Speak to our admissions office for details.
                    </div>
                </div>
            </div>
        </section>

    @endif {{-- end static fallback --}}

    {{-- ══════════════════ CTA ══════════════════ --}}
    <section class="relative py-24 text-white text-center overflow-hidden"
        style="background:linear-gradient(135deg,#1B2A4A 0%,#16223d 50%,#4a148c 100%)">
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-24 -left-24 w-80 h-80 border border-white/5 rounded-full"></div>
            <div class="absolute -bottom-16 -right-16 w-96 h-96 border border-gold/8 rounded-full"></div>
        </div>
        <div class="relative max-w-2xl mx-auto px-4 reveal">
            <div class="text-5xl mb-5">🏠</div>
            <h2 class="font-display font-bold text-4xl mb-4">Apply for Boarding</h2>
            <p class="text-white/65 text-lg leading-relaxed mb-10">
                Give your child the full SSSS experience. Boarding spaces are limited — applications are reviewed on a
                first-come, first-served basis.
            </p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('admissions.index') }}"
                    class="group relative overflow-hidden bg-gold text-white font-bold px-10 py-4 rounded-xl text-sm shadow-lg">
                    Apply Now →
                </a>
                <a href="{{ route('contact.index') }}"
                    class="border-2 border-white/30 hover:border-gold text-white hover:text-gold font-semibold px-10 py-4 rounded-xl transition-all text-sm">
                    Ask a Question
                </a>
            </div>
            <p class="text-white/35 text-xs mt-8">
                Questions? Call us on {{ \App\Models\SiteSetting::get('phone', '+977-1-XXXXXXX') }} or email
                {{ \App\Models\SiteSetting::get('email', 'info@school.edu.np') }}
            </p>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const obs = new IntersectionObserver(entries => {
                entries.forEach(e => {
                    if (e.isIntersecting) e.target.classList.add('visible');
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -40px 0px'
            });
            document.querySelectorAll('.reveal, .stagger, .gold-line').forEach(el => obs.observe(el));
        });
    </script>
@endpush
