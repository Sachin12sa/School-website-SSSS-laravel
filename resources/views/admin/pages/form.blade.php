@extends('admin.layouts.admin')
@section('title', $page->exists ? 'Edit Page' : 'New Page')
@section('content')
    <div class="max-w-4xl">
        <form action="{{ $page->exists ? route('admin.pages.update', $page) : route('admin.pages.store') }}" method="POST"
            enctype="multipart/form-data" class="space-y-6">
            @csrf @if ($page->exists)
                @method('PUT')
            @endif
            <div class="grid lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-5">
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-5">
                        <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Page Title
                                <span class="text-red-400">*</span></label>
                            <input type="text" name="title" value="{{ old('title', $page->title) }}" required
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500">
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Slug</label>
                            <input type="text" name="slug" value="{{ old('slug', $page->slug) }}"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm font-mono text-slate-400 focus:outline-none focus:ring-2 focus:ring-gold-500/30"
                                placeholder="auto-generated-from-title">
                        </div>
                        <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Hero
                                Heading</label>
                            <input type="text" name="hero_title" value="{{ old('hero_title', $page->hero_title) }}"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                        </div>
                        <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Hero
                                Subtitle</label>
                            <input type="text" name="hero_subtitle"
                                value="{{ old('hero_subtitle', $page->hero_subtitle) }}"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                        </div>
                        <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Page Content
                                (HTML)</label>
                            <textarea name="content" rows="16"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-gold-500/30">{{ old('content', $page->content) }}</textarea>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-4">
                        <h3 class="font-display font-bold text-navy-900">SEO</h3>
                        <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Meta
                                Title</label><input type="text" name="meta_title"
                                value="{{ old('meta_title', $page->meta_title) }}"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                        </div>
                        <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Meta
                                Description</label>
                            <textarea name="meta_description" rows="2"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-gold-500/30">{{ old('meta_description', $page->meta_description) }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="space-y-5">
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-4">
                        <h3 class="font-display font-bold text-navy-900">Settings</h3>
                        <div class="flex items-center justify-between"><label
                                class="text-sm font-medium text-slate-700">Published</label>
                            <label class="relative inline-flex items-center cursor-pointer"><input type="checkbox"
                                    name="is_published" value="1"
                                    {{ old('is_published', $page->is_published) ? 'checked' : '' }} class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full after:absolute after:top-0.5 after:left-0.5 after:bg-white after:w-5 after:h-5 after:rounded-full after:transition-all peer-checked:bg-navy-900">
                                </div>
                            </label>
                        </div>
                        <div><label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Order</label><input
                                type="number" name="order" value="{{ old('order', $page->order ?? 0) }}"
                                class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                        <h3 class="font-display font-bold text-navy-900 mb-3">Hero Image</h3>
                        @if ($page->hero_image)
                            <img src="{{ asset('storage/' . $page->hero_image) }}"
                                class="w-full rounded-xl mb-3 object-cover h-24">
                        @endif
                        <input type="file" name="hero_image" accept="image/*"
                            class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-navy-900 file:text-white file:text-xs file:font-semibold hover:file:bg-gold-500 file:transition-colors cursor-pointer">
                    </div>
                    <div class="flex gap-3">
                        <button type="submit"
                            class="flex-1 bg-navy-900 hover:bg-gold-500 text-white font-semibold py-3 rounded-xl transition-colors text-sm">{{ $page->exists ? 'Update' : 'Create' }}
                            Page</button>
                        <a href="{{ route('admin.pages.index') }}"
                            class="px-4 py-3 border border-slate-200 text-slate-600 rounded-xl text-sm hover:bg-slate-50">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
