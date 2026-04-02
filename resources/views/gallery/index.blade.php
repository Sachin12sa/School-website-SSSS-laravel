@extends('layouts.app')
@section('title', 'Gallery')
@section('content')
    <div class="bg-navy py-20">
        <div class="max-w-7xl mx-auto px-4">
            <p class="text-gold text-sm font-semibold tracking-widest uppercase mb-3">Visual Stories</p>
            <h1 class="font-display text-5xl font-bold text-white mb-4">Our Gallery</h1>
            <div class="flex items-center gap-2 text-navy-200 text-sm"><a href="{{ route('home') }}"
                    class="hover:text-gold">Home</a><span>›</span><span class="text-gold">Gallery</span></div>
        </div>
    </div>
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            @forelse($galleries as $gallery)
                <div class="mb-16">
                    <div class="flex items-end justify-between mb-6">
                        <div>
                            <h2 class="font-display text-3xl font-bold text-navy gold-underline">{{ $gallery->name }}</h2>
                            @if ($gallery->description)
                                <p class="text-gray-500 mt-4 text-sm">{{ $gallery->description }}</p>
                            @endif
                        </div>
                        @if ($gallery->images->count() > 4)
                            <a href="{{ route('gallery.show', $gallery->id) }}"
                                class="text-gold font-semibold text-sm hover:underline">View All
                                ({{ $gallery->images->count() }}) →</a>
                        @endif
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3" x-data="lightbox()">
                        @foreach ($gallery->images->take(8) as $img)
                            <div @click="open('{{ $img->url }}','{{ $img->caption }}')"
                                class="aspect-square rounded-xl overflow-hidden cursor-pointer group relative">
                                <img src="{{ $img->url }}" alt="{{ $img->caption }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div
                                    class="absolute inset-0 bg-navy/0 group-hover:bg-navy/40 transition-colors flex items-center justify-center">
                                    <svg class="w-10 h-10 text-white opacity-0 group-hover:opacity-100 transition-opacity"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                    </svg>
                                </div>
                            </div>
                        @endforeach
                        <div x-show="show" x-cloak @click.self="show=false"
                            class="fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4"
                            @keydown.escape.window="show=false">
                            <button @click="show=false"
                                class="absolute top-4 right-4 text-white hover:text-gold text-3xl">✕</button>
                            <div class="max-w-4xl w-full"><img :src="src" :alt="caption"
                                    class="w-full rounded-xl">
                                <p x-text="caption" class="text-white text-center mt-3 text-sm opacity-70"></p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 text-gray-400"><svg class="w-16 h-16 mx-auto mb-4 opacity-30" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-lg font-medium">No gallery albums yet.</p>
                </div>
            @endforelse
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
