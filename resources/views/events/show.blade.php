@extends('layouts.app')
@section('title', $event->meta_title ?? $event->title)
@section('meta_description', $event->meta_description ?? $event->description)

@section('content')

    @include('components.page-hero', [
        'breadcrumb' => 'Events',
        'title' => $event->title,
    ])

    <section class="py-14 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-10">

                {{-- ── Event detail ─────────────────────────────────────────────────── --}}
                <article class="lg:col-span-2">
                    @if ($event->image)
                        <div class="rounded-2xl overflow-hidden mb-8 shadow-md">
                            <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-full">
                        </div>
                    @endif

                    <div class="bg-white rounded-2xl p-7 lg:p-10 shadow-sm">

                        {{-- Info cards --}}
                        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8 pb-8 border-b border-gray-100">
                            <div class="bg-navy/5 rounded-xl p-4 text-center">
                                <div class="font-display font-bold text-navy text-3xl">{{ $event->start_date->format('d') }}
                                </div>
                                <div class="text-navy font-semibold text-sm">{{ $event->start_date->format('F Y') }}</div>
                                <div class="text-gray-400 text-xs mt-0.5">{{ $event->start_date->format('l') }}</div>
                            </div>

                            @if ($event->location)
                                <div class="bg-navy/5 rounded-xl p-4 text-center flex flex-col items-center justify-center">
                                    <svg class="w-5 h-5 text-gold mb-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <div class="text-navy font-semibold text-sm">{{ $event->location }}</div>
                                    <div class="text-gray-400 text-xs mt-0.5">Location</div>
                                </div>
                            @endif

                            @if ($event->organizer)
                                <div class="bg-navy/5 rounded-xl p-4 text-center flex flex-col items-center justify-center">
                                    <svg class="w-5 h-5 text-gold mb-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <div class="text-navy font-semibold text-sm">{{ $event->organizer }}</div>
                                    <div class="text-gray-400 text-xs mt-0.5">Organiser</div>
                                </div>
                            @endif
                        </div>

                        {{-- End date if multi-day --}}
                        @if ($event->end_date && !$event->end_date->isSameDay($event->start_date))
                            <div class="flex items-center gap-2 mb-6 text-sm text-gray-500">
                                <svg class="w-4 h-4 text-gold shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Runs until <strong class="text-navy ml-1">{{ $event->end_date->format('d F Y') }}</strong>
                            </div>
                        @endif

                        {{-- Body / description --}}
                        @if ($event->body)
                            <div
                                class="prose prose-lg max-w-none text-gray-700 leading-relaxed prose-headings:font-display prose-headings:text-navy prose-a:text-gold">
                                {!! $event->body !!}
                            </div>
                        @elseif($event->description)
                            <p class="text-gray-600 leading-relaxed text-lg">{{ $event->description }}</p>
                        @endif
                    </div>

                    <a href="{{ route('events.index') }}"
                        class="inline-flex items-center gap-2 mt-6 text-navy hover:text-gold transition-colors text-sm font-semibold group">
                        <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                        </svg>
                        Back to Events
                    </a>
                </article>

                {{-- ── Sidebar ───────────────────────────────────────────────────────── --}}
                <aside class="space-y-6">

                    @if ($related->count())
                        <div class="bg-white rounded-2xl p-6 shadow-sm">
                            <h3 class="font-display font-bold text-navy text-lg mb-1">Other Events</h3>
                            <div class="w-8 h-0.5 bg-gold mb-5 rounded-full"></div>
                            @foreach ($related as $r)
                                <a href="{{ route('events.show', $r->slug) }}" class="flex gap-3 mb-4 group last:mb-0">
                                    <div class="bg-gold text-white text-center rounded-xl px-3 py-2 min-w-[48px] shrink-0">
                                        <div class="font-bold text-sm leading-none">{{ $r->start_date->format('d') }}</div>
                                        <div class="text-[10px] mt-0.5">{{ $r->start_date->format('M') }}</div>
                                    </div>
                                    <div>
                                        <h4
                                            class="text-navy text-sm font-semibold group-hover:text-gold transition-colors leading-snug">
                                            {{ Str::limit($r->title, 55) }}
                                        </h4>
                                        @if ($r->location)
                                            <p class="text-gray-400 text-xs mt-0.5">{{ $r->location }}</p>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <div class="bg-navy rounded-2xl p-6 text-center">
                        <h3 class="font-display font-bold text-white text-lg mb-2">Stay Updated</h3>
                        <p class="text-white/60 text-sm mb-4">Don't miss future events and announcements.</p>
                        <a href="{{ route('contact.index') }}"
                            class="block bg-gold hover:bg-gold-dark text-white font-bold py-3 rounded-xl text-sm transition-colors">Contact
                            Us</a>
                    </div>
                </aside>

            </div>
        </div>
    </section>

@endsection
