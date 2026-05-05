@extends('layouts.app')
@section('title', 'About Us — Sathya Sai Shiksha Sadan')

@push('styles')
<style>
/* ── About page animations ────────────────────────────────────── */
@keyframes page-enter { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:none} }
@keyframes badge-drop { from{opacity:0;transform:translateY(-10px) scale(.95)} to{opacity:1;transform:none} }

.h-anim-1 { animation: badge-drop .6s .08s both cubic-bezier(0.23,1,0.32,1); }
.h-anim-2 { animation: page-enter .85s .2s  both cubic-bezier(0.23,1,0.32,1); }
.h-anim-3 { animation: page-enter .85s .38s both cubic-bezier(0.23,1,0.32,1); }

/* ── Value card ───────────────────────────────────────────────── */
.value-card {
    border-top: 2px solid var(--gold);
    border-radius: 20px;
    transition: transform .28s var(--ease-spring),
                box-shadow .28s var(--ease-out);
}
@media (hover:hover) and (pointer:fine) {
    .value-card:hover { transform: translateY(-6px); box-shadow: 0 24px 48px rgba(13,27,46,0.10); }
}
.value-card:active { transform: translateY(-3px) scale(0.99); }

.value-icon {
    width: 52px; height: 52px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
    background: rgba(201,162,39,0.08);
    border: 1px solid rgba(201,162,39,0.18);
    transition: background .2s var(--ease-out), border-color .2s var(--ease-out);
}
.value-card:hover .value-icon { background: rgba(201,162,39,0.15); border-color: rgba(201,162,39,0.4); }

/* ── Journey timeline ─────────────────────────────────────────── */
.journey-row {
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 14px 0;
    border-bottom: 1px solid rgba(13,27,46,0.06);
    transition: background .18s var(--ease-out);
    cursor: default;
    padding-left: 10px; padding-right: 10px;
    border-radius: 8px;
}
@media (hover:hover) and (pointer:fine) {
    .journey-row:hover { background: rgba(201,162,39,0.04); }
    .journey-row:hover .journey-year { color: var(--gold); }
}
.journey-year {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; font-weight: 800;
    color: var(--navy);
    letter-spacing: 0.04em;
    transition: color .18s var(--ease-out);
    flex-shrink: 0; width: 52px;
}

/* ── Philosophy card ──────────────────────────────────────────── */
.phil-card {
    border-radius: 20px;
    border-left: 3px solid var(--gold);
    transition: transform .28s var(--ease-spring), box-shadow .28s ease;
}
@media (hover:hover) and (pointer:fine) {
    .phil-card:hover { transform: translateY(-5px); box-shadow: 0 20px 44px rgba(13,27,46,0.09); }
}

