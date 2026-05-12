@props(['section', 'index' => 0])

@php
    $items = collect($section->items ?? []);
    $settings = $section->settings ?? [];
    $bg = data_get($settings, 'background', $index % 2 === 0 ? 'white' : 'cream');
    $bgStyle = match ($bg) {
        'navy' => 'background:var(--navy)',
        'dark' => 'background:linear-gradient(135deg,#0D1B2E 0%,#1a237e 50%,#111d35 100%)',
        'cream' => 'background:var(--cream)',
        default => 'background:#fff',
    };
    $isDark = in_array($bg, ['navy', 'dark'], true);
    $titleClass = $isDark ? 'font-display font-bold text-white' : 'section-title';
    $textClass = $isDark ? 'text-white/55' : 'text-gray-400';
    $image = $section->image_url ?: data_get($settings, 'image');
    $imageAlt = data_get($settings, 'image_alt', $section->title ?? '');
    $accent = $section->badge_color ?: 'var(--gold)';
    $grid = data_get($settings, 'grid', 'md:grid-cols-3');
    $sectionPadding = data_get($settings, 'padding', $section->layout === 'cta' ? 'py-16 lg:py-20' : 'py-28');
@endphp

<section class="{{ $section->layout === 'cta' ? 'grand-cta' : '' }} {{ $sectionPadding }} {{ $isDark ? 'text-white' : '' }} {{ data_get($settings, 'class') }}"
    style="{{ $bgStyle }};{{ data_get($settings, 'min_height') ? 'min-height:'.data_get($settings, 'min_height') : '' }}"
    data-particle-type="{{ data_get($settings, 'particle_type', 'soft') }}"
    data-particle-1="{{ data_get($settings, 'particle_1', $isDark ? 'rgba(255,255,255,0.15)' : 'rgba(13,27,46,0.18)') }}"
    data-particle-2="{{ data_get($settings, 'particle_2', 'rgba(201,162,39,0.28)') }}">

    @if ($section->layout === 'cta')
        <canvas class="cta-canvas"></canvas>
        <div class="absolute -top-20 -left-20 w-80 h-80 border rounded-full pointer-events-none" style="border-color:rgba(255,255,255,0.04)"></div>
        <div class="absolute -bottom-20 -right-20 w-[440px] h-[440px] border rounded-full pointer-events-none" style="border-color:rgba(201,162,39,0.08)"></div>
    @endif

    <div class="relative max-w-7xl mx-auto px-6 lg:px-10">
        @if (in_array($section->layout, ['image-left', 'image-right'], true))
            <div class="grid lg:grid-cols-2 gap-20 items-center">
                @if ($section->layout === 'image-left' && $image)
                    <div class="reveal from-left">
                        <div class="img-zoom rounded-[24px] overflow-hidden shadow-[0_32px_80px_rgba(13,27,46,0.13)]" style="aspect-ratio:{{ data_get($settings, 'aspect', '4/3') }}">
                            <img src="{{ $image }}" alt="{{ $imageAlt }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                @endif

                <div class="reveal {{ $section->layout === 'image-left' ? 'from-right' : 'from-left' }}">
                    @include('components.section-heading', ['section' => $section, 'isDark' => $isDark])
                    @if ($section->content)
                        <div class="{{ $isDark ? 'text-white/60' : 'text-gray-500' }} leading-[1.85] mt-8 mb-8" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:14.5px">{!! $section->content !!}</div>
                    @endif
                    @if ($items->isNotEmpty())
                        <div class="grid sm:grid-cols-2 gap-2">
                            @foreach ($items as $item)
                                @include('components.section-item-feature', ['item' => $item, 'accent' => $accent])
                            @endforeach
                        </div>
                    @endif
                    @if ($section->button_text)
                        <a href="{{ $section->button_url ?: '#' }}" class="btn-primary mt-8 inline-flex">{{ $section->button_text }}</a>
                    @endif
                </div>

                @if ($section->layout === 'image-right' && $image)
                    <div class="reveal from-right">
                        <div class="img-zoom rounded-[24px] overflow-hidden shadow-[0_32px_80px_rgba(13,27,46,0.13)]" style="aspect-ratio:{{ data_get($settings, 'aspect', '4/3') }}">
                            <img src="{{ $image }}" alt="{{ $imageAlt }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                @endif
            </div>
        @elseif ($section->layout === 'stats')
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ($items as $item)
                    <div class="flex items-center gap-3 text-white">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.12)">
                            @include('components.section-icon', ['path' => data_get($item, 'icon'), 'color' => 'var(--gold)'])
                        </div>
                        <div>
                            <div class="font-display font-bold text-white text-xl leading-none">{{ data_get($item, 'value', data_get($item, 'title')) }}</div>
                            <div class="text-white/45 text-xs mt-0.5" style="font-family:'Plus Jakarta Sans',sans-serif">{{ data_get($item, 'label', data_get($item, 'description')) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif ($section->layout === 'cards')
            @include('components.section-heading', ['section' => $section, 'isDark' => $isDark, 'center' => true])
            <div class="grid {{ $grid }} gap-6 stagger">
                @foreach ($items as $item)
                    <div class="{{ data_get($settings, 'card_class', 'facility-card') }} bg-white p-7 border border-gray-100 shadow-sm" style="border-left:{{ data_get($item, 'color', $accent) ? '3px solid '.data_get($item, 'color', $accent) : '' }}">
                        @include('components.section-icon-box', ['item' => $item, 'accent' => data_get($item, 'color', $accent)])
                        <h3 class="font-display font-bold text-navy text-xl mb-3">{{ data_get($item, 'title') }}</h3>
                        <p class="text-gray-400 text-sm leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif">{{ data_get($item, 'description') }}</p>
                        @if (data_get($item, 'tag'))
                            <span class="text-xs font-bold tracking-wide mt-4 inline-block" style="color:{{ data_get($item, 'color', $accent) }};font-family:'Plus Jakarta Sans',sans-serif">{{ data_get($item, 'tag') }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
        @elseif ($section->layout === 'program-cards')
            @include('components.section-heading', ['section' => $section, 'isDark' => $isDark, 'center' => true])
            <div class="grid {{ data_get($settings, 'grid', 'sm:grid-cols-2 xl:grid-cols-4') }} gap-6 stagger">
                @foreach ($items as $item)
                    @php
                        $cardImage = data_get($item, 'image');
                        $cardColor = data_get($item, 'color', $accent);
                        $cardUrl = data_get($item, 'url', '#');
                    @endphp
                    <a href="{{ $cardUrl }}" class="prog-card block group">
                        <div class="relative" style="aspect-ratio:{{ data_get($settings, 'aspect', '3/4') }}">
                            @if ($cardImage)
                                <img src="{{ $cardImage }}" alt="{{ data_get($item, 'title') }}" class="absolute inset-0 w-full h-full object-cover">
                            @else
                                <div class="absolute inset-0" style="background:linear-gradient(135deg,var(--navy),var(--gold-dark))"></div>
                            @endif
                            <div class="prog-overlay"></div>
                            @if (data_get($item, 'badge'))
                                <div class="absolute top-5 left-5 text-[10.5px] font-bold px-3.5 py-1.5 rounded-full tracking-wide uppercase"
                                    style="background:{{ $cardColor }};font-family:'Plus Jakarta Sans',sans-serif;color:{{ data_get($item, 'badge_text_color', $cardColor === 'var(--navy)' ? 'var(--gold)' : 'var(--navy)') }}">
                                    {{ data_get($item, 'badge') }}
                                </div>
                            @endif
                            <div class="absolute bottom-0 left-0 right-0 p-7">
                                <h3 class="font-display font-bold text-white text-2xl mb-2 leading-tight">{{ data_get($item, 'title') }}</h3>
                                <p class="text-white/65 text-sm leading-relaxed mb-5" style="font-family:'Plus Jakarta Sans',sans-serif">{{ data_get($item, 'description') }}</p>
                                <div class="flex items-center gap-2 font-semibold text-sm" style="color:var(--gold);font-family:'Plus Jakarta Sans',sans-serif">
                                    {{ data_get($item, 'link_label', 'Explore') }}
                                    <svg class="w-4 h-4 group-hover:translate-x-1.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @elseif ($section->layout === 'list')
            @include('components.section-heading', ['section' => $section, 'isDark' => $isDark, 'center' => true])
            <div class="max-w-4xl mx-auto bg-white border border-gray-100 rounded-[24px] shadow-sm p-8 reveal">
                @if ($section->content)
                    <div class="text-gray-500 leading-[1.85] mb-6" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:14.5px">{!! $section->content !!}</div>
                @endif
                <div class="grid sm:grid-cols-2 gap-3">
                    @foreach ($items as $item)
                        @include('components.section-item-feature', ['item' => $item, 'accent' => data_get($item, 'color', $accent)])
                    @endforeach
                </div>
            </div>
        @elseif ($section->layout === 'full-image')
            <div class="relative rounded-[24px] overflow-hidden min-h-[420px] flex items-end shadow-[0_32px_80px_rgba(13,27,46,0.16)] reveal">
                @if ($image)
                    <img src="{{ $image }}" alt="{{ $imageAlt }}" class="absolute inset-0 w-full h-full object-cover">
                @endif
                <div class="absolute inset-0" style="background:linear-gradient(180deg,rgba(13,27,46,0.12) 0%,rgba(13,27,46,0.88) 100%)"></div>
                <div class="relative p-8 lg:p-12 max-w-2xl">
                    @if ($section->badge_text)
                        <div class="section-label" style="color:rgba(201,162,39,0.85)">{{ $section->badge_text }}</div>
                    @endif
                    <h2 class="font-display font-bold text-white mb-4" style="font-size:clamp(2rem,4vw,3.4rem);line-height:1.1">{{ $section->title }}</h2>
                    @if ($section->content)
                        <div class="text-white/65 leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif">{!! $section->content !!}</div>
                    @endif
                </div>
            </div>
        @elseif ($section->layout === 'timeline')
            @include('components.section-heading', ['section' => $section, 'isDark' => $isDark, 'center' => true])
            <div class="bg-white border border-gray-100 rounded-[24px] shadow-sm overflow-hidden reveal max-w-4xl mx-auto">
                <div class="grid {{ data_get($settings, 'columns', 'sm:grid-cols-2') }} divide-y sm:divide-y-0 sm:divide-x divide-gray-100">
                    @foreach ($items as $group)
                        <div class="p-7 lg:p-8">
                            <h3 class="font-display font-bold text-navy text-lg mb-7">{{ data_get($group, 'title') }}</h3>
                            @foreach (data_get($group, 'items', []) as $row)
                                <div class="timeline-row py-3 border-b border-gray-50 last:border-0">
                                    <div class="timeline-dot" style="background:{{ data_get($row, 'color', $accent) }}"></div>
                                    <span class="font-bold text-sm shrink-0 w-24" style="color:{{ data_get($row, 'color', $accent) }};font-family:'Plus Jakarta Sans',sans-serif">{{ data_get($row, 'time', data_get($row, 'year')) }}</span>
                                    <span class="text-gray-500 text-sm" style="font-family:'Plus Jakarta Sans',sans-serif">{{ data_get($row, 'text', data_get($row, 'activity')) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        @elseif ($section->layout === 'program-tabs')
            @include('components.section-heading', ['section' => $section, 'isDark' => $isDark, 'center' => true])
            @include('components.program-tabs', ['tabs' => $items])
        @elseif ($section->layout === 'steps')
            @include('components.section-heading', ['section' => $section, 'isDark' => $isDark, 'center' => true])
            <div class="grid md:grid-cols-4 gap-6 stagger">
                @foreach ($items as $item)
                    <div class="text-center">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg mx-auto border-4 border-white mb-5" style="background:{{ data_get($item, 'color', $accent) }}">
                            @include('components.section-icon', ['path' => data_get($item, 'icon'), 'color' => '#fff'])
                        </div>
                        <p class="text-xs font-black tracking-widest mb-1.5" style="color:{{ data_get($item, 'color', $accent) }};font-family:'Plus Jakarta Sans',sans-serif">STEP {{ data_get($item, 'step') }}</p>
                        <h4 class="font-display font-bold text-navy text-sm mb-1.5">{{ data_get($item, 'title') }}</h4>
                        <p class="text-gray-400 text-xs leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif">{{ data_get($item, 'description') }}</p>
                    </div>
                @endforeach
            </div>
        @elseif ($section->layout === 'routes')
            @include('components.section-heading', ['section' => $section, 'isDark' => $isDark, 'center' => true])
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 stagger">
                @foreach ($items as $route)
                    <div class="route-card bg-white border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                            <h4 class="font-display font-bold text-navy text-lg">{{ data_get($route, 'title') }}</h4>
                            <span class="text-xs font-bold px-3 py-1 rounded-full" style="background:{{ data_get($route, 'bg', '#DBEAFE') }};color:{{ data_get($route, 'color', '#3B82F6') }}">{{ data_get($route, 'badge') }}</span>
                        </div>
                        <div class="px-6 py-4 space-y-3">
                            @foreach (data_get($route, 'details', []) as $label => $value)
                                <div class="flex items-center justify-between text-sm" style="font-family:'Plus Jakarta Sans',sans-serif">
                                    <span class="text-gray-400 text-xs">{{ $label }}</span>
                                    <span class="text-navy font-bold">{{ $value }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif ($section->layout === 'video')
            <div class="max-w-4xl mx-auto text-center reveal">
                @include('components.section-heading', ['section' => $section, 'isDark' => $isDark, 'center' => true])
                <div class="relative rounded-[20px] overflow-hidden shadow-[0_32px_80px_rgba(0,0,0,0.4)] cursor-pointer group img-zoom">
                    <img src="{{ $image }}" alt="{{ $imageAlt }}" class="w-full aspect-video object-cover">
                    <div class="absolute inset-0 flex flex-col items-center justify-center" style="background:rgba(0,0,0,0.38)">
                        <div class="play-btn mb-4">
                            <svg class="w-7 h-7 ml-1" style="color:var(--navy)" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 006 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
                        </div>
                        <div class="text-white font-semibold text-sm tracking-wide" style="font-family:'Plus Jakarta Sans',sans-serif">{{ data_get($settings, 'play_label', 'Watch Video') }}</div>
                    </div>
                </div>
            </div>
        @elseif ($section->layout === 'cta')
            <div class="relative max-w-3xl mx-auto px-6 reveal w-full text-center">
                @include('components.section-heading', ['section' => $section, 'isDark' => $isDark, 'center' => true])
                @if ($section->content)
                    <div class="{{ $textClass }} mb-10 leading-relaxed mx-auto max-w-xl" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:15px">{!! $section->content !!}</div>
                @endif
                <div class="flex flex-wrap gap-4 justify-center">
                    @foreach ($items as $button)
                        <a href="{{ data_get($button, 'url', '#') }}" class="{{ data_get($button, 'style') === 'ghost' ? ($isDark ? 'btn-ghost-white' : 'btn-ghost') : 'btn-primary' }}">{{ data_get($button, 'label') }}</a>
                    @endforeach
                </div>
            </div>
        @else
            <div class="max-w-3xl mx-auto px-6 text-center reveal">
                @include('components.section-heading', ['section' => $section, 'isDark' => $isDark, 'center' => true])
                @if ($section->content)
                    <div class="{{ $isDark ? 'text-white/55' : 'text-gray-500' }} leading-[1.85] mt-10" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:15px">{!! $section->content !!}</div>
                @endif
            </div>
        @endif
    </div>
</section>

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const obs = new IntersectionObserver(entries => {
                    entries.forEach(e => {
                        if (!e.isIntersecting) return;
                        e.target.classList.add('visible', 'active');
                        e.target.querySelectorAll('.gold-bar,[data-goldbar]').forEach(b => setTimeout(() => { b.style.width = '48px'; }, 250));
                    });
                }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
                document.querySelectorAll('.reveal, .stagger').forEach(el => obs.observe(el));

                document.querySelectorAll('.grand-cta').forEach(section => {
                    const canvas = section.querySelector('.cta-canvas');
                    if (!canvas) return;
                    const ctx = canvas.getContext('2d');
                    const c1 = section.dataset.particle1 || 'rgba(255,255,255,0.12)';
                    const c2 = section.dataset.particle2 || 'rgba(201,162,39,0.22)';
                    const type = section.dataset.particleType || 'soft';
                    let particles = [];
                    function resize() { canvas.width = section.offsetWidth; canvas.height = section.offsetHeight; }
                    window.addEventListener('resize', resize); resize();
                    class Particle {
                        constructor() { this.init(); }
                        init() {
                            this.x = Math.random() * canvas.width; this.y = Math.random() * canvas.height;
                            this.size = type === 'geometric' ? Math.random() * 6 + 3 : Math.random() * 2 + 0.5;
                            this.speedX = (Math.random() - .5) * .28; this.speedY = (Math.random() - .5) * .28;
                            this.color = Math.random() > .5 ? c1 : c2;
                            this.rotation = Math.random() * Math.PI * 2; this.rotSpeed = (Math.random() - .5) * .015;
                            this.shape = Math.floor(Math.random() * 3);
                        }
                        update() {
                            this.x += this.speedX; this.y += this.speedY; this.rotation += this.rotSpeed;
                            if (this.x < 0 || this.x > canvas.width || this.y < 0 || this.y > canvas.height) this.init();
                        }
                        draw() {
                            ctx.save(); ctx.translate(this.x, this.y); ctx.rotate(this.rotation); ctx.fillStyle = this.color;
                            if (type === 'geometric') {
                                if (this.shape === 0) { ctx.beginPath(); ctx.arc(0, 0, this.size / 2, 0, Math.PI * 2); ctx.fill(); }
                                else if (this.shape === 1) { ctx.fillRect(-this.size / 2, -this.size / 2, this.size, this.size); }
                                else { ctx.beginPath(); ctx.moveTo(0, -this.size / 2); ctx.lineTo(this.size / 2, this.size / 2); ctx.lineTo(-this.size / 2, this.size / 2); ctx.closePath(); ctx.fill(); }
                            } else { ctx.beginPath(); ctx.arc(0, 0, this.size / 2, 0, Math.PI * 2); ctx.fill(); }
                            ctx.restore();
                        }
                    }
                    for (let i = 0, count = Math.min(60, Math.floor((canvas.width * canvas.height) / 14000)); i < count; i++) particles.push(new Particle());
                    (function animate() { ctx.clearRect(0, 0, canvas.width, canvas.height); particles.forEach(p => { p.update(); p.draw(); }); requestAnimationFrame(animate); })();
                });
            });
        </script>
    @endpush
@endonce
