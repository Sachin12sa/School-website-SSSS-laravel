@extends('admin.layouts.admin')
@section('title', 'Page Heroes')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="font-display font-bold text-navy text-2xl">Page Heroes</h1>
            <p class="text-gray-400 text-sm mt-1" style="font-family:'Plus Jakarta Sans',sans-serif">
                Manage hero sections across all pages
            </p>
        </div>
        <span class="text-xs text-gray-400 bg-gray-100 px-3 py-1.5 rounded-full font-medium">
            {{ $heroes->count() }} pages
        </span>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="flex items-center gap-3 rounded-xl p-4 mb-6 border text-sm"
         style="background:rgba(5,150,105,0.07);border-color:rgba(5,150,105,0.2);color:#047857;font-family:'Plus Jakarta Sans',sans-serif">
        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-sm" style="font-family:'Plus Jakarta Sans',sans-serif">
            <thead>
                <tr style="background:var(--cream);border-bottom:1px solid rgba(13,27,46,0.07)">
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Page</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Heading</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest hidden md:table-cell">Badge</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest hidden lg:table-cell">BG Image</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Status</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($heroes as $hero)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-semibold text-navy">{{ $hero->page_label }}</div>
                        <div class="text-gray-400 text-xs mt-0.5 font-mono">{{ $hero->page_slug }}</div>
                    </td>
                    <td class="px-6 py-4 text-gray-700 max-w-xs truncate">{{ $hero->heading }}</td>
                    <td class="px-6 py-4 text-gray-500 max-w-[180px] truncate hidden md:table-cell">
                        {{ $hero->badge_text ?? '—' }}
                    </td>
                    <td class="px-6 py-4 hidden lg:table-cell">
                        @if($hero->bg_image_path)
                        <div class="flex items-center gap-2">
                            <img src="{{ $hero->bgImageUrl() }}" class="w-12 h-8 rounded-lg object-cover border border-gray-100">
                            <span class="text-xs text-green-600 font-medium">Set</span>
                        </div>
                        @else
                        <span class="text-xs text-gray-300">Default gradient</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($hero->is_active)
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full"
                              style="background:rgba(5,150,105,0.1);color:#047857">Active</span>
                        @else
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full"
                              style="background:rgba(239,68,68,0.1);color:#DC2626">Inactive</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.heroes.edit', $hero) }}"
                           class="inline-flex items-center gap-1.5 text-xs font-bold px-4 py-2 rounded-lg border transition-colors"
                           style="border-color:rgba(13,27,46,0.14);color:var(--navy)"
                           onmouseenter="this.style.background='var(--navy)';this.style.color='#fff'"
                           onmouseleave="this.style.background='transparent';this.style.color='var(--navy)'">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection