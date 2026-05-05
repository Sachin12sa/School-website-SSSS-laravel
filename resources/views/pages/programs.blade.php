@extends('layouts.app')
@section('title', 'Academic Programs — SSSS')

@push('styles')
<style>
@keyframes page-enter { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:none} }
@keyframes badge-drop { from{opacity:0;transform:translateY(-10px) scale(.95)} to{opacity:1;transform:none} }

.h-anim-1 { animation: badge-drop .6s .08s both cubic-bezier(0.23,1,0.32,1); }
.h-anim-2 { animation: page-enter .85s .2s  both cubic-bezier(0.23,1,0.32,1); }
.h-anim-3 { animation: page-enter .85s .38s both cubic-bezier(0.23,1,0.32,1); }

/* ── Stats bar items ──────────────────────────────────────────── */
.stats-item {
    display: flex; align-items: flex-start; gap: 14px;
    transition: transform .22s var(--ease-spring);
}
@media (hover:hover) and (pointer:fine) {
    .stats-item:hover { transform: translateY(-2px); }
}

.stats-icon {
    width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.12);
    display: flex; align-items: center; justify-content: center;
    transition: background .18s ease;
}
.stats-item:hover .stats-icon { background: rgba(201,162,39,0.2); }

/* ── Program tabs ─────────────────────────────────────────────── */
.tab-btn {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; font-weight: 600;
    padding: 10px 24px;
    border-radius: 10px;
    border: 1.5px solid rgba(13,27,46,0.14);
    color: var(--text-muted);
    background: transparent;
    cursor: pointer;
    transition: background .18s var(--ease-out),
                border-color .18s var(--ease-out),
                color .18s var(--ease-out),
                transform .16s var(--ease-spring),
                box-shadow .18s ease;
}
.tab-btn:hover { border-color: var(--navy); color: var(--navy); transform: translateY(-1px); }
.tab-btn:active { transform: scale(0.97); }
.tab-btn.active {
    background: var(--navy); color: #fff; border-color: var(--navy);
    box-shadow: 0 4px 16px rgba(13,27,46,0.2);
}

/* ── Program image cards ──────────────────────────────────────── */
.prog-img-card {
    border-radius: 20px; overflow: hidden; position: relative; cursor: pointer;
    transition: transform .32s var(--ease-spring), box-shadow .32s var(--ease-out);
}
@media (hover:hover) and (pointer:fine) {
    .prog-img-card:hover { transform: translateY(-6px); box-shadow: 0 28px 56px rgba(13,27,46,0.15); }
    .prog-img-card:hover img { transform: scale(1.05); }
}
.prog-img-card:active { transform: scale(0.99); }
.prog-img-card img { transition: transform .55s var(--ease-out); width:100%; height:100%; object-fit:cover; }

/* ── Subject check items ──────────────────────────────────────── */
.subject-row {
    display: flex; gap: 10px; align-items: flex-start;
    padding: 8px 0;
    border-bottom: 1px solid rgba(13,27,46,0.05);
    transition: background .15s ease;
}
.subject-row:last-child { border-bottom: none; }
.subject-row:hover { background: rgba(201,162,39,0.03); border-radius: 6px; padding-left: 4px; }

/* ── Beyond academics cards ───────────────────────────────────── */
.beyond-card {
    border-radius: 20px;
    border-left: 3px solid transparent;
    transition: transform .28s var(--ease-spring), box-shadow .28s ease, border-color .2s ease;
}
@media (hover:hover) and (pointer:fine) {
    .beyond-card:hover { transform: translateY(-5px); box-shadow: 0 20px 44px rgba(13,27,46,0.09); }
}

/* ── Grand CTA ────────────────────────────────────────────────── */
.grand-cta { position: relative; overflow: hidden; z-index: 1; }
.cta-canvas { position: absolute; top:0; left:0; width:100%; height:100%; z-index:-1; pointer-events:none; }
</style>
@endpush

@section('content')

{{-- ══ HERO ══════════════════════════════════════════════════════════ --}}
@php $hero = $hero ?? \App\Models\PageHero::forPage('programs'); @endphp
@if($hero)
    <x-page-hero :hero="$hero" />
@endif

@if(($sections ?? collect())->isNotEmpty())
    @foreach($sections as $i => $section)
        @include('components.section-renderer', ['section' => $section, 'index' => $i])
    @endforeach
@else

