@extends('layouts.app')
@section('title', 'Life at SSSS — Sathya Sai Shiksha Sadan')

@push('styles')
<style>
@keyframes page-enter { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:none} }
@keyframes badge-drop { from{opacity:0;transform:translateY(-10px) scale(.95)} to{opacity:1;transform:none} }
@keyframes shimmer-gold { from{background-position:-200% 0} to{background-position:200% 0} }

.h-anim-1 { animation: badge-drop .6s .08s both cubic-bezier(0.23,1,0.32,1); }
.h-anim-2 { animation: page-enter .85s .2s  both cubic-bezier(0.23,1,0.32,1); }
.h-anim-3 { animation: page-enter .85s .38s both cubic-bezier(0.23,1,0.32,1); }

/* ── Activity cards ───────────────────────────────────────────── */
.activity-card {
    border-radius: 20px;
    transition: transform .28s var(--ease-spring),
                box-shadow .28s ease,
                border-color .22s var(--ease-out);
}
@media (hover:hover) and (pointer:fine) {
    .activity-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 48px rgba(13,27,46,0.10);
        border-color: rgba(201,162,39,0.3);
    }
    .activity-card:hover .activity-icon { background: rgba(201,162,39,0.14); border-color: rgba(201,162,39,0.4); }
}
.activity-card:active { transform: translateY(-3px) scale(0.99); }

.activity-icon {
    width: 48px; height: 48px; border-radius: 14px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    background: rgba(201,162,39,0.08);
    border: 1px solid rgba(201,162,39,0.16);
    transition: background .2s var(--ease-out), border-color .2s var(--ease-out);
    margin-bottom: 16px;
}

/* ── Boarding feature rows ────────────────────────────────────── */
.board-feat {
    display: flex; gap: 12px; align-items: flex-start;
    padding: 10px 10px;
    border-radius: 12px;
    transition: background .18s var(--ease-out);
}
@media (hover:hover) and (pointer:fine) {
    .board-feat:hover { background: rgba(201,162,39,0.05); }
}

/* ── Event cards ──────────────────────────────────────────────── */
.event-card {
    border-radius: 18px;
    border: 1px solid rgba(255,255,255,0.12);
    background: rgba(255,255,255,0.07);
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.1);
    backdrop-filter: blur(8px);
    transition: background .22s var(--ease-out),
                border-color .22s var(--ease-out),
                transform .22s var(--ease-spring);
}
@media (hover:hover) and (pointer:fine) {
    .event-card:hover {
        background: rgba(255,255,255,0.11);
        border-color: rgba(201,162,39,0.4);
        transform: translateY(-4px);
    }
}

/* ── Video play button ────────────────────────────────────────── */
.play-btn {
    width: 64px; height: 64px; border-radius: 50%;
    background: #fff;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 8px 32px rgba(0,0,0,0.3);
    transition: transform .22s var(--ease-spring), box-shadow .22s ease;
}
@media (hover:hover) and (pointer:fine) {
    .group:hover .play-btn {
        transform: scale(1.12);
        box-shadow: 0 12px 40px rgba(0,0,0,0.4);
    }
}

/* ── Grand CTA ────────────────────────────────────────────────── */
.grand-cta { position: relative; overflow: hidden; z-index: 1; }
.cta-canvas { position: absolute; top:0; left:0; width:100%; height:100%; z-index:-1; pointer-events:none; }
</style>
@endpush

@section('content')

{{-- ══ HERO ══════════════════════════════════════════════════════════ --}}
@php $hero = $hero ?? \App\Models\PageHero::forPage('life-at-ssss'); @endphp
@if($hero)
    <x-page-hero :hero="$hero" />
@endif

@if(($sections ?? collect())->isNotEmpty())
    @foreach($sections as $i => $section)
        @include('components.section-renderer', ['section' => $section, 'index' => $i])
    @endforeach
@else

{{-- ══ BEYOND TEXTBOOKS ═════════════════════════════════════════════════ --}}
<section class="py-28" style="background:#fff">
<div class="max-w-3xl mx-auto px-6 text-center">
    <div class="reveal">
        <div class="section-label justify-center">Our Community</div>
        <h2 class="section-title">Beyond Textbooks</h2>
        <div class="gold-bar mx-auto mt-4"></div>
        <p class="text-gray-500 leading-[1.85] mt-10" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:15px">
            At Sathya Sai Shiksha Sadan, we believe in holistic education. Life at SSSS offers numerous opportunities for
            students to explore their interests, develop new skills, build character, and grow into well-rounded individuals.
        </p>
    </div>
</div>
</section>

