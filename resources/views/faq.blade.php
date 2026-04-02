@extends('layouts.app')
@section('title', 'FAQ')
@section('content')
    <div class="bg-navy py-20">
        <div class="max-w-7xl mx-auto px-4">
            <p class="text-gold text-sm font-semibold tracking-widest uppercase mb-3">Help Centre</p>
            <h1 class="font-display text-5xl font-bold text-white mb-4">Frequently Asked Questions</h1>
            <div class="flex items-center gap-2 text-navy-200 text-sm"><a href="{{ route('home') }}"
                    class="hover:text-gold">Home</a><span>›</span><span class="text-gold">FAQ</span></div>
        </div>
    </div>
    <section class="py-16 bg-gray-50">
        <div class="max-w-3xl mx-auto px-4">
            @forelse($faqs as $category => $items)
                <div class="mb-12">
                    @if ($category)
                        <h2 class="font-display text-2xl font-bold text-navy mb-6">{{ $category }}</h2>
                    @endif
                    <div class="space-y-3">
                        @foreach ($items as $faq)
                            <div class="bg-white rounded-2xl shadow-sm overflow-hidden" x-data="{ open: false }">
                                <button @click="open=!open"
                                    class="w-full flex items-center justify-between p-6 text-left hover:bg-gray-50 transition-colors">
                                    <span class="font-semibold text-navy pr-4">{{ $faq->question }}</span>
                                    <svg :class="open ? 'rotate-180' : ''"
                                        class="w-5 h-5 text-gold shrink-0 transition-transform duration-200" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 -translate-y-2"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    class="px-6 pb-6 text-gray-600 leading-relaxed border-t border-gray-100 pt-4">
                                    {!! $faq->answer !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="text-center py-20 text-gray-400">
                    <p class="text-lg font-medium">No FAQs available yet.</p>
                </div>
            @endforelse
            <div class="bg-navy rounded-2xl p-8 text-center mt-12">
                <h3 class="font-display font-bold text-white text-2xl mb-2">Still have questions?</h3>
                <p class="text-navy-200 mb-6">Our team is happy to help you with any queries.</p>
                <a href="{{ route('contact.index') }}"
                    class="inline-block bg-gold hover:bg-gold-500 text-white font-semibold px-8 py-3 rounded-xl transition-colors">Contact
                    Us</a>
            </div>
        </div>
    </section>
@endsection
