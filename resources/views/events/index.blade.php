@extends('layouts.app')
@section('title', 'Events')
@section('content')
    <div class="bg-navy py-20 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 relative">
            <p class="text-gold text-sm font-semibold tracking-widest uppercase mb-3">School Calendar</p>
            <h1 class="font-display text-5xl font-bold text-white mb-4">Events</h1>
            <div class="flex items-center gap-2 text-navy-200 text-sm">
                <a href="{{ route('home') }}" class="hover:text-gold transition-colors">Home</a><span>›</span><span
                    class="text-gold">Events</span>
            </div>
        </div>
    </div>
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            {{-- Filter tabs --}}
            <div class="flex gap-2 mb-10">
                <a href="?filter=upcoming"
                    class="px-6 py-2.5 rounded-full text-sm font-semibold transition-colors {{ $filter === 'upcoming' ? 'bg-navy text-white' : 'bg-white text-navy hover:bg-navy hover:text-white border border-gray-200' }}">Upcoming</a>
                <a href="?filter=past"
                    class="px-6 py-2.5 rounded-full text-sm font-semibold transition-colors {{ $filter === 'past' ? 'bg-navy text-white' : 'bg-white text-navy hover:bg-navy hover:text-white border border-gray-200' }}">Past</a>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($events as $event)
                    <article class="bg-white rounded-2xl overflow-hidden shadow-sm card-hover flex flex-col">
                        <a href="{{ route('events.show', $event->slug) }}"
                            class="block aspect-video overflow-hidden relative">
                            <img src="{{ $event->image_url }}" alt="{{ $event->title }}"
                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                            <div
                                class="absolute top-4 left-4 bg-gold text-white text-center rounded-xl px-3 py-2 min-w-[52px]">
                                <div class="font-display font-bold text-xl leading-none">
                                    {{ $event->start_date->format('d') }}</div>
                                <div class="text-xs font-medium">{{ $event->start_date->format('M') }}</div>
                            </div>
                        </a>
                        <div class="p-6 flex-1 flex flex-col">
                            <h3 class="font-display font-bold text-navy text-xl mb-3 leading-snug flex-1">
                                <a href="{{ route('events.show', $event->slug) }}"
                                    class="hover:text-gold transition-colors">{{ $event->title }}</a>
                            </h3>
                            @if ($event->location)
                                <div class="flex items-center gap-1.5 text-gray-400 text-sm mb-2">
                                    <svg class="w-4 h-4 shrink-0 text-gold" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                            clip-rule="evenodd" />
                                    </svg>{{ $event->location }}
                                </div>
                            @endif
                            @if ($event->description)
                                <p class="text-gray-500 text-sm line-clamp-2 mb-4">{{ $event->description }}</p>
                            @endif
                            <a href="{{ route('events.show', $event->slug) }}"
                                class="mt-auto pt-4 border-t border-gray-100 text-gold text-sm font-semibold hover:underline block">View
                                Details →</a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-3 text-center py-20 text-gray-400">
                        <svg class="w-16 h-16 mx-auto mb-4 opacity-30" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-lg font-medium">No {{ $filter }} events.</p>
                    </div>
                @endforelse
            </div>
            @if ($events->hasPages())
                <div class="mt-12 flex justify-center">{{ $events->links() }}</div>
            @endif
        </div>
    </section>
@endsection
