@extends('admin.layouts.admin')
@section('title', $section->exists ? 'Edit Section — ' . $pageTitle : 'Add Section — ' . $pageTitle)

@section('content')
    @php
        $sectionExamples = [
            'default' => [
                'items' => '',
                'settings' => ['background' => 'white'],
                'note' => 'Use Title, Subtitle, and Content only. Structured Items can stay empty.',
            ],
            'image-left' => [
                'items' => [
                    ['title' => 'Comfortable Dorms', 'description' => 'Spacious, well-ventilated rooms.', 'icon' => 'M3 12l2-2m0 0l7-7 7 7'],
                    ['title' => 'Study Facilities', 'description' => 'Supervised evening study hours.', 'icon' => 'M12 6.253v13'],
                ],
                'settings' => ['background' => 'cream', 'image' => 'https://example.com/image.jpg', 'image_alt' => 'Students on campus'],
                'note' => 'Use items for the small feature list. Upload an image or add an image URL in settings.',
            ],
            'image-right' => [
                'items' => [
                    ['title' => 'Modern Classrooms', 'description' => 'Bright rooms prepared for active learning.', 'icon' => 'M19 21V5a2 2 0 00-2-2H7'],
                    ['title' => 'Value Education', 'description' => 'Daily practices that build character.', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364'],
                ],
                'settings' => ['background' => 'white', 'image' => 'https://example.com/image.jpg', 'image_alt' => 'Classroom'],
                'note' => 'Same as Image Left, but the image appears on the right.',
            ],
            'full-image' => [
                'items' => '',
                'settings' => ['background' => 'white', 'image' => 'https://example.com/image.jpg', 'image_alt' => 'Campus highlight'],
                'note' => 'Best for one large image with title/content overlay. Structured Items can stay empty.',
            ],
            'cards' => [
                'items' => [
                    ['title' => 'Science Labs', 'description' => 'Hands-on practical learning for students.', 'icon' => 'M9.663 17h4.673M12 3v1', 'color' => 'var(--gold)'],
                    ['title' => 'Library', 'description' => 'Books and digital learning resources.', 'icon' => 'M12 6.253v13', 'color' => 'var(--navy)'],
                    ['title' => 'Sports', 'description' => 'Outdoor and indoor activities.', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'color' => '#D97706'],
                ],
                'settings' => ['background' => 'cream', 'grid' => 'md:grid-cols-3'],
                'note' => 'Use one item per card. Optional color changes the icon/card accent.',
            ],
            'list' => [
                'items' => [
                    ['title' => 'Verified Drivers', 'description' => 'Every driver is checked and trained.', 'icon' => 'M5 13l4 4L19 7'],
                    ['title' => 'Emergency Support', 'description' => 'Transport team available during school travel.', 'icon' => 'M3 5a2 2 0 012-2h3.28'],
                ],
                'settings' => ['background' => 'white'],
                'note' => 'Use this for compact bullet-style feature lists.',
            ],
            'stats' => [
                'items' => [
                    ['value' => '500+', 'label' => 'Students', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857'],
                    ['value' => '40+', 'label' => 'Teachers', 'icon' => 'M12 4.354a4 4 0 110 5.292'],
                    ['value' => '26', 'label' => 'Years', 'icon' => 'M8 7V3m8 4V3m-9 8h10'],
                    ['value' => '3', 'label' => 'Programs', 'icon' => 'M9 5H7a2 2 0 00-2 2v12'],
                ],
                'settings' => ['background' => 'navy', 'class' => '!py-10'],
                'note' => 'Stats are usually short numbers and labels. Use navy background for the dark strip style.',
            ],
            'timeline' => [
                'items' => [
                    ['title' => 'Morning Routine', 'items' => [
                        ['time' => '5:30 AM', 'text' => 'Wake Up'],
                        ['time' => '6:00 AM', 'text' => 'Prayer & Meditation'],
                    ]],
                    ['title' => 'Evening Routine', 'items' => [
                        ['time' => '6:00 PM', 'text' => 'Supervised Study', 'color' => 'var(--navy)'],
                        ['time' => '9:30 PM', 'text' => 'Lights Out', 'color' => '#6b7280'],
                    ]],
                ],
                'settings' => ['background' => 'white'],
                'note' => 'Use grouped items. Each group becomes one timeline column.',
            ],
            'program-tabs' => [
                'items' => [
                    ['key' => 'science', 'label' => '+2 Science', 'title' => '+2 Science Stream', 'badge' => 'Grades 11-12', 'description' => 'NEB-aligned science curriculum.', 'image' => 'https://example.com/science.jpg', 'subjects' => [
                        ['name' => 'Physics', 'description' => 'Mechanics, optics, and modern physics'],
                        ['name' => 'Chemistry'],
                    ]],
                    ['key' => 'management', 'label' => '+2 Management', 'title' => '+2 Management Stream', 'badge' => 'Grades 11-12', 'description' => 'Business and commerce curriculum.', 'subjects' => [
                        ['name' => 'Accountancy'],
                        ['name' => 'Economics'],
                    ]],
                ],
                'settings' => ['background' => 'white'],
                'note' => 'Each top-level item becomes one tab. The key should be short and lowercase.',
            ],
            'steps' => [
                'items' => [
                    ['step' => '01', 'title' => 'Student Boards Bus', 'description' => 'Student taps ID card on the scanner.', 'color' => 'var(--navy)'],
                    ['step' => '02', 'title' => 'Parent Notified', 'description' => 'Parents receive an instant notification.', 'color' => '#059669'],
                ],
                'settings' => ['background' => 'cream'],
                'note' => 'Best for process sections. Keep each step short.',
            ],
            'routes' => [
                'items' => [
                    ['title' => 'Route A', 'badge' => 'SSSS-01', 'color' => '#3B82F6', 'bg' => '#DBEAFE', 'details' => [
                        'Coverage Area' => 'North Sector',
                        'Stops' => '7 stops',
                        'Departure' => '7:15 AM',
                    ]],
                    ['title' => 'Route B', 'badge' => 'SSSS-02', 'color' => '#059669', 'bg' => '#D1FAE5', 'details' => [
                        'Coverage Area' => 'East Zone',
                        'Stops' => '9 stops',
                        'Departure' => '7:20 AM',
                    ]],
                ],
                'settings' => ['background' => 'cream'],
                'note' => 'Use for transport route cards. Details can contain any label/value pairs.',
            ],
            'video' => [
                'items' => '',
                'settings' => ['background' => 'navy', 'image' => 'https://example.com/video-cover.jpg', 'image_alt' => 'Campus video', 'play_label' => 'Watch Campus Tour'],
                'note' => 'Use settings image as the video cover. Structured Items can stay empty.',
            ],
            'cta' => [
                'items' => [
                    ['label' => 'Apply for Admission', 'url' => '/admissions'],
                    ['label' => 'Contact Us', 'url' => '/contact', 'style' => 'ghost'],
                ],
                'settings' => ['background' => 'dark', 'particle_type' => 'soft'],
                'note' => 'Items are buttons. Use style ghost for the secondary button.',
            ],
        ];
    @endphp

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
                    <select name="layout" required id="section-layout"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30 bg-white">
                        @foreach ([
                            'default'     => 'Default (text only)',
                            'image-left'  => 'Image Left + Text Right',
                            'image-right' => 'Image Right + Text Left',
                            'full-image'  => 'Full-width Image with Overlay',
                            'cards'       => 'Card Grid',
                            'list'        => 'Bullet List',
                            'stats'       => 'Stats Bar',
                            'timeline'    => 'Timeline / Routine',
                            'program-tabs'=> 'Program Tabs',
                            'steps'       => 'Process Steps',
                            'routes'      => 'Route Cards',
                            'video'       => 'Video / Media Feature',
                            'cta'         => 'CTA Banner',
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
                    <div class="mt-3 rounded-xl border border-gold-500/20 bg-gold-50/60 p-4">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0" style="background:#C9A227">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 18a6 6 0 100-12 6 6 0 000 12z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-navy-900">Section setup guide</p>
                                <p class="text-xs text-slate-600 mt-1" id="layout-help-note">
                                    Choose a layout to see the JSON shape needed below.
                                </p>
                            </div>
                        </div>
                    </div>
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

                <div>
                    <div class="flex items-center justify-between gap-3 mb-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide">Structured Items JSON</label>
                        <button type="button" data-fill-json="items"
                            class="text-[11px] font-bold text-navy-900 border border-slate-200 rounded-lg px-3 py-1.5 hover:bg-slate-50 transition-colors">
                            Use layout example
                        </button>
                    </div>
                    <textarea name="items_json" rows="8" id="items-json"
                        placeholder='[{"title":"Modern Classrooms","description":"...","icon":"M..."}]'
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm resize-y focus:outline-none focus:ring-2 focus:ring-gold-500/30 font-mono">{{ old('items_json', $section->items ? json_encode($section->items, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
                    @error('items_json')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    <p class="text-slate-400 text-xs mt-1">Use this for cards, lists, stats, timelines, tabs, routes, and CTA buttons.</p>
                    <pre id="items-example-preview" class="mt-3 hidden whitespace-pre-wrap rounded-xl bg-slate-950 text-slate-100 text-xs p-4 overflow-x-auto"></pre>
                </div>

                <div>
                    <div class="flex items-center justify-between gap-3 mb-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide">Section Settings JSON</label>
                        <button type="button" data-fill-json="settings"
                            class="text-[11px] font-bold text-navy-900 border border-slate-200 rounded-lg px-3 py-1.5 hover:bg-slate-50 transition-colors">
                            Use layout example
                        </button>
                    </div>
                    <textarea name="settings_json" rows="5" id="settings-json"
                        placeholder='{"background":"cream","particle_type":"geometric","image_alt":"Campus"}'
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm resize-y focus:outline-none focus:ring-2 focus:ring-gold-500/30 font-mono">{{ old('settings_json', $section->settings ? json_encode($section->settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
                    @error('settings_json')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    <p class="text-slate-400 text-xs mt-1">Common backgrounds: white, cream, navy, dark. Optional display options include image, image_alt, grid, particle_type, and custom colors.</p>
                    <pre id="settings-example-preview" class="mt-3 hidden whitespace-pre-wrap rounded-xl bg-slate-950 text-slate-100 text-xs p-4 overflow-x-auto"></pre>
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const examples = @json($sectionExamples, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            const layout = document.getElementById('section-layout');
            const note = document.getElementById('layout-help-note');
            const items = document.getElementById('items-json');
            const settings = document.getElementById('settings-json');
            const itemsPreview = document.getElementById('items-example-preview');
            const settingsPreview = document.getElementById('settings-example-preview');

            function pretty(value) {
                if (!value || value === '') return '';
                return JSON.stringify(value, null, 2);
            }

            function refreshGuide() {
                const selected = examples[layout.value] || examples.default;
                const itemExample = pretty(selected.items);
                const settingsExample = pretty(selected.settings);

                note.textContent = selected.note || 'Use Title, Subtitle, Content, and optional JSON below.';
                items.placeholder = itemExample || 'No structured items needed for this layout.';
                settings.placeholder = settingsExample || '{"background":"white"}';

                itemsPreview.textContent = itemExample ? 'Items example:\n' + itemExample : 'This layout does not need Structured Items JSON.';
                settingsPreview.textContent = settingsExample ? 'Settings example:\n' + settingsExample : 'No settings example available.';
                itemsPreview.classList.remove('hidden');
                settingsPreview.classList.remove('hidden');
            }

            document.querySelectorAll('[data-fill-json]').forEach(button => {
                button.addEventListener('click', () => {
                    const selected = examples[layout.value] || examples.default;
                    const target = button.dataset.fillJson === 'items' ? items : settings;
                    const value = button.dataset.fillJson === 'items' ? selected.items : selected.settings;
                    target.value = pretty(value);
                    target.focus();
                });
            });

            layout.addEventListener('change', refreshGuide);
            refreshGuide();
        });
    </script>
@endpush
