@extends('admin.layouts.admin')
@section('title', 'Homepage Blocks')
@section('content')
    <p class="text-slate-500 text-sm mb-6">Manage the sections that appear on your homepage. Toggle visibility or edit
        content for each block.</p>
    <div class="space-y-3" id="blocks-list">
        @forelse($blocks as $block)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5" x-data="{ editing: false }">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0"
                            style="background: {{ $block->is_visible ? '#1B2A4A' : '#f1f5f9' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                style="color: {{ $block->is_visible ? '#C9A227' : '#94a3b8' }}">
                                @php
                                    $icons = [
                                        'hero' =>
                                            'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z',
                                        'stats' =>
                                            'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                                        'about_intro' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                                        'news_feed' =>
                                            'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z',
                                        'events_feed' =>
                                            'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                                        'testimonial_slider' =>
                                            'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z',
                                        'cta_banner' =>
                                            'M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z',
                                    ];
                                @endphp
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $icons[$block->type] ?? 'M4 6h16M4 12h16M4 18h16' }}" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-display font-bold text-navy-900 text-sm capitalize">
                                {{ str_replace('_', ' ', $block->type) }}</p>
                            <p class="text-slate-400 text-xs mt-0.5">
                                {{ $block->title ? Str::limit($block->title, 50) : 'No title set' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 shrink-0">
                        <span
                            class="text-xs px-2.5 py-1 rounded-full font-bold {{ $block->is_visible ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-400' }}">{{ $block->is_visible ? 'Visible' : 'Hidden' }}</span>
                        <button @click="editing=!editing"
                            class="p-2 text-slate-400 hover:text-navy-900 hover:bg-slate-100 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div x-show="editing" x-cloak x-transition class="mt-5 pt-5 border-t border-slate-100">
                    <form action="{{ route('admin.blocks.update', $block->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-4">
                        @csrf @method('PUT')
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div><label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">Title</label>
                                <input type="text" name="title" value="{{ $block->title }}"
                                    class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                            </div>
                            <div><label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">Subtitle</label>
                                <input type="text" name="subtitle" value="{{ $block->subtitle }}"
                                    class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                            </div>
                        </div>
                        @if (in_array($block->type, ['hero', 'about_intro', 'cta_banner']))
                            <div><label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">Content</label>
                                <textarea name="content" rows="4"
                                    class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-gold-500/30">{{ $block->content }}</textarea>
                            </div>
                            <div class="grid sm:grid-cols-2 gap-4">
                                <div><label
                                        class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">Button
                                        Text</label><input type="text" name="button_text"
                                        value="{{ $block->button_text }}"
                                        class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                                </div>
                                <div><label
                                        class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">Button
                                        URL</label><input type="text" name="button_url" value="{{ $block->button_url }}"
                                        class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                                </div>
                            </div>
                        @endif
                        @if ($block->type === 'stats')
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                @foreach (['students' => 'Students', 'teachers' => 'Teachers', 'years' => 'Years', 'programmes' => 'Programmes'] as $k => $label)
                                    <div><label
                                            class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">{{ $label }}</label>
                                        <input type="text" name="extra[{{ $k }}]"
                                            value="{{ $block->extra[$k] ?? '' }}"
                                            class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30"
                                            placeholder="e.g. 1,200+">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">Background
                                Image</label>
                            @if ($block->image_path)
                                <img src="{{ $block->image_url }}" class="h-16 rounded-lg mb-2 object-cover">
                            @endif
                            <input type="file" name="image_path" accept="image/*"
                                class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-navy-900 file:text-white file:text-xs file:font-semibold hover:file:bg-gold-500 file:transition-colors cursor-pointer">
                        </div>
                        <div class="flex items-center gap-3">
                            <label class="text-sm font-medium text-slate-700">Visible on homepage</label>
                            <label class="relative inline-flex items-center cursor-pointer"><input type="checkbox"
                                    name="is_visible" value="1" {{ $block->is_visible ? 'checked' : '' }}
                                    class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full after:absolute after:top-0.5 after:left-0.5 after:bg-white after:w-5 after:h-5 after:rounded-full after:transition-all peer-checked:bg-navy-900">
                                </div>
                            </label>
                        </div>
                        <div class="flex gap-3">
                            <button type="submit"
                                class="bg-navy-900 hover:bg-gold-500 text-white font-semibold px-6 py-2.5 rounded-xl transition-colors text-sm">Save
                                Changes</button>
                            <button type="button" @click="editing=false"
                                class="px-4 py-2.5 border border-slate-200 text-slate-600 rounded-xl text-sm hover:bg-slate-50">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl p-12 text-center text-slate-400 border border-slate-100">No homepage blocks
                found. Run <code class="bg-slate-100 px-2 py-0.5 rounded text-xs">php artisan db:seed</code> to create them.
            </div>
        @endforelse
    </div>
@endsection
