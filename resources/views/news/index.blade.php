@extends('layouts.app')
@section('title', 'News')
@section('content')

    {{-- Page Hero --}}
    <div class="bg-navy py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5"
            style="background-image: url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E\")">
        </div>
        <div class="max-w-7xl mx-auto px-4 relative">
            <p class="text-gold text-sm font-semibold tracking-widest uppercase mb-3">Stay Informed</p>
            <h1 class="font-display text-5xl font-bold text-white mb-4">Latest News</h1>
            <div class="flex items-center gap-2 text-navy-200 text-sm">
                <a href="{{ route('home') }}" class="hover:text-gold transition-colors">Home</a>
                <span>›</span><span class="text-gold">News</span>
            </div>
        </div>
    </div>

    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            {{-- Featured Post --}}
            @if ($featured)
                <div class="mb-14">
                    <a href="{{ route('news.show', $featured->slug) }}"
                        class="group grid lg:grid-cols-2 gap-0 bg-white rounded-2xl overflow-hidden shadow-md card-hover">
                        <div class="aspect-video lg:aspect-auto overflow-hidden">
                            <img src="{{ $featured->image_url }}" alt="{{ $featured->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-10 flex flex-col justify-center">
                            <span
                                class="inline-block bg-gold text-white text-xs font-bold px-3 py-1 rounded-full mb-4 w-fit">Featured</span>
                            @if ($featured->category)
                                <span
                                    class="text-gold text-xs font-semibold tracking-wide uppercase mb-2 block">{{ $featured->category }}</span>
                            @endif
                            <h2
                                class="font-display text-3xl font-bold text-navy mb-4 group-hover:text-gold transition-colors leading-snug">
                                {{ $featured->title }}</h2>
                            @if ($featured->excerpt)
                                <p class="text-gray-500 leading-relaxed mb-6">{{ $featured->excerpt }}</p>
                            @endif
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-400">{{ $featured->published_at->format('d M Y') }}</span>
                                <span class="text-gold font-semibold text-sm">Read Article →</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endif

            {{-- Grid --}}
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($news as $post)
                    <article class="bg-white rounded-2xl overflow-hidden shadow-sm card-hover flex flex-col">
                        <a href="{{ route('news.show', $post->slug) }}" class="block aspect-video overflow-hidden">
                            <img src="{{ $post->image_url }}" alt="{{ $post->title }}"
                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                        </a>
                        <div class="p-6 flex flex-col flex-1">
                            @if ($post->category)
                                <span
                                    class="inline-block bg-gold/10 text-gold text-xs font-semibold px-3 py-1 rounded-full mb-3">{{ $post->category }}</span>
                            @endif
                            <h3 class="font-display font-bold text-navy text-xl mb-3 leading-snug flex-1">
                                <a href="{{ route('news.show', $post->slug) }}"
                                    class="hover:text-gold transition-colors">{{ $post->title }}</a>
                            </h3>
                            @if ($post->excerpt)
                                <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ $post->excerpt }}</p>
                            @endif
                            <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100">
                                <span class="text-xs text-gray-400">{{ $post->published_at->format('d M Y') }}</span>
                                <a href="{{ route('news.show', $post->slug) }}"
                                    class="text-gold text-sm font-semibold hover:underline">Read More →</a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-3 text-center py-20 text-gray-400">
                        <svg class="w-16 h-16 mx-auto mb-4 opacity-30" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        <p class="text-lg font-medium">No news articles yet.</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($news->hasPages())
                <div class="mt-12 flex justify-center">{{ $news->links() }}</div>
            @endif
        </div>
    </section>
@endsection