{{-- ══ STATS BAR ════════════════════════════════════════════════════════ --}}
<section class="py-10" style="background:var(--navy)">
<div class="max-w-7xl mx-auto px-6 lg:px-8 grid grid-cols-2 md:grid-cols-4 gap-6">
    @foreach([
        ['M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4', 'Qualified Teachers',  'Experienced educators dedicated to student success'],
        ['M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',            'Modern Curriculum',    'Up-to-date syllabus aligned with national standards'],
        ['M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z', 'Science Labs', 'Well-equipped laboratories for practical learning'],
        ['M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z', '100% Results', 'Consistent excellence in board examinations'],
    ] as [$iconPath, $title, $desc])
    <div class="stats-item text-white">
        <div class="stats-icon">
            <svg class="w-5 h-5" style="color:var(--gold)" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPath }}"/>
            </svg>
        </div>
        <div>
            <div class="font-semibold text-sm text-white">{{ $title }}</div>
            <div class="text-white/50 text-xs mt-0.5" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $desc }}</div>
        </div>
    </div>
    @endforeach
</div>
</section>

{{-- ══ EXPLORE PROGRAMS ═════════════════════════════════════════════════ --}}
<section class="py-28" style="background:#fff">
<div class="max-w-7xl mx-auto px-6 lg:px-10">

    <div class="text-center mb-16 reveal">
        <div class="section-label justify-center">What We Offer</div>
        <h2 class="section-title">Explore Our Programs</h2>
        <div class="gold-bar mx-auto mt-4"></div>
        <p class="text-gray-400 text-sm mt-6 max-w-xl mx-auto leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif">
            Choose your path — from foundational school education to specialised higher secondary streams.
        </p>
    </div>

    <div x-data="{
        tab: 'school',
        init() {
            this.handleHash();
            window.addEventListener('hashchange', () => this.handleHash());
        },
        handleHash() {
            const hash = window.location.hash.substring(1);
            if (!hash) return;
            if (hash === 'science' || hash === 'management') { this.tab = hash; }
            else if (hash === 'primary' || hash === 'secondary') { this.tab = 'school'; }
            this.$nextTick(() => {
                const el = document.getElementById(hash);
                if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        }
    }">

        {{-- Tab Buttons --}}
        <div class="flex gap-3 justify-center mb-12 flex-wrap">
            @foreach([['school','School Level'],[' science','+2 Science'],['management','+2 Management']] as [$val,$label])
            @php $val = trim($val); @endphp
            <button
                @click="tab='{{ $val }}'; window.history.pushState(null, null, '#{{ $val }}');"
                :class="tab === '{{ $val }}' ? 'active' : ''"
                class="tab-btn">{{ $label }}</button>
            @endforeach
        </div>

        {{-- School Level --}}
        <div x-show="tab==='school'" x-transition id="school" class="scroll-mt-24">
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                @foreach([['Grades 1–5','Primary Level','https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=600'],['Grades 6–10','Secondary Level','https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=600']] as [$badge,$title,$img])
                <div class="prog-img-card" style="aspect-ratio:16/9">
                    <img src="{{ $img }}" alt="{{ $title }}">
                    <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(13,27,46,0.85) 0%, transparent 55%)"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <span class="text-xs font-bold px-3 py-1 rounded-full mb-3 inline-block" style="background:var(--gold);color:var(--navy)">{{ $badge }}</span>
                        <h3 class="font-display font-bold text-white text-2xl">{{ $title }}</h3>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                {{-- Primary --}}
                <div id="primary" class="bg-white border border-gray-100 rounded-2xl p-8 shadow-sm scroll-mt-24" style="border-top:2px solid var(--gold)">
                    <div class="flex items-center gap-3 mb-5">
                        <span class="w-3 h-3 rounded-full" style="background:var(--gold)"></span>
                        <h3 class="font-display font-bold text-navy text-xl">Primary Level (Grades 1–5)</h3>
                    </div>
                    <p class="text-gray-500 text-sm mb-6" style="font-family:'Plus Jakarta Sans',sans-serif">Foundation stage focusing on basic skills, creativity, and moral values.</p>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach(['English','Mathematics','Science','Social Studies','Nepali/Hindi','Computer'] as $subj)
                        <div class="flex items-center gap-2 text-sm text-gray-700" style="font-family:'Plus Jakarta Sans',sans-serif">
                            <svg class="w-4 h-4 shrink-0" style="color:var(--gold)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            {{ $subj }}
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Secondary --}}
                <div id="secondary" class="bg-white border border-gray-100 rounded-2xl p-8 shadow-sm scroll-mt-24" style="border-top:2px solid var(--navy-mid)">
                    <div class="flex items-center gap-3 mb-5">
                        <span class="w-3 h-3 rounded-full" style="background:var(--navy)"></span>
                        <h3 class="font-display font-bold text-navy text-xl">Secondary Level (Grades 6–10)</h3>
                    </div>
                    <p class="text-gray-500 text-sm mb-6" style="font-family:'Plus Jakarta Sans',sans-serif">Advanced curriculum preparing students for higher secondary education.</p>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach(['English','Mathematics','Science','Social Studies','Nepali/Hindi','Computer Science','Account','Optional Math'] as $subj)
                        <div class="flex items-center gap-2 text-sm text-gray-700" style="font-family:'Plus Jakarta Sans',sans-serif">
                            <svg class="w-4 h-4 shrink-0" style="color:var(--navy)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            {{ $subj }}
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- +2 Science --}}
        <div x-show="tab==='science'" x-cloak x-transition id="science" class="scroll-mt-24">
            <div class="grid md:grid-cols-2 gap-8">
                <div class="prog-img-card" style="aspect-ratio:4/3">
                    <img src="https://images.unsplash.com/photo-1576319155264-99536e0be1ee?w=800" alt="+2 Science">
                    <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(13,27,46,0.7) 0%, transparent 55%)"></div>
                </div>
                <div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-sm" style="border-top:2px solid var(--gold)">
                    <span class="text-xs font-bold px-3 py-1 rounded-full" style="background:var(--gold);color:var(--navy)">Grades 11–12</span>
                    <h3 class="font-display font-bold text-navy text-2xl mt-4 mb-3">+2 Science Stream</h3>
                    <p class="text-gray-500 text-sm mb-6 leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif">Rigorous science curriculum aligned with NEB syllabus, preparing students for medical, engineering, and technical higher education.</p>
                    <div class="space-y-1">
                        @foreach([['Physics','Advanced mechanics, waves, optics, modern physics'],['Chemistry','Organic, inorganic & physical chemistry with practicals'],['Biology','Cell biology, genetics, ecology (for Med stream)'],['Mathematics','Calculus, algebra, statistics (for Tech stream)'],['English','Advanced language and communication'],['Nepali','Regional language proficiency']] as [$s,$d])
                        <div class="subject-row">
                            <svg class="w-4 h-4 shrink-0 mt-0.5" style="color:var(--gold)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <div>
                                <div class="text-sm font-semibold text-navy" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $s }}</div>
                                <div class="text-xs text-gray-400 mt-0.5" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $d }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- +2 Management --}}
        <div x-show="tab==='management'" x-cloak x-transition id="management" class="scroll-mt-24">
            <div class="grid md:grid-cols-2 gap-8">
                <div class="prog-img-card" style="aspect-ratio:4/3">
                    <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=800" alt="+2 Management">
                    <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(13,27,46,0.7) 0%, transparent 55%)"></div>
                </div>
                <div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-sm" style="border-top:2px solid var(--navy-mid)">
                    <span class="text-xs font-bold px-3 py-1 rounded-full text-white" style="background:var(--navy)">Grades 11–12</span>
                    <h3 class="font-display font-bold text-navy text-2xl mt-4 mb-3">+2 Management Stream</h3>
                    <p class="text-gray-500 text-sm mb-6 leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif">Business and management curriculum preparing students for commerce, banking, entrepreneurship, and professional fields.</p>
                    <div class="space-y-1">
                        @foreach([['Business Studies','Entrepreneurship, marketing, management concepts'],['Accountancy','Bookkeeping, financial statements, taxation'],['Economics','Micro and macroeconomics, Nepali economy'],['Business Mathematics','Statistics, financial mathematics, data analysis'],['English','Advanced language and business communication'],['Nepali','Regional language proficiency']] as [$s,$d])
                        <div class="subject-row">
                            <svg class="w-4 h-4 shrink-0 mt-0.5" style="color:var(--navy)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <div>
                                <div class="text-sm font-semibold text-navy" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $s }}</div>
                                <div class="text-xs text-gray-400 mt-0.5" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $d }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</section>

