@extends('admin.layouts.admin')
@section('title', $post->exists ? 'Edit: ' . $post->title : 'New Article')

@section('content')

    <form action="{{ $post->exists ? route('admin.news.update', $post) : route('admin.news.store') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @if ($post->exists)
            @method('PUT')
        @endif

        <div class="grid lg:grid-cols-3 gap-6">

            {{-- ════════════════════════════════════════════════
             LEFT COLUMN: main content (2/3 width)
        ════════════════════════════════════════════════ --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Title --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">
                        Article Title <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="title" id="title-input" value="{{ old('title', $post->title) }}" required
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-base font-semibold text-slate-800
                              focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold transition-colors
                              @error('title') border-red-300 @enderror"
                        placeholder="Write a clear, engaging headline…" oninput="autoSlug(this.value)">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    {{-- Slug (auto-generated, editable) --}}
                    <div class="mt-3 flex items-center gap-2">
                        <span class="text-slate-400 text-xs shrink-0">URL: /news/</span>
                        <input type="text" name="slug" id="slug-input" value="{{ old('slug', $post->slug) }}"
                            class="flex-1 border-0 border-b border-dashed border-slate-300 text-slate-500 text-xs
                                  focus:outline-none focus:border-gold py-0.5 bg-transparent transition-colors"
                            placeholder="auto-generated-from-title">
                    </div>
                    @error('slug')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Excerpt --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide">
                            Excerpt / Summary
                        </label>
                        <span id="excerpt-count" class="text-xs text-slate-400">0 / 300</span>
                    </div>
                    <textarea name="excerpt" id="excerpt-input" rows="3" maxlength="300"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm resize-none
                                 focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold transition-colors"
                        placeholder="A short summary shown on the news listing page and in search results…"
                        oninput="document.getElementById('excerpt-count').textContent = this.value.length + ' / 300'">{{ old('excerpt', $post->excerpt) }}</textarea>
                    <p class="text-slate-400 text-xs mt-1.5">Shown on the news card grid and in search results. Keep it
                        under 200 characters for best display.</p>
                </div>

                {{-- Article Body --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">
                        Article Body <span class="text-red-400">*</span>
                    </label>
                    <textarea name="body" rows="16" required
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm font-mono resize-y
                                 focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold transition-colors
                                 @error('body') border-red-300 @enderror"
                        placeholder="Write the full article here. HTML is supported — use &lt;p&gt;, &lt;h2&gt;, &lt;strong&gt;, &lt;ul&gt;, &lt;img&gt; etc.">{{ old('body', $post->body) }}</textarea>
                    @error('body')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-slate-400 text-xs mt-2">HTML is supported. For images: <code
                            class="bg-slate-100 px-1.5 py-0.5 rounded text-[10px]">&lt;img src="..."
                            class="rounded-xl w-full"&gt;</code></p>
                </div>

                {{-- SEO (collapsible) --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden" x-data="{ open: false }">
                    <button type="button" @click="open=!open"
                        class="w-full flex items-center justify-between px-6 py-4 hover:bg-slate-50 transition-colors">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <span class="font-semibold text-slate-700 text-sm">SEO Settings</span>
                            <span class="text-slate-400 text-xs">(optional — overrides default title &amp;
                                description)</span>
                        </div>
                        <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 text-slate-400 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-cloak x-transition class="px-6 pb-6 space-y-4 border-t border-slate-100 pt-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Meta
                                Title</label>
                            <input type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}"
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold/30"
                                placeholder="SEO title (leave blank to use article title)">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Meta
                                Description</label>
                            <textarea name="meta_description" rows="2"
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-gold/30"
                                placeholder="SEO description (leave blank to use excerpt)">{{ old('meta_description', $post->meta_description) }}</textarea>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ════════════════════════════════════════════════
             RIGHT COLUMN: settings sidebar (1/3 width)
        ════════════════════════════════════════════════ --}}
            <div class="space-y-5">

                {{-- Publish / Save actions --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 space-y-4">
                    <h3 class="font-display font-bold text-navy-900 text-sm">Publish</h3>

                    {{-- Status toggle --}}
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-slate-700">Published</p>
                            <p class="text-xs text-slate-400 mt-0.5">Visible to all visitors</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_published" value="1"
                                {{ old('is_published', $post->is_published ?? false) ? 'checked' : '' }}
                                class="sr-only peer">
                            <div
                                class="w-12 h-6 bg-slate-200 rounded-full peer
                                    peer-checked:bg-emerald-500
                                    after:absolute after:top-0.5 after:left-0.5
                                    after:bg-white after:w-5 after:h-5
                                    after:rounded-full after:transition-all after:shadow-sm
                                    peer-checked:after:translate-x-6">
                            </div>
                        </label>
                    </div>

                    {{-- Featured toggle --}}
                    <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                        <div>
                            <p class="text-sm font-semibold text-slate-700">Featured</p>
                            <p class="text-xs text-slate-400 mt-0.5">Shown prominently on news page</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1"
                                {{ old('is_featured', $post->is_featured ?? false) ? 'checked' : '' }}
                                class="sr-only peer">
                            <div
                                class="w-12 h-6 bg-slate-200 rounded-full peer
                                    peer-checked:bg-gold
                                    after:absolute after:top-0.5 after:left-0.5
                                    after:bg-white after:w-5 after:h-5
                                    after:rounded-full after:transition-all after:shadow-sm
                                    peer-checked:after:translate-x-6">
                            </div>
                        </label>
                    </div>

                    {{-- Publish date --}}
                    <div class="pt-3 border-t border-slate-100">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Publish Date &
                            Time</label>
                        <input type="datetime-local" name="published_at"
                            value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}"
                            class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold/30">
                        <p class="text-slate-400 text-xs mt-1.5">Set a future date to schedule.</p>
                    </div>

                    {{-- Buttons --}}
                    <div class="pt-3 border-t border-slate-100 space-y-2.5">
                        <button type="submit"
                            class="w-full bg-navy-900 hover:bg-gold text-white font-bold py-3 rounded-xl text-sm transition-colors shadow-sm flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            {{ $post->exists ? 'Update Article' : 'Publish Article' }}
                        </button>
                        <a href="{{ route('admin.news.index') }}"
                            class="w-full flex items-center justify-center py-2.5 border border-slate-200 text-slate-600 hover:bg-slate-50 rounded-xl text-sm transition-colors">
                            Cancel
                        </a>
                        @if ($post->exists && $post->is_published)
                            <a href="{{ route('news.show', $post->slug) }}" target="_blank"
                                class="w-full flex items-center justify-center gap-2 py-2.5 text-slate-400 hover:text-navy-900 text-xs transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                View on site
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Featured image --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 space-y-3">
                    <h3 class="font-display font-bold text-navy-900 text-sm">Featured Image</h3>

                    {{-- Current image preview --}}
                    @if ($post->exists && $post->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($post->image))
                        <div id="current-img" class="relative">
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($post->image) }}"
                                alt="{{ $post->title }}"
                                class="w-full aspect-video object-cover rounded-xl border border-slate-100">
                            <span
                                class="absolute top-2 right-2 bg-black/50 text-white text-[9px] font-bold px-2 py-0.5 rounded-full backdrop-blur-sm">Current</span>
                        </div>
                    @endif

                    {{-- New image preview container --}}
                    <div id="new-img-wrap" class="hidden">
                        <img id="new-img-preview" src="" alt="Preview"
                            class="w-full aspect-video object-cover rounded-xl border border-emerald-200">
                        <p class="text-xs text-emerald-600 font-semibold mt-1.5">✓ New image ready — save to apply</p>
                    </div>

                    {{-- Upload zone --}}
                    <div class="border-2 border-dashed border-slate-200 hover:border-gold rounded-xl p-5 text-center transition-colors cursor-pointer"
                        onclick="document.getElementById('img-file').click()">
                        <svg class="w-8 h-8 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-slate-500 text-xs font-semibold mb-0.5">
                            {{ $post->exists && $post->image ? 'Replace image' : 'Upload image' }}
                        </p>
                        <p class="text-slate-400 text-[11px]">JPG, PNG, WebP · Max 50MB<br>Recommended: 1200×630px</p>
                        <input type="file" id="img-file" name="image" accept="image/*" class="sr-only"
                            onchange="previewImage(this)">
                    </div>
                </div>

                {{-- Category --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 space-y-3">
                    <h3 class="font-display font-bold text-navy-900 text-sm">Category</h3>
                    <div>
                        <input type="text" name="category" list="category-list"
                            value="{{ old('category', $post->category) }}"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold/30 focus:border-gold"
                            placeholder="e.g. Achievement">
                        {{-- Datalist with common categories --}}
                        <datalist id="category-list">
                            <option value="Achievement">
                            <option value="Campus News">
                            <option value="Student Success">
                            <option value="Announcements">
                            <option value="Sports">
                            <option value="Cultural">
                            <option value="Academic">
                            <option value="Community">
                        </datalist>
                        <p class="text-slate-400 text-xs mt-1.5">Used for filtering on the news page. Type or choose from
                            common categories.</p>
                    </div>
                </div>

            </div>
        </div>
    </form>

    @push('scripts')
        <script>
            // Auto-generate slug from title (only when slug is still empty)
            let slugEdited = {{ $post->exists && $post->slug ? 'true' : 'false' }};
            const slugInput = document.getElementById('slug-input');

            slugInput.addEventListener('input', () => {
                slugEdited = true;
            });

            function autoSlug(title) {
                if (slugEdited) return;
                slugInput.value = title
                    .toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/[\s_]+/g, '-')
                    .replace(/^-+|-+$/g, '');
            }

            // Image preview before upload
            function previewImage(input) {
                if (!input.files || !input.files[0]) return;
                if (input.files[0].size > 5 * 1024 * 1024) {
                    alert('Image too large. Maximum size is 5MB.');
                    input.value = '';
                    return;
                }
                const reader = new FileReader();
                reader.onload = e => {
                    document.getElementById('new-img-preview').src = e.target.result;
                    document.getElementById('new-img-wrap').classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }

            // Init excerpt counter
            const excerptInput = document.getElementById('excerpt-input');
            if (excerptInput) {
                document.getElementById('excerpt-count').textContent =
                    excerptInput.value.length + ' / 300';
            }
        </script>
    @endpush

@endsection
