@extends('admin.layouts.admin')
@section('title', 'Edit Hero — ' . $hero->page_label)

@push('styles')
    <style>
        .field-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: #475569;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 8px;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .field-input {
            width: 100%;
            border: 1.5px solid #E2E8F0;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #0F172A;
            background: #F8FAFC;
            outline: none;
            transition: all .2s ease;
        }

        .field-input:focus {
            background: #fff;
            border-color: #C9A227;
            box-shadow: 0 0 0 4px rgba(201, 162, 39, 0.1);
        }

        .field-input::placeholder {
            color: #94A3B8;
        }

        .field-hint {
            font-size: 12px;
            color: #94A3B8;
            margin-top: 6px;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .card {
            background: #fff;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 20px;
            padding: 32px;
            margin-bottom: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }

        .card-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: #0F172A;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .card-title-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: linear-gradient(135deg, rgba(201, 162, 39, 0.15), rgba(201, 162, 39, 0.05));
            border: 1px solid rgba(201, 162, 39, 0.2);
            color: #C9A227;
        }

        .radio-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .radio-opt {
            cursor: pointer;
        }

        .radio-opt input {
            display: none;
        }

        .radio-opt span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #F8FAFC;
            border: 1.5px solid #E2E8F0;
            color: #64748B;
            transition: all .2s ease;
        }

        .radio-opt:hover span {
            background: #F1F5F9;
            border-color: #CBD5E1;
        }

        .radio-opt input:checked+span {
            background: #1B2A4A;
            color: #fff;
            border-color: #1B2A4A;
            box-shadow: 0 4px 12px rgba(27, 42, 74, 0.15);
        }

        .toggle {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
        }

        .toggle input {
            opacity: 0;
            position: absolute;
            width: 0;
            height: 0;
        }

        .toggle-track {
            width: 44px;
            height: 24px;
            border-radius: 12px;
            background: #CBD5E1;
            transition: background .2s ease;
            position: relative;
            flex-shrink: 0;
        }

        .toggle-track::after {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #fff;
            transition: transform .2s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .toggle input:checked~.toggle-track {
            background: #C9A227;
        }

        .toggle input:checked~.toggle-track::after {
            transform: translateX(20px);
        }

        /* FIX: opacity range accent */
        input[type="range"] {
            accent-color: #C9A227;
        }

        /* Preview */
        [x-cloak] {
            display: none !important;
        }

        .preview-wrap {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 28px;
        }
    </style>
@endpush

@section('content')

    {{-- Single Alpine scope wraps EVERYTHING including form --}}
    <div class="max-w-5xl mx-auto px-4 py-8" x-data="{
        showPreview: true,
        badge: @js(old('badge_text', $hero->badge_text)),
        heading: @js(old('heading', $hero->heading)),
        subheading: @js(old('subheading', $hero->subheading)),
        primaryBtn: @js(old('primary_button_text', $hero->primary_button_text)),
        secondaryBtn: @js(old('secondary_button_text', $hero->secondary_button_text)),
        overlay: @js(old('bg_overlay_style', $hero->bg_overlay_style)),
        textAlign: @js(old('text_align', $hero->text_align)),
        badgeStyleVal: @js(old('badge_style', $hero->badge_style)),
        showRings: @js((bool) old('show_rings', $hero->show_rings)),
        minHeight: @js(old('min_height', $hero->min_height)),
        /*
         * FIX 1: opacity stored in DB as 0.00–1.00 (float).
         * Keep the JS variable as 0–1. Display * 100 for the label.
         * The hidden input sends the raw 0–1 value to the controller.
         */
        opacity: parseFloat(@js(old('bg_image_opacity', $hero->bg_image_opacity))),
    
        opacityDisplay() { return Math.round(this.opacity * 100) + '%'; },
    
        overlayGradient() {
            if (this.overlay === 'light') return 'background:linear-gradient(135deg,rgba(255,255,255,0.65),rgba(255,255,255,0.35))';
            if (this.overlay === 'gold') return 'background:linear-gradient(135deg,rgba(201,162,39,0.9),rgba(13,27,46,0.5))';
            return 'background:linear-gradient(135deg,rgba(6,14,28,0.97),rgba(13,27,46,0.88))';
        },
    
        badgeInlineStyle() {
            if (this.badgeStyleVal === 'gold')
                return 'background:rgba(201,162,39,0.14);border:1px solid rgba(201,162,39,0.3);color:#C9A227;box-shadow:inset 0 1px 0 rgba(255,255,255,0.08)';
            return 'background:rgba(255,255,255,0.09);border:1px solid rgba(255,255,255,0.15);color:rgba(255,255,255,0.9);box-shadow:inset 0 1px 0 rgba(255,255,255,0.1)';
        },
        heightLabel() {
            const labels = {
                '56vh': 'Compact',
                '68vh': 'Standard',
                '72vh': 'Tall',
                '80vh': 'Extra tall',
                '90vh': 'Near full',
                '100dvh': 'Full screen',
            };
            return labels[this.minHeight] || this.minHeight;
        },
    }">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-sm mb-6" style="font-family:'Plus Jakarta Sans',sans-serif;color:#9CA3AF">
            <a href="{{ route('admin.heroes.index') }}" class="hover:text-gray-700 transition-colors">Heroes</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-700 font-medium">{{ $hero->page_label }}</span>
        </div>

        <div class="rounded-2xl border border-gold-500/20 bg-gold-50/70 p-5 mb-6"
            style="font-family:'Plus Jakarta Sans',sans-serif">
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background:#C9A227">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M12 18a6 6 0 100-12 6 6 0 000 12z" />
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-gray-900 text-sm">Hero editor guide</p>
                    <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                        Edit the text on the left, control the visual style on the right, and keep Live Preview open to
                        confirm overlay, badge style, rings, alignment, buttons, and opacity before saving.
                    </p>
                </div>
            </div>
        </div>

        {{-- Header row --}}
        <div class="flex items-start justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900" style="font-family:'Outfit',sans-serif">
                    {{ $hero->page_label }}
                </h1>
                <div class="font-mono text-xs text-gray-400 mt-1">
                    page_slug: <strong class="text-gray-700">{{ $hero->page_slug }}</strong>
                </div>
            </div>

            {{-- FIX 2: Live Preview toggle — use x-model directly on the div's x-data --}}
            <label class="toggle">
                <input type="checkbox" x-model="showPreview">
                <div class="toggle-track"></div>
                <span class="text-sm font-medium text-gray-500" style="font-family:'Plus Jakarta Sans',sans-serif">
                    Live Preview
                </span>
            </label>
        </div>

        {{-- ── LIVE PREVIEW ──────────────────────────────────────────────── --}}
        {{-- FIX 3: x-show on showPreview (now in same scope), no x-cloak needed here --}}
        <div x-show="showPreview" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            class="preview-wrap"
            style="min-height:260px;background:linear-gradient(135deg,#060e1c,#1B2A4A);position:relative;overflow:hidden">

            @if ($hero->bg_image_path)
                <div class="absolute inset-0">
                    <img src="{{ $hero->bgImageUrl() }}" class="w-full h-full object-cover" {{-- FIX 4: use opacity from DB for initial server render --}}
                        :style="`opacity: ${opacity}`">
                </div>
            @endif

            <div class="absolute inset-0" :style="overlayGradient()"></div>

            <div x-show="showRings" class="absolute top-8 right-10 w-44 h-44 border rounded-full pointer-events-none hidden md:block"
                style="border-color:rgba(255,255,255,0.08)"></div>
            <div x-show="showRings" class="absolute top-16 right-20 w-28 h-28 border rounded-full pointer-events-none hidden md:block"
                style="border-color:rgba(201,162,39,0.18)"></div>

            <div class="absolute bottom-4 right-5 text-[10px] font-bold px-2 py-1 rounded-full"
                style="background:rgba(255,255,255,0.08);color:rgba(255,255,255,0.5);font-family:'Plus Jakarta Sans',sans-serif">
                Preview height: <span x-text="heightLabel()"></span>
            </div>

            <div class="relative py-14 px-10 max-w-2xl" :class="textAlign === 'center' ? 'mx-auto text-center' : ''">

                {{-- Badge preview --}}
                <div x-show="badge" class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-xs font-bold mb-5"
                    :style="badgeInlineStyle()"
                    style="letter-spacing:.12em;text-transform:uppercase;backdrop-filter:blur(8px)">
                    <span class="w-1.5 h-1.5 rounded-full" style="background:#C9A227"></span>
                    <span x-text="badge"></span>
                </div>

                <h1 class="font-bold text-white mb-4"
                    style="font-family:'Cormorant Garamond',Georgia,serif;font-size:2.6rem;line-height:1.08"
                    x-text="heading || 'Your heading will appear here…'"></h1>

                <p class="text-white/60 mb-8 text-sm leading-relaxed max-w-md"
                    style="font-family:'Plus Jakarta Sans',sans-serif" x-text="subheading || 'Subheading preview…'"></p>

                <div class="flex flex-wrap gap-3" :class="textAlign === 'center' ? 'justify-center' : ''">
                    <template x-if="primaryBtn">
                        <span class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold"
                            style="background:#C9A227;color:#0D1B2E" x-text="primaryBtn"></span>
                    </template>
                    <template x-if="secondaryBtn">
                        <span class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold"
                            style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.18);color:rgba(255,255,255,0.85)"
                            x-text="secondaryBtn"></span>
                    </template>
                </div>
            </div>
        </div>

        {{-- ── REMOVE IMAGE FORM (separate, so it can submit independently) ── --}}
        <form id="remove-image-form" action="{{ route('admin.heroes.remove-image', $hero) }}" method="POST"
            onsubmit="return confirm('Remove this background image? This cannot be undone.')">
            @csrf
            @method('DELETE')
        </form>

        {{-- ── MAIN FORM ─────────────────────────────────────────────────── --}}
        <form action="{{ route('admin.heroes.update', $hero) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="rounded-xl p-4 mb-6 border text-sm"
                    style="background:rgba(239,68,68,0.06);border-color:rgba(239,68,68,0.2);font-family:'Plus Jakarta Sans',sans-serif;color:#DC2626">
                    <strong>Please fix these errors:</strong>
                    <ul class="mt-2 space-y-1 list-disc list-inside">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid lg:grid-cols-3 gap-6">

                {{-- ═══ LEFT — 2/3 width ═══════════════════════════════════ --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- ── Content ─────────────────────────────────────────── --}}
                    <div class="card">
                        <div class="card-title">
                            <div class="card-title-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            Content
                        </div>
                        <div class="space-y-5">
                            <div>
                                <label class="field-label">Badge Text</label>
                                <input type="text" name="badge_text" x-model="badge" class="field-input"
                                    placeholder="e.g. Admissions 2026–27 Open" maxlength="120">
                                <p class="field-hint">Small pill shown above heading. Leave blank to hide.</p>
                            </div>
                            <div>
                                <label class="field-label">Heading <span class="text-red-400">*</span></label>
                                <input type="text" name="heading" x-model="heading" required
                                    class="field-input {{ $errors->has('heading') ? 'border-red-400' : '' }}"
                                    placeholder="Main H1 heading">
                                @error('heading')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="field-label">Subheading</label>
                                <textarea name="subheading" rows="3" x-model="subheading" class="field-input" style="resize:vertical"
                                    placeholder="Supporting paragraph below heading">{{ old('subheading', $hero->subheading) }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- ── CTA Buttons ──────────────────────────────────────── --}}
                    <div class="card">
                        <div class="card-title">
                            <div class="card-title-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            Call-to-Action Buttons
                        </div>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="field-label">Primary Button Text</label>
                                <input type="text" name="primary_button_text" x-model="primaryBtn"
                                    value="{{ old('primary_button_text', $hero->primary_button_text) }}"
                                    class="field-input" placeholder="Apply Now">
                            </div>
                            <div>
                                <label class="field-label">Primary Button URL</label>
                                <input type="text" name="primary_button_url"
                                    value="{{ old('primary_button_url', $hero->primary_button_url) }}"
                                    class="field-input" placeholder="/admissions or #form">
                            </div>
                            <div>
                                <label class="field-label">Secondary Button Text</label>
                                <input type="text" name="secondary_button_text" x-model="secondaryBtn"
                                    value="{{ old('secondary_button_text', $hero->secondary_button_text) }}"
                                    class="field-input" placeholder="Learn More">
                            </div>
                            <div>
                                <label class="field-label">Secondary Button URL</label>
                                <input type="text" name="secondary_button_url"
                                    value="{{ old('secondary_button_url', $hero->secondary_button_url) }}"
                                    class="field-input" placeholder="/about">
                            </div>
                        </div>
                    </div>

                    {{-- ── Background Image ─────────────────────────────────── --}}
                    <div class="card">
                        <div class="card-title">
                            <div class="card-title-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            Background Image
                        </div>

                        @if ($hero->bg_image_path)
                            <div class="flex items-center gap-4 mb-5 p-4 rounded-xl border"
                                style="background:#F8FAFC;border-color:#E2E8F0">
                                <img src="{{ $hero->bgImageUrl() }}"
                                    class="w-24 h-16 rounded-xl object-cover border border-gray-200 shadow-sm">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800 text-sm"
                                        style="font-family:'Plus Jakarta Sans',sans-serif">
                                        Current background image
                                    </p>
                                    <p class="text-xs text-gray-400 mt-0.5"
                                        style="font-family:'Plus Jakarta Sans',sans-serif">
                                        Upload a new image below to replace it
                                    </p>
                                </div>
                                {{-- FIX 5: button submits the SEPARATE remove-image-form, not the main form --}}
                                <button type="submit" form="remove-image-form"
                                    class="text-xs font-bold text-red-500 hover:text-red-700 px-4 py-2 rounded-lg border border-red-200 hover:bg-red-50 transition-colors flex-shrink-0">
                                    Remove
                                </button>
                            </div>
                        @endif

                        <div class="space-y-5">
                            <div>
                                <label class="field-label">
                                    Upload New Background
                                    <span class="text-gray-400 font-normal normal-case tracking-normal ml-1">(JPG/PNG/WebP,
                                        max 4MB)</span>
                                </label>
                                <label for="bg-image-input"
                                    class="flex flex-col items-center justify-center border-2 border-dashed border-gray-200 rounded-xl p-8 text-center cursor-pointer hover:border-yellow-400 hover:bg-yellow-50/30 transition-all">
                                    <svg class="w-9 h-9 mb-2 text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    <p class="text-gray-400 text-sm font-semibold" id="bg-file-label"
                                        style="font-family:'Plus Jakarta Sans',sans-serif">
                                        Click to upload background image
                                    </p>
                                    <p class="text-gray-300 text-xs mt-1"
                                        style="font-family:'Plus Jakarta Sans',sans-serif">
                                        Recommended: 1920×1080px or wider
                                    </p>
                                    <input type="file" id="bg-image-input" name="bg_image"
                                        accept="image/jpeg,image/png,image/webp" class="sr-only"
                                        onchange="
                                           const name = this.files[0]?.name;
                                           document.getElementById('bg-file-label').textContent = name || 'Click to upload background image';
                                       ">
                                </label>
                            </div>

                            {{--
                            FIX 1 (CORE): opacity range stays 0–1.
                            x-model binds to `opacity` (0.00–1.00).
                            The HIDDEN input submits the raw float to the controller.
                            We display it as percentage via opacityDisplay() helper.
                            NO Math.round(opacity*100) in init() — that was the bug.
                        --}}
                            <div>
                                <label class="field-label">
                                    Image Opacity:
                                    <strong x-text="opacityDisplay()" class="text-gray-700 ml-1"></strong>
                                </label>
                                {{-- Hidden input submits the real 0–1 float --}}
                                <input type="hidden" name="bg_image_opacity" :value="opacity">
                                {{-- Visible range, x-model on opacity (0–1) --}}
                                <input type="range" min="0" max="1" step="0.01" x-model="opacity"
                                    class="w-full mt-2" style="accent-color:#C9A227">
                                <div class="flex justify-between text-xs text-gray-300 mt-1"
                                    style="font-family:'Plus Jakarta Sans',sans-serif">
                                    <span>Hidden (0)</span>
                                    <span>Full (1)</span>
                                </div>
                                <p class="field-hint">How visible the image is beneath the overlay. 0.2–0.35 gives the best
                                    dark hero look.</p>
                            </div>

                            <div>
                                <label class="field-label">Overlay Style</label>
                                <div class="radio-group">
                                    @foreach (['dark' => '🌑 Dark (default)', 'light' => '☀️ Light', 'gold' => '✨ Gold tint'] as $val => $label)
                                        <label class="radio-opt">
                                            <input type="radio" name="bg_overlay_style" value="{{ $val }}"
                                                x-model="overlay"
                                                {{ old('bg_overlay_style', $hero->bg_overlay_style) === $val ? 'checked' : '' }}>
                                            <span>{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ── Stats Strip ──────────────────────────────────────── --}}
                    {{--
                    FIX 6: Stats are in their OWN x-data scope but inside the main <form>,
                    so inputs are submitted correctly. The nested scope is isolated from
                    heroEditor but that's fine — stats don't affect the preview.
                --}}
                    <div class="card" x-data="{
                        stats: @js(old('stats', $hero->stats ?? [])),
                        addStat() { this.stats.push({ value: '', label: '' }); },
                        removeStat(i) { this.stats.splice(i, 1); }
                    }">
                        <div class="card-title">
                            <div class="card-title-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            Stats Strip
                            <span class="text-xs text-gray-400 font-normal ml-auto"
                                style="font-family:'Plus Jakarta Sans',sans-serif">
                                Shown below hero CTAs (optional)
                            </span>
                        </div>

                        <div class="space-y-3 mb-4">
                            <template x-for="(stat, i) in stats" :key="i">
                                <div class="flex gap-3 items-center">
                                    <div class="flex-shrink-0 w-7 h-7 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-400"
                                        x-text="i + 1"></div>
                                    <input type="text" :name="`stats[${i}][value]`" x-model="stat.value"
                                        class="field-input" style="max-width:110px" placeholder="500+" maxlength="20">
                                    <input type="text" :name="`stats[${i}][label]`" x-model="stat.label"
                                        class="field-input" placeholder="Students" maxlength="40">
                                    <button type="button" @click="removeStat(i)"
                                        class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg border border-red-200 text-red-400 hover:bg-red-50 hover:text-red-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>

                        <div x-show="stats.length === 0"
                            class="text-gray-400 text-sm text-center py-4 border border-dashed border-gray-200 rounded-xl mb-4"
                            style="font-family:'Plus Jakarta Sans',sans-serif">
                            No stats yet — add one below
                        </div>

                        <button type="button" @click="addStat()" :disabled="stats.length >= 6"
                            class="flex items-center gap-2 text-sm font-semibold transition-colors disabled:opacity-40"
                            style="color:#C9A227;font-family:'Plus Jakarta Sans',sans-serif">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Add stat <span class="text-gray-300 font-normal" x-text="`(${stats.length}/6)`"></span>
                        </button>
                    </div>

                    {{-- ── SEO ──────────────────────────────────────────────── --}}
                    <div class="card">
                        <div class="card-title">
                            <div class="card-title-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            SEO
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="field-label">Meta Title</label>
                                <input type="text" name="meta_title"
                                    value="{{ old('meta_title', $hero->meta_title) }}" class="field-input"
                                    maxlength="120" placeholder="Page title for search engines">
                            </div>
                            <div>
                                <label class="field-label">Meta Description</label>
                                <textarea name="meta_description" rows="2" class="field-input" style="resize:none" maxlength="320"
                                    placeholder="Brief page description for search engines (max 320 chars)">{{ old('meta_description', $hero->meta_description) }}</textarea>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- ═══ RIGHT SIDEBAR ══════════════════════════════════════ --}}
                <div class="space-y-6">

                    {{-- ── Status & Save ───────────────────────────────────── --}}
                    <div class="card">
                        <div class="card-title">
                            <div class="card-title-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            Status
                        </div>

                        <div class="mb-5">
                            {{-- FIX 7: hidden + checkbox pattern for boolean — checkbox must come AFTER hidden --}}
                            <input type="hidden" name="is_active" value="0">
                            <label class="toggle">
                                <input type="checkbox" name="is_active" value="1"
                                    {{ old('is_active', $hero->is_active) ? 'checked' : '' }}>
                                <div class="toggle-track"></div>
                                <span class="text-sm font-medium text-gray-700"
                                    style="font-family:'Plus Jakarta Sans',sans-serif">
                                    Active / Visible on website
                                </span>
                            </label>
                        </div>

                        <button type="submit"
                            class="w-full py-3.5 rounded-xl text-white text-sm font-bold flex items-center justify-center gap-2 transition-all hover:-translate-y-0.5 active:scale-95 shadow-sm"
                            style="background:#1B2A4A;font-family:'Plus Jakarta Sans',sans-serif">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Save Hero
                        </button>

                        <a href="{{ route('admin.heroes.index') }}"
                            class="flex items-center justify-center w-full mt-3 py-2.5 rounded-xl border border-gray-200 text-gray-500 text-sm font-medium hover:border-gray-400 hover:text-gray-700 transition-colors"
                            style="font-family:'Plus Jakarta Sans',sans-serif">
                            Cancel
                        </a>
                    </div>

                    {{-- ── Appearance ───────────────────────────────────────── --}}
                    <div class="card">
                        <div class="card-title" style="margin-bottom:20px">
                            <div class="card-title-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm0 8a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zm12 0a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                                </svg>
                            </div>
                            Appearance
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="field-label">Badge Style</label>
                                <div class="radio-group">
                                    {{-- FIX 8: x-model badgeStyleVal so preview updates when radio changes --}}
                                    <label class="radio-opt">
                                        <input type="radio" name="badge_style" value="white" x-model="badgeStyleVal"
                                            {{ old('badge_style', $hero->badge_style) === 'white' ? 'checked' : '' }}>
                                        <span>White</span>
                                    </label>
                                    <label class="radio-opt">
                                        <input type="radio" name="badge_style" value="gold" x-model="badgeStyleVal"
                                            {{ old('badge_style', $hero->badge_style) === 'gold' ? 'checked' : '' }}>
                                        <span>Gold</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="field-label">Text Alignment</label>
                                <div class="radio-group">
                                    <label class="radio-opt">
                                        <input type="radio" name="text_align" value="center" x-model="textAlign"
                                            {{ old('text_align', $hero->text_align) === 'center' ? 'checked' : '' }}>
                                        <span>Center</span>
                                    </label>
                                    <label class="radio-opt">
                                        <input type="radio" name="text_align" value="left" x-model="textAlign"
                                            {{ old('text_align', $hero->text_align) === 'left' ? 'checked' : '' }}>
                                        <span>Left</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="field-label">Min Height</label>
                                <select name="min_height" class="field-input" x-model="minHeight">
                                    @foreach (['56vh' => '56vh — Compact', '68vh' => '68vh — Standard', '72vh' => '72vh — Tall', '80vh' => '80vh — Extra tall', '90vh' => '90vh — Near full', '100dvh' => '100dvh — Full screen'] as $h => $label)
                                        <option value="{{ $h }}"
                                            {{ old('min_height', $hero->min_height) === $h ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <input type="hidden" name="show_rings" value="0">
                                <label class="toggle">
                                    <input type="checkbox" name="show_rings" value="1"
                                        x-model="showRings"
                                        {{ old('show_rings', $hero->show_rings) ? 'checked' : '' }}>
                                    <div class="toggle-track"></div>
                                    <span class="text-sm font-medium text-gray-600"
                                        style="font-family:'Plus Jakarta Sans',sans-serif">
                                        Show decorative rings
                                    </span>
                                </label>
                                <p class="field-hint mt-2">Subtle circle decorations in the top-right corner of the hero
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- ── Quick Reference ─────────────────────────────────── --}}
                    <div class="rounded-xl p-5 border text-xs space-y-2"
                        style="background:#F8FAFC;border-color:#E2E8F0;font-family:'Plus Jakarta Sans',sans-serif;color:#64748B">
                        <p class="font-bold text-gray-700 mb-3">💡 Tips</p>
                        <p>• Opacity <strong>0.20–0.35</strong> looks best for dark hero backgrounds</p>
                        <p>• Leave badge blank to hide the pill entirely</p>
                        <p>• Stats only show if at least one is added with a value</p>
                        <p>• Toggle <strong>Live Preview</strong> at top to see changes in real time</p>
                    </div>

                </div>
            </div>
        </form>

    </div>
@endsection

@push('scripts')
    <script>
        /*
         * FIX SUMMARY:
         * 1. opacity stays 0–1 in JS. Display via opacityDisplay(). Hidden input submits raw float.
         * 2. Live preview toggle uses x-model="showPreview" (same Alpine scope).
         * 3. badgeStyleVal x-model on radios so preview badge style updates live.
         * 4. @@js() instead of @@json() — cleaner escaping.
         * 5. Remove-image button uses form="remove-image-form" attribute (separate form).
         * 6. Stats x-data nested inside main form — inputs submit correctly.
         * 7. hidden+checkbox ordering: hidden BEFORE checkbox (standard Laravel boolean pattern).
         * 8. x-cloak removed from preview wrapper — x-show handles visibility.
         */

        // Fix old opacity values > 1 that may have been saved by the buggy version
        document.addEventListener('alpine:init', () => {
            // No action needed — PageHero model clamps via cast. But if DB has 22 instead of 0.22,
            // run: php artisan tinker -> PageHero::all()->each(fn($h) => $h->bg_image_opacity > 1 ? $h->update(['bg_image_opacity' => $h->bg_image_opacity / 100]) : null)
        });
    </script>
@endpush
