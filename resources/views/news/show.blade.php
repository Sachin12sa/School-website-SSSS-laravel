@extends('layouts.app')
@section('title', $post->meta_title ?? $post->title)
@section('meta_description', $post->meta_description ?? $post->excerpt)

@section('content')

    @include('components.page-hero', [
        'breadcrumb' => 'News',
        'title' => $post->title,
    ])

    <section class="py-14 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-10">

                {{-- ── Article ──────────────────────────────────────────────────────── --}}
                <article class="lg:col-span-2">

                    {{-- Hero image --}}
                    @if ($post->image)
                        <div class="rounded-2xl overflow-hidden mb-8 shadow-md">
                            <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full">
                        </div>
                    @endif

                    {{-- Article card --}}
                    <div class="bg-white rounded-2xl p-7 lg:p-10 shadow-sm">

                        {{-- Meta row --}}
                        <div class="flex flex-wrap items-center gap-3 mb-6 pb-6 border-b border-gray-100">
                            @if ($post->category)
                                <span
                                    class="bg-gold/10 text-gold text-xs font-bold px-3 py-1 rounded-full">{{ $post->category }}</span>
                            @endif
                            <span class="flex items-center gap-1.5 text-xs text-gray-400">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $post->published_at->format('d F Y') }}
                            </span>
                        </div>

                        {{-- Body content --}}
                        <div
                            class="prose prose-lg max-w-none text-gray-700 leading-relaxed
                    prose-headings:font-display prose-headings:text-navy
                    prose-h2:text-2xl prose-h2:mt-8 prose-h2:mb-3
                    prose-h3:text-xl prose-h3:mt-6 prose-h3:mb-2
                    prose-p:text-gray-600 prose-p:leading-relaxed
                    prose-a:text-gold prose-a:no-underline hover:prose-a:underline
                    prose-img:rounded-xl prose-img:shadow-md
                    prose-strong:text-navy prose-blockquote:border-gold prose-blockquote:text-gray-600">
                            {!! $post->body !!}
                        </div>

                        {{-- Share --}}
                        <div class="mt-10 pt-6 border-t border-gray-100 flex items-center gap-3">
                            <span class="text-sm text-gray-400 font-medium">Share:</span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                target="_blank"
                                class="w-8 h-8 bg-navy hover:bg-gold rounded-lg flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z" />
                                </svg>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}"
                                target="_blank"
                                class="w-8 h-8 bg-navy hover:bg-gold rounded-lg flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    {{-- Back link --}}
                    <a href="{{ route('news.index') }}"
                        class="inline-flex items-center gap-2 mt-6 text-navy hover:text-gold transition-colors text-sm font-semibold group">
                        <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                        </svg>
                        Back to News
                    </a>
                </article>

                {{-- ── Sidebar ───────────────────────────────────────────────────────── --}}
                <aside class="space-y-6">

                    {{-- Related articles --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm">
                        <h3 class="font-display font-bold text-navy text-lg mb-1">More News</h3>
                        <div class="w-8 h-0.5 bg-gold mb-5 rounded-full"></div>

                        @forelse($related as $r)
                            <a href="{{ route('news.show', $r->slug) }}" class="flex gap-3 mb-4 group last:mb-0">
                                <div class="w-16 h-16 rounded-xl overflow-hidden shrink-0">
                                    <img src="{{ $r->image_url }}" alt="{{ $r->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4
                                        class="text-navy text-sm font-semibold group-hover:text-gold transition-colors leading-snug line-clamp-2">
                                        {{ $r->title }}
                                    </h4>
                                    <span
                                        class="text-xs text-gray-400 mt-1 block">{{ $r->published_at->format('d M Y') }}</span>
                                </div>
                            </a>
                        @empty
                            <p class="text-gray-400 text-sm">No other articles yet.</p>
                        @endforelse

                        <a href="{{ route('news.index') }}"
                            class="mt-5 block text-center border border-gray-200 text-navy hover:border-gold hover:text-gold py-2.5 rounded-xl text-sm font-semibold transition-colors">
                            View All News →
                        </a>
                    </div>

                    {{-- CTA widget --}}
                    <div class="bg-navy rounded-2xl p-6 text-center">
                        <div class="w-12 h-12 bg-gold rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="font-display font-bold text-white text-lg mb-2">Admissions Open</h3>
                        <p class="text-white/60 text-sm mb-4 leading-relaxed">Join our school community for the 2026–27
                            academic year.</p>
                        <a href="{{ route('admissions.index') }}"
                            class="block bg-gold hover:bg-gold-dark text-white font-bold py-3 rounded-xl transition-colors text-sm">
                            Apply Now
                        </a>
                    </div>

                </aside>
            </div>
        </div>
    </section>

@endsection
