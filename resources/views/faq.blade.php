@extends('layouts.app')
@section('title', 'FAQ')
@section('meta_description', 'Answers to frequently asked questions about admissions, academic programmes, and school
    life at ' . \App\Models\SiteSetting::get('school_name', 'Our School') . '.')

@section('content')

    @include('components.page-hero', [
        'breadcrumb' => 'FAQ',
        'title' => 'Frequently Asked Questions',
        'subtitle' =>
            'Find answers to the most common questions about our school, programmes, and admissions process.',
    ])

    <section class="py-14 bg-gray-50">
        <div class="max-w-3xl mx-auto px-4 lg:px-8">

            @if ($faqs->isEmpty())
                <div class="text-center py-24 text-gray-400">
                    <svg class="w-16 h-16 mx-auto mb-4 opacity-25" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-lg font-medium text-gray-500">No FAQs yet.</p>
                    <p class="text-sm mt-1">Add them in Admin → FAQs.</p>
                </div>
            @else
                {{-- ── Category sections ─────────────────────────────────────────────── --}}
                @php $globalIndex = 0; @endphp

                <div x-data="{ open: null }">
                    @foreach ($faqs as $category => $items)
                        {{-- Category heading --}}
                        @if ($category)
                            <h2
                                class="font-display font-bold text-xl text-navy mt-10 mb-5 pb-3 border-b-2 border-gold/30 first:mt-0">
                                {{ $category }}
                            </h2>
                        @endif

                        {{-- Accordion items --}}
                        <div class="space-y-3 {{ $loop->first ? '' : 'mt-3' }}">
                            @foreach ($items as $faq)
                                @php $idx = $globalIndex++; @endphp
                                <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                                    <button @click="open === {{ $idx }} ? open = null : open = {{ $idx }}"
                                        class="w-full flex items-start justify-between px-6 py-5 text-left hover:bg-gray-50 transition-colors gap-4">
                                        <span
                                            class="font-semibold text-navy text-sm leading-snug">{{ $faq->question }}</span>
                                        <span
                                            class="shrink-0 w-6 h-6 rounded-full border-2 flex items-center justify-center transition-colors mt-0.5"
                                            :class="open === {{ $idx }} ? 'border-gold bg-gold' : 'border-gray-200'">
                                            <svg :class="open === {{ $idx }} ? 'rotate-45 text-white' : 'text-gray-400'"
                                                class="w-3.5 h-3.5 transition-all duration-200" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                        </span>
                                    </button>
                                    <div x-show="open === {{ $idx }}" x-cloak
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 -translate-y-1"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        class="px-6 pb-5 text-gray-600 text-sm leading-relaxed border-t border-gray-100 pt-4">
                                        {!! $faq->answer !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>

            @endif

            {{-- Contact prompt --}}
            <div class="mt-12 bg-navy rounded-2xl p-8 text-center">
                <div class="w-12 h-12 bg-gold rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <h3 class="font-display font-bold text-white text-xl mb-2">Still have questions?</h3>
                <p class="text-white/60 text-sm mb-6 leading-relaxed">
                    Our team is happy to help. Reach out and we'll get back to you within 24 hours.
                </p>
                <div class="flex flex-wrap gap-3 justify-center">
                    <a href="{{ route('contact.index') }}"
                        class="bg-gold hover:bg-gold-dark text-white font-bold px-7 py-3 rounded-xl text-sm transition-colors">
                        Send a Message
                    </a>
                    @if (\App\Models\SiteSetting::get('phone'))
                        <a href="tel:{{ \App\Models\SiteSetting::get('phone') }}"
                            class="border-2 border-white/25 hover:border-gold text-white hover:text-gold font-semibold px-7 py-3 rounded-xl text-sm transition-colors">
                            Call Us
                        </a>
                    @endif
                </div>
            </div>

        </div>
    </section>

@endsection