/* ── Facility card ────────────────────────────────────────────── */
.facility-card {
    border-radius: 20px;
    transition: transform .28s var(--ease-spring),
                box-shadow .28s ease,
                border-color .22s var(--ease-out);
}
@media (hover:hover) and (pointer:fine) {
    .facility-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 44px rgba(13,27,46,0.09);
        border-color: rgba(201,162,39,0.35);
    }
}
 /* ── Canvas Background Positioning ── */
 .cta-canvas {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none; /* Allows clicking buttons through the particles */
        z-index: 0;
    }
    
    /* ── Shimmering Text for the Title ── */
    .text-shimmer {
        background: linear-gradient(90deg, #ffffff 0%, #c9a227 50%, #ffffff 100%);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: shimmer 4s linear infinite;
    }
    @keyframes shimmer { to { background-position: 200% center; } }
    
    /* Ensure the section is the "parent" for the canvas */
    .grand-cta {
        position: relative !important;
        overflow: hidden;
    }
</style>
@endpush

@section('content')

{{-- ══ HERO ══════════════════════════════════════════════════════════ --}}
@php $hero = $hero ?? \App\Models\PageHero::forPage('about'); @endphp
@if($hero)
    <x-page-hero :hero="$hero" />
@endif

@if(($sections ?? collect())->isNotEmpty())
    @foreach($sections as $i => $section)
        @include('components.section-renderer', ['section' => $section, 'index' => $i])
    @endforeach
@else

{{-- ══ OUR MISSION ══════════════════════════════════════════════════════ --}}
<section class="py-28" style="background:#fff">
<div class="max-w-3xl mx-auto px-6 text-center">
    <div class="reveal">
        <div class="section-label justify-center">Why We Exist</div>
        <h2 class="section-title">Our Mission</h2>
        <div class="gold-bar mx-auto mt-4"></div>
        <p class="text-gray-500 leading-[1.85] mt-10 mb-6" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:15px">
            Sathya Sai Shiksha Sadan is dedicated to providing quality education that nurtures not just academic
            excellence, but also character development through the five human values: Truth, Right Conduct, Peace, Love,
            and Non-Violence.
        </p>
        <p class="text-gray-400 leading-[1.85]" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:14px">
            We believe that education should develop the whole person — intellectually, emotionally, physically, and
            spiritually. Our students emerge as responsible citizens who contribute positively to society while
            maintaining strong moral and ethical foundations.
        </p>
    </div>
</div>
</section>

{{-- ══ FIVE HUMAN VALUES ════════════════════════════════════════════════ --}}
<section class="py-28" style="background:var(--cream)">
<div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="text-center mb-16 reveal">
        <div class="section-label justify-center">Our Philosophy</div>
        <h2 class="section-title">Five Human Values</h2>
        <div class="gold-bar mx-auto mt-4"></div>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 stagger">

        @foreach([
            ['Truth (Sathya)',         'We cultivate honesty and integrity in all aspects of student life.',                   'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
            ['Right Conduct (Dharma)', 'We instill moral and ethical behavior through example and practice.',                   'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
            ['Peace (Shanti)',          'We nurture inner harmony and peaceful coexistence among students.',                    'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0'],
            ['Love & Non-Violence',    'We promote compassion, service, and respect for all life.',                            'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
        ] as [$title, $desc, $iconPath])
        <div class="value-card bg-white p-8 text-center">
            <div class="value-icon" style="color:var(--gold)">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPath }}"/>
                </svg>
            </div>
            <h3 class="font-display font-bold text-navy text-lg mb-3">{{ $title }}</h3>
            <p class="text-gray-400 text-sm leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $desc }}</p>
        </div>
        @endforeach

    </div>
</div>
</section>

{{-- ══ OUR JOURNEY ══════════════════════════════════════════════════════ --}}
<section class="py-28" style="background:#fff">
<div class="max-w-7xl mx-auto px-6 lg:px-10">
<div class="grid lg:grid-cols-2 gap-20 items-center">

    {{-- Timeline --}}
    <div class="reveal from-left">
        <div class="section-label">Our Story</div>
        <h2 class="section-title">Our Journey</h2>
        <div class="gold-bar mt-4"></div>
        <p class="text-gray-500 leading-[1.85] mt-10 mb-8" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:14.5px">
            Since our establishment in 2000, Sathya Sai Shiksha Sadan has been committed to providing holistic
            education that combines academic rigour with character development. What began as a small institution
            has grown into a respected educational centre serving hundreds of students from grades 1 through +2.
        </p>
        <div class="space-y-1">
            @foreach([
                ['2000','Sathya Sai Shiksha Sadan established'],
                ['2005','Expanded to secondary level (up to grade 10)'],
                ['2010','Introduced +2 Science program'],
                ['2015','+2 Management program launched'],
                ['2026','26 years of excellence in education'],
            ] as [$year,$milestone])
            <div class="journey-row">
                <span class="journey-year">{{ $year }}</span>
                <span class="text-gray-500 text-sm text-right" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $milestone }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Image --}}
    <div class="reveal from-right">
        <div class="img-zoom rounded-[24px] overflow-hidden shadow-[0_32px_80px_rgba(13,27,46,0.13)]" style="aspect-ratio:4/3">
            <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=800" alt="Our Journey" class="w-full h-full object-cover">
        </div>
    </div>

