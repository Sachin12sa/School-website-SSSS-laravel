@extends('layouts.app')
@section('title', 'Admissions')
@section('content')
    <div class="bg-navy py-20">
        <div class="max-w-7xl mx-auto px-4">
            <p class="text-gold text-sm font-semibold tracking-widest uppercase mb-3">Join Our Community</p>
            <h1 class="font-display text-5xl font-bold text-white mb-4">Admissions</h1>
            <div class="flex items-center gap-2 text-navy-200 text-sm"><a href="{{ route('home') }}"
                    class="hover:text-gold">Home</a><span>›</span><span class="text-gold">Admissions</span></div>
        </div>
    </div>

    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 grid lg:grid-cols-3 gap-12">
            {{-- Form --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm p-8 lg:p-12">
                    <h2 class="font-display text-3xl font-bold text-navy mb-2">Online Application Form</h2>
                    <p class="text-gray-500 mb-8">Fill in the form below and we will get back to you within 2–3 working
                        days.</p>

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

                    <form action="{{ route('admissions.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-navy mb-2">Applicant's Full Name <span
                                        class="text-red-400">*</span></label>
                                <input type="text" name="applicant_name" value="{{ old('applicant_name') }}"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold transition-colors @error('applicant_name') border-red-300 @enderror">
                                @error('applicant_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-navy mb-2">Date of Birth</label>
                                <input type="date" name="dob" value="{{ old('dob') }}"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold transition-colors">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-navy mb-2">Parent / Guardian Name <span
                                    class="text-red-400">*</span></label>
                            <input type="text" name="parent_name" value="{{ old('parent_name') }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold transition-colors @error('parent_name') border-red-300 @enderror">
                            @error('parent_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-navy mb-2">Email Address <span
                                        class="text-red-400">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold transition-colors @error('email') border-red-300 @enderror">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-navy mb-2">Phone Number <span
                                        class="text-red-400">*</span></label>
                                <input type="text" name="phone" value="{{ old('phone') }}"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold transition-colors @error('phone') border-red-300 @enderror">
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-navy mb-2">Class Applying For <span
                                    class="text-red-400">*</span></label>
                            <select name="class_applying"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold transition-colors bg-white @error('class_applying') border-red-300 @enderror">
                                <option value="">Select a class…</option>
                                @foreach (['Nursery', 'LKG', 'UKG', 'Class 1', 'Class 2', 'Class 3', 'Class 4', 'Class 5', 'Class 6', 'Class 7', 'Class 8', 'Class 9', 'Class 10', 'Class 11', 'Class 12'] as $cls)
                                    <option value="{{ $cls }}"
                                        {{ old('class_applying') === $cls ? 'selected' : '' }}>{{ $cls }}
                                    </option>
                                @endforeach
                            </select>
                            @error('class_applying')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-navy mb-2">Additional Message</label>
                            <textarea name="message" rows="4"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold transition-colors resize-none">{{ old('message') }}</textarea>
                        </div>
                        <button type="submit"
                            class="w-full bg-navy hover:bg-gold text-white font-bold py-4 rounded-xl transition-colors text-lg shadow-lg">
                            Submit Application
                        </button>
                    </form>
                </div>
            </div>

            {{-- Sidebar --}}
            <aside class="space-y-6">
                <div class="bg-navy rounded-2xl p-6 text-white">
                    <h3 class="font-display font-bold text-xl mb-4">Admission Process</h3>
                    <div class="space-y-4">
                        @foreach (['Submit online application', 'Document verification', 'Entrance assessment', 'Interview (if required)', 'Offer of admission'] as $i => $step)
                            <div class="flex gap-3">
                                <div
                                    class="w-7 h-7 bg-gold rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0">
                                    {{ $i + 1 }}</div>
                                <p class="text-navy-200 text-sm pt-1">{{ $step }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="bg-gold/10 border border-gold/30 rounded-2xl p-6">
                    <h3 class="font-display font-bold text-navy text-lg mb-3">Need Help?</h3>
                    <p class="text-gray-600 text-sm mb-4">Our admissions team is here to assist you.</p>
                    @if (\App\Models\SiteSetting::get('phone'))
                        <p class="flex items-center gap-2 text-navy font-semibold text-sm mb-2"><svg
                                class="w-4 h-4 text-gold" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                            </svg>{{ \App\Models\SiteSetting::get('phone') }}</p>
                    @endif
                    @if (\App\Models\SiteSetting::get('email'))
                        <p class="flex items-center gap-2 text-navy font-semibold text-sm"><svg class="w-4 h-4 text-gold"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>{{ \App\Models\SiteSetting::get('email') }}</p>
                    @endif
                </div>
            </aside>
        </div>
    </section>
@endsection
