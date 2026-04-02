@extends('layouts.app')
@section('title', $event->meta_title ?? $event->title)
@section('content')
    <div class="bg-navy py-16">
        <div class="max-w-4xl mx-auto px-4">
            <p class="text-gold text-sm font-semibold tracking-widest uppercase mb-3">Event Details</p>
            <h1 class="font-display text-4xl lg:text-5xl font-bold text-white mb-4 leading-tight">{{ $event->title }}</h1>
            <div class="flex items-center gap-2 text-navy-200 text-sm">
                <a href="{{ route('home') }}" class="hover:text-gold">Home</a><span>›</span>
                <a href="{{ route('events.index') }}" class="hover:text-gold">Events</a><span>›</span><span
                    class="text-gold">{{ Str::limit($event->title, 40) }}</span>
            </div>
        </div>
    </div>
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 grid lg:grid-cols-3 gap-12">
            <article class="lg:col-span-2">
                @if ($event->image)
                    <div class="rounded-2xl overflow-hidden mb-8 shadow-md"><img src="{{ $event->image_url }}"
                            alt="{{ $event->title }}" class="w-full"></div>
                @endif
                <div class="bg-white rounded-2xl p-8 lg:p-12 shadow-sm">
                    <div class="grid sm:grid-cols-3 gap-4 mb-8 pb-6 border-b border-gray-100">
                        <div class="bg-navy/5 rounded-xl p-4 text-center">
                            <div class="text-gold font-bold font-display text-2xl">{{ $event->start_date->format('d') }}
                            </div>
                            <div class="text-navy text-sm font-semibold">{{ $event->start_date->format('M Y') }}</div>
                            <div class="text-gray-400 text-xs mt-1">{{ $event->start_date->format('l') }}</div>
                        </div>
                        @if ($event->location)
                            <div class="bg-navy/5 rounded-xl p-4 text-center flex flex-col items-center justify-center"><svg
                                    class="w-5 h-5 text-gold mb-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="text-navy text-sm font-semibold">{{ $event->location }}</div>
                                <div class="text-gray-400 text-xs mt-1">Location</div>
                            </div>
                        @endif
                        @if ($event->organizer)
                            <div class="bg-navy/5 rounded-xl p-4 text-center flex flex-col items-center justify-center"><svg
                                    class="w-5 h-5 text-gold mb-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                                </svg>
                                <div class="text-navy text-sm font-semibold">{{ $event->organizer }}</div>
                                <div class="text-gray-400 text-xs mt-1">Organizer</div>
                            </div>
                        @endif
                    </div>
                    @if ($event->body)
                        <div
                            class="prose prose-lg max-w-none text-gray-700 leading-relaxed prose-headings:font-display prose-headings:text-navy">
                            {!! $event->body !!}</div>
                    @elseif($event->description)
                        <p class="text-gray-700 leading-relaxed text-lg">{{ $event->description }}</p>
                    @endif
                </div>
            </article>
            <aside class="space-y-6">
                @if ($related->count())
                    <div class="bg-white rounded-2xl p-6 shadow-sm">
                        <h3 class="font-display font-bold text-navy text-lg mb-4 gold-underline">Other Events</h3>
                        <div class="mt-6 space-y-4">
                            @foreach ($related as $r)
                                <a href="{{ route('events.show', $r->slug) }}" class="flex gap-3 group">
                                    <div class="bg-gold text-white text-center rounded-xl p-2 min-w-[44px]">
                                        <div class="font-bold text-sm">{{ $r->start_date->format('d') }}</div>
                                        <div class="text-xs">{{ $r->start_date->format('M') }}</div>
                                    </div>
                                    <div>
                                        <h4
                                            class="text-navy text-sm font-semibold group-hover:text-gold transition-colors leading-snug">
                                            {{ Str::limit($r->title, 50) }}</h4>
                                        @if ($r->location)
                                            <p class="text-xs text-gray-400 mt-0.5">{{ $r->location }}</p>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="bg-navy rounded-2xl p-6 text-center">
                    <h3 class="font-display font-bold text-white text-lg mb-2">Stay Updated</h3>
                    <p class="text-navy-200 text-sm mb-4">Don't miss any school events or announcements.</p><a
                        href="{{ route('contact.index') }}"
                        class="block bg-gold hover:bg-gold-500 text-white font-semibold py-3 rounded-xl transition-colors">Contact
                        Us</a>
                </div>
            </aside>
        </div>
    </section>
@endsection
