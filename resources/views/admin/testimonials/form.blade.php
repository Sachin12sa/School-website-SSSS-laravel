@extends('admin.layouts.admin')
@section('title', $testimonial->exists ? 'Edit Testimonial' : 'Add Testimonial')
@section('content')
    <div class="max-w-2xl">
        <form
            action="{{ $testimonial->exists ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf @if ($testimonial->exists)
                @method('PUT')
            @endif
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-5">
                <div class="grid sm:grid-cols-2 gap-5">
                    <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Author Name <span
                                class="text-red-400">*</span></label>
                        <input type="text" name="author_name" value="{{ old('author_name', $testimonial->author_name) }}"
                            required
                            class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                    </div>
                    <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Role /
                            Title</label>
                        <input type="text" name="author_role" value="{{ old('author_role', $testimonial->author_role) }}"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30"
                            placeholder="e.g. Parent of Year 9 Student">
                    </div>
                </div>
                <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Testimonial Text
                        <span class="text-red-400">*</span></label>
                    <textarea name="content" rows="5" required
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-gold-500/30">{{ old('content', $testimonial->content) }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="grid sm:grid-cols-3 gap-5">
                    <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Rating</label>
                        <select name="rating"
                            class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                            @for ($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}"
                                    {{ old('rating', $testimonial->rating ?? 5) == $i ? 'selected' : '' }}>
                                    {{ $i }} stars
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Order</label>
                        <input type="number" name="order" value="{{ old('order', $testimonial->order ?? 0) }}"
                            class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                    </div>
                    <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Photo</label>
                        <input type="file" name="photo" accept="image/*"
                            class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-2 file:rounded-lg file:border-0 file:bg-navy-900 file:text-white file:text-xs cursor-pointer">
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-2"><input type="checkbox" name="is_featured" value="1"
                            {{ old('is_featured', $testimonial->is_featured) ? 'checked' : '' }} id="featured"
                            class="rounded border-slate-300"><label for="featured"
                            class="text-sm font-medium text-slate-700">Featured on homepage</label></div>
                    <div class="flex items-center gap-2"><input type="checkbox" name="is_published" value="1"
                            {{ old('is_published', $testimonial->is_published ?? true) ? 'checked' : '' }} id="published"
                            class="rounded border-slate-300"><label for="published"
                            class="text-sm font-medium text-slate-700">Published</label></div>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="bg-navy-900 hover:bg-gold-500 text-white font-semibold px-6 py-3 rounded-xl transition-colors text-sm">{{ $testimonial->exists ? 'Update' : 'Add Testimonial' }}</button>
                    <a href="{{ route('admin.testimonials.index') }}"
                        class="px-5 py-3 border border-slate-200 text-slate-600 rounded-xl text-sm hover:bg-slate-50">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
