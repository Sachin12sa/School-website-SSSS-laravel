@extends('layouts.app')
@section('title', 'Gallery')
@section('page_title', 'Photo Albums')

@section('content')

    @include('components.page-hero', [
        'breadcrumb' => 'Gallery',
        'title' => 'Our Gallery',
        'subtitle' => 'A visual journey through school life, events, achievements, and campus moments.',
    ])

    <section class="py-14 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">

            @if ($galleries->count())
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-7">
                    @foreach ($galleries as $gallery)
                        <a href="{{ route('gallery.show', $gallery->id) }}"
                            class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-shadow block card-lift">

                            {{-- Cover image --}}
                            <div class="aspect-video overflow-hidden relative">
                                <img src="{{ $gallery->cover_url }}" alt="{{ $gallery->name }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

                                {{-- Photo count badge --}}
                                <div
                                    class="absolute bottom-3 right-3 bg-black/50 backdrop-blur-sm text-white text-xs font-semibold px-2.5 py-1.5 rounded-lg flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $gallery->images_count }} {{ Str::plural('item', $gallery->images_count) }}
                                </div>

                                {{-- Hover overlay with "View Album" --}}
                                <div
                                    class="absolute inset-0 bg-navy/0 group-hover:bg-navy/50 transition-colors flex items-center justify-center">
                                    <span
                                        class="bg-gold text-white text-sm font-bold px-5 py-2.5 rounded-xl opacity-0 group-hover:opacity-100 transition-all duration-300 -translate-y-2 group-hover:translate-y-0">
                                        View Album
                                    </span>
                                </div>
                            </div>

                            {{-- Album info --}}
                            <div class="p-5">
                                <h3
                                    class="font-display font-bold text-navy text-lg group-hover:text-gold transition-colors">
                                    {{ $gallery->name }}
                                </h3>
                                @if ($gallery->description)
                                    <p class="text-gray-500 text-sm mt-1 line-clamp-2">{{ $gallery->description }}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-24">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-gray-500 text-lg font-medium">No galleries yet.</p>
                    <p class="text-gray-400 text-sm mt-1">Check back soon for photos and videos.</p>
                </div>
            @endif

        </div>
    </section>

@endsection
