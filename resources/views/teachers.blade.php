@extends('layouts.app')
@section('title', 'Our Faculty')
@section('meta_description', 'Meet the dedicated team of educators at ' . \App\Models\SiteSetting::get('school_name',
    'Our School') . '.')

@section('content')

    @include('components.page-hero', [
        'breadcrumb' => 'Faculty',
        'title' => 'Our Faculty',
        'subtitle' =>
            'Dedicated educators committed to shaping every student into a person of knowledge and character.',
    ])

    <section class="py-14 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">

            @if ($teachers->isEmpty())
                <div class="text-center py-24 text-gray-400">
                    <svg class="w-16 h-16 mx-auto mb-4 opacity-25" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <p class="text-lg font-medium text-gray-500">Faculty listing coming soon.</p>
                </div>
            @else
                {{-- ── Department sections ────────────────────────────────────────────── --}}
                @foreach ($teachers as $dept => $group)
                    <div class="mb-14 last:mb-0">

                        {{-- Department heading --}}
                        @if ($dept)
                            <div class="flex items-center gap-4 mb-8">
                                <h2 class="font-display font-bold text-2xl text-navy whitespace-nowrap">{{ $dept }}
                                </h2>
                                <div class="flex-1 h-px bg-gradient-to-r from-gold to-transparent"></div>
                            </div>
                        @endif

                        {{-- Teacher cards --}}
                        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach ($group as $teacher)
                                {{-- Each card uses Alpine for the bio toggle --}}
                                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow"
                                    x-data="{ bioOpen: false }">

                                    {{-- Photo --}}
                                    <div class="aspect-square overflow-hidden bg-gray-100 relative">
                                        <img src="{{ $teacher->photo_url }}" alt="{{ $teacher->name }}"
                                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                                            loading="lazy">

                                        {{-- LinkedIn badge --}}
                                        @if ($teacher->linkedin)
                                            <a href="{{ $teacher->linkedin }}" target="_blank"
                                                class="absolute top-3 right-3 w-8 h-8 bg-[#0077B5] rounded-lg flex items-center justify-center hover:bg-[#005fa3] transition-colors shadow-md">
                                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                                </svg>
                                            </a>
                                        @endif
                                    </div>

                                    {{-- Info --}}
                                    <div class="p-5">
                                        <h3 class="font-display font-bold text-navy text-lg leading-tight">
                                            {{ $teacher->name }}</h3>
                                        <p class="text-gold text-sm font-medium mt-1">{{ $teacher->designation }}</p>
                                        @if ($teacher->department && !$dept)
                                            <p class="text-gray-400 text-xs mt-0.5">{{ $teacher->department }}</p>
                                        @endif

                                        @if ($teacher->email)
                                            <a href="mailto:{{ $teacher->email }}"
                                                class="flex items-center gap-1.5 text-xs text-gray-400 hover:text-gold transition-colors mt-2">
                                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                {{ $teacher->email }}
                                            </a>
                                        @endif

                                        @if ($teacher->bio)
                                            <button @click="bioOpen = !bioOpen"
                                                class="mt-3 text-xs font-semibold text-navy/50 hover:text-gold transition-colors flex items-center gap-1">
                                                <span x-text="bioOpen ? 'Hide Bio' : 'View Bio'"></span>
                                                <svg :class="bioOpen ? 'rotate-180' : ''"
                                                    class="w-3.5 h-3.5 transition-transform" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </button>

                                            {{-- Bio expand --}}
                                            <div x-show="bioOpen" x-cloak
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0 -translate-y-1"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                class="mt-3 pt-3 border-t border-gray-100 text-xs text-gray-500 leading-relaxed">
                                                {{ $teacher->bio }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            @endif

        </div>
    </section>

    {{-- Join CTA --}}
    <section class="py-14 bg-navy text-white text-center">
        <div class="max-w-2xl mx-auto px-4">
            <h2 class="font-display font-bold text-3xl mb-3">Join Our Team</h2>
            <p class="text-white/60 mb-8 leading-relaxed">We are always looking for passionate educators who share our
                commitment to academic excellence and human values.</p>
            <a href="{{ route('contact.index') }}"
                class="inline-block bg-gold hover:bg-gold-dark text-white font-bold px-10 py-4 rounded-xl transition-colors shadow-lg">
                Contact Us About Opportunities
            </a>
        </div>
    </section>

@endsection
