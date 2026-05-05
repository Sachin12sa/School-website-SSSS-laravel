@props(['tabs'])

<div x-data="{ tab: '{{ data_get($tabs->first(), 'key', 'tab') }}' }">
    <div class="flex gap-3 justify-center mb-12 flex-wrap">
        @foreach ($tabs as $tab)
            <button @click="tab='{{ data_get($tab, 'key') }}'; window.history.pushState(null, null, '#{{ data_get($tab, 'key') }}');"
                :class="tab === '{{ data_get($tab, 'key') }}' ? 'active' : ''"
                class="tab-btn">{{ data_get($tab, 'label', data_get($tab, 'title')) }}</button>
        @endforeach
    </div>

    @foreach ($tabs as $tab)
        <div x-show="tab==='{{ data_get($tab, 'key') }}'" x-transition id="{{ data_get($tab, 'key') }}" class="scroll-mt-24">
            <div class="grid md:grid-cols-2 gap-8">
                @if (data_get($tab, 'image'))
                    <div class="prog-img-card" style="aspect-ratio:4/3">
                        <img src="{{ data_get($tab, 'image') }}" alt="{{ data_get($tab, 'title') }}">
                        <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(13,27,46,0.7) 0%, transparent 55%)"></div>
                    </div>
                @endif
                <div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-sm" style="border-top:2px solid {{ data_get($tab, 'color', 'var(--gold)') }}">
                    @if (data_get($tab, 'badge'))
                        <span class="text-xs font-bold px-3 py-1 rounded-full" style="background:{{ data_get($tab, 'color', 'var(--gold)') }};color:{{ data_get($tab, 'badge_text_color', 'var(--navy)') }}">{{ data_get($tab, 'badge') }}</span>
                    @endif
                    <h3 class="font-display font-bold text-navy text-2xl mt-4 mb-3">{{ data_get($tab, 'title') }}</h3>
                    <p class="text-gray-500 text-sm mb-6 leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif">{{ data_get($tab, 'description') }}</p>
                    <div class="space-y-1">
                        @foreach (data_get($tab, 'subjects', []) as $subject)
                            <div class="subject-row">
                                <svg class="w-4 h-4 shrink-0 mt-0.5" style="color:{{ data_get($tab, 'color', 'var(--gold)') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <div>
                                    <div class="text-sm font-semibold text-navy" style="font-family:'Plus Jakarta Sans',sans-serif">{{ data_get($subject, 'name', $subject) }}</div>
                                    @if (data_get($subject, 'description'))
                                        <div class="text-xs text-gray-400 mt-0.5" style="font-family:'Plus Jakarta Sans',sans-serif">{{ data_get($subject, 'description') }}</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
