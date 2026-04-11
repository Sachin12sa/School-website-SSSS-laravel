{{--
    Reusable page hero bar.
    Usage:
        @include('components.page-hero', [
            'breadcrumb' => 'News',
            'title'      => 'Latest News',
            'subtitle'   => 'Stay informed about what\'s happening at SSSS',  // optional
            'bg'         => 'https://...url...',  // optional background image
        ])
--}}
<div class="relative py-16 lg:py-20 overflow-hidden"
    style="background: linear-gradient(135deg, rgba(27,42,74,0.96) 0%, rgba(27,42,74,0.80) 60%, rgba(201,162,39,0.25) 100%)">

    {{-- Optional background image --}}
    @if (!empty($bg))
        <div class="absolute inset-0 -z-10">
            <img src="{{ $bg }}" alt="" class="w-full h-full object-cover">
        </div>
    @else
        {{-- Subtle dot-grid pattern --}}
        <div class="absolute inset-0 opacity-[0.04]"
            style="background-image: radial-gradient(circle, #C9A227 1px, transparent 1px); background-size: 28px 28px;">
        </div>
    @endif

    <div class="relative max-w-7xl mx-auto px-4 lg:px-8">
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-white/50 text-xs mb-4">
            <a href="{{ route('home') }}" class="hover:text-gold transition-colors">Home</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            @if (!empty($breadcrumb))
                <span class="text-gold">{{ $breadcrumb }}</span>
            @endif
        </div>

        {{-- Title --}}
        <h1 class="font-display font-bold text-4xl lg:text-5xl text-white leading-tight">
            {{ $title ?? 'Page' }}
        </h1>

        {{-- Subtitle --}}
        @if (!empty($subtitle))
            <p class="text-white/65 text-base lg:text-lg mt-3 max-w-2xl leading-relaxed">{{ $subtitle }}</p>
        @endif

        {{-- Gold accent line --}}
        <div class="w-12 h-0.5 bg-gold mt-5 rounded-full"></div>
    </div>
</div>
