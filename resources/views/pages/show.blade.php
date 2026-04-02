@extends('layouts.app')
@section('title', $page->meta_title ?? $page->title)
@section('meta_description', $page->meta_description ?? '')
@section('content')

    {{-- Page Hero --}}
    <div class="relative bg-navy py-24 overflow-hidden">
        @if ($page->hero_image)
            <div class="absolute inset-0">
                <img src="{{ asset('storage/' . $page->hero_image) }}" alt="{{ $page->title }}"
                    class="w-full h-full object-cover opacity-30">
                <div class="absolute inset-0 bg-gradient-to-r from-navy via-navy/80 to-transparent"></div>
            </div>
        @else
            <div class="absolute inset-0 opacity-5"
                style="background-image:url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E\")">
            </div>
        @endif
        <div class="relative max-w-7xl mx-auto px-4">
            <p class="text-gold text-sm font-semibold tracking-widest uppercase mb-3">
                {{ \App\Models\SiteSetting::get('school_name') }}</p>
            <h1 class="font-display text-5xl lg:text-6xl font-bold text-white mb-4 leading-tight">
                {{ $page->hero_title ?? $page->title }}
            </h1>
            @if ($page->hero_subtitle)
                <p class="text-navy-200 text-xl max-w-2xl leading-relaxed">{{ $page->hero_subtitle }}</p>
            @endif
            <div class="flex items-center gap-2 text-navy-300 text-sm mt-6">
                <a href="{{ route('home') }}" class="hover:text-gold transition-colors">Home</a>
                <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gold">{{ $page->title }}</span>
            </div>
        </div>
    </div>

    {{-- Page Content --}}
    @if ($page->content)
        <section class="py-16 lg:py-24 bg-white">
            <div class="max-w-4xl mx-auto px-4">
                <div
                    class="prose prose-lg max-w-none text-gray-700 leading-relaxed
            prose-headings:font-display prose-headings:text-navy
            prose-h2:text-3xl prose-h2:mt-10 prose-h2:mb-4
            prose-h3:text-xl prose-h3:mt-8 prose-h3:mb-3
            prose-p:leading-relaxed prose-p:text-gray-600
            prose-a:text-gold prose-a:no-underline hover:prose-a:underline
            prose-ul:space-y-2 prose-li:text-gray-600
            prose-img:rounded-2xl prose-img:shadow-md
            prose-strong:text-navy prose-strong:font-semibold">
                    {!! $page->content !!}
                </div>
            </div>
        </section>
    @endif

    {{-- Dynamic blocks if any --}}
    @if ($page->blocks->count())
        @foreach ($page->blocks->where('is_visible', true)->sortBy('order') as $block)
            <section class="py-12 {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                <div class="max-w-7xl mx-auto px-4">
                    @if ($block->title)
                        <h2 class="font-display text-3xl font-bold text-navy mb-6">{{ $block->title }}</h2>
                    @endif
                    @if ($block->content)
                        <div class="prose prose-lg max-w-none text-gray-600">{!! $block->content !!}</div>
                    @endif
                </div>
            </section>
        @endforeach
    @endif

    {{-- CTA strip --}}
    <section class="py-16 bg-navy">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="font-display text-3xl font-bold text-white mb-3">Ready to Learn More?</h2>
            <p class="text-navy-300 mb-8">Get in touch with our team or apply for admission today.</p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('admissions.index') }}"
                    class="bg-gold hover:bg-gold-600 text-white font-semibold px-8 py-3.5 rounded-xl transition-colors shadow-lg">Apply
                    Now</a>
                <a href="{{ route('contact.index') }}"
                    class="border-2 border-white/40 hover:border-gold text-white hover:text-gold font-semibold px-8 py-3.5 rounded-xl transition-colors">Contact
                    Us</a>
            </div>
        </div>
    </section>

@endsection
