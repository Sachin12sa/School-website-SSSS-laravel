@extends('admin.layouts.admin')
@section('title', $post->exists ? 'Edit Post' : 'New Post')
@section('content')
    <div class="max-w-4xl">
        <form action="{{ $post->exists ? route('admin.news.update', $post) : route('admin.news.store') }}" method="POST"
            enctype="multipart/form-data" class="space-y-6">
            @csrf @if ($post->exists)
                @method('PUT')
            @endif
            <div class="grid lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm p-6 space-y-5">
                        <div><label class="block text-sm font-semibold text-navy mb-2">Title <span
                                    class="text-red-400">*</span></label>
                            <input type="text" name="title" value="{{ old('title', $post->title) }}" required
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold text-sm">
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div><label class="block text-sm font-semibold text-navy mb-2">Slug</label>
                            <input type="text" name="slug" value="{{ old('slug', $post->slug) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold text-sm font-mono text-gray-500"
                                placeholder="auto-generated-from-title">
                        </div>
                        <div><label class="block text-sm font-semibold text-navy mb-2">Excerpt</label>
                            <textarea name="excerpt" rows="2"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold text-sm resize-none">{{ old('excerpt', $post->excerpt) }}</textarea>
                        </div>
                        <div><label class="block text-sm font-semibold text-navy mb-2">Body <span
                                    class="text-red-400">*</span></label>
                            <textarea name="body" id="body" rows="14"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold text-sm">{{ old('body', $post->body) }}</textarea>
                            @error('body')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-sm p-6 space-y-5">
                        <h3 class="font-semibold text-navy">SEO</h3>
                        <div><label class="block text-sm font-semibold text-navy mb-2">Meta Title</label><input
                                type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold text-sm">
                        </div>
                        <div><label class="block text-sm font-semibold text-navy mb-2">Meta Description</label>
                            <textarea name="meta_description" rows="2"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold text-sm resize-none">{{ old('meta_description', $post->meta_description) }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm p-6 space-y-4">
                        <h3 class="font-semibold text-navy">Publish</h3>
                        <div class="flex items-center justify-between"><label
                                class="text-sm font-medium text-gray-700">Status</label>
                            <label class="relative inline-flex items-center cursor-pointer"><input type="checkbox"
                                    name="is_published" value="1"
                                    {{ old('is_published', $post->is_published) ? 'checked' : '' }} class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-navy peer-checked:after:translate-x-full after:absolute after:top-0.5 after:left-0.5 after:bg-white after:w-5 after:h-5 after:rounded-full after:transition-all">
                                </div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between"><label
                                class="text-sm font-medium text-gray-700">Featured</label>
                            <label class="relative inline-flex items-center cursor-pointer"><input type="checkbox"
                                    name="is_featured" value="1"
                                    {{ old('is_featured', $post->is_featured) ? 'checked' : '' }} class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-gold peer-checked:after:translate-x-full after:absolute after:top-0.5 after:left-0.5 after:bg-white after:w-5 after:h-5 after:rounded-full after:transition-all">
                                </div>
                            </label>
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-2">Publish Date</label><input
                                type="datetime-local" name="published_at"
                                value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}"
                                class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gold/40">
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-2">Category</label><input
                                type="text" name="category" value="{{ old('category', $post->category) }}"
                                class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gold/40">
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <h3 class="font-semibold text-navy mb-4">Featured Image</h3>
                        @if ($post->image)
                            <img src="{{ $post->image_url }}" class="w-full rounded-xl mb-3 object-cover h-32">
                        @endif
                        <input type="file" name="image" accept="image/*"
                            class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-navy file:text-white file:text-sm file:font-semibold hover:file:bg-gold file:transition-colors cursor-pointer">
                    </div>
                    <div class="flex gap-3">
                        <button type="submit"
                            class="flex-1 bg-navy hover:bg-gold text-white font-semibold py-3 rounded-xl transition-colors text-sm">{{ $post->exists ? 'Update' : 'Create' }}
                            Post</button>
                        <a href="{{ route('admin.news.index') }}"
                            class="px-4 py-3 border border-gray-200 text-gray-600 rounded-xl text-sm hover:bg-gray-50 transition-colors">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
