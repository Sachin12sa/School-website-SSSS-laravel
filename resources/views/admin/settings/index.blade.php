@extends('admin.layouts.admin')
@section('title', 'Site Settings')

@section('content')

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- ── TAB STATE ─────────────────────────────────────────────────────────────── --}}
        <div x-data="{
            allowedTabs: ['identity', 'branding', 'social', 'seo', 'admissions', 'popup'],
            tab: ['identity', 'branding', 'social', 'seo', 'admissions', 'popup'].includes(window.location.hash.replace('#', '')) ? window.location.hash.replace('#', '') : 'identity'
        }">
            <input type="hidden" name="active_tab" x-model="tab">

            {{-- Tab nav --}}
            <div class="flex flex-wrap gap-1 mb-7 bg-white rounded-2xl border border-slate-100 p-1.5 shadow-sm">
                @foreach ([
            ['identity', 'School Identity', 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 5h2a2 2 0 002-2v-1a2 2 0 00-2-2h-2a2 2 0 00-2 2v1a2 2 0 002 2z'],
            ['branding', 'Logo & Branding', 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
            ['social', 'Social Media', 'M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1'],
            ['seo', 'SEO & Meta', 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'],
            ['admissions', 'Admissions Form', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
            ['popup', 'Popup Banner', 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'],
        ] as [$id, $label, $icon])
                    <button type="button" @click="tab='{{ $id }}'; window.location.hash='{{ $id }}'"
                        :class="tab === '{{ $id }}' ?
                            'bg-navy-900 text-white shadow-sm' :
                            'text-slate-500 hover:text-navy-900 hover:bg-slate-50'"
                        class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold transition-all flex-1 min-w-fit justify-center sm:justify-start">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}" />
                        </svg>
                        <span class="hidden sm:inline">{{ $label }}</span>
                    </button>
                @endforeach
            </div>

            {{-- ════════════════════════════════════════════════════════
         TAB 1 — SCHOOL IDENTITY
    ════════════════════════════════════════════════════════ --}}
            <div x-show="tab === 'identity'" x-cloak>
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-7 space-y-6">
                    <h2 class="font-display font-bold text-navy-900 text-lg flex items-center gap-2">
                        <span
                            class="w-7 h-7 bg-navy-900 rounded-lg flex items-center justify-center text-white text-xs font-bold">1</span>
                        School Identity
                    </h2>

                    <div class="grid sm:grid-cols-2 gap-5">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">School Name
                                <span class="text-red-400">*</span></label>
                            <input type="text" name="school_name" value="{{ $settings['school_name'] ?? '' }}"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 transition-colors"
                                placeholder="Sathya Sai Shiksha Sadan">
                        </div>
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Tagline</label>
                            <input type="text" name="school_tagline" value="{{ $settings['school_tagline'] ?? '' }}"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 transition-colors"
                                placeholder="Education in Human Values">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Established
                                Year</label>
                            <input type="text" name="established_year" value="{{ $settings['established_year'] ?? '' }}"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 transition-colors"
                                placeholder="2000">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Short About
                                (used in footer)</label>
                            <textarea name="about_short" rows="2"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30 resize-none">{{ $settings['about_short'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ════════════════════════════════════════════════════════
         TAB 2 — LOGO & BRANDING
    ════════════════════════════════════════════════════════ --}}
            <div x-show="tab === 'branding'" x-cloak>
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-7 space-y-7">
                    <h2 class="font-display font-bold text-navy-900 text-lg flex items-center gap-2">
                        <span
                            class="w-7 h-7 bg-navy-900 rounded-lg flex items-center justify-center text-white text-xs font-bold">2</span>
                        Logo & Branding
                    </h2>

                    {{-- Logo --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-3">School
                            Logo</label>
                        <div class="flex items-start gap-5">
                            @if (!empty($settings['logo']))
                                <div class="shrink-0">
                                    <div
                                        class="w-24 h-24 bg-slate-50 border border-slate-200 rounded-xl overflow-hidden flex items-center justify-center">
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($settings['logo']) }}"
                                            alt="Current logo" class="max-w-full max-h-full object-contain p-2">
                                    </div>
                                    <p class="text-xs text-slate-400 mt-1.5 text-center">Current</p>
                                </div>
                            @endif
                            <div class="flex-1">
                                <div
                                    class="border-2 border-dashed border-slate-200 rounded-xl p-6 hover:border-gold-500 transition-colors text-center">
                                    <svg class="w-8 h-8 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-slate-400 text-xs mb-3">PNG or SVG recommended. Transparent background.
                                    </p>
                                    <input type="file" name="logo"
                                        accept="image/png,image/svg+xml,image/jpeg,image/webp"
                                        class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-navy-900 file:text-white file:text-xs file:font-semibold hover:file:bg-gold-500 file:transition-colors cursor-pointer">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Favicon --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-3">Favicon</label>
                        <div class="flex items-start gap-5">
                            @if (!empty($settings['favicon']))
                                <div class="shrink-0">
                                    <div
                                        class="w-14 h-14 bg-slate-50 border border-slate-200 rounded-xl overflow-hidden flex items-center justify-center">
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($settings['favicon']) }}"
                                            alt="Favicon" class="w-8 h-8 object-contain">
                                    </div>
                                    <p class="text-xs text-slate-400 mt-1.5 text-center">Current</p>
                                </div>
                            @endif
                            <div class="flex-1">
                                <input type="file" name="favicon" accept="image/png,image/x-icon,image/svg+xml"
                                    class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-navy-900 file:text-white file:text-xs file:font-semibold hover:file:bg-gold-500 file:transition-colors cursor-pointer">
                                <p class="text-slate-400 text-xs mt-2">32×32 or 64×64 PNG recommended. Shows in browser tab.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ════════════════════════════════════════════════════════
         TAB 3 — CONTACT & LOCATION
    ════════════════════════════════════════════════════════ --}}
            <div x-show="tab === 'contact'" x-cloak>
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-7 space-y-5">
                    <h2 class="font-display font-bold text-navy-900 text-lg flex items-center gap-2">
                        <span
                            class="w-7 h-7 bg-navy-900 rounded-lg flex items-center justify-center text-white text-xs font-bold">3</span>
                        Contact & Location
                    </h2>

                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Phone
                                Number</label>
                            <input type="text" name="phone" value="{{ $settings['phone'] ?? '' }}"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500"
                                placeholder="+977-1-XXXXXXX">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Email
                                Address</label>
                            <input type="email" name="email" value="{{ $settings['email'] ?? '' }}"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500"
                                placeholder="info@school.edu.np">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Full
                                Address</label>
                            <textarea name="address" rows="2"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30 resize-none"
                                placeholder="Street, City, District, Nepal">{{ $settings['address'] ?? '' }}</textarea>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">
                                Google Maps Embed
                                <span class="ml-2 text-gold-500 font-normal normal-case tracking-normal">Paste the iframe
                                    HTML from Google Maps → Share → Embed</span>
                            </label>
                            <textarea name="map_embed" rows="4"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-gold-500/30 resize-none"
                                placeholder='&lt;iframe src="https://www.google.com/maps/embed?..." ...&gt;&lt;/iframe&gt;'>{{ $settings['map_embed'] ?? '' }}</textarea>
                            {{-- Preview if embed exists --}}
                            @if (!empty($settings['map_embed']))
                                <div class="mt-3 rounded-xl overflow-hidden h-40 border border-slate-200">
                                    {!! $settings['map_embed'] !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- ════════════════════════════════════════════════════════
         TAB 4 — ABOUT & MISSION (NEW)
    ════════════════════════════════════════════════════════ --}}
            <div x-show="tab === 'about'" x-cloak>
                <div class="space-y-6">

                    {{-- Mission & Vision --}}
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-7 space-y-5">
                        <h2 class="font-display font-bold text-navy-900 text-lg flex items-center gap-2">
                            <span
                                class="w-7 h-7 bg-navy-900 rounded-lg flex items-center justify-center text-white text-xs font-bold">4</span>
                            Mission, Vision & History
                        </h2>
                        <p class="text-slate-400 text-xs">These power the <strong class="text-slate-600">About Us</strong>
                            page. They are editable here and reflected immediately on the live site.</p>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Mission
                                Statement</label>
                            <textarea name="mission" rows="4"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30 resize-none"
                                placeholder="To provide a world-class education that integrates academic excellence with human values...">{{ $settings['mission'] ?? '' }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Vision
                                Statement</label>
                            <textarea name="vision" rows="4"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30 resize-none"
                                placeholder="To be the leading institution in value-based education...">{{ $settings['vision'] ?? '' }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">History
                                Intro Paragraph</label>
                            <textarea name="history_intro" rows="3"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30 resize-none"
                                placeholder="Since our founding in 2000, Sathya Sai Shiksha Sadan has been...">{{ $settings['history_intro'] ?? '' }}</textarea>
                            <p class="text-slate-400 text-xs mt-1">Appears below the "A Legacy of Excellence" heading on
                                the About page.</p>
                        </div>
                    </div>

                    {{-- About page content --}}
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-7 space-y-5">
                        <h3 class="font-display font-bold text-navy-900 text-base">About Page — Main Content</h3>
                        <p class="text-slate-400 text-xs">This rich text appears in the left column of the About page intro
                            section. Supports basic HTML.</p>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Content
                                (HTML supported)</label>
                            <textarea name="about_content" rows="8"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-gold-500/30 resize-y"
                                placeholder="<p>At Sathya Sai Shiksha Sadan, we believe...</p>">{{ $settings['about_content'] ?? '' }}</textarea>
                            <p class="text-slate-400 text-xs mt-1">You can use &lt;p&gt;, &lt;strong&gt;, &lt;em&gt;,
                                &lt;ul&gt;, &lt;li&gt; tags.</p>
                        </div>
                    </div>

                    {{-- Hero subtitle --}}
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-7">
                        <h3 class="font-display font-bold text-navy-900 text-base mb-4">Homepage Hero Subtitle</h3>
                        <textarea name="hero_subtitle" rows="2"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30 resize-none"
                            placeholder="Nurturing excellence and character from Grade 1 to +2...">{{ $settings['hero_subtitle'] ?? '' }}</textarea>
                        <p class="text-slate-400 text-xs mt-2">The subtitle text below the school name on the homepage
                            hero.</p>
                    </div>

                </div>
            </div>

            {{-- ════════════════════════════════════════════════════════
         TAB 5 — SOCIAL MEDIA
    ════════════════════════════════════════════════════════ --}}
            <div x-show="tab === 'social'" x-cloak>
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-7 space-y-5">
                    <h2 class="font-display font-bold text-navy-900 text-lg flex items-center gap-2">
                        <span
                            class="w-7 h-7 bg-navy-900 rounded-lg flex items-center justify-center text-white text-xs font-bold">5</span>
                        Social Media Links
                    </h2>
                    <p class="text-slate-400 text-xs">Leave blank to hide the icon from the top bar and footer. Full URL
                        required.</p>

                    <div class="grid sm:grid-cols-2 gap-5">
                        @foreach ([['facebook', 'Facebook', 'https://facebook.com/yourpage', '#1877F2'], ['twitter', 'Twitter / X', 'https://twitter.com/yourhandle', '#000000'], ['instagram', 'Instagram', 'https://instagram.com/yourpage', '#E4405F'], ['youtube', 'YouTube', 'https://youtube.com/@yourchannel', '#FF0000']] as [$key, $label, $placeholder, $color])
                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2 flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full" style="background:{{ $color }}"></span>
                                    {{ $label }}
                                </label>
                                <input type="url" name="{{ $key }}" value="{{ $settings[$key] ?? '' }}"
                                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500"
                                    placeholder="{{ $placeholder }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ════════════════════════════════════════════════════════
         TAB 6 — SEO
    ════════════════════════════════════════════════════════ --}}
            <div x-show="tab === 'seo'" x-cloak>
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-7 space-y-5">
                    <h2 class="font-display font-bold text-navy-900 text-lg flex items-center gap-2">
                        <span
                            class="w-7 h-7 bg-navy-900 rounded-lg flex items-center justify-center text-white text-xs font-bold">6</span>
                        SEO & Meta Tags
                    </h2>
                    <p class="text-slate-400 text-xs">These are the global defaults. Individual pages can override them in
                        Admin → Pages.</p>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Default Meta
                            Description</label>
                        <textarea name="meta_description" rows="3"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30 resize-none"
                            placeholder="Sathya Sai Shiksha Sadan — nurturing excellence and character...">{{ $settings['meta_description'] ?? '' }}</textarea>
                        <div class="flex justify-between mt-1">
                            <p class="text-slate-400 text-xs">Appears in Google search results. Ideal length: 120–160
                                characters.</p>
                            <span class="text-xs text-slate-400" id="meta-count">0 / 160</span>
                        </div>
                    </div>

                    {{-- Google Analytics --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Google Analytics
                            ID <span
                                class="text-slate-400 font-normal normal-case tracking-normal">(optional)</span></label>
                        <input type="text" name="ga_id" value="{{ $settings['ga_id'] ?? '' }}"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500"
                            placeholder="G-XXXXXXXXXX">
                        <p class="text-slate-400 text-xs mt-1">Add your Google Analytics 4 Measurement ID to enable
                            tracking.</p>
                    </div>
                </div>
            </div>

            {{-- ════════════════════════════════════════════════════════
         TAB — ADMISSIONS FORM
    ════════════════════════════════════════════════════════ --}}
            <div x-show="tab === 'admissions'" x-cloak>
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-7 space-y-5">
                        <h2 class="font-display font-bold text-navy-900 text-lg flex items-center gap-2">
                            <span class="w-7 h-7 bg-navy-900 rounded-lg flex items-center justify-center text-white text-xs font-bold">A</span>
                            Admissions Form Settings
                        </h2>
                        <p class="text-slate-400 text-xs">Control form text, class choices, visible fields, and required fields. Admission page sections are managed from Admin Pages → Admissions.</p>

                        <div class="grid sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Academic Year</label>
                                <input type="text" name="admission_year" value="{{ \App\Models\SiteSetting::get('admission_year', '2026-27') }}"
                                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30"
                                    placeholder="2026-27">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Class Options</label>
                                <input type="text" name="admission_class_options"
                                    value="{{ \App\Models\SiteSetting::get('admission_class_options', 'Grade 1|Grade 2|Grade 3|Grade 4|Grade 5|Grade 6|Grade 7|Grade 8|Grade 9|Grade 10|+2 Science|+2 Management') }}"
                                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30"
                                    placeholder="Grade 1|Grade 2|+2 Science">
                                <p class="text-slate-400 text-xs mt-1">Separate choices with <code class="bg-slate-100 px-1 rounded">|</code>.</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Form Intro Text</label>
                            <textarea name="admission_form_intro" rows="2"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30 resize-none">{{ \App\Models\SiteSetting::get('admission_form_intro', 'Complete this form to apply for admission. Our admissions team will contact you within 2-3 working days.') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Success Message</label>
                            <textarea name="admission_success_message" rows="2"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30 resize-none">{{ \App\Models\SiteSetting::get('admission_success_message', 'Your application has been submitted successfully.') }}</textarea>
                        </div>
                    </div>

                    @php
                        $fieldLabels = [
                            'applicant_first_name' => 'Student First Name',
                            'applicant_last_name' => 'Student Last Name',
                            'dob' => 'Date of Birth',
                            'gender' => 'Gender',
                            'nationality' => 'Nationality',
                            'religion' => 'Religion',
                            'address' => 'Permanent Address',
                            'parent_name' => 'Parent / Guardian Name',
                            'relationship' => 'Relationship',
                            'email' => 'Email',
                            'phone' => 'Phone',
                            'occupation' => 'Occupation',
                            'income' => 'Annual Income',
                            'class_applying' => 'Class Applying For',
                            'previous_school' => 'Previous School',
                            'last_class' => 'Last Class / Grade',
                            'message' => 'Additional Message',
                        ];
                        $defaultVisible = implode(',', array_keys($fieldLabels));
                        $visibleAdmissionFields = explode(',', \App\Models\SiteSetting::get('admission_visible_fields', $defaultVisible));
                        $requiredAdmissionFields = explode(',', \App\Models\SiteSetting::get('admission_required_fields', 'applicant_first_name,parent_name,email,phone,class_applying'));
                        $lockedFields = ['parent_name', 'email', 'phone', 'class_applying'];
                    @endphp

                    <div class="grid lg:grid-cols-2 gap-6">
                        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-7">
                            <h3 class="font-display font-bold text-navy-900 text-base mb-2">Visible Fields</h3>
                            <p class="text-slate-400 text-xs mb-5">Choose what appears on the public application form.</p>
                            <div class="grid sm:grid-cols-2 gap-3">
                                @foreach ($fieldLabels as $key => $label)
                                    <label class="flex items-center gap-2 rounded-xl border border-slate-100 px-3 py-2 text-sm text-slate-600">
                                        <input type="checkbox" name="admission_visible_fields[]" value="{{ $key }}"
                                            {{ in_array($key, $visibleAdmissionFields, true) || in_array($key, $lockedFields, true) ? 'checked' : '' }}
                                            {{ in_array($key, $lockedFields, true) ? 'onclick=this.checked=true' : '' }}
                                            class="rounded border-slate-300 text-gold-500 focus:ring-gold-500">
                                        {{ $label }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-7">
                            <h3 class="font-display font-bold text-navy-900 text-base mb-2">Required Fields</h3>
                            <p class="text-slate-400 text-xs mb-5">Required fields must be filled before submit.</p>
                            <div class="grid sm:grid-cols-2 gap-3">
                                @foreach ($fieldLabels as $key => $label)
                                    <label class="flex items-center gap-2 rounded-xl border border-slate-100 px-3 py-2 text-sm text-slate-600">
                                        <input type="checkbox" name="admission_required_fields[]" value="{{ $key }}"
                                            {{ in_array($key, $requiredAdmissionFields, true) || in_array($key, $lockedFields, true) ? 'checked' : '' }}
                                            {{ in_array($key, $lockedFields, true) ? 'onclick=this.checked=true' : '' }}
                                            class="rounded border-slate-300 text-gold-500 focus:ring-gold-500">
                                        {{ $label }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
{{-- ══════════════════════════════════════════════════════
     TAB: POPUP BANNER SETTINGS
══════════════════════════════════════════════════════ --}}

            @php $existingImg = \App\Models\SiteSetting::get('popup_image'); @endphp
            <div x-show="tab==='popup'" x-cloak
                x-data="popupEditor({
                    mode: @js(\App\Models\SiteSetting::get('popup_mode', 'template')),
                    badge: @js(\App\Models\SiteSetting::get('popup_badge_text', 'Admissions Now Open')),
                    deadline: @js(\App\Models\SiteSetting::get('popup_deadline', 'March 15, 2026 · Last date for submission')),
                    title: @js(\App\Models\SiteSetting::get('popup_title', 'Give Your Child the Gift of Human Values')),
                    subtitle: @js(\App\Models\SiteSetting::get('popup_subtitle', 'Enrol now for the 2026–27 academic year. Limited seats available across all levels.')),
                    pills: @js(\App\Models\SiteSetting::get('popup_pills', 'Grade 1 to +2|Expert Faculty|Boarding|Human Values|100% Results')),
                    primaryText: @js(\App\Models\SiteSetting::get('popup_primary_text', 'Apply for Admission')),
                    secondaryText: @js(\App\Models\SiteSetting::get('popup_secondary_text', 'Learn More')),
                    imageSrc: @js($existingImg && \Illuminate\Support\Facades\Storage::disk('public')->exists($existingImg) ? \Illuminate\Support\Facades\Storage::url($existingImg) : '')
                })"
                @popup-image-preview.window="imagePreview = $event.detail.src">
                <div class="space-y-6">

                    {{-- ── HEADER: master toggle ──────────────────────────────────────────── --}}
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <h2 class="font-display font-bold text-navy-900 text-lg">Popup Banner</h2>
                                <p class="text-slate-400 text-xs mt-1 max-w-md">
                                    Shows every time a visitor opens or refreshes your site. Great for admissions
                                    announcements, events, or special notices.
                                </p>
                            </div>
                            <div class="flex items-center gap-6">
                                <span class="hidden sm:inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-700 rounded-xl text-xs font-bold">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    Preview updates while typing
                                </span>
                                <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                                    <input type="checkbox" name="popup_enabled" value="1"
                                        {{ \App\Models\SiteSetting::get('popup_enabled', '1') !== '0' ? 'checked' : '' }}
                                        class="sr-only peer">
                                    <div
                                        class="w-14 h-7 bg-slate-200 rounded-full peer
                                peer-checked:bg-emerald-500
                                after:absolute after:top-0.5 after:left-0.5
                                after:bg-white after:w-6 after:h-6 after:rounded-full
                                after:transition-all after:shadow-sm
                                peer-checked:after:translate-x-7">
                                    </div>
                                    <span class="ml-3 text-sm font-semibold text-slate-700">Show popup</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- ── LIVE PREVIEW ─────────────────────────────────────────────────── --}}
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                        <div class="flex items-center justify-between gap-4 mb-5">
                            <div>
                                <h3 class="font-display font-bold text-navy-900 text-base">Live Preview</h3>
                                <p class="text-slate-400 text-xs mt-1">This preview changes immediately as you type. Save to publish it on the website.</p>
                            </div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 bg-slate-50 border border-slate-100 rounded-full px-3 py-1" x-text="modeLabel"></span>
                        </div>

                        <div class="rounded-2xl overflow-hidden border border-slate-200 bg-slate-950/90 shadow-sm max-w-3xl">
                            <template x-if="mode === 'image'">
                                <a :href="'#'" class="block bg-slate-100">
                                    <template x-if="previewImage">
                                        <img :src="previewImage" alt="Popup preview" class="w-full max-h-[360px] object-cover">
                                    </template>
                                    <template x-if="!previewImage">
                                        <div class="h-72 flex items-center justify-center text-slate-400 text-sm">Upload an image to preview this mode</div>
                                    </template>
                                </a>
                            </template>

                            <template x-if="mode !== 'image'">
                                <div>
                                    <template x-if="mode === 'image-top' && previewImage">
                                        <img :src="previewImage" alt="Popup preview" class="w-full max-h-56 object-cover bg-slate-100">
                                    </template>
                                    <div class="relative p-8 sm:p-10 text-white overflow-hidden" style="background:linear-gradient(135deg,#0d1628,#1B2A4A,#2d1f5e)">
                                        <div class="absolute -right-10 -top-14 w-48 h-48 rounded-full border border-gold-500/20"></div>
                                        <div class="absolute left-5 bottom-5 grid grid-cols-5 gap-2 opacity-20">
                                            <template x-for="i in 25" :key="i"><span class="w-1 h-1 rounded-full bg-gold-400"></span></template>
                                        </div>
                                        <div class="relative">
                                            <div class="inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/15 px-4 py-2 text-[11px] font-bold tracking-wider uppercase text-gold-300" x-show="badge">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gold-400"></span>
                                                <span x-text="badge"></span>
                                            </div>
                                            <h4 class="font-display text-3xl sm:text-4xl font-bold leading-tight mt-5 max-w-xl" x-html="highlightedTitle"></h4>
                                            <p class="text-white/70 text-sm mt-4 max-w-xl" x-text="subtitle"></p>
                                        </div>
                                    </div>
                                    <div class="bg-white p-6">
                                        <div class="flex flex-wrap gap-2 mb-5">
                                            <template x-for="pill in pillList" :key="pill">
                                                <span class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-bold text-navy-900">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-gold-500"></span>
                                                    <span x-text="pill"></span>
                                                </span>
                                            </template>
                                        </div>
                                        <div class="rounded-xl border border-gold-500/30 bg-gold-50/70 px-5 py-4 mb-5" x-show="deadline">
                                            <div class="text-[10px] font-bold uppercase tracking-widest text-gold-600 mb-1">Application Deadline</div>
                                            <div class="font-bold text-navy-900 text-sm" x-text="deadline"></div>
                                        </div>
                                        <div class="grid sm:grid-cols-2 gap-3">
                                            <span class="inline-flex items-center justify-center rounded-xl bg-gold-500 px-5 py-3 text-sm font-bold text-white shadow-sm" x-text="primaryText || 'Primary button'"></span>
                                            <span class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-bold text-navy-900" x-text="secondaryText || 'Secondary button'"></span>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- ── ADVANCED BEHAVIOR ─────────────────────────────────────────────── --}}
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                        <h3 class="font-display font-bold text-navy-900 text-base mb-2">Display Rules</h3>
                        <p class="text-slate-400 text-xs mb-5">Control where and how often the popup appears.</p>

                        <div class="grid sm:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Show On</label>
                                <select name="popup_show_on"
                                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30 bg-white">
                                    @foreach (['home' => 'Homepage only', 'all' => 'All public pages'] as $value => $label)
                                        <option value="{{ $value }}" {{ \App\Models\SiteSetting::get('popup_show_on', 'home') === $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Delay</label>
                                <input type="number" name="popup_delay_ms" min="0" step="100"
                                    value="{{ \App\Models\SiteSetting::get('popup_delay_ms', '800') }}"
                                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30"
                                    placeholder="800">
                                <p class="text-slate-400 text-xs mt-1">Milliseconds before opening.</p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Hide After Close</label>
                                <input type="number" name="popup_hide_hours" min="0" step="1"
                                    value="{{ \App\Models\SiteSetting::get('popup_hide_hours', '24') }}"
                                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30"
                                    placeholder="24">
                                <p class="text-slate-400 text-xs mt-1">Hours. Use 0 to show every visit.</p>
                            </div>
                        </div>
                    </div>

                    {{-- ── MODE SELECTOR ──────────────────────────────────────────────────── --}}
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                        <h3 class="font-display font-bold text-navy-900 text-base mb-5">Choose Display Mode</h3>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-7">

                            {{-- Mode 1: Template --}}
                            <label
                                :class="mode === 'template' ? 'border-navy-900 ring-2 ring-navy-900/20 bg-navy-50' :
                                    'border-slate-200 hover:border-slate-300'"
                                class="relative cursor-pointer border-2 rounded-2xl p-4 transition-all">
                                <input type="radio" name="popup_mode" value="template" x-model="mode"
                                    class="sr-only">
                                {{-- Mini template preview --}}
                                <div class="rounded-xl overflow-hidden shadow-sm mb-3">
                                    <div class="h-16 flex flex-col justify-center items-center gap-1"
                                        style="background:linear-gradient(135deg,#0d1628,#1B2A4A,#2d1f5e)">
                                        <div class="w-16 h-1.5 rounded-full bg-gold/60"></div>
                                        <div class="w-24 h-2 rounded-full bg-white/30"></div>
                                        <div class="w-20 h-1.5 rounded-full bg-white/20"></div>
                                    </div>
                                    <div class="bg-white p-2 flex gap-1.5">
                                        <div class="flex-1 h-5 rounded-md"
                                            style="background:linear-gradient(135deg,#C9A227,#dbb82f)"></div>
                                        <div class="flex-1 h-5 rounded-md border border-slate-200"></div>
                                    </div>
                                </div>
                                <div :class="mode === 'template' ? 'text-navy-900' : 'text-slate-600'"
                                    class="font-semibold text-sm mb-1">Designed Template</div>
                                <p class="text-slate-400 text-xs leading-relaxed">Use the built-in branded design. Edit
                                    text from this page.</p>
                                <div x-show="mode==='template'"
                                    class="absolute top-3 right-3 w-5 h-5 bg-navy-900 rounded-full flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </label>

                            {{-- Mode 2: Image only --}}
                            <label
                                :class="mode === 'image' ? 'border-navy-900 ring-2 ring-navy-900/20 bg-navy-50' :
                                    'border-slate-200 hover:border-slate-300'"
                                class="relative cursor-pointer border-2 rounded-2xl p-4 transition-all">
                                <input type="radio" name="popup_mode" value="image" x-model="mode" class="sr-only">
                                {{-- Mini image preview --}}
                                <div
                                    class="rounded-xl overflow-hidden shadow-sm mb-3 bg-slate-100 h-[76px] flex items-center justify-center">
                                    @php $existingImg = \App\Models\SiteSetting::get('popup_image'); @endphp
                                    @if ($existingImg && \Illuminate\Support\Facades\Storage::disk('public')->exists($existingImg))
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($existingImg) }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="text-center p-3">
                                            <svg class="w-8 h-8 text-slate-300 mx-auto mb-1" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="text-slate-400 text-[10px]">Upload image</p>
                                        </div>
                                    @endif
                                </div>
                                <div :class="mode === 'image' ? 'text-navy-900' : 'text-slate-600'"
                                    class="font-semibold text-sm mb-1">Custom Image Only</div>
                                <p class="text-slate-400 text-xs leading-relaxed">Upload your Canva or Figma banner. Shows
                                    full image as popup.</p>
                                <div x-show="mode==='image'"
                                    class="absolute top-3 right-3 w-5 h-5 bg-navy-900 rounded-full flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </label>

                            {{-- Mode 3: Image + Template --}}
                            <label
                                :class="mode === 'image-top' ? 'border-navy-900 ring-2 ring-navy-900/20 bg-navy-50' :
                                    'border-slate-200 hover:border-slate-300'"
                                class="relative cursor-pointer border-2 rounded-2xl p-4 transition-all">
                                <input type="radio" name="popup_mode" value="image-top" x-model="mode"
                                    class="sr-only">
                                {{-- Mini combo preview --}}
                                <div class="rounded-xl overflow-hidden shadow-sm mb-3">
                                    <div class="h-10 bg-slate-200 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14" />
                                        </svg>
                                    </div>
                                    <div class="bg-white p-2 space-y-1">
                                        <div class="h-4 rounded bg-amber-100 border border-amber-200"></div>
                                        <div class="flex gap-1.5">
                                            <div class="flex-1 h-5 rounded-md"
                                                style="background:linear-gradient(135deg,#C9A227,#dbb82f)"></div>
                                            <div class="flex-1 h-5 rounded-md border border-slate-200"></div>
                                        </div>
                                    </div>
                                </div>
                                <div :class="mode === 'image-top' ? 'text-navy-900' : 'text-slate-600'"
                                    class="font-semibold text-sm mb-1">Image + CTA Buttons</div>
                                <p class="text-slate-400 text-xs leading-relaxed">Custom image on top, deadline + Apply
                                    button below.</p>
                                <div x-show="mode==='image-top'"
                                    class="absolute top-3 right-3 w-5 h-5 bg-navy-900 rounded-full flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </label>
                        </div>

                        {{-- ── IMAGE UPLOAD (shown for image / image-top modes) ──────────────── --}}
                        <div x-show="mode === 'image' || mode === 'image-top'" x-cloak
                            class="border-t border-slate-100 pt-6 space-y-5">
                            <div>
                                <h3 class="font-semibold text-navy-900 text-sm mb-1">Upload Banner Image</h3>
                                <p class="text-slate-400 text-xs mb-4">Design your banner in <strong
                                        class="text-slate-600">Canva</strong> or <strong
                                        class="text-slate-600">Figma</strong>, export as PNG or JPG, then upload here.</p>

                                {{-- Tips --}}
                                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-4">
                                    <p class="text-blue-700 text-xs font-semibold mb-2 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Design tips for best results
                                    </p>
                                    <ul class="text-blue-600 text-xs space-y-1">
                                        <li>• Recommended size: <strong>1080 × 720px</strong> (3:2 ratio)</li>
                                        <li>• Keep text large enough to read on mobile (min 24px)</li>
                                        <li>• PNG for sharp edges · JPG for photos (max 3MB)</li>
                                        <li>• Include your school colours: Navy <code
                                                class="bg-blue-100 px-1 rounded">#1B2A4A</code> and Gold <code
                                                class="bg-blue-100 px-1 rounded">#C9A227</code></li>
                                        <li>• Add a clear "Apply Now" call-to-action in the image itself</li>
                                    </ul>
                                </div>

                                {{-- Current image --}}
                                @if ($existingImg && \Illuminate\Support\Facades\Storage::disk('public')->exists($existingImg))
                                    <div class="mb-4">
                                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Current
                                            image</p>
                                        <div class="relative inline-block">
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($existingImg) }}"
                                                class="max-h-48 rounded-xl border border-slate-200 shadow-sm">
                                            <span
                                                class="absolute top-2 right-2 bg-emerald-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">Active</span>
                                        </div>
                                        <div class="mt-3">
                                            <label class="inline-flex items-center cursor-pointer">
                                                <input type="checkbox" name="delete_popup_image" value="1"
                                                    class="rounded border-slate-300 text-red-500 focus:ring-red-500 mr-2">
                                                <span
                                                    class="text-xs text-red-500 font-semibold hover:text-red-600 transition-colors">Delete
                                                    this image on save</span>
                                            </label>
                                        </div>
                                    </div>
                                @endif

                                {{-- Upload zone --}}
                                <div class="border-2 border-dashed border-slate-200 hover:border-gold rounded-xl p-8 text-center transition-colors cursor-pointer"
                                    onclick="document.getElementById('popup-img-input').click()">
                                    <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-slate-500 text-sm font-semibold mb-1">Click to upload your banner</p>
                                    <p class="text-slate-400 text-xs">PNG, JPG or WebP · Max 3MB · Recommended 1080×720px
                                    </p>
                                    <input type="file" id="popup-img-input" name="popup_image"
                                        accept="image/png,image/jpeg,image/webp" class="sr-only"
                                        onchange="previewPopupImg(this)">
                                </div>

                                {{-- Preview after picking --}}
                                <div id="popup-img-preview" class="hidden mt-4">
                                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">New image
                                        preview</p>
                                    <img id="popup-img-preview-img" src=""
                                        class="max-h-56 rounded-xl border border-slate-200 shadow-sm">
                                    <p class="text-xs text-emerald-600 font-semibold mt-2">✓ Ready to save — click "Save
                                        All Settings" below</p>
                                </div>
                            </div>

                            {{-- Click-through URL --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">
                                    Image Click Link <span
                                        class="text-slate-400 font-normal normal-case tracking-normal">(where does clicking
                                        the image go?)</span>
                                </label>
                                <input type="url" name="popup_image_link"
                                    value="{{ \App\Models\SiteSetting::get('popup_image_link', route('admissions.index')) }}"
                                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500"
                                    placeholder="{{ route('admissions.index') }}">
                                <p class="text-slate-400 text-xs mt-1">Leave blank to make the image non-clickable.</p>
                            </div>
                        </div>

                        {{-- ── TEMPLATE FIELDS (shown for template / image-top modes) ──────── --}}
                        <div x-show="mode === 'template' || mode === 'image-top'" x-cloak
                            class="border-t border-slate-100 pt-6 space-y-5">
                            <h3 class="font-semibold text-navy-900 text-sm">Template Text</h3>

                            <div class="grid sm:grid-cols-2 gap-5">
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Badge
                                        Text</label>
                                    <input type="text" name="popup_badge_text"
                                        x-model="badge"
                                        value="{{ \App\Models\SiteSetting::get('popup_badge_text', 'Admissions Now Open') }}"
                                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30"
                                        placeholder="Admissions Now Open">
                                    <p class="text-slate-400 text-xs mt-1">Small blinking badge at the top of the popup</p>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Deadline
                                        Text</label>
                                    <input type="text" name="popup_deadline"
                                        x-model="deadline"
                                        value="{{ \App\Models\SiteSetting::get('popup_deadline', 'March 15, 2026 · Last date for submission') }}"
                                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30"
                                        placeholder="March 15, 2026 · Last date for submission">
                                    <p class="text-slate-400 text-xs mt-1">Shown in the gold deadline strip</p>
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Main
                                    Title</label>
                                <input type="text" name="popup_title"
                                    x-model="title"
                                    value="{{ \App\Models\SiteSetting::get('popup_title', 'Give Your Child the Gift of Human Values') }}"
                                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30"
                                    placeholder="Give Your Child the Gift of Human Values">
                                <p class="text-slate-400 text-xs mt-1">Words “Human Values” and “SSSS” are highlighted automatically.</p>
                            </div>

                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Subtitle</label>
                                <textarea name="popup_subtitle" rows="2"
                                    x-model="subtitle"
                                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30 resize-none"
                                    placeholder="Enrol now for the 2026–27 academic year...">{{ \App\Models\SiteSetting::get('popup_subtitle', 'Enrol now for the 2026–27 academic year. Limited seats available across all levels.') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Feature Pills</label>
                                <input type="text" name="popup_pills"
                                    x-model="pills"
                                    value="{{ \App\Models\SiteSetting::get('popup_pills', 'Grade 1 to +2|Expert Faculty|Boarding|Human Values|100% Results') }}"
                                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30"
                                    placeholder="Grade 1 to +2|Expert Faculty|Boarding">
                                <p class="text-slate-400 text-xs mt-1">Separate pills using <code class="bg-slate-100 px-1 rounded">|</code>. Keep each pill short.</p>
                            </div>

                            <div class="grid sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Primary Button Text</label>
                                    <input type="text" name="popup_primary_text"
                                        x-model="primaryText"
                                        value="{{ \App\Models\SiteSetting::get('popup_primary_text', 'Apply for Admission') }}"
                                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30"
                                        placeholder="Apply for Admission">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Primary Button URL</label>
                                    <input type="text" name="popup_primary_url"
                                        value="{{ \App\Models\SiteSetting::get('popup_primary_url', route('admissions.index')) }}"
                                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30"
                                        placeholder="/admissions">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Secondary Button Text</label>
                                    <input type="text" name="popup_secondary_text"
                                        x-model="secondaryText"
                                        value="{{ \App\Models\SiteSetting::get('popup_secondary_text', 'Learn More') }}"
                                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30"
                                        placeholder="Learn More">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Secondary Button URL</label>
                                    <input type="text" name="popup_secondary_url"
                                        value="{{ \App\Models\SiteSetting::get('popup_secondary_url', route('contact.index')) }}"
                                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30"
                                        placeholder="/contact">
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- ── QUICK REFERENCE ────────────────────────────────────────────────── --}}


                </div>
            </div>




            {{-- ════════════════════════════════════════════════════════
         TAB 7 — HOMEPAGE CONTENT (stats numbers)
    ════════════════════════════════════════════════════════ --}}
            <div x-show="tab === 'homepage'" x-cloak>
                <div class="space-y-6">

                    {{-- Stats numbers --}}
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-7 space-y-5">
                        <h2 class="font-display font-bold text-navy-900 text-lg flex items-center gap-2">
                            <span
                                class="w-7 h-7 bg-navy-900 rounded-lg flex items-center justify-center text-white text-xs font-bold">7</span>
                            Homepage Stats Numbers
                        </h2>
                        <p class="text-slate-400 text-xs">These appear in the hero section stats card (desktop) and the
                            stats strip (mobile). Use "+" suffix e.g. <code class="bg-slate-100 px-1 rounded">500+</code>
                        </p>

                        <div class="grid sm:grid-cols-2 gap-5">
                            @foreach ([['stats_students', 'Students Enrolled', '500+'], ['stats_teachers', 'Expert Teachers', '40+'], ['stats_years', 'Years of Excellence', '26+'], ['stats_programmes', 'Programmes Offered', '3']] as [$key, $label, $placeholder])
                                @php
                                    // Read from the homepage_blocks stats extra JSON
                                    $block = \App\Models\PageBlock::whereNull('page_id')
                                        ->where('type', 'stats')
                                        ->first();
                                    $extra = $block ? $block->extra ?? [] : [];
                                    $shortKey = str_replace('stats_', '', $key);
                                    $val = $extra[$shortKey] ?? '';
                                @endphp
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">{{ $label }}</label>
                                    <input type="text" name="{{ $key }}" value="{{ old($key, $val) }}"
                                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500"
                                        placeholder="{{ $placeholder }}">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Hero block content --}}
                    @php $heroBlock = \App\Models\PageBlock::whereNull('page_id')->where('type','hero')->first(); @endphp
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-7 space-y-5">
                        <h3 class="font-display font-bold text-navy-900 text-base">Hero Section</h3>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Hero
                                Heading</label>
                            <input type="text" name="hero_title"
                                value="{{ old('hero_title', $heroBlock->title ?? '') }}"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30"
                                placeholder="Education in Human Values">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Hero
                                Subtitle</label>
                            <textarea name="hero_subtitle_block" rows="2"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30 resize-none"
                                placeholder="Nurturing excellence and character...">{{ old('hero_subtitle_block', $heroBlock->subtitle ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Hero
                                Background Image</label>
                            @if (
                                $heroBlock &&
                                    $heroBlock->image_path &&
                                    \Illuminate\Support\Facades\Storage::disk('public')->exists($heroBlock->image_path))
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($heroBlock->image_path) }}"
                                    class="h-28 w-auto rounded-xl mb-3 object-cover border border-slate-200">
                            @endif
                            <input type="file" name="hero_image" accept="image/*"
                                class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-navy-900 file:text-white file:text-xs file:font-semibold hover:file:bg-gold-500 file:transition-colors cursor-pointer">
                            <p class="text-slate-400 text-xs mt-1.5">Recommended: 1600×900px or wider. JPG or WebP.</p>
                        </div>
                    </div>

                    {{-- CTA block --}}
                    @php $ctaBlock = \App\Models\PageBlock::whereNull('page_id')->where('type','cta_banner')->first(); @endphp
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-7 space-y-4">
                        <h3 class="font-display font-bold text-navy-900 text-base">CTA Banner (bottom of homepage)</h3>
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Heading</label>
                            <input type="text" name="cta_title"
                                value="{{ old('cta_title', $ctaBlock->title ?? 'Join Our Learning Community') }}"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                        </div>
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Subtitle</label>
                            <textarea name="cta_subtitle" rows="2"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30 resize-none">{{ old('cta_subtitle', $ctaBlock->subtitle ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── SAVE BUTTON (always visible) ──────────────────────────────────────── --}}
            <div
                class="mt-6 flex items-center justify-between bg-white rounded-2xl border border-slate-100 shadow-sm px-7 py-4">
                <p class="text-xs text-slate-400">Changes are applied immediately after saving. Cache clears automatically.
                </p>
                <button type="submit"
                    class="flex items-center gap-2 bg-navy-900 hover:bg-gold-500 text-white font-bold px-8 py-3 rounded-xl transition-colors shadow-md text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Save All Settings
                </button>
            </div>

        </div>{{-- end x-data --}}
    </form>

    @push('scripts')
        <script>
            function popupEditor(initial) {
                return {
                    mode: initial.mode || 'template',
                    badge: initial.badge || '',
                    deadline: initial.deadline || '',
                    title: initial.title || '',
                    subtitle: initial.subtitle || '',
                    pills: initial.pills || '',
                    primaryText: initial.primaryText || '',
                    secondaryText: initial.secondaryText || '',
                    imageSrc: initial.imageSrc || '',
                    imagePreview: '',
                    get previewImage() {
                        return this.imagePreview || this.imageSrc;
                    },
                    get modeLabel() {
                        return {
                            template: 'Designed template',
                            image: 'Image only',
                            'image-top': 'Image + CTA'
                        } [this.mode] || 'Designed template';
                    },
                    get pillList() {
                        return this.pills.split('|').map((pill) => pill.trim()).filter(Boolean).slice(0, 6);
                    },
                    get highlightedTitle() {
                        const safe = (this.title || 'Popup title').replace(/[&<>"']/g, (char) => ({
                            '&': '&amp;',
                            '<': '&lt;',
                            '>': '&gt;',
                            '"': '&quot;',
                            "'": '&#039;'
                        } [char]));
                        return safe
                            .replace(/Human Values/gi, '<span class="text-gold-300">$&</span>')
                            .replace(/SSSS/gi, '<span class="text-gold-300">$&</span>');
                    }
                };
            }

            // Live meta description character count
            const metaArea = document.querySelector('textarea[name="meta_description"]');
            const metaCount = document.getElementById('meta-count');
            if (metaArea && metaCount) {
                const update = () => {
                    const len = metaArea.value.length;
                    metaCount.textContent = len + ' / 160';
                    metaCount.className = 'text-xs ' + (len > 160 ? 'text-red-400' : len > 120 ? 'text-green-500' :
                        'text-slate-400');
                };
                metaArea.addEventListener('input', update);
                update();
            }
        </script>
        <script>
            function previewPopupImg(input) {
                if (!input.files || !input.files[0]) return;
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('popup-img-preview-img').src = e.target.result;
                    document.getElementById('popup-img-preview').classList.remove('hidden');
                    window.dispatchEvent(new CustomEvent('popup-image-preview', {
                        detail: {
                            src: e.target.result
                        }
                    }));
                };
                reader.readAsDataURL(input.files[0]);
            }
        </script>
    @endpush

@endsection
