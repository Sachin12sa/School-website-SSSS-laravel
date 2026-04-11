@extends('layouts.app')
@section('title', 'News & Updates')
@section('page_title', 'Stay Informed')

@section('content')

    @include('components.page-hero', [
        'breadcrumb' => 'News',
        'title' => 'News & Updates',
        'subtitle' => 'Stay informed about achievements, events, and announcements from our school community.',
    ])

    <section class="py-14 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">

            {{-- ── Featured post (most recent featured article, if any) ─────────────── --}}
            @if ($featured)
                <a href="{{ route('news.show', $featured->slug) }}"
                    class="group grid lg:grid-cols-2 gap-0 bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-shadow mb-12 block">
                    <div class="aspect-video lg:aspect-auto overflow-hidden">
                        <img src="{{ $featured->image_url }}" alt="{{ $featured->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-8 lg:p-10 flex flex-col justify-center">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="bg-gold text-white text-xs font-bold px-3 py-1 rounded-full">Featured</span>
                            @if ($featured->category)
                                <span
                                    class="bg-gold/10 text-gold text-xs font-semibold px-3 py-1 rounded-full">{{ $featured->category }}</span>
                            @endif
                        </div>
                        <h2
                            class="font-display font-bold text-navy text-2xl lg:text-3xl mb-3 leading-snug group-hover:text-gold transition-colors">
                            {{ $featured->title }}
                        </h2>
                        @if ($featured->excerpt)
                            <p class="text-gray-500 leading-relaxed mb-5">{{ $featured->excerpt }}</p>
                        @endif
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-400 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $featured->published_at->format('d M Y') }}
                            </span>
                            <span class="text-gold text-sm font-semibold group-hover:underline">Read Article →</span>
                        </div>
                    </div>
                </a>
            @endif

            {{-- ── Category filter tabs ──────────────────────────────────────────────── --}}
            @if ($categories->count() > 1)
                <div class="flex gap-2 flex-wrap mb-8">
                    <a href="{{ route('news.index') }}"
                        class="px-4 py-2 rounded-full text-sm font-semibold transition-colors {{ !request('category') ? 'bg-navy text-white' : 'bg-white text-navy border border-gray-200 hover:border-navy hover:text-navy' }}">
                        All
                    </a>
                    @foreach ($categories as $cat)
                        <a href="{{ route('news.index', ['category' => $cat]) }}"
                            class="px-4 py-2 rounded-full text-sm font-semibold transition-colors {{ request('category') === $cat ? 'bg-navy text-white' : 'bg-white text-navy border border-gray-200 hover:border-navy' }}">
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>
            @endif

            {{-- ── News grid ─────────────────────────────────────────────────────────── --}}
            @if ($news->count())
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-7">
                    @foreach ($news as $post)
                        <article
                            class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow flex flex-col card-lift">
                            {{-- Image --}}
                            <a href="{{ route('news.show', $post->slug) }}" class="block aspect-video overflow-hidden">
                                <img src="{{ $post->image_url }}" alt="{{ $post->title }}"
                                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                            </a>

                            <div class="p-6 flex flex-col flex-1">
                                {{-- Category --}}
                                @if ($post->category)
                                    <span
                                        class="inline-block bg-gold/10 text-gold text-xs font-bold px-2.5 py-1 rounded-full mb-3 w-fit">
                                        {{ $post->category }}
                                    </span>
                                @endif

                                {{-- Title --}}
                                <h3 class="font-display font-bold text-navy text-xl mb-3 leading-snug flex-1">
                                    <a href="{{ route('news.show', $post->slug) }}"
                                        class="hover:text-gold transition-colors">
                                        {{ $post->title }}
                                    </a>
                                </h3>

                                {{-- Excerpt --}}
                                @if ($post->excerpt)
                                    <p class="text-gray-500 text-sm leading-relaxed mb-4 line-clamp-2">{{ $post->excerpt }}
                                    </p>
                                @endif

                                {{-- Footer --}}
                                <div class="flex items-center justify-between pt-4 mt-auto border-t border-gray-100">
                                    <span class="text-xs text-gray-400">{{ $post->published_at->format('d M Y') }}</span>
                                    <a href="{{ route('news.show', $post->slug) }}"
                                        class="text-gold text-sm font-semibold hover:underline">Read →</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if ($news->hasPages())
                    <div class="mt-12 flex justify-center">
                        {{ $news->links() }}
                    </div>
                @endif
            @else
                {{-- Empty state --}}
                <div class="text-center py-24 text-gray-400">
                    <svg class="w-16 h-16 mx-auto mb-4 opacity-25" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    <p class="text-lg font-medium text-gray-500">No news articles yet.</p>
                    <p class="text-sm mt-1">Check back soon for updates.</p>
                </div>
            @endif

        </div>
    </section>

@endsection
