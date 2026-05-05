@extends('layouts.app')

@section('title', $hero?->meta_title ?? 'Testimonials')
@section('meta_description', $hero?->meta_description ?? 'Read parent and student testimonials from Sathya Sai Shiksha Sadan.')

@section('content')

    <x-page-hero :hero="$hero" title="Testimonials" subtitle="Voices from families, students, and alumni who have experienced value-based education at SSSS." breadcrumb="Testimonials" />

    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            @if ($testimonials->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm text-center py-20 px-6">
                    <div class="w-14 h-14 mx-auto rounded-2xl bg-gold/10 text-gold flex items-center justify-center mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                    </div>
                    <h2 class="font-display font-bold text-2xl text-navy mb-2">Testimonials coming soon</h2>
                    <p class="text-gray-500">Published testimonials will appear here automatically.</p>
                </div>
            @else
                <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach ($testimonials as $testimonial)
                        <article class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-lg transition-shadow">
                            <div class="flex items-center gap-4 mb-5">
                                <div class="w-14 h-14 rounded-2xl bg-navy/5 overflow-hidden flex items-center justify-center shrink-0">
                                    @if ($testimonial->photo_url)
                                        <img src="{{ $testimonial->photo_url }}" alt="{{ $testimonial->author_name }}"
                                            class="w-full h-full object-cover" loading="lazy">
                                    @else
                                        <span class="font-display font-bold text-xl text-gold">{{ strtoupper(substr($testimonial->author_name, 0, 1)) }}</span>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-display font-bold text-navy text-lg leading-tight">{{ $testimonial->author_name }}</h3>
                                    @if ($testimonial->author_role)
                                        <p class="text-sm text-gray-400">{{ $testimonial->author_role }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="flex gap-1 mb-4" aria-label="{{ $testimonial->rating }} star rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= (int) $testimonial->rating ? 'text-gold' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.802 2.035a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.802-2.035a1 1 0 00-1.176 0l-2.802 2.035c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 00.95-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>

                            <p class="text-gray-600 leading-relaxed text-sm">“{{ $testimonial->content }}”</p>

                            @if ($testimonial->is_featured)
                                <span class="inline-flex mt-5 text-[10px] font-bold uppercase tracking-wider text-gold bg-gold/10 rounded-full px-3 py-1">Featured story</span>
                            @endif
                        </article>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $testimonials->links() }}
                </div>
            @endif
        </div>
    </section>

@endsection
