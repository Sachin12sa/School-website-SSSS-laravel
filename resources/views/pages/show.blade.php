@extends('layouts.app')
@section('title', $page->meta_title ?? $page->title)
@section('meta_description', $page->meta_description ?? '')

@push('styles')
<style>
@keyframes page-enter { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:none} }
@keyframes badge-drop { from{opacity:0;transform:translateY(-10px) scale(.95)} to{opacity:1;transform:none} }

.h-anim-1 { animation: badge-drop .6s .05s both cubic-bezier(0.23,1,0.32,1); }
.h-anim-2 { animation: page-enter .85s .18s both cubic-bezier(0.23,1,0.32,1); }
.h-anim-3 { animation: page-enter .85s .34s both cubic-bezier(0.23,1,0.32,1); }
.h-anim-4 { animation: page-enter .85s .48s both cubic-bezier(0.23,1,0.32,1); }

/* ── Breadcrumb ───────────────────────────────────────────────── */
.breadcrumb-link {
    color: rgba(255,255,255,0.5);
    font-size: 12px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    transition: color .18s var(--ease-out);
}
.breadcrumb-link:hover { color: var(--gold); }

/* ── Prose content ────────────────────────────────────────────── */
.page-prose {
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: #4B5563;
    line-height: 1.85;
    font-size: 15px;
}

.page-prose h2 {
    font-family: 'Cormorant Garamond', Georgia, serif;
    font-size: clamp(1.7rem, 3vw, 2.4rem);
    font-weight: 700;
    color: var(--navy);
    letter-spacing: -0.02em;
    line-height: 1.15;
    margin-top: 2.5rem;
    margin-bottom: 1rem;
}

.page-prose h3 {
    font-family: 'Cormorant Garamond', Georgia, serif;
    font-size: clamp(1.3rem, 2.2vw, 1.7rem);
    font-weight: 700;
    color: var(--navy);
    margin-top: 2rem;
    margin-bottom: 0.75rem;
}

.page-prose p { margin-bottom: 1.25rem; }

.page-prose a {
    color: var(--gold);
    text-decoration: none;
    border-bottom: 1px solid rgba(201,162,39,0.3);
    transition: border-color .18s var(--ease-out), color .18s var(--ease-out);
}
.page-prose a:hover { color: var(--gold-dark); border-color: var(--gold); }

.page-prose ul { margin-bottom: 1.25rem; padding-left: 0; list-style: none; }
.page-prose ul li {
    position: relative; padding-left: 20px; margin-bottom: 0.5rem;
}
.page-prose ul li::before {
    content: '';
    position: absolute; left: 0; top: 8px;
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--gold);
}

.page-prose ol { margin-bottom: 1.25rem; padding-left: 0; list-style: none; counter-reset: ol-counter; }
.page-prose ol li {
    position: relative; padding-left: 28px; margin-bottom: 0.5rem;
    counter-increment: ol-counter;
}
.page-prose ol li::before {
    content: counter(ol-counter) '.';
    position: absolute; left: 0;
    font-weight: 700; color: var(--gold); font-size: 13px;
}

.page-prose strong { font-weight: 700; color: var(--navy); }

.page-prose img {
    border-radius: 18px;
    box-shadow: 0 20px 48px rgba(13,27,46,0.12);
    margin: 1.5rem 0;
    width: 100%;
}

.page-prose blockquote {
    border-left: 3px solid var(--gold);
    padding: 12px 20px;
    margin: 1.5rem 0;
    background: rgba(201,162,39,0.05);
    border-radius: 0 12px 12px 0;
    font-style: italic;
    color: var(--text-muted);
}

/* ── Dynamic blocks ───────────────────────────────────────────── */
.block-section {
    transition: none;
}

/* ── CTA strip ────────────────────────────────────────────────── */
.cta-strip {
    background: linear-gradient(140deg, #0D1B2E 0%, #111d35 40%, #1a1035 70%, #0D1B2E 100%);
    position: relative;
    overflow: hidden;
}

.cta-strip::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 30% 50%, rgba(201,162,39,0.08) 0%, transparent 65%);
    pointer-events: none;
}
</style>
@endpush

@section('content')

