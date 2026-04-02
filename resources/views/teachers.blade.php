@extends('layouts.app')
@section('title', 'Our Faculty')
@section('content')
    <div class="bg-navy py-20">
        <div class="max-w-7xl mx-auto px-4">
            <p class="text-gold text-sm font-semibold tracking-widest uppercase mb-3">Meet the Team</p>
            <h1 class="font-display text-5xl font-bold text-white mb-4">Our Faculty</h1>
            <div class="flex items-center gap-2 text-navy-200 text-sm"><a href="{{ route('home') }}"
                    class="hover:text-gold">Home</a><span>›</span><span class="text-gold">Faculty</span></div>
        </div>
    </div>
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            @forelse($teachers as $dept => $group)
                <div class="mb-16">
                    @if ($dept)
                        <h2 class="font-display text-2xl font-bold text-navy mb-8 pb-3 border-b-2 border-gold inline-block">
                            {{ $dept }}</h2>
                    @endif
                    <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($group as $teacher)
                            <div class="bg-white rounded-2xl overflow-hidden shadow-sm card-hover text-center"
                                x-data="{ bio: false }">
                                <div class="aspect-square overflow-hidden">
                                    <img src="{{ $teacher->photo_url }}" alt="{{ $teacher->name }}"
                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                </div>
                                <div class="p-5">
                                    <h3 class="font-display font-bold text-navy text-lg">{{ $teacher->name }}</h3>
                                    <p class="text-gold text-sm font-medium mt-1">{{ $teacher->designation }}</p>
                                    @if ($teacher->department)
                                        <p class="text-gray-400 text-xs mt-0.5">{{ $teacher->department }}</p>
                                    @endif
                                    @if ($teacher->bio)
                                        <button @click="bio=!bio"
                                            class="mt-3 text-xs text-navy/60 hover:text-gold transition-colors">{{ bio ? 'Hide' : 'View Bio' }}</button>
                                        <div x-show="bio" x-cloak x-transition
                                            class="mt-3 text-xs text-gray-500 text-left leading-relaxed border-t border-gray-100 pt-3">
                                            {{ $teacher->bio }}</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="text-center py-20 text-gray-400">
                    <p class="text-lg font-medium">No faculty listed yet.</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection
