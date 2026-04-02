@extends('layouts.app')
@section('title', 'Contact Us')
@section('content')
    <div class="bg-navy py-20">
        <div class="max-w-7xl mx-auto px-4">
            <p class="text-gold text-sm font-semibold tracking-widest uppercase mb-3">Get in Touch</p>
            <h1 class="font-display text-5xl font-bold text-white mb-4">Contact Us</h1>
            <div class="flex items-center gap-2 text-navy-200 text-sm"><a href="{{ route('home') }}"
                    class="hover:text-gold">Home</a><span>›</span><span class="text-gold">Contact</span></div>
        </div>
    </div>
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 grid lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-8 lg:p-12">
                <h2 class="font-display text-3xl font-bold text-navy mb-2">Send Us a Message</h2>
                <p class="text-gray-500 mb-8">We'll get back to you within 24 hours.</p>
                @if (session('success'))
                    <div
                        class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 mb-6 flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-6">
                        <div><label class="block text-sm font-semibold text-navy mb-2">Your Name <span
                                    class="text-red-400">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold transition-colors @error('name') border-red-300 @enderror">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div><label class="block text-sm font-semibold text-navy mb-2">Email Address <span
                                    class="text-red-400">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold transition-colors @error('email') border-red-300 @enderror">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div><label class="block text-sm font-semibold text-navy mb-2">Phone Number</label><input
                                type="text" name="phone" value="{{ old('phone') }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold transition-colors">
                        </div>
                        <div><label class="block text-sm font-semibold text-navy mb-2">Subject</label><input type="text"
                                name="subject" value="{{ old('subject') }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold transition-colors">
                        </div>
                    </div>
                    <div><label class="block text-sm font-semibold text-navy mb-2">Message <span
                                class="text-red-400">*</span></label>
                        <textarea name="message" rows="6"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold transition-colors resize-none @error('message') border-red-300 @enderror">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit"
                        class="w-full bg-navy hover:bg-gold text-white font-bold py-4 rounded-xl transition-colors text-lg shadow-lg">Send
                        Message</button>
                </form>
            </div>
            <aside class="space-y-6">
                @foreach ([['icon' => 'M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z', 'label' => 'Address', 'value' => \App\Models\SiteSetting::get('address', 'School Address, City, Country')], ['icon' => 'M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z', 'label' => 'Phone', 'value' => \App\Models\SiteSetting::get('phone', '+1 234 567 890')], ['icon' => 'M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z', 'label' => 'Email', 'value' => \App\Models\SiteSetting::get('email', 'info@school.edu')]] as $info)
                    <div class="bg-white rounded-2xl shadow-sm p-6 flex gap-4 items-start">
                        <div class="w-10 h-10 bg-gold/10 rounded-xl flex items-center justify-center shrink-0"><svg
                                class="w-5 h-5 text-gold" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="{{ $info['icon'] }}" clip-rule="evenodd" />
                            </svg></div>
                        <div>
                            <div class="font-semibold text-navy text-sm mb-1">{{ $info['label'] }}</div>
                            <div class="text-gray-500 text-sm">{{ $info['value'] }}</div>
                        </div>
                    </div>
                @endforeach
                @if (\App\Models\SiteSetting::get('map_embed'))
                    <div class="rounded-2xl overflow-hidden shadow-sm h-48">{!! \App\Models\SiteSetting::get('map_embed') !!}</div>
                @endif
            </aside>
        </div>
    </section>
@endsection
