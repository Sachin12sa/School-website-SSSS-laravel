@extends('admin.layouts.admin')
@section('title', $section->exists ? 'Edit Section — ' . $pageTitle : 'Add Section — ' . $pageTitle)

@section('content')
    <div class="max-w-3xl">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('admin.sections.index', $pageKey) }}"
                class="p-2 text-slate-400 hover:text-navy-900 hover:bg-slate-100 rounded-xl transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <p class="text-xs text-slate-400">{{ $pageTitle }}</p>
                <h1 class="font-display font-bold text-navy-900 text-xl">
                    {{ $section->exists ? 'Edit Section' : 'Add New Section' }}
                </h1>
            </div>
        </div>

        <form
            action="{{ $section->exists
                ? route('admin.sections.update', [$pageKey, $section])
                : route('admin.sections.store', $pageKey) }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-5">
            @csrf
            @if ($section->exists)
                @method('PUT')
            @endif

            {{-- Basic Info --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-5">
                <h2 class="font-display font-bold text-navy-900 text-lg">Section Details</h2>

                {{-- Layout --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">
                        Layout <span class="text-red-400">*</span>
                    </label>
                    <select name="layout" required
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30 bg-white">
                        @foreach ([
                            'default'     => 'Default (text only)',
                            'image-left'  => 'Image Left + Text Right',
                            'image-right' => 'Image Right + Text Left',
                            'full-image'  => 'Full-width Image with Overlay',
                            'cards'       => 'Card Grid',
                            'list'        => 'Bullet List',
                        ] as $val => $label)
                            <option value="{{ $val }}"
                                {{ old('layout', $section->layout ?? 'default') === $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('layout')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid sm:grid-cols-2 gap-5">
                    {{-- Title --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Title</label>
                        <input type="text" name="title" value="{{ old('title', $section->title) }}"
                            placeholder="Section heading"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                        @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Subtitle --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Subtitle</label>
                        <input type="text" name="subtitle" value="{{ old('subtitle', $section->subtitle) }}"
                            placeholder="Short description under the title"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                    </div>
                </div>

                {{-- Content --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Content</label>
                    <textarea name="content" rows="6" placeholder="Main section content (HTML allowed)…"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm resize-y focus:outline-none focus:ring-2 focus:ring-gold-500/30 font-mono">{{ old('content', $section->content) }}</textarea>
                    <p class="text-slate-400 text-xs mt-1">HTML tags are supported for rich formatting.</p>
                </div>
            </div>

            {{-- Badge & Image --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-5">
                <h2 class="font-display font-bold text-navy-900 text-lg">Badge & Image</h2>

                <div class="grid sm:grid-cols-2 gap-5">
                    {{-- Badge Text --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Badge Text</label>
                        <input type="text" name="badge_text" value="{{ old('badge_text', $section->badge_text) }}"
                            placeholder="e.g. Grades 1–5"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                        <p class="text-slate-400 text-xs mt-1">Small colored badge displayed above the title.</p>
                    </div>

                    {{-- Badge Color --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Badge Color</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="badge_color"
                                value="{{ old('badge_color', $section->badge_color ?? '#C9A227') }}"
                                class="w-12 h-10 rounded-lg border border-slate-200 cursor-pointer p-1">
                            <input type="text" value="{{ old('badge_color', $section->badge_color ?? '#C9A227') }}"
                                class="flex-1 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none"
                                readonly>
                        </div>
                    </div>
                </div>

                {{-- Image --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Section Image</label>
                    @if ($section->image_url)
                        <div class="mb-3">
                            <img src="{{ $section->image_url }}" class="h-32 rounded-xl object-cover border border-slate-200"
                                alt="Current image">
                            <p class="text-xs text-slate-400 mt-1">Current image — upload a new one to replace it.</p>
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/*"
                        class="w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-navy-900 file:text-white file:text-sm file:font-semibold hover:file:bg-gold-500 file:transition-colors cursor-pointer">
                    <p class="text-slate-400 text-xs mt-1">Recommended: 1200×600px, max 5MB.</p>
                </div>
            </div>

            {{-- CTA & Settings --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-5">
                <h2 class="font-display font-bold text-navy-900 text-lg">Call-to-Action & Settings</h2>

                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Button Text</label>
                        <input type="text" name="button_text" value="{{ old('button_text', $section->button_text) }}"
                            placeholder="e.g. Learn More"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Button URL</label>
                        <input type="text" name="button_url" value="{{ old('button_url', $section->button_url) }}"
                            placeholder="e.g. /admissions or https://…"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <label class="text-sm font-medium text-slate-700">Published</label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_published" value="1"
                                {{ old('is_published', $section->is_published ?? true) ? 'checked' : '' }}
                                class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full
                                after:absolute after:top-0.5 after:left-0.5 after:bg-white after:w-5 after:h-5
                                after:rounded-full after:transition-all peer-checked:bg-navy-900"></div>
                        </label>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Order</label>
                        <input type="number" name="order" value="{{ old('order', $section->order ?? 0) }}" min="0"
                            class="w-24 border border-slate-200 rounded-xl px-3 py-2 text-sm text-center focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3">
                <button type="submit"
                    class="bg-navy-900 hover:bg-gold-500 text-white font-bold px-6 py-3 rounded-xl transition-colors text-sm shadow-sm">
                    {{ $section->exists ? 'Update Section' : 'Add Section' }}
                </button>
                <a href="{{ route('admin.sections.index', $pageKey) }}"
                    class="px-5 py-3 border border-slate-200 text-slate-600 rounded-xl text-sm hover:bg-slate-50 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
