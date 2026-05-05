@extends('layouts.app')
@section('title', 'Contact Us')
@section('meta_description', 'Get in touch with ' . \App\Models\SiteSetting::get('school_name', 'Our School') . '. We
    are here to answer your questions.')

@section('content')

    @if ($hero)
        <x-page-hero :hero="$hero" />
    @else
        @include('components.page-hero', [
            'breadcrumb' => 'Contact',
            'title' => 'Contact Us',
            'subtitle' => "We're here to answer your questions and help guide your child's educational journey.",
        ])
    @endif

    @php
        $contactSections = $sections ?? collect();
        $ctaSections = $contactSections->where('layout', 'cta');
        $contentSections = $contactSections->where('layout', '!=', 'cta');
    @endphp

    @if ($contactSections->isNotEmpty())
        @foreach ($contentSections as $i => $section)
            @include('components.section-renderer', ['section' => $section, 'index' => $i])
        @endforeach
    @else

    {{-- ── 4 INFO CARDS ─────────────────────────────────────────────────────────── --}}
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach ([['📍', 'Visit Us', \App\Models\SiteSetting::get('address', 'Sathya Sai Shiksha Sadan, Nepal'), '#e53e3e', null], ['📞', 'Call Us', \App\Models\SiteSetting::get('phone', '+977-1-XXXXXXX'), '#1a237e', 'tel:' . \App\Models\SiteSetting::get('phone', '')], ['📧', 'Email Us', \App\Models\SiteSetting::get('email', 'info@sathyasaishiksha.edu.np'), '#d97706', 'mailto:' . \App\Models\SiteSetting::get('email', '')], ['⏰', 'Office Hours', "Mon–Fri: 8:00 AM – 4:00 PM\nSaturday: 8:00 AM – 1:00 PM", '#059669', null]] as [$icon, $title, $val, $color, $href])
                    <div class="bg-white border-t-4 rounded-2xl p-6 shadow-sm text-center hover:shadow-md transition-shadow"
                        style="border-color:{{ $color }}">
                        <div class="text-3xl mb-3">{{ $icon }}</div>
                        <h4 class="font-display font-bold text-navy text-lg mb-2" style="color:{{ $color }}">
                            {{ $title }}</h4>
                        @if ($href)
                            <a href="{{ $href }}"
                                class="text-gray-500 text-sm leading-relaxed hover:text-navy transition-colors whitespace-pre-line">{{ $val }}</a>
                        @else
                            <p class="text-gray-500 text-sm leading-relaxed whitespace-pre-line">{{ $val }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @endif

    {{-- ── FORM + MAP ───────────────────────────────────────────────────────────── --}}
    <section class="py-14 bg-gray-50" id="contact-form">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 grid lg:grid-cols-2 gap-12">

            {{-- Contact Form --}}
            <div id="map">
                <h2 class="font-display font-bold text-3xl text-navy mb-2">Send Us a Message</h2>
                <div class="w-10 h-0.5 bg-gold mb-6 rounded-full"></div>

                {{-- Success alert --}}
                @if (session('success'))
                    <div
                        class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 mb-6 flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <div>
                            <p class="font-semibold">Message received!</p>
                            <p class="text-sm mt-0.5">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">First
                                Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy transition-colors"
                                placeholder="John">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Last
                                Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy transition-colors"
                                placeholder="Doe">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Email Address
                            <span class="text-red-400">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy transition-colors @error('email') border-red-300 @enderror"
                            placeholder="john@example.com">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Phone
                            Number</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy transition-colors"
                            placeholder="+977-1-XXXXXXX">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Subject</label>
                        <select name="subject"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy transition-colors">
                            <option value="">Select a topic…</option>
                            @foreach (['General Enquiry', 'Admission Enquiry', 'Fee Information', 'Transport Query', 'Academic Query', 'Campus Visit', 'Scholarship Information', 'Other'] as $opt)
                                <option value="{{ $opt }}" {{ old('subject') === $opt ? 'selected' : '' }}>
                                    {{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Message <span
                                class="text-red-400">*</span></label>
                        <textarea name="message" rows="5" required
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy transition-colors resize-none @error('message') border-red-300 @enderror"
                            placeholder="How can we help you?">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-navy hover:bg-gold text-white font-bold py-4 rounded-xl transition-colors shadow-md text-sm">
                        Send Message →
                    </button>
                </form>
            </div>

            {{-- Map --}}
            <div>
                <h2 class="font-display font-bold text-3xl text-navy mb-2">Find Us</h2>
                <div class="w-10 h-0.5 bg-gold mb-6 rounded-full"></div>

                @if (\App\Models\SiteSetting::get('map_embed'))
                    <div class="rounded-2xl overflow-hidden shadow-md h-80 mb-6">
                        {!! \App\Models\SiteSetting::get('map_embed') !!}
                    </div>
                @else
                    {{-- Fallback placeholder --}}
                    <div
                        class="bg-gray-100 rounded-2xl h-80 flex flex-col items-center justify-center text-gray-400 shadow-sm mb-6">
                        <div class="w-14 h-14 bg-navy rounded-full flex items-center justify-center mb-3">
                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="font-semibold text-navy text-sm">
                            {{ \App\Models\SiteSetting::get('school_name', 'Our School') }}</p>
                        <p class="text-xs mt-1 text-center px-8">{{ \App\Models\SiteSetting::get('address', 'Nepal') }}</p>
                        <p class="text-xs text-gray-400 mt-3 italic">Add Google Maps embed in Admin → Settings → map_embed
                        </p>
                    </div>
                @endif

                {{-- Contact details below map --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm space-y-4">
                    @foreach ([['📍', \App\Models\SiteSetting::get('address', '—')], ['📞', \App\Models\SiteSetting::get('phone', '—')], ['📧', \App\Models\SiteSetting::get('email', '—')]] as [$icon, $val])
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <span class="text-lg shrink-0">{{ $icon }}</span>
                            <span>{{ $val }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </section>

    @if (($sections ?? collect())->isEmpty())
    {{-- ── DEPARTMENT DIRECTORY ─────────────────────────────────────────────────── --}}
    <section class="py-14 bg-white">
        <div class="max-w-5xl mx-auto px-4 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="font-display font-bold text-3xl text-navy mb-2">Department Directory</h2>
                <div class="w-10 h-0.5 bg-gold mx-auto rounded-full"></div>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ([['Admissions Office', 'admissions@sathyasaishiksha.edu.np', '+977-1-XXXXXXX'], ["Principal's Office", 'principal@sathyasaishiksha.edu.np', '+977-1-XXXXXXX'], ['Accounts Department', 'accounts@sathyasaishiksha.edu.np', '+977-1-XXXXXXX'], ['Academic Coordinator', 'academics@sathyasaishiksha.edu.np', '+977-1-XXXXXXX'], ['Transport Coordinator', 'transport@sathyasaishiksha.edu.np', '+977-1-XXXXXXX'], ['IT Support', 'it@sathyasaishiksha.edu.np', '+977-1-XXXXXXX']] as [$dept, $email, $phone])
                    <div
                        class="bg-gray-50 rounded-2xl p-5 border border-gray-100 hover:border-gold/30 hover:shadow-sm transition-all">
                        <h4 class="font-semibold text-navy mb-3 text-sm">{{ $dept }}</h4>
                        <a href="mailto:{{ $email }}"
                            class="flex items-center gap-2 text-xs text-navy hover:text-gold transition-colors mb-2">
                            <svg class="w-3.5 h-3.5 text-gold shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ $email }}
                        </a>
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <svg class="w-3.5 h-3.5 text-gold shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            {{ $phone }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── FAQ ACCORDION ────────────────────────────────────────────────────────── --}}
    @if ($faqs->count())
        <section class="py-14 bg-gray-50">
            <div class="max-w-3xl mx-auto px-4 lg:px-8">
                <div class="text-center mb-10">
                    <h2 class="font-display font-bold text-3xl text-navy mb-2">Frequently Asked Questions</h2>
                    <div class="w-10 h-0.5 bg-gold mx-auto rounded-full"></div>
                </div>
                <div class="space-y-3" x-data="{ open: null }">
                    @foreach ($faqs as $i => $faq)
                        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                            <button @click="open === {{ $i }} ? open = null : open = {{ $i }}"
                                class="w-full flex items-center justify-between px-6 py-5 text-left hover:bg-gray-50 transition-colors">
                                <span class="font-semibold text-navy text-sm pr-4">{{ $faq->question }}</span>
                                <svg :class="open === {{ $i }} ? 'rotate-180 text-gold' : 'text-gray-300'"
                                    class="w-5 h-5 shrink-0 transition-all duration-200" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open === {{ $i }}" x-cloak
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 -translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="px-6 pb-5 text-gray-600 text-sm leading-relaxed border-t border-gray-100 pt-4">
                                {!! $faq->answer !!}
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-8">
                    <p class="text-gray-500 text-sm">Still have questions?</p>
                    <a href="#"
                        onclick="document.querySelector('form').scrollIntoView({behavior:'smooth'});return false;"
                        class="text-gold font-semibold text-sm hover:underline">Send us a message ↑</a>
                </div>
            </div>
        </section>
    @endif
    @endif

    @if (($ctaSections ?? collect())->isNotEmpty())
        @foreach ($ctaSections as $i => $section)
            @include('components.section-renderer', ['section' => $section, 'index' => $i])
        @endforeach
    @endif

@endsection