{{-- ══ CAMPUS TOUR VIDEO ════════════════════════════════════════════════ --}}
<section class="py-20" style="background:var(--navy)">
<div class="max-w-4xl mx-auto px-6 text-center reveal">
    <div class="section-label justify-center" style="color:rgba(201,162,39,0.8)">Virtual Tour</div>
    <h2 class="section-title-light font-display font-bold text-white mb-3" style="font-size:clamp(1.8rem,3.5vw,2.8rem)">See Life at SSSS</h2>
    <p class="text-white/55 mb-10 text-sm" style="font-family:'Plus Jakarta Sans',sans-serif">
        Experience the vibrant learning community of Sathya Sai Shiksha Sadan
    </p>
    <div class="relative rounded-[20px] overflow-hidden shadow-[0_32px_80px_rgba(0,0,0,0.4)] cursor-pointer group img-zoom">
        <img src="https://images.unsplash.com/photo-1562774053-701939374585?w=1200" alt="Campus" class="w-full aspect-video object-cover">
        <div class="absolute inset-0 flex flex-col items-center justify-center" style="background:rgba(0,0,0,0.38)">
            <div class="play-btn mb-4">
                <svg class="w-7 h-7 ml-1" style="color:var(--navy)" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                </svg>
            </div>
            <div class="text-white font-semibold text-sm tracking-wide" style="font-family:'Plus Jakarta Sans',sans-serif">Watch Campus Tour</div>
        </div>
    </div>
</div>
</section>

{{-- ══ STUDENT ACTIVITIES ═══════════════════════════════════════════════ --}}
<section class="py-28" style="background:#fff">
<div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="text-center mb-16 reveal">
        <div class="section-label justify-center">What We Do</div>
        <h2 class="section-title">Student Activities</h2>
        <div class="gold-bar mx-auto mt-4"></div>
    </div>
    <div class="grid md:grid-cols-3 gap-6 stagger">
        @foreach([
            ['M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3',  'Music & Dance',     'Traditional and modern music, dance classes and performances.',  'Weekly Classes',  'var(--gold)'],
            ['M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z', 'Sports & Athletics','Cricket, Football, Basketball, Athletics, and indoor games.', '10+ Sports',      'var(--navy)'],
            ['M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z',                                                                                                                                                                                    'Arts & Craft',      'Drawing, painting, handicrafts, and creative expression.',       'Art Programs',    '#D97706'],
            ['M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',                                                                                                                                                                                                                     'Value Education',   'Daily prayers, meditation, and character development sessions.',  'Daily Practice',  'var(--gold)'],
            ['M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',                                                                                            'Literary Activities','Debates, elocution, essay writing, and quiz competitions.',   'Regular Events',  'var(--navy)'],
            ['M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z',                                                                                                                                         'Cultural Programs', 'Annual day, festivals, and cultural celebrations.',              'Year-round',      '#D97706'],
        ] as [$iconPath, $title, $desc, $tag, $color])
        <div class="activity-card bg-white p-7 border border-gray-100">
            <div class="activity-icon" style="color:{{ $color }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPath }}"/>
                </svg>
            </div>
            <h3 class="font-display font-bold text-navy text-xl mb-2">{{ $title }}</h3>
            <p class="text-gray-400 text-sm mb-4 leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $desc }}</p>
            <span class="text-xs font-bold tracking-wide" style="color:{{ $color }};font-family:'Plus Jakarta Sans',sans-serif">{{ $tag }}</span>
        </div>
        @endforeach
    </div>
</div>
</section>

{{-- ══ BOARDING SNAPSHOT ════════════════════════════════════════════════ --}}
<section class="py-28" style="background:var(--cream)">
<div class="max-w-7xl mx-auto px-6 lg:px-10">
<div class="grid lg:grid-cols-2 gap-20 items-center">

    <div class="reveal from-left">
        <div class="img-zoom rounded-[24px] overflow-hidden shadow-[0_32px_80px_rgba(13,27,46,0.13)]" style="aspect-ratio:4/3">
            <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=800" alt="Boarding" class="w-full h-full object-cover">
        </div>
    </div>

    <div class="reveal from-right">
        <div class="section-label">Residential Life</div>
        <h2 class="section-title mb-4">Boarding at SSSS</h2>
        <div class="gold-bar mb-8"></div>
        <p class="text-gray-500 leading-[1.85] mt-8 mb-8" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:14.5px">
            Our residential boarding facility provides a safe, nurturing home-away-from-home for students.
        </p>
        <div class="grid sm:grid-cols-2 gap-2">
            @foreach([
                ['M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'Comfortable Dorms',    'Spacious, well-ventilated rooms'],
                ['M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z', 'Nutritious Meals',     'Freshly prepared vegetarian meals'],
                ['M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',      'Study Facilities',     'Supervised evening study hours'],
                ['M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', '24/7 Supervision',     'Trained resident housemasters'],
            ] as [$iconPath, $title, $desc])
            <div class="board-feat">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(201,162,39,0.09);border:1px solid rgba(201,162,39,0.18)">
                    <svg class="w-4.5 h-4.5" style="color:var(--gold);width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPath }}"/>
                    </svg>
                </div>
                <div>
                    <div class="text-sm font-semibold text-navy" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $title }}</div>
                    <div class="text-xs text-gray-400 mt-0.5 leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $desc }}</div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-8">
            <a href="{{ route('page.show','boarding') }}" class="btn-primary">
                Explore Boarding
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>

</div>
</div>
</section>