</div>
</div>
</section>

{{-- ══ EDUCATIONAL PHILOSOPHY ═══════════════════════════════════════════ --}}
<section class="py-28" style="background:var(--cream)">
<div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="text-center mb-16 reveal">
        <div class="section-label justify-center">How We Think</div>
        <h2 class="section-title">Our Educational Philosophy</h2>
        <div class="gold-bar mx-auto mt-4"></div>
    </div>
    <div class="grid md:grid-cols-3 gap-6 stagger">
        @foreach([
            ['Educare',              'Drawing out the inherent goodness and potential within each child rather than just filling them with information.'],
            ['Ceiling on Desires',   'Teaching students to live sustainably and responsibly, avoiding waste and excessive consumption.'],
            ['Service to Society',   'Encouraging students to use their education for the betterment of society through selfless service.'],
        ] as [$title, $desc])
        <div class="phil-card bg-white p-8 border border-gray-100">
            <h3 class="font-display font-bold text-navy text-xl mb-4">{{ $title }}</h3>
            <p class="text-gray-400 text-sm leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $desc }}</p>
        </div>
        @endforeach
    </div>
</div>
</section>

{{-- ══ FACILITIES ════════════════════════════════════════════════════════ --}}
<section class="py-28" style="background:#fff">
<div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="text-center mb-16 reveal">
        <div class="section-label justify-center">Campus</div>
        <h2 class="section-title">Our Facilities</h2>
        <div class="gold-bar mx-auto mt-4"></div>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 stagger">
        @foreach([
            ['Modern Classrooms',      'Well-ventilated, spacious classrooms equipped with modern teaching aids and comfortable seating arrangements.',    'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
            ['Science Laboratories',   'Fully equipped Physics, Chemistry, and Biology labs for hands-on practical learning and experiments.',              'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z'],
            ['Library & Computer Lab', 'Well-stocked library with diverse books and a modern computer lab with internet connectivity.',                    'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
            ['Sports Facilities',      'Playground for cricket, football, basketball, and facilities for indoor games and athletics.',                     'M13 10V3L4 14h7v7l9-11h-7z'],
            ['Meditation Hall',        'Dedicated space for prayer, meditation, and value education activities promoting inner peace.',                    'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
            ['Cafeteria',             'Clean and hygienic cafeteria providing nutritious meals and snacks for students throughout the day.',              'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'],
        ] as [$name, $desc, $iconPath])
        <div class="facility-card bg-white p-7 border border-gray-100">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-5" style="background:rgba(201,162,39,0.09);border:1px solid rgba(201,162,39,0.18)">
                <svg class="w-5 h-5" style="color:var(--gold)" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPath }}"/>
                </svg>
            </div>
            <h3 class="font-display font-bold text-navy text-lg mb-3">{{ $name }}</h3>
            <p class="text-gray-400 text-sm leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif">{{ $desc }}</p>
        </div>
        @endforeach
    </div>
</div>
</section>

{{-- ══ CTA ═══════════════════════════════════════════════════════════════ --}}
{{-- ── FINAL CTA: Adjusted for "Grand" Layout ────────────────────────────── --}}
<section class="grand-cta min-h-[550px] flex items-center py-24 text-white text-center relative overflow-hidden"
    style="background: linear-gradient(140deg, #0D1B2E 0%, #111d35 40%, #1a1035 70%, #0D1B2E 100%)"
    data-particle-1="rgba(255,255,255,0.12)" 
    data-particle-2="rgba(201,162,39,0.22)">

    {{-- Background Decorative Rings (as seen in your image) --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-24 -left-24 w-96 h-96 border border-white/5 rounded-full"></div>
        <div class="absolute -bottom-32 -right-32 w-[500px] h-[500px] border border-gold/10 rounded-full"></div>
        <div class="absolute bottom-10 right-40 w-32 h-32 border border-white/5 rounded-full"></div>
    </div>

    <div class="relative max-w-3xl mx-auto px-6 reveal w-full">
        {{-- Label --}}
        <div class="section-label justify-center tracking-[0.2em] text-gold/80 mb-4">
            BE PART OF SSSS
        </div>

        {{-- Main Heading with Shimmer --}}
        <h2 class="font-display font-bold text-white leading-[1.1] mb-8 text-shimmer" 
            style="font-size: clamp(2.5rem, 6vw, 4.2rem);">
            Ready to Begin<br>Your Journey?
        </h2>

        {{-- Description --}}
        <p class="text-white/50 mb-12 leading-relaxed mx-auto max-w-xl" 
           style="font-size: 16px; font-family: 'Plus Jakarta Sans', sans-serif;">
            Join a school where excellence meets values. Our admissions team is here to help you find your path.
        </p>

        {{-- Buttons matching image style --}}
        <div class="flex flex-wrap gap-5 justify-center">
            <a href="{{ route('admissions.index') }}" 
               class="bg-gold hover:bg-white hover:text-navy text-white font-bold px-10 py-4 rounded-xl text-sm shadow-2xl transition-all hover:-translate-y-1">
                Apply for Admission —>
            </a>
            <a href="{{ route('contact.index') }}" 
               class="bg-white/5 border border-white/20 hover:border-white/40 text-white font-semibold px-10 py-4 rounded-xl transition-all text-sm backdrop-blur-sm">
                Contact Us
            </a>
        </div>
    </div>
</section>

@endif
@endsection
@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', () => {
    // Scroll reveal (uses global observer from app.blade)
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                e.target.querySelectorAll('.gold-bar').forEach(b => setTimeout(() => b.classList.add('visible'), 250));
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
    document.querySelectorAll('.reveal, .stagger').forEach(el => obs.observe(el));
document.addEventListener('DOMContentLoaded', () => {
    // ── Particle Engine ──
    const ctaSections = document.querySelectorAll('.grand-cta');

    ctaSections.forEach(section => {
        let canvas = section.querySelector('.cta-canvas');
        if (!canvas) {
            canvas = document.createElement('canvas');
            canvas.className = 'cta-canvas';
            section.prepend(canvas); // Put it behind the content
        }

        const ctx = canvas.getContext('2d');
        let particles = [];
        
        // Get colors from data attributes
        const c1 = section.dataset.particle1 || 'rgba(255,255,255,0.15)';
        const c2 = section.dataset.particle2 || 'rgba(201,162,39,0.25)';

        function resize() {
            canvas.width = section.offsetWidth;
            canvas.height = section.offsetHeight;
        }
        
        window.addEventListener('resize', resize);
        resize();

        class Particle {
            constructor() { this.init(); }
            init() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.size = Math.random() * 2 + 0.5;
                this.speedX = (Math.random() - 0.5) * 0.4;
                this.speedY = (Math.random() - 0.5) * 0.4;
                this.color = Math.random() > 0.5 ? c1 : c2;
            }
            update() {
                this.x += this.speedX;
                this.y += this.speedY;
                // Wrap around edges
                if (this.x < 0) this.x = canvas.width;
                if (this.x > canvas.width) this.x = 0;
                if (this.y < 0) this.y = canvas.height;
                if (this.y > canvas.height) this.y = 0;
            }
            draw() {
                ctx.fillStyle = this.color;
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        // Create 60 particles
        for (let i = 0; i < 60; i++) {
            particles.push(new Particle());
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particles.forEach(p => {
                p.update();
                p.draw();
            });
            requestAnimationFrame(animate);
        }
        animate();
    });

    // ── Intersection Observer (For the "Reveal" effect) ──
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                // Support for your "active" class as well
                e.target.classList.add('active'); 
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal, .stagger').forEach(el => obs.observe(el));
});
</script>

@endpush
