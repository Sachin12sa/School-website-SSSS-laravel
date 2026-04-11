@extends('layouts.app')
@section('title', 'Events')
@section('page_title', 'School Calendar')

@section('content')

    @include('components.page-hero', [
        'breadcrumb' => 'Events',
        'title' => 'Events',
        'subtitle' => 'Stay up to date with upcoming school events, competitions, and celebrations.',
    ])

    <section class="py-14 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">

            {{-- Filter tabs --}}
            <div class="flex gap-2 mb-10">
                <a href="{{ route('events.index') }}"
                    class="px-5 py-2.5 rounded-full text-sm font-semibold transition-colors {{ !request('filter') || request('filter') === 'upcoming' ? 'bg-navy text-white' : 'bg-white text-navy border border-gray-200 hover:border-navy' }}">
                    Upcoming
                </a>
                <a href="{{ route('events.index', ['filter' => 'past']) }}"
                    class="px-5 py-2.5 rounded-full text-sm font-semibold transition-colors {{ request('filter') === 'past' ? 'bg-navy text-white' : 'bg-white text-navy border border-gray-200 hover:border-navy' }}">
                    Past Events
                </a>
            </div>

            @if ($events->count())
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-7">
                    @foreach ($events as $event)
                        <article
                            class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow flex flex-col card-lift">

                            {{-- Image with date badge --}}
                            <a href="{{ route('events.show', $event->slug) }}"
                                class="block aspect-video overflow-hidden relative">
                                <img src="{{ $event->image_url }}" alt="{{ $event->title }}"
                                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                {{-- Date badge over image --}}
                                <div
                                    class="absolute top-3 left-3 bg-gold text-white text-center rounded-xl px-3 py-2 min-w-[52px] shadow-lg">
                                    <div class="font-display font-bold text-xl leading-none">
                                        {{ $event->start_date->format('d') }}</div>
                                    <div class="text-xs font-semibold mt-0.5">{{ $event->start_date->format('M') }}</div>
                                </div>
                            </a>

                            <div class="p-6 flex flex-col flex-1">
                                <h3 class="font-display font-bold text-navy text-xl mb-2 leading-snug flex-1">
                                    <a href="{{ route('events.show', $event->slug) }}"
                                        class="hover:text-gold transition-colors">{{ $event->title }}</a>
                                </h3>

                                {{-- Location --}}
                                @if ($event->location)
                                    <div class="flex items-center gap-1.5 text-gray-400 text-sm mb-2">
                                        <svg class="w-4 h-4 text-gold shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $event->location }}
                                    </div>
                                @endif

                                {{-- Time range --}}
                                <div class="flex items-center gap-1.5 text-gray-400 text-xs mb-3">
                                    <svg class="w-3.5 h-3.5 text-gold shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $event->start_date->format('l, d M Y') }}
                                    @if ($event->end_date && !$event->end_date->isSameDay($event->start_date))
                                        – {{ $event->end_date->format('d M Y') }}
                                    @endif
                                </div>

                                @if ($event->description)
                                    <p class="text-gray-500 text-sm leading-relaxed mb-4 line-clamp-2">
                                        {{ $event->description }}</p>
                                @endif

                                <div class="pt-4 mt-auto border-t border-gray-100">
                                    <a href="{{ route('events.show', $event->slug) }}"
                                        class="text-gold text-sm font-semibold hover:underline">View Details →</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if ($events->hasPages())
                    <div class="mt-12 flex justify-center">{{ $events->links() }}</div>
                @endif
            @else
                <div class="text-center py-24 text-gray-400">
                    <svg class="w-16 h-16 mx-auto mb-4 opacity-25" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-lg font-medium text-gray-500">
                        No {{ request('filter') === 'past' ? 'past' : 'upcoming' }} events at the moment.
                    </p>
                </div>
            @endif

        </div>
    </section>

@endsection
