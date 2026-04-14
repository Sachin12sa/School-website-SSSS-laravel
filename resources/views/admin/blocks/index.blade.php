@extends('admin.layouts.admin')
@section('title', 'Homepage Blocks')

@section('content')

    @if (session('success'))
        <div
            class="mb-5 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl px-5 py-3.5 text-sm">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ── Page header ──────────────────────────────────────────────────────────── --}}
    <div class="flex items-start justify-between mb-6">
        <div>
            <p class="text-slate-500 text-sm">Each card below controls one section of your homepage. Toggle visibility or
                expand to edit content.</p>
            <p class="text-slate-400 text-xs mt-1">Changes take effect immediately after saving. The order matches how
                sections appear on the live site.</p>
        </div>
        <a href="{{ url('/') }}" target="_blank"
            class="shrink-0 inline-flex items-center gap-1.5 border border-slate-200 text-slate-500 hover:text-navy-900 hover:border-slate-400 text-xs font-semibold px-4 py-2 rounded-xl transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
            Preview Site
        </a>
    </div>

    {{-- ── Block list ───────────────────────────────────────────────────────────── --}}
    <div class="space-y-4" id="blocks-list">

        @php
            // Map each block type to a rich config used for the card UI
            $blockMeta = [
                'hero' => [
                    'label' => 'Hero Section',
                    'desc' => 'Full-screen banner with heading, subtitle, and two CTA buttons.',
                    'hint' => 'This is the first thing visitors see. Upload a background image for best impact.',
                    'icon' =>
                        'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z',
                    'color' => '#4a148c',
                    'fields' => ['title', 'subtitle', 'button_text', 'button_url', 'image', 'visible'],
                ],
                'stats' => [
                    'label' => 'Stats Strip',
                    'desc' => 'Four animated counters — students, teachers, years, programmes.',
                    'hint' => 'Shown inside the hero card (desktop) and as a strip on mobile.',
                    'icon' =>
                        'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                    'color' => '#1B2A4A',
                    'fields' => ['stats', 'visible'],
                ],
                'about_intro' => [
                    'label' => 'Welcome / About Intro',
                    'desc' => 'Two-column layout — text on left, photo on right with a floating "Years" badge.',
                    'hint' => 'Edit the full HTML in Admin → Settings → About & Mission for richer formatting.',
                    'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                    'color' => '#0f6e56',
                    'fields' => ['title', 'content', 'image', 'visible'],
                ],
                'programs' => [
                    'label' => 'Academic Programs',
                    'desc' => 'Three hover-animated program cards — Primary, Secondary, +2.',
                    'hint' => 'Card content is static. Edit program details in Admin → Pages → Programs.',
                    'icon' =>
                        'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z',
                    'color' => '#C9A227',
                    'fields' => ['title', 'subtitle', 'visible'],
                ],
                'values' => [
                    'label' => 'Five Human Values',
                    'desc' => 'Left campus image + right numbered list of Sathya, Dharma, Shanti, Prema, Ahimsa.',
                    'hint' => 'Values list is part of school philosophy — toggle visibility here.',
                    'icon' =>
                        'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
                    'color' => '#C9A227',
                    'fields' => ['visible'],
                ],
                'legacy' => [
                    'label' => 'Legacy / History Timeline',
                    'desc' => '"Our Story" badge, intro paragraph, animated timeline with years, building photo.',
                    'hint' => 'Edit the history intro text in Admin → Settings → About & Mission.',
                    'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                    'color' => '#854F0B',
                    'fields' => ['title', 'content', 'image', 'visible'],
                ],
                'news_feed' => [
                    'label' => 'Latest News',
                    'desc' => 'Automatically shows the 3 most recent published news articles.',
                    'hint' => 'Add news in Admin → News. This section updates automatically.',
                    'icon' =>
                        'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z',
                    'color' => '#185FA5',
                    'fields' => ['title', 'subtitle', 'visible'],
                ],
                'events_feed' => [
                    'label' => 'Upcoming Events',
                    'desc' => 'Automatically shows up to 4 upcoming events on a dark navy background.',
                    'hint' => 'Add events in Admin → Events. Hidden automatically if no upcoming events exist.',
                    'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                    'color' => '#185FA5',
                    'fields' => ['title', 'visible'],
                ],
                'gallery_preview' => [
                    'label' => 'Gallery Preview',
                    'desc' => 'Grid of 4 album thumbnails with hover overlay. Links to the full gallery.',
                    'hint' => 'Upload photos in Admin → Gallery. Albums show here automatically.',
                    'icon' =>
                        'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z',
                    'color' => '#534AB7',
                    'fields' => ['title', 'visible'],
                ],
                'testimonial_slider' => [
                    'label' => 'Testimonials',
                    'desc' => 'Three testimonial cards from parents and alumni with star ratings.',
                    'hint' => 'Add or edit testimonials in Admin → Testimonials.',
                    'icon' =>
                        'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z',
                    'color' => '#534AB7',
                    'fields' => ['title', 'visible'],
                ],
                'contact_strip' => [
                    'label' => 'Get in Touch',
                    'desc' => 'Three contact cards (Call, Email, Visit) with a "Contact Us" button.',
                    'hint' => 'Contact info is pulled from Admin → Settings → Contact & Location.',
                    'icon' =>
                        'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z',
                    'color' => '#0f6e56',
                    'fields' => ['title', 'subtitle', 'visible'],
                ],
                'cta_banner' => [
                    'label' => 'Join Us — CTA Banner',
                    'desc' => 'Full-width dark banner with shimmer heading, subtitle, and two buttons.',
                    'hint' => 'This is the last section before the footer. A strong admissions call to action.',
                    'icon' =>
                        'M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z',
                    'color' => '#4a148c',
                    'fields' => ['title', 'subtitle', 'button_text', 'button_url', 'visible'],
                ],
            ];
        @endphp

        @forelse($blocks as $i => $block)
            @php
                $meta = $blockMeta[$block->type] ?? [
                    'label' => ucwords(str_replace('_', ' ', $block->type)),
                    'desc' => '',
                    'hint' => '',
                    'icon' => 'M4 6h16M4 12h16M4 18h16',
                    'color' => '#1B2A4A',
                    'fields' => ['title', 'subtitle', 'content', 'button_text', 'button_url', 'image', 'visible'],
                ];
                $fields = $meta['fields'];
            @endphp

            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden" x-data="{ open: false }">

                {{-- ── Card header row ──────────────────────────────────────────────── --}}
                <div class="flex items-center gap-4 px-5 py-4">

                    {{-- Order number + icon --}}
                    <div class="flex items-center gap-3 shrink-0">
                        <span class="text-slate-300 font-mono text-xs font-bold w-5 text-center">{{ $i + 1 }}</span>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 shadow-sm"
                            style="background:{{ $block->is_visible ? $meta['color'] : '#f1f5f9' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                style="color:{{ $block->is_visible ? '#fff' : '#94a3b8' }}">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="{{ $meta['icon'] }}" />
                            </svg>
                        </div>
                    </div>

                    {{-- Title + description --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2.5 flex-wrap">
                            <p class="font-display font-bold text-navy-900 text-sm">{{ $meta['label'] }}</p>
                            <span
                                class="text-[10px] font-bold px-2 py-0.5 rounded-full
                    {{ $block->is_visible ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-400' }}">
                                {{ $block->is_visible ? '● Visible' : '○ Hidden' }}
                            </span>
                        </div>
                        <p class="text-slate-400 text-xs mt-0.5 leading-relaxed truncate">{{ $meta['desc'] }}</p>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 shrink-0">

                        {{-- Quick visibility toggle --}}
                        <form action="{{ route('admin.blocks.update', $block->id) }}" method="POST" class="flex">
                            @csrf @method('PUT')
                            <input type="hidden" name="is_visible" value="{{ $block->is_visible ? '0' : '1' }}">
                            <button type="submit"
                                title="{{ $block->is_visible ? 'Hide this section' : 'Show this section' }}"
                                class="p-2 rounded-xl transition-colors
                               {{ $block->is_visible
                                   ? 'text-emerald-500 hover:bg-emerald-50'
                                   : 'text-slate-300 hover:bg-slate-50 hover:text-slate-500' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if ($block->is_visible)
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    @endif
                                </svg>
                            </button>
                        </form>

                        {{-- Expand / Edit toggle --}}
                        <button @click="open = !open"
                            class="p-2 text-slate-400 hover:text-navy-900 hover:bg-slate-100 rounded-xl transition-colors">
                            <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform duration-200"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- ── Expanded edit form ───────────────────────────────────────────── --}}
                <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    class="border-t border-slate-100">

                    {{-- Hint banner --}}
                    @if ($meta['hint'])
                        <div class="flex items-start gap-2.5 px-5 py-3 bg-blue-50 border-b border-blue-100">
                            <svg class="w-4 h-4 text-blue-400 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                            <p class="text-blue-600 text-xs leading-relaxed">{{ $meta['hint'] }}</p>
                        </div>
                    @endif

                    <form action="{{ route('admin.blocks.update', $block->id) }}" method="POST"
                        enctype="multipart/form-data" class="p-6 space-y-5">
                        @csrf @method('PUT')

                        {{-- ── TITLE + SUBTITLE ──────────────────────────────────────── --}}
                        @if (in_array('title', $fields) || in_array('subtitle', $fields))
                            <div class="grid sm:grid-cols-2 gap-4">
                                @if (in_array('title', $fields))
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Section
                                            Heading</label>
                                        <input type="text" name="title" value="{{ old('title', $block->title) }}"
                                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold transition-colors"
                                            placeholder="e.g. Latest News & Updates">
                                    </div>
                                @endif
                                @if (in_array('subtitle', $fields))
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Subtitle
                                            / Tagline</label>
                                        <input type="text" name="subtitle"
                                            value="{{ old('subtitle', $block->subtitle) }}"
                                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold transition-colors"
                                            placeholder="Short supporting text">
                                    </div>
                                @endif
                            </div>
                        @endif

                        {{-- ── RICH CONTENT ─────────────────────────────────────────── --}}
                        @if (in_array('content', $fields))
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">
                                    Content
                                    <span class="text-slate-400 font-normal normal-case tracking-normal ml-1">(HTML
                                        supported — use &lt;p&gt;, &lt;strong&gt;, &lt;ul&gt;)</span>
                                </label>
                                <textarea name="content" rows="5"
                                    class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-mono resize-y focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold transition-colors">{{ old('content', $block->content) }}</textarea>
                            </div>
                        @endif

                        {{-- ── BUTTON FIELDS ────────────────────────────────────────── --}}
                        @if (in_array('button_text', $fields) || in_array('button_url', $fields))
                            <div class="grid sm:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Button
                                        Label</label>
                                    <input type="text" name="button_text"
                                        value="{{ old('button_text', $block->button_text) }}"
                                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold/30"
                                        placeholder="e.g. Apply Now">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Button
                                        URL</label>
                                    <input type="text" name="button_url"
                                        value="{{ old('button_url', $block->button_url) }}"
                                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold/30"
                                        placeholder="/admissions">
                                </div>
                            </div>
                        @endif

                        {{-- ── STATS (special 4-field grid) ────────────────────────── --}}
                        @if (in_array('stats', $fields))
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-3">
                                    Animated Counters
                                    <span class="text-slate-400 font-normal normal-case tracking-normal ml-1">Include the +
                                        suffix e.g. "500+"</span>
                                </label>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                    @foreach (['students' => ['🎓', 'Students Enrolled'], 'teachers' => ['👨‍🏫', 'Expert Teachers'], 'years' => ['🏆', 'Years of Service'], 'programmes' => ['📚', 'Programmes']] as $k => [$emoji, $label])
                                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-3 text-center">
                                            <div class="text-2xl mb-1">{{ $emoji }}</div>
                                            <label
                                                class="text-[10px] font-bold text-slate-400 uppercase tracking-wide block mb-2">{{ $label }}</label>
                                            <input type="text" name="extra[{{ $k }}]"
                                                value="{{ old("extra.$k", $block->extra[$k] ?? '') }}"
                                                class="w-full border border-slate-200 bg-white rounded-lg px-2 py-2 text-sm font-bold text-center focus:outline-none focus:ring-2 focus:ring-gold/30"
                                                placeholder="e.g. 500+">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- ── IMAGE UPLOAD ─────────────────────────────────────────── --}}
                        @if (in_array('image', $fields))
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">
                                    Background / Section Image
                                </label>
                                @if ($block->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($block->image_path))
                                    <div class="mb-3 relative inline-block">
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($block->image_path) }}"
                                            class="h-24 w-auto rounded-xl border border-slate-200 object-cover shadow-sm">
                                        <span
                                            class="absolute -top-1.5 -right-1.5 bg-emerald-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full">Current</span>
                                    </div>
                                @endif
                                <div class="border-2 border-dashed border-slate-200 hover:border-gold rounded-xl p-5 text-center transition-colors cursor-pointer"
                                    onclick="document.getElementById('img-{{ $block->id }}').click()">
                                    <svg class="w-7 h-7 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-slate-400 text-xs">Click to upload a new image</p>
                                    <p class="text-slate-300 text-[10px] mt-0.5">JPG, PNG, WebP · Max 5MB · Recommended
                                        1600×900px</p>
                                    <input type="file" id="img-{{ $block->id }}" name="image_path"
                                        accept="image/*" class="sr-only"
                                        onchange="previewBlockImg(this, 'prev-{{ $block->id }}')">
                                </div>
                                <div id="prev-{{ $block->id }}" class="hidden mt-3">
                                    <img src="" class="h-20 rounded-xl border border-slate-200 object-cover">
                                    <p class="text-xs text-emerald-600 font-semibold mt-1">✓ Ready — click Save to apply
                                    </p>
                                </div>
                            </div>
                        @endif

                        {{-- ── VISIBILITY TOGGLE (inside form) ─────────────────────── --}}
                        @if (in_array('visible', $fields))
                            <div
                                class="flex items-center justify-between bg-slate-50 border border-slate-200 rounded-xl px-4 py-3">
                                <div>
                                    <p class="text-sm font-semibold text-slate-700">Show on homepage</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Toggle off to hide this section without
                                        deleting it</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_visible" value="1"
                                        {{ old('is_visible', $block->is_visible) ? 'checked' : '' }} class="sr-only peer">
                                    <div
                                        class="w-12 h-6 bg-slate-200 rounded-full peer
                                peer-checked:bg-emerald-500
                                after:absolute after:top-0.5 after:left-0.5
                                after:bg-white after:w-5 after:h-5 after:rounded-full
                                after:transition-all after:shadow-sm
                                peer-checked:after:translate-x-6">
                                    </div>
                                </label>
                            </div>
                        @endif

                        {{-- ── Save / Cancel ────────────────────────────────────────── --}}
                        <div class="flex gap-3 pt-1">
                            <button type="submit"
                                class="bg-navy-900 hover:bg-gold text-white font-bold px-7 py-2.5 rounded-xl text-sm transition-colors shadow-sm flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Save Changes
                            </button>
                            <button type="button" @click="open = false"
                                class="px-5 py-2.5 border border-slate-200 text-slate-600 hover:bg-slate-50 rounded-xl text-sm transition-colors">
                                Cancel
                            </button>
                            <a href="{{ url('/') }}" target="_blank"
                                class="ml-auto px-4 py-2.5 text-slate-400 hover:text-navy-900 text-xs font-medium transition-colors flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                Preview live
                            </a>
                        </div>
                    </form>
                </div>

            </div>
        @empty
            <div class="bg-white rounded-2xl border border-slate-100 p-16 text-center text-slate-400 shadow-sm">
                <svg class="w-14 h-14 mx-auto mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                </svg>
                <p class="text-lg font-semibold text-slate-500 mb-2">No homepage blocks found</p>
                <p class="text-sm mb-6">Run the database seeder to create the default blocks.</p>
                <code class="bg-slate-100 text-slate-600 px-4 py-2.5 rounded-xl text-sm font-mono">
                    php artisan db:seed
                </code>
            </div>
        @endforelse

    </div>

    {{-- ── Legend: what each block does ──────────────────────────────────────────── --}}
    <div class="mt-8 bg-white border border-slate-100 rounded-2xl shadow-sm p-6">
        <h3 class="font-display font-bold text-navy-900 text-sm mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
            </svg>
            Homepage Section Order
        </h3>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-2">
            @foreach ($blocks as $i => $b)
                @php $m = $blockMeta[$b->type] ?? ['label'=>ucwords(str_replace('_',' ',$b->type)),'color'=>'#1B2A4A']; @endphp
                <div class="flex items-center gap-2.5 text-xs {{ $b->is_visible ? 'text-slate-600' : 'text-slate-300' }}">
                    <span
                        class="w-5 h-5 rounded-full flex items-center justify-center text-white text-[9px] font-bold shrink-0"
                        style="background:{{ $b->is_visible ? $m['color'] : '#e2e8f0' }}">{{ $i + 1 }}</span>
                    {{ $m['label'] }}
                    @if (!$b->is_visible)
                        <span class="text-slate-300 text-[9px]">(hidden)</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    @push('scripts')
        <script>
            function previewBlockImg(input, previewId) {
                if (!input.files || !input.files[0]) return;
                const reader = new FileReader();
                reader.onload = e => {
                    const wrap = document.getElementById(previewId);
                    wrap.querySelector('img').src = e.target.result;
                    wrap.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        </script>
    @endpush

@endsection