{{-- ══ BEYOND ACADEMICS ═════════════════════════════════════════════════ --}}
<section class="py-28" style="background:var(--cream)">
<div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="text-center mb-16 reveal">
        <div class="section-label justify-center">Holistic Development</div>
        <h2 class="section-title">Beyond Academics</h2>
        <div class="gold-bar mx-auto mt-4"></div>
        <p class="text-gray-400 text-sm mt-6 max-w-xl mx-auto" style="font-family:'Plus Jakarta Sans',sans-serif">We believe in holistic development — sports, arts, music, debates, and community service.</p>
    </div>
    <div class="grid md:grid-cols-3 gap-6 stagger">
        @foreach([
            ['Sports & Athletics', 'Cricket, Football, Basketball, Athletics, and indoor games', 'var(--gold)'],
            ['Arts & Culture',     'Music, Dance, Drama, Art, and cultural celebrations',        'var(--navy)'],
            ['Competitions',       'Debates, Quiz, Science exhibitions, and essay writing',       '#D97706'],
        ] as [$title,$desc,$color])
        <div class="beyond-card bg-white p-8 border border-gray-100" style="border-left-color:{{ $color }}">
            <h3 class="font-display font-bold text-navy text-xl mb-3">{{ $title }}</h3>
            <p class="text-gray-400 text-sm leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $desc }}</p>
        </div>
        @endforeach
    </div>