{{-- ══ ANNUAL EVENTS ════════════════════════════════════════════════════ --}}
<section class="py-28" style="background:var(--navy)">
<div class="max-w-7xl mx-auto px-6 lg:px-10 text-center">
    <div class="reveal">
        <div class="section-label justify-center" style="color:rgba(201,162,39,0.8)">Every Year</div>
        <h2 class="font-display font-bold text-white mb-3" style="font-size:clamp(1.8rem,3.5vw,2.8rem);line-height:1.1;letter-spacing:-0.02em">
            Annual Events &amp; Celebrations
        </h2>
        <div class="mx-auto mt-4 mb-3" style="width:0;height:2px;background:linear-gradient(90deg,var(--gold),var(--gold-light));border-radius:2px;transition:width .7s .25s var(--ease-out)" data-goldbar></div>
        <p class="text-white/55 mt-6 mb-14 text-sm max-w-2xl mx-auto" style="font-family:'Plus Jakarta Sans',sans-serif">
            We celebrate festivals and organise special events that bring our entire community together.
        </p>
    </div>
    <div class="grid sm:grid-cols-3 gap-6 stagger">
        @foreach([
            ['M15 10l4.553-2.069A1 1 0 0121 8.82v6.362a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z','Annual Day',    'Cultural performances'],
            ['M13 10V3L4 14h7v7l9-11h-7z',                                                                                                            'Sports Day',    'Athletic competitions'],
            ['M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z','Science Fair',  'Student innovations'],
        ] as [$iconPath, $title, $desc])
        <div class="event-card p-8">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-5" style="background:rgba(201,162,39,0.15);border:1px solid rgba(201,162,39,0.3)">
                <svg class="w-6 h-6" style="color:var(--gold)" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPath }}"/>
                </svg>
            </div>
            <h4 class="font-display font-bold text-white text-xl mb-2">{{ $title }}</h4>
            <p class="text-white/55 text-sm" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $desc }}</p>
        </div>
        @endforeach
    </div>
</div>
</section>

{{-- ══ CTA ═══════════════════════════════════════════════════════════════ --}}
<section class="grand-cta py-28 text-center"
    style="background:#fff"
    data-particle-type="geometric"
    data-particle-1="rgba(13,27,46,0.22)" data-particle-2="rgba(201,162,39,0.35)">
    <canvas class="cta-canvas"></canvas>

    <div class="max-w-2xl mx-auto px-6 reveal w-full" style="position:relative">
        <div class="section-label justify-center">Join SSSS</div>
        <h2 class="font-display font-bold text-navy mb-4" style="font-size:clamp(2rem,4.5vw,3.2rem);line-height:1.1">
            Ready to Be Part of SSSS?
        </h2>
        <div class="mx-auto mb-6" style="width:48px;height:2px;background:linear-gradient(90deg,var(--gold),var(--gold-light));border-radius:2px"></div>
        <p class="text-gray-400 mb-10 leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:15px">
            Join our vibrant community and experience education that nurtures the whole child.
        </p>
        <a href="{{ route('admissions.index') }}" class="btn-primary">
            Apply for Admission
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
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
                e.target.querySelectorAll('.gold-bar,[data-goldbar]').forEach(b => setTimeout(() => { b.style.width='48px'; }, 250));
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
    document.querySelectorAll('.reveal, .stagger').forEach(el => obs.observe(el));

    // Particle CTA — geometric shapes as per your original
    document.querySelectorAll('.grand-cta').forEach(section => {
        const canvas = section.querySelector('.cta-canvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        const c1 = section.dataset.particle1 || 'rgba(26,35,126,0.2)';
        const c2 = section.dataset.particle2 || 'rgba(201,162,39,0.3)';
        const type = section.dataset.particleType || 'geometric';
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
                ctx.save(); ctx.translate(this.x, this.y); ctx.rotate(this.rotation);
                ctx.fillStyle = this.color;
                if (type === 'geometric') {
                    ctx.shadowBlur = 2; ctx.shadowColor = this.color;
                    if (this.shape === 0) { ctx.beginPath(); ctx.arc(0,0,this.size/2,0,Math.PI*2); ctx.fill(); }
                    else if (this.shape === 1) { ctx.fillRect(-this.size/2,-this.size/2,this.size,this.size); }
                    else { ctx.beginPath(); ctx.moveTo(0,-this.size/2); ctx.lineTo(this.size/2,this.size/2); ctx.lineTo(-this.size/2,this.size/2); ctx.closePath(); ctx.fill(); }
                } else { ctx.beginPath(); ctx.arc(0,0,this.size/2,0,Math.PI*2); ctx.fill(); }
                ctx.restore();
            }
        }
        const count = Math.min(60, Math.floor((canvas.width * canvas.height) / 14000));
        for (let i = 0; i < count; i++) particles.push(new Particle());
        (function animate() { ctx.clearRect(0,0,canvas.width,canvas.height); particles.forEach(p=>{p.update();p.draw();}); requestAnimationFrame(animate); })();
    });
});
</script>
@endpush
