@extends('admin.layouts.admin')
@section('title', $gallery->exists ? 'Edit Album: ' . $gallery->name : 'New Album')
@section('content')
    <div class="max-w-4xl space-y-6">
        {{-- Album details --}}
        <form action="{{ $gallery->exists ? route('admin.gallery.update', $gallery) : route('admin.gallery.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf @if ($gallery->exists)
                @method('PUT')
            @endif
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-5">
                <h2 class="font-display font-bold text-navy-900 text-lg">Album Details</h2>
                <div class="grid sm:grid-cols-2 gap-5">
                    <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Album Name <span
                                class="text-red-400">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $gallery->name) }}" required
                            class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Cover
                            Image</label>
                        @if ($gallery->cover_image)
                            <img src="{{ $gallery->cover_url }}" class="h-10 rounded-lg mb-2 object-cover">
                        @endif
                        <input type="file" name="cover_image" accept="image/*"
                            class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-navy-900 file:text-white file:text-xs file:font-semibold hover:file:bg-gold-500 file:transition-colors cursor-pointer">
                    </div>
                </div>
                <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Description</label>
                    <textarea name="description" rows="2"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-gold-500/30">{{ old('description', $gallery->description) }}</textarea>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3"><label class="text-sm font-medium text-slate-700">Published</label>
                        <label class="relative inline-flex items-center cursor-pointer"><input type="checkbox"
                                name="is_published" value="1"
                                {{ old('is_published', $gallery->is_published ?? true) ? 'checked' : '' }}
                                class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full after:absolute after:top-0.5 after:left-0.5 after:bg-white after:w-5 after:h-5 after:rounded-full after:transition-all peer-checked:bg-navy-900">
                            </div>
                        </label>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit"
                            class="bg-navy-900 hover:bg-gold-500 text-white font-semibold px-6 py-2.5 rounded-xl transition-colors text-sm">{{ $gallery->exists ? 'Update Album' : 'Create Album' }}</button>
                        <a href="{{ route('admin.gallery.index') }}"
                            class="px-4 py-2.5 border border-slate-200 text-slate-600 rounded-xl text-sm hover:bg-slate-50">Cancel</a>
                    </div>
                </div>
            </div>
        </form>

        @if ($gallery->exists)
            {{-- Upload more images --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <h2 class="font-display font-bold text-navy-900 text-lg mb-5">Upload Photos</h2>
                <form action="{{ route('admin.gallery.images.upload', $gallery) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div
                        class="border-2 border-dashed border-slate-200 rounded-xl p-8 text-center hover:border-gold-500 transition-colors">
                        <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <input type="file" name="images[]" multiple accept="image/*"
                            class="w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-navy-900 file:text-white file:text-sm file:font-semibold hover:file:bg-gold-500 file:transition-colors cursor-pointer">
                        <p class="text-slate-400 text-xs mt-2">Select multiple images at once. Max 5MB each.</p>
                    </div>
                    <button type="submit"
                        class="bg-navy-900 hover:bg-gold-500 text-white font-semibold px-6 py-2.5 rounded-xl transition-colors text-sm">Upload
                        Images</button>
                </form>
            </div>

            {{-- Existing images --}}
            @if ($gallery->images->count())
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <h2 class="font-display font-bold text-navy-900 text-lg mb-5">Photos ({{ $gallery->images->count() }})
                    </h2>
                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3">
                        @foreach ($gallery->images as $img)
                            <div class="relative group aspect-square">
                                <img src="{{ $img->url }}" class="w-full h-full object-cover rounded-xl">
                                <div
                                    class="absolute inset-0 bg-black/0 group-hover:bg-black/40 rounded-xl transition-colors flex items-center justify-center">
                                    <form action="{{ route('admin.gallery.images.destroy', $img) }}" method="POST"
                                        onsubmit="return confirm('Delete?')"
                                        class="opacity-0 group-hover:opacity-100 transition-opacity">@csrf @method('DELETE')
                                        <button
                                            class="w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors"><svg
                                                class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg></button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
    </div>
@endsection
