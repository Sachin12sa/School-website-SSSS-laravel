@extends('layouts.app')
@section('title', $gallery->name)
@section('content')

    <div class="bg-navy py-20 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 relative">
            <p class="text-gold text-sm font-semibold tracking-widest uppercase mb-3">Gallery</p>
            <h1 class="font-display text-5xl font-bold text-white mb-4">{{ $gallery->name }}</h1>
            @if ($gallery->description)
                <p class="text-navy-200 text-lg max-w-2xl">{{ $gallery->description }}</p>
            @endif
            <div class="flex items-center gap-2 text-navy-300 text-sm mt-5">
                <a href="{{ route('home') }}" class="hover:text-gold transition-colors">Home</a>
                <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ route('gallery.index') }}" class="hover:text-gold transition-colors">Gallery</a>
                <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gold">{{ $gallery->name }}</span>
            </div>
        </div>
    </div>

    <section class="py-16 bg-gray-50" x-data="lightbox()">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between mb-8">
                <p class="text-gray-500 text-sm">{{ $gallery->images->count() }}
                    {{ Str::plural('photo', $gallery->images->count()) }}</p>
                <a href="{{ route('gallery.index') }}"
                    class="text-navy text-sm font-semibold hover:text-gold transition-colors flex items-center gap-1.5 group">
                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                    </svg>
                    All Albums
                </a>
            </div>

            @if ($gallery->images->count())
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                    @foreach ($gallery->images as $img)
                        <div @click="open('{{ $img->url }}','{{ $img->caption }}')"
                            class="aspect-square rounded-xl overflow-hidden cursor-pointer group relative shadow-sm">
                            <img src="{{ $img->url }}" alt="{{ $img->caption }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div
                                class="absolute inset-0 bg-navy/0 group-hover:bg-navy/40 transition-colors flex flex-col items-center justify-center">
                                <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                </svg>
                                @if ($img->caption)
                                    <p
                                        class="text-white text-xs mt-2 px-2 text-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        {{ $img->caption }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 text-gray-400">
                    <svg class="w-16 h-16 mx-auto mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-lg font-medium">No photos in this album yet.</p>
                </div>
            @endif
        </div>

        {{-- Lightbox --}}
        <div x-show="show" x-cloak @click.self="show=false" @keydown.escape.window="show=false"
            class="fixed inset-0 bg-black/95 z-50 flex items-center justify-center p-4"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">
            <button @click="show=false"
                class="absolute top-5 right-5 w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="max-w-5xl w-full">
                <img :src="src" :alt="caption" class="w-full max-h-[80vh] object-contain rounded-xl">
                <p x-show="caption" x-text="caption" class="text-white/70 text-center mt-4 text-sm"></p>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            function lightbox() {
                return {
                    show: false,
                    src: '',
                    caption: '',
                    open(s, c) {
                        this.src = s;
                        this.caption = c;
                        this.show = true;
                    }
                };
            }
        </script>
    @endpush
@endsection