</div>
</section>

{{-- ══ CTA ═══════════════════════════════════════════════════════════════ --}}
<section class="grand-cta py-28 text-white text-center"
    style="background:linear-gradient(135deg,#0D1B2E 0%,#1a237e 50%,#111d35 100%)"
    data-particle-1="rgba(255,255,255,0.15)" data-particle-2="rgba(255,193,7,0.25)">
    <canvas class="cta-canvas"></canvas>

    <div class="absolute -top-20 -left-20 w-80 h-80 border rounded-full pointer-events-none" style="border-color:rgba(255,255,255,0.04)"></div>
    <div class="absolute -bottom-20 -right-20 w-[440px] h-[440px] border rounded-full pointer-events-none" style="border-color:rgba(201,162,39,0.06)"></div>

    <div class="relative max-w-2xl mx-auto px-6 reveal">
        <div class="section-label justify-center" style="color:rgba(201,162,39,0.8)">Start Your Journey</div>
        <h2 class="font-display font-bold leading-tight mb-6 mt-2" style="font-size:clamp(2.2rem,5vw,3.8rem)">
            <span style="background:linear-gradient(90deg,#fff 0%,#C9A227 35%,#E2B93B 50%,#fff 65%);background-size:250% 100%;-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;animation:shimmer-gold 4s linear infinite">Ready to Join Us?</span>
        </h2>
        <p class="text-white/60 mb-12 leading-relaxed" style="font-size:15px;font-family:'Plus Jakarta Sans',sans-serif">
            Discover the right program for your child. Our admissions team is here to guide you through every step.
        </p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('admissions.index') }}" class="btn-primary">Apply for Admission</a>
            <a href="{{ route('contact.index') }}" class="btn-ghost-white">Contact Admissions</a>
        </div>
    </div>
</section>

@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                e.target.querySelectorAll('.gold-bar').forEach(b => setTimeout(() => b.classList.add('visible'), 250));
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
    document.querySelectorAll('.reveal, .stagger').forEach(el => obs.observe(el));

    document.querySelectorAll('.grand-cta').forEach(section => {
        const canvas = section.querySelector('.cta-canvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        const c1 = section.dataset.particle1 || 'rgba(255,255,255,0.15)';
        const c2 = section.dataset.particle2 || 'rgba(201,162,39,0.25)';
        let particles = [];
        function resize() { canvas.width = section.offsetWidth; canvas.height = section.offsetHeight; }
        window.addEventListener('resize', resize); resize();
        class Particle { constructor(){this.init();} init(){this.x=Math.random()*canvas.width;this.y=Math.random()*canvas.height;this.size=Math.random()*2+0.5;this.speedX=(Math.random()-.5)*.4;this.speedY=(Math.random()-.5)*.4;this.color=Math.random()>.5?c1:c2;} update(){this.x+=this.speedX;this.y+=this.speedY;if(this.x<0||this.x>canvas.width||this.y<0||this.y>canvas.height)this.init();} draw(){ctx.fillStyle=this.color;ctx.beginPath();ctx.arc(this.x,this.y,this.size,0,Math.PI*2);ctx.fill();} }
        for(let i=0;i<55;i++) particles.push(new Particle());
        (function animate(){ctx.clearRect(0,0,canvas.width,canvas.height);particles.forEach(p=>{p.update();p.draw();});requestAnimationFrame(animate);})();
    });
});
</script>
@endpush
