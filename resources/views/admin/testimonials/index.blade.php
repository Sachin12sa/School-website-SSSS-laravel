{{-- testimonials/index --}}
@extends('admin.layouts.admin')
@section('title', 'Testimonials')
@section('content')
    <div class="flex justify-end mb-6">
        <a href="{{ route('admin.testimonials.create') }}"
            class="inline-flex items-center gap-2 bg-navy-900 hover:bg-gold-500 text-white font-semibold px-5 py-2.5 rounded-xl transition-colors text-sm shadow-sm"><svg
                class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>Add Testimonial</a>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @foreach ([['Total Stories', $stats['total'] ?? 0], ['Published', $stats['published'] ?? 0], ['Featured', $stats['featured'] ?? 0], ['Hidden', $stats['hidden'] ?? 0]] as [$label, $value])
            <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wide text-slate-400">{{ $label }}</p>
                <p class="mt-2 font-display font-bold text-2xl text-navy-900">{{ $value }}</p>
            </div>
        @endforeach
    </div>
    <div class="space-y-3">
        @forelse($testimonials as $t)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-start justify-between gap-4">
                <div class="flex items-start gap-4">
                    @if ($t->photo_url)
                    <img src="{{ $t->photo_url }}" class="w-11 h-11 rounded-full object-cover shrink-0">@else<div
                            class="w-11 h-11 rounded-full bg-navy-100 flex items-center justify-center text-navy-700 font-bold shrink-0">
                            {{ substr($t->author_name, 0, 1) }}</div>
                    @endif
                    <div>
                        <p class="font-bold text-navy-900">{{ $t->author_name }} @if ($t->author_role)
                                <span class="font-normal text-slate-400 text-sm">— {{ $t->author_role }}</span>
                            @endif
                        </p>
                        <p class="text-slate-500 text-sm mt-1 line-clamp-2">{{ $t->content }}</p>
                        <div class="flex items-center gap-2 mt-2">
                            @if ($t->is_featured)
                                <span
                                    class="text-xs bg-gold-100 text-gold-700 font-bold px-2 py-0.5 rounded-full">Featured</span>
                            @endif
                            <span
                                class="text-xs px-2 py-0.5 rounded-full font-bold {{ $t->is_published ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-400' }}">{{ $t->is_published ? 'Published' : 'Hidden' }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-1 shrink-0">
                    <a href="{{ route('admin.testimonials.edit', $t) }}"
                        class="p-2 text-slate-400 hover:text-navy-900 hover:bg-slate-100 rounded-lg transition-colors"><svg
                            class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg></a>
                    <form action="{{ route('admin.testimonials.destroy', $t) }}" method="POST"
                        onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button
                            class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"><svg
                                class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg></button></form>
                </div>
            </div>
        @empty<div class="bg-white rounded-2xl border border-slate-100 p-16 text-center text-slate-400">No testimonials
                yet.</div>
        @endforelse
        @if ($testimonials->hasPages())
            <div class="mt-4">{{ $testimonials->links() }}</div>
        @endif
    </div>
@endsection
