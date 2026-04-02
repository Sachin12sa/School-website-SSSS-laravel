@extends('admin.layouts.admin')
@section('title', $event->exists ? 'Edit Event' : 'New Event')
@section('content')
    <div class="max-w-4xl">
        <form action="{{ $event->exists ? route('admin.events.update', $event) : route('admin.events.store') }}"
            method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf @if ($event->exists)
                @method('PUT')
            @endif
            <div class="grid lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-5">
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-5">
                        <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Title <span
                                    class="text-red-400">*</span></label>
                            <input type="text" name="title" value="{{ old('title', $event->title) }}" required
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 text-sm transition-colors">
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Short
                                Description</label>
                            <textarea name="description" rows="2"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 text-sm resize-none">{{ old('description', $event->description) }}</textarea>
                        </div>
                        <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Full Body
                                (optional)</label>
                            <textarea name="body" rows="8"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 text-sm">{{ old('body', $event->body) }}</textarea>
                        </div>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div><label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Location</label>
                                <input type="text" name="location" value="{{ old('location', $event->location) }}"
                                    class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 text-sm">
                            </div>
                            <div><label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Organizer</label>
                                <input type="text" name="organizer" value="{{ old('organizer', $event->organizer) }}"
                                    class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500 text-sm">
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-4">
                        <h3 class="font-display font-bold text-navy-900">SEO</h3>
                        <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Meta
                                Title</label><input type="text" name="meta_title"
                                value="{{ old('meta_title', $event->meta_title) }}"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gold-500/30 text-sm">
                        </div>
                        <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Meta
                                Description</label>
                            <textarea name="meta_description" rows="2"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gold-500/30 text-sm resize-none">{{ old('meta_description', $event->meta_description) }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="space-y-5">
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-4">
                        <h3 class="font-display font-bold text-navy-900">Scheduling</h3>
                        <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Start Date &
                                Time <span class="text-red-400">*</span></label>
                            <input type="datetime-local" name="start_date"
                                value="{{ old('start_date', $event->start_date?->format('Y-m-d\TH:i')) }}" required
                                class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                            @error('start_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">End Date &
                                Time</label>
                            <input type="datetime-local" name="end_date"
                                value="{{ old('end_date', $event->end_date?->format('Y-m-d\TH:i')) }}"
                                class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                        </div>
                        <div class="flex items-center justify-between pt-2">
                            <label class="text-sm font-medium text-slate-700">Published</label>
                            <label class="relative inline-flex items-center cursor-pointer"><input type="checkbox"
                                    name="is_published" value="1"
                                    {{ old('is_published', $event->is_published) ? 'checked' : '' }} class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full after:absolute after:top-0.5 after:left-0.5 after:bg-white after:w-5 after:h-5 after:rounded-full after:transition-all peer-checked:bg-navy-900">
                                </div>
                            </label>
                        </div>
                        <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Slug (auto
                                from title)</label>
                            <input type="text" name="slug" value="{{ old('slug', $event->slug) }}"
                                class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm font-mono text-slate-400 focus:outline-none focus:ring-2 focus:ring-gold-500/30"
                                placeholder="auto-generated">
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                        <h3 class="font-display font-bold text-navy-900 mb-4">Cover Image</h3>
                        @if ($event->image)
                            <img src="{{ $event->image_url }}" class="w-full rounded-xl mb-3 object-cover h-32">
                        @endif
                        <input type="file" name="image" accept="image/*"
                            class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-navy-900 file:text-white file:text-xs file:font-semibold hover:file:bg-gold-500 file:transition-colors cursor-pointer">
                    </div>
                    <div class="flex gap-3">
                        <button type="submit"
                            class="flex-1 bg-navy-900 hover:bg-gold-500 text-white font-semibold py-3 rounded-xl transition-colors text-sm shadow-sm">{{ $event->exists ? 'Update' : 'Create' }}</button>
                        <a href="{{ route('admin.events.index') }}"
                            class="px-4 py-3 border border-slate-200 text-slate-600 rounded-xl text-sm hover:bg-slate-50 transition-colors">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
