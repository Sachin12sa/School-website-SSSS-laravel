@extends('layouts.app')
@section('title', \App\Models\SiteSetting::get('school_name', 'Our School'))
@section('content')

    {{-- ═══ HERO ═══ --}}
    <section class="relative min-h-screen flex items-center overflow-hidden">
        @php
            $hero = collect($blocks)->firstWhere('type', 'hero');
        @endphp
        <div class="absolute inset-0 bg-navy">
            @if ($hero && $hero->image_url)
                <img src="{{ $hero->image_url }}" alt="School" class="w-full h-full object-cover opacity-40">
            @else
                <div class="absolute inset-0"
                    style="background: linear-gradient(135deg, #1B2A4A 0%, #2e4d8a 50%, #1a3060 100%)"></div>
            @endif
            <div class="absolute inset-0 hero-gradient"></div>
        </div>
        {{-- Decorative geometric shapes --}}
        <div class="absolute top-20 right-20 w-64 h-64 border border-gold/20 rounded-full hidden lg:block"></div>
        <div class="absolute bottom-20 right-40 w-32 h-32 border border-gold/10 rounded-full hidden lg:block"></div>
        <div class="absolute top-1/3 right-1/4 w-4 h-4 bg-gold/30 rounded-full hidden lg:block"></div>

        <div class="relative max-w-7xl mx-auto px-4 py-32 grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <div
                    class="inline-flex items-center gap-2 bg-gold/20 border border-gold/40 text-gold text-xs font-semibold tracking-widest uppercase px-4 py-2 rounded-full mb-6">
                    <span class="w-1.5 h-1.5 bg-gold rounded-full"></span>
                    {{ \App\Models\SiteSetting::get('established_year') ? 'Est. ' . \App\Models\SiteSetting::get('established_year') : 'Excellence in Education' }}
                </div>
                <h1 class="font-display text-5xl lg:text-7xl font-bold text-white leading-tight mb-6">
                    {!! $hero
                        ? nl2br(e($hero->title ?? \App\Models\SiteSetting::get('school_name', 'Our School')))
                        : \App\Models\SiteSetting::get('school_name', 'Our School') !!}
                </h1>
                <p class="text-navy-100 text-lg lg:text-xl leading-relaxed mb-10 max-w-xl">
                    {{ $hero->subtitle ?? \App\Models\SiteSetting::get('hero_subtitle', 'Nurturing young minds, building strong characters, and inspiring a lifelong love of learning in every student.') }}
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('admissions.index') }}"
                        class="bg-gold hover:bg-gold-500 text-white font-semibold px-8 py-4 rounded transition-all shadow-lg hover:shadow-gold/30 hover:shadow-xl">
                        Apply for Admission
                    </a>
                    <a href="{{ $hero->button_url ?? route('page.show', 'about') }}"
                        class="border-2 border-white/50 hover:border-gold text-white hover:text-gold font-semibold px-8 py-4 rounded transition-all">
                        {{ $hero->button_text ?? 'Discover More' }}
                    </a>
                </div>
            </div>

            {{-- Hero stats card --}}
            @php
                $stats = $blocks->firstWhere('type', 'stats');
                $statsData = $stats->extra ?? [];
            @endphp
            <div class="hidden lg:block">
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-8 grid grid-cols-2 gap-6">
                    @foreach ([['value' => $statsData['students'] ?? '1,200+', 'label' => 'Students'], ['value' => $statsData['teachers'] ?? '80+', 'label' => 'Expert Teachers'], ['value' => $statsData['years'] ?? '45+', 'label' => 'Years of Excellence'], ['value' => $statsData['programmes'] ?? '20+', 'label' => 'Programmes']] as $stat)
                        <div class="text-center p-4 bg-white/10 rounded-xl">
                            <div class="font-display text-4xl font-bold text-gold mb-1">{{ $stat['value'] }}</div>
                            <div class="text-navy-100 text-sm">{{ $stat['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Scroll indicator --}}
        <div
            class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-white/50 text-xs animate-bounce">
            <span>Scroll</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </section>

    {{-- ═══ STATS STRIP (mobile) ═══ --}}
    @php
        $stats = $blocks->firstWhere('type', 'stats');
        $statsData = $stats ? $stats->extra ?? [] : [];
    @endphp
    @if ($stats && $stats->is_visible)
        <section class="bg-navy py-12 lg:hidden">
            <div class="max-w-7xl mx-auto px-4 grid grid-cols-2 gap-6">
                @foreach ([['value' => $statsData['students'] ?? '1,200+', 'label' => 'Students'], ['value' => $statsData['teachers'] ?? '80+', 'label' => 'Teachers'], ['value' => $statsData['years'] ?? '45+', 'label' => 'Years'], ['value' => $statsData['programmes'] ?? '20+', 'label' => 'Programmes']] as $stat)
                    <div class="text-center">
                        <div class="font-display text-3xl font-bold text-gold">{{ $stat['value'] }}</div>
                        <div class="text-navy-200 text-sm mt-1">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ═══ ABOUT INTRO ═══ --}}
    @php $about = $blocks->firstWhere('type','about_intro'); @endphp
    @if (!$about || $about->is_visible)
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 grid lg:grid-cols-2 gap-16 items-center">
                <div class="relative">
                    <div class="aspect-[4/3] rounded-2xl overflow-hidden shadow-2xl">
                        @if ($about && $about->image_url)
                            <img src="{{ $about->image_url }}" alt="About" class="w-full h-full object-cover">
                        @else
                            <div
                                class="w-full h-full bg-gradient-to-br from-navy to-navy-700 flex items-center justify-center">
                                <svg class="w-24 h-24 text-gold/40" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path
                                        d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    {{-- Decorative accent --}}
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-gold/10 rounded-2xl -z-10"></div>
                    <div class="absolute -top-6 -left-6 w-24 h-24 bg-navy/5 rounded-2xl -z-10"></div>
                </div>
                <div>
                    <p class="text-gold font-semibold text-sm tracking-widest uppercase mb-3">About Our School</p>
                    <h2 class="font-display text-4xl lg:text-5xl font-bold text-navy mb-6 gold-underline">
                        {{ $about->title ?? 'A Tradition of Academic Excellence' }}
                    </h2>
                    <div class="mt-8 prose prose-navy text-gray-600 leading-relaxed">
                        {!! $about
                            ? $about->content
                            : \App\Models\SiteSetting::get(
                                'about_content',
                                '<p>We are committed to providing a world-class education that prepares students for success in an ever-changing world. Our experienced faculty, modern facilities, and supportive community create the ideal environment for learning and growth.</p><p>Founded on the principles of academic rigor, character development, and community service, our school has been shaping future leaders for generations.</p>',
                            ) !!}
                    </div>
                    <div class="mt-8 flex flex-wrap gap-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gold/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-gold" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z" />
                                    <path
                                        d="M3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762z" />
                                    <path
                                        d="M9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                </svg>
                            </div>
                            <span class="text-navy font-medium text-sm">Academic Excellence</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gold/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-gold" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="text-navy font-medium text-sm">Holistic Development</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gold/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-gold" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                </svg>
                            </div>
                            <span class="text-navy font-medium text-sm">Vibrant Community</span>
                        </div>
                    </div>
                    <a href="{{ route('page.show', 'about') }}"
                        class="mt-8 inline-flex items-center gap-2 text-navy font-semibold hover:text-gold transition-colors group">
                        Learn More About Us
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- ═══ NEWS FEED ═══ --}}
    @if ($latestNews->count())
        <section class="py-24 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                    <div>
                        <p class="text-gold font-semibold text-sm tracking-widest uppercase mb-2">Stay Informed</p>
                        <h2 class="font-display text-4xl font-bold text-navy gold-underline">Latest News</h2>
                    </div>
                    <a href="{{ route('news.index') }}"
                        class="mt-6 md:mt-0 inline-flex items-center gap-2 text-navy font-semibold hover:text-gold transition-colors group">
                        View All News <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    @foreach ($latestNews as $i => $post)
                        <article
                            class="bg-white rounded-2xl overflow-hidden shadow-sm card-hover {{ $i === 0 ? 'md:col-span-1' : '' }}">
                            <a href="{{ route('news.show', $post->slug) }}" class="block">
                                <div class="aspect-video overflow-hidden">
                                    <img src="{{ $post->image_url }}" alt="{{ $post->title }}"
                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                </div>
                            </a>
                            <div class="p-6">
                                @if ($post->category)
                                    <span
                                        class="inline-block bg-gold/10 text-gold text-xs font-semibold px-3 py-1 rounded-full mb-3">{{ $post->category }}</span>
                                @endif
                                <h3 class="font-display font-semibold text-navy text-xl mb-3 leading-snug">
                                    <a href="{{ route('news.show', $post->slug) }}"
                                        class="hover:text-gold transition-colors">{{ $post->title }}</a>
                                </h3>
                                @if ($post->excerpt)
                                    <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ $post->excerpt }}</p>
                                @endif
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-400">{{ $post->published_at->format('d M Y') }}</span>
                                    <a href="{{ route('news.show', $post->slug) }}"
                                        class="text-gold text-sm font-semibold hover:underline">Read More →</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ═══ EVENTS ═══ --}}
    @if ($upcomingEvents->count())
        <section class="py-24 bg-navy">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                    <div>
                        <p class="text-gold font-semibold text-sm tracking-widest uppercase mb-2">What's On</p>
                        <h2 class="font-display text-4xl font-bold text-white">Upcoming Events</h2>
                        <div class="w-12 h-0.5 bg-gold mt-4"></div>
                    </div>
                    <a href="{{ route('events.index') }}"
                        class="mt-6 md:mt-0 inline-flex items-center gap-2 text-gold font-semibold hover:underline group">
                        See All Events <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
                <div class="grid md:grid-cols-3 gap-6">
                    @foreach ($upcomingEvents as $event)
                        <a href="{{ route('events.show', $event->slug) }}"
                            class="group bg-white/5 hover:bg-white/10 border border-white/10 hover:border-gold/40 rounded-2xl p-6 transition-all card-hover">
                            <div class="flex gap-4 items-start">
                                <div class="bg-gold text-white text-center rounded-xl p-3 min-w-[60px]">
                                    <div class="font-display font-bold text-2xl leading-none">
                                        {{ $event->start_date->format('d') }}</div>
                                    <div class="text-xs font-medium mt-0.5">{{ $event->start_date->format('M') }}</div>
                                </div>
                                <div>
                                    <h3
                                        class="font-display font-semibold text-white text-lg group-hover:text-gold transition-colors leading-snug">
                                        {{ $event->title }}</h3>
                                    @if ($event->location)
                                        <div class="flex items-center gap-1.5 mt-2 text-navy-200 text-xs">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $event->location }}
                                        </div>
                                    @endif
                                    @if ($event->description)
                                        <p class="mt-2 text-navy-300 text-sm line-clamp-2">{{ $event->description }}</p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ═══ TESTIMONIALS ═══ --}}
    @if ($testimonials->count())
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-14">
                    <p class="text-gold font-semibold text-sm tracking-widest uppercase mb-2">Community Voices</p>
                    <h2 class="font-display text-4xl font-bold text-navy">What Our Community Says</h2>
                    <div class="w-12 h-0.5 bg-gold mx-auto mt-4"></div>
                </div>
                <div x-data="{ active: 0 }">
                    <div class="grid md:grid-cols-3 gap-8">
                        @foreach ($testimonials->take(3) as $i => $t)
                            <div class="bg-gray-50 rounded-2xl p-8 relative card-hover">
                                <svg class="w-10 h-10 text-gold/20 absolute top-6 right-6" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                                </svg>
                                <div class="flex gap-1 mb-4">
                                    @for ($s = 1; $s <= 5; $s++)
                                        <svg class="w-4 h-4 {{ $s <= $t->rating ? 'text-gold' : 'text-gray-300' }}"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                                <p class="text-gray-600 italic leading-relaxed mb-6">"{{ $t->content }}"</p>
                                <div class="flex items-center gap-3">
                                    @if ($t->photo_url)
                                        <img src="{{ $t->photo_url }}" alt="{{ $t->author_name }}"
                                            class="w-11 h-11 rounded-full object-cover">
                                    @else
                                        <div
                                            class="w-11 h-11 bg-navy rounded-full flex items-center justify-center text-white font-bold">
                                            {{ substr($t->author_name, 0, 1) }}</div>
                                    @endif
                                    <div>
                                        <div class="font-semibold text-navy text-sm">{{ $t->author_name }}</div>
                                        @if ($t->author_role)
                                            <div class="text-gold text-xs">{{ $t->author_role }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ═══ CTA BANNER ═══ --}}
    @php $cta = $blocks->firstWhere('type','cta_banner'); @endphp
    <section class="relative py-20 overflow-hidden"
        style="background: linear-gradient(135deg, #C9A227 0%, #e0b830 50%, #C9A227 100%)">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-4 left-10 w-40 h-40 border-2 border-white rounded-full"></div>
            <div class="absolute bottom-4 right-10 w-64 h-64 border border-white rounded-full"></div>
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 border border-white rounded-full">
            </div>
        </div>
        <div class="relative max-w-4xl mx-auto px-4 text-center text-white">
            <h2 class="font-display text-4xl lg:text-5xl font-bold mb-4">{{ $cta->title ?? 'Begin Your Journey With Us' }}
            </h2>
            <p class="text-white/80 text-lg mb-10">
                {{ $cta->subtitle ?? 'Join our school family and unlock your child\'s full potential. Admissions are now open.' }}
            </p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('admissions.index') }}"
                    class="bg-navy hover:bg-navy-700 text-white font-semibold px-10 py-4 rounded transition-all shadow-lg hover:shadow-xl">
                    {{ $cta->button_text ?? 'Apply Now' }}
                </a>
                <a href="{{ route('contact.index') }}"
                    class="border-2 border-white/60 hover:border-white text-white font-semibold px-10 py-4 rounded transition-all">
                    Get in Touch
                </a>
            </div>
        </div>
    </section>

@endsection
