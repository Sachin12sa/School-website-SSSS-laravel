@extends('layouts.app')
@section('title', $gallery->name . ' — Gallery')

@section('content')

    @include('components.page-hero', [
        'breadcrumb' => 'Gallery',
        'title' => $gallery->name,
        'subtitle' => $gallery->description,
    ])

    <section class="py-14 bg-gray-50" x-data="lightbox()">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">

            {{-- Back link + photo count --}}
            <div class="flex items-center justify-between mb-8">
                <a href="{{ route('gallery.index') }}"
                    class="inline-flex items-center gap-2 text-navy hover:text-gold transition-colors text-sm font-semibold group">
                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                    </svg>
                    All Albums
                </a>
                <span class="text-gray-400 text-sm">{{ $gallery->images->count() }}
                    {{ Str::plural('photo', $gallery->images->count()) }}</span>
            </div>

            @if ($gallery->images->count())

                {{-- Photo grid — clicking any photo opens lightbox --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                    @foreach ($gallery->images as $img)
                        <button @click="open('{{ $img->url }}', '{{ addslashes($img->caption ?? '') }}')"
                            class="group relative aspect-square rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow cursor-zoom-in">

                            <img src="{{ $img->url }}" alt="{{ $img->caption }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                loading="lazy">

                            {{-- Hover overlay --}}
                            <div
                                class="absolute inset-0 bg-navy/0 group-hover:bg-navy/35 transition-colors flex items-center justify-center">
                                <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                </svg>
                            </div>

                            {{-- Caption on hover --}}
                            @if ($img->caption)
                                <div
                                    class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent px-3 py-3
                        translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                    <p class="text-white text-xs leading-snug">{{ $img->caption }}</p>
                                </div>
                            @endif
                        </button>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 text-gray-400">
                    <p class="text-lg font-medium">No photos in this album yet.</p>
                </div>
            @endif

        </div>

        {{-- ── LIGHTBOX OVERLAY ─────────────────────────────────────────────────────── --}}
        <div x-show="visible" x-cloak @click.self="close()" @keydown.escape.window="close()"
            class="fixed inset-0 bg-black/92 z-[999] flex items-center justify-center p-4"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            {{-- Close button --}}
            <button @click="close()"
                class="absolute top-5 right-5 w-11 h-11 bg-white/10 hover:bg-white/25 rounded-full flex items-center justify-center text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Prev --}}
            <button @click="prev()"
                class="absolute left-4 top-1/2 -translate-y-1/2 w-11 h-11 bg-white/10 hover:bg-white/25 rounded-full flex items-center justify-center text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            {{-- Next --}}
            <button @click="next()"
                class="absolute right-4 top-1/2 -translate-y-1/2 w-11 h-11 bg-white/10 hover:bg-white/25 rounded-full flex items-center justify-center text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            {{-- Image --}}
            <div class="max-w-5xl w-full mx-16">
                <img :src="src" :alt="caption"
                    class="w-full max-h-[80vh] object-contain rounded-xl shadow-2xl">
                <p x-show="caption" x-text="caption" class="text-white/65 text-center mt-3 text-sm"></p>
                {{-- Counter --}}
                <p class="text-white/35 text-center text-xs mt-1" x-text="(index+1) + ' / ' + images.length"></p>
            </div>
        </div>

    </section>

    @push('scripts')
        <script>
            function lightbox() {
                // Build images array from the DOM so prev/next works without extra DB calls
                const imgs = @json($gallery->images->map(fn($i) => ['src' => $i->url, 'caption' => $i->caption ?? '']));

                return {
                    visible: false,
                    src: '',
                    caption: '',
                    index: 0,
                    images: imgs,

                    open(src, caption) {
                        this.src = src;
                        this.caption = caption;
                        this.index = this.images.findIndex(i => i.src === src);
                        this.visible = true;
                        document.body.style.overflow = 'hidden';
                    },
                    close() {
                        this.visible = false;
                        document.body.style.overflow = '';
                    },
                    prev() {
                        this.index = (this.index - 1 + this.images.length) % this.images.length;
                        this.src = this.images[this.index].src;
                        this.caption = this.images[this.index].caption;
                    },
                    next() {
                        this.index = (this.index + 1) % this.images.length;
                        this.src = this.images[this.index].src;
                        this.caption = this.images[this.index].caption;
                    },
                };
            }
        </script>
    @endpush
@endsection