{{-- ══ PAGE HERO ═════════════════════════════════════════════════════════ --}}
<section class="relative flex items-center overflow-hidden" style="min-height:56vh;background:#060e1c">

    @if($page->hero_image)
    <div class="absolute inset-0">
        <img src="{{ asset('storage/' . $page->hero_image) }}" alt="{{ $page->title }}"
             class="w-full h-full object-cover opacity-28">
        <div class="absolute inset-0" style="background:linear-gradient(135deg,rgba(6,14,28,0.96) 0%,rgba(13,27,46,0.88) 60%,rgba(201,162,39,0.06) 100%)"></div>
    </div>
    @else
    <div class="absolute inset-0">
        {{-- Subtle grid --}}
        <div class="absolute inset-0" style="background:linear-gradient(150deg,#070e1d 0%,#0d1b35 30%,#060a14 100%)"></div>
        <div class="absolute inset-0 pointer-events-none" style="opacity:.025;background-image:linear-gradient(rgba(201,162,39,1) 1px,transparent 1px),linear-gradient(90deg,rgba(201,162,39,1) 1px,transparent 1px);background-size:70px 70px"></div>
    </div>
    @endif

    {{-- Decorative rings --}}
    <div class="absolute top-12 right-16 w-64 h-64 border rounded-full pointer-events-none hidden xl:block" style="border-color:rgba(255,255,255,0.04)"></div>
    <div class="absolute top-28 right-28 w-40 h-40 border rounded-full pointer-events-none hidden xl:block" style="border-color:rgba(201,162,39,0.07)"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-10 w-full py-28">
        <div class="max-w-3xl">

            {{-- School name badge --}}
            <div class="h-anim-1" style="display:inline-flex;align-items:center;gap:8px;background:rgba(201,162,39,0.12);border:1px solid rgba(201,162,39,0.28);box-shadow:inset 0 1px 0 rgba(255,255,255,0.08);color:var(--gold);font-size:10.5px;font-weight:700;letter-spacing:0.13em;text-transform:uppercase;padding:8px 18px;border-radius:50px;margin-bottom:1.5rem">
                <span class="w-1.5 h-1.5 rounded-full" style="background:var(--gold)"></span>
                {{ \App\Models\SiteSetting::get('school_name') }}
            </div>

            <h1 class="h-anim-2 font-display font-bold text-white mb-5" style="font-size:clamp(2.6rem,6vw,4.5rem);line-height:1.06;letter-spacing:-0.025em">
                {{ $page->hero_title ?? $page->title }}
            </h1>

            @if($page->hero_subtitle)
            <p class="h-anim-3 text-white/60 leading-relaxed max-w-xl mb-8" style="font-size:clamp(0.95rem,2vw,1.1rem);font-family:'Plus Jakarta Sans',sans-serif">
                {{ $page->hero_subtitle }}
            </p>
            @endif

            {{-- Breadcrumb --}}
            <div class="h-anim-4 flex items-center gap-2">
                <a href="{{ route('home') }}" class="breadcrumb-link">Home</a>
                <svg class="w-3 h-3 opacity-40" style="color:rgba(255,255,255,0.5)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-xs font-semibold" style="color:var(--gold);font-family:'Plus Jakarta Sans',sans-serif">{{ $page->title }}</span>
            </div>

        </div>
    </div>
</section>

{{-- ══ PAGE CONTENT ═════════════════════════════════════════════════════ --}}
@if($page->content)
<section class="py-24" style="background:#fff">
    <div class="max-w-4xl mx-auto px-6">
        <div class="page-prose">
            {!! $page->content !!}
        </div>
    </div>
</section>
@endif

{{-- ══ DYNAMIC BLOCKS ════════════════════════════════════════════════════ --}}
@if($page->blocks->count())
    @foreach($page->blocks->where('is_visible', true)->sortBy('order') as $block)
    <section class="py-16 block-section" style="{{ $loop->even ? 'background:var(--cream)' : 'background:#fff' }}">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            @if($block->title)
            <div class="mb-8 reveal">
                <h2 class="font-display font-bold text-navy" style="font-size:clamp(1.7rem,3vw,2.4rem);line-height:1.1;letter-spacing:-0.02em">{{ $block->title }}</h2>
                <div class="mt-3" style="width:48px;height:2px;background:linear-gradient(90deg,var(--gold),var(--gold-light));border-radius:2px"></div>
            </div>
            @endif
            @if($block->content)
            <div class="page-prose reveal">
                {!! $block->content !!}
            </div>
            @endif
        </div>
    </section>
    @endforeach
@endif

{{-- ══ CTA STRIP ═════════════════════════════════════════════════════════ --}}
<section class="cta-strip py-24">
    <div class="relative max-w-4xl mx-auto px-6 text-center reveal">
        <div class="section-label justify-center" style="color:rgba(201,162,39,0.8)">Take the Next Step</div>
        <h2 class="font-display font-bold text-white mb-4 mt-2" style="font-size:clamp(1.8rem,4vw,3rem);line-height:1.1">
            Ready to Learn More?
        </h2>
        <p class="text-white/45 mb-10 leading-relaxed" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:14px">
            Get in touch with our team or apply for admission today.
        </p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('admissions.index') }}" class="btn-primary">Apply Now</a>
            <a href="{{ route('contact.index') }}" class="btn-ghost-white">Contact Us</a>
        </div>
    </div>
</section>

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
});
</script>
@endpush