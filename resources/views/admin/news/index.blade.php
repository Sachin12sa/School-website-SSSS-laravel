@extends('admin.layouts.admin')
@section('title', 'News & Updates')

@section('content')

    {{-- Success / Error flash --}}
    @if (session('success'))
        <div
            class="mb-5 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl px-5 py-3.5 text-sm font-medium">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Page header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-slate-400 text-xs mt-0.5">{{ $news->total() }} {{ Str::plural('article', $news->total()) }} total
            </p>
        </div>
        <a href="{{ route('admin.news.create') }}"
            class="inline-flex items-center gap-2 bg-navy-900 hover:bg-gold text-white font-bold px-5 py-2.5 rounded-xl text-sm transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            New Article
        </a>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @foreach ([['Total Articles', $stats['total'] ?? 0], ['Published', $stats['published'] ?? 0], ['Drafts', $stats['drafts'] ?? 0], ['Latest Publish', !empty($stats['latest']) ? \Carbon\Carbon::parse($stats['latest'])->format('d M Y') : '—']] as [$label, $value])
            <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wide text-slate-400">{{ $label }}</p>
                <p class="mt-2 font-display font-bold text-2xl text-navy-900">{{ $value }}</p>
            </div>
        @endforeach
    </div>

    {{-- Table --}}
    @if ($news->count())
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50">
                        <th class="text-left px-5 py-3.5 text-xs font-bold text-slate-400 uppercase tracking-wide">Article
                        </th>
                        <th
                            class="text-left px-4 py-3.5 text-xs font-bold text-slate-400 uppercase tracking-wide hidden md:table-cell">
                            Category</th>
                        <th
                            class="text-left px-4 py-3.5 text-xs font-bold text-slate-400 uppercase tracking-wide hidden lg:table-cell">
                            Published</th>
                        <th class="text-center px-4 py-3.5 text-xs font-bold text-slate-400 uppercase tracking-wide">Status
                        </th>
                        <th class="text-right px-5 py-3.5 text-xs font-bold text-slate-400 uppercase tracking-wide">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach ($news as $post)
                        <tr class="hover:bg-slate-50 transition-colors group">

                            {{-- Title + thumbnail --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl overflow-hidden shrink-0 bg-slate-100">
                                        @if ($post->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($post->image))
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($post->image) }}"
                                                alt="{{ $post->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-slate-800 text-sm leading-tight truncate max-w-xs">
                                            {{ $post->title }}
                                        </p>
                                        @if ($post->excerpt)
                                            <p class="text-slate-400 text-xs mt-0.5 truncate max-w-xs">
                                                {{ Str::limit($post->excerpt, 60) }}</p>
                                        @endif
                                        @if ($post->is_featured)
                                            <span
                                                class="inline-block mt-1 bg-gold/10 text-gold text-[10px] font-bold px-2 py-0.5 rounded-full">★
                                                Featured</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Category --}}
                            <td class="px-4 py-4 hidden md:table-cell">
                                @if ($post->category)
                                    <span
                                        class="text-xs bg-slate-100 text-slate-600 font-semibold px-2.5 py-1 rounded-full">
                                        {{ $post->category }}
                                    </span>
                                @else
                                    <span class="text-slate-300 text-xs">—</span>
                                @endif
                            </td>

                            {{-- Published date --}}
                            <td class="px-4 py-4 text-slate-400 text-xs hidden lg:table-cell">
                                @if ($post->published_at)
                                    {{ $post->published_at->format('d M Y') }}
                                @else
                                    <span class="text-slate-300">Not set</span>
                                @endif
                            </td>

                            {{-- Status badge --}}
                            <td class="px-4 py-4 text-center">
                                @if ($post->is_published)
                                    <span
                                        class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-700 text-[11px] font-bold px-2.5 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                        Published
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 bg-amber-100 text-amber-700 text-[11px] font-bold px-2.5 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 bg-amber-400 rounded-full"></span>
                                        Draft
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-1">
                                    {{-- Preview --}}
                                    @if ($post->is_published)
                                        <a href="{{ route('news.show', $post->slug) }}" target="_blank"
                                            title="View on site"
                                            class="p-2 text-slate-400 hover:text-navy-900 hover:bg-slate-100 rounded-xl transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    @endif

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.news.edit', $post) }}" title="Edit"
                                        class="p-2 text-slate-400 hover:text-navy-900 hover:bg-slate-100 rounded-xl transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('admin.news.destroy', $post) }}" method="POST"
                                        onsubmit="return confirm('Delete «{{ addslashes($post->title) }}»? This cannot be undone.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Delete"
                                            class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($news->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $news->links() }}
            </div>
        @endif
    @else
        {{-- Empty state --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-16 text-center">
            <svg class="w-14 h-14 text-slate-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
            </svg>
            <p class="text-slate-500 font-semibold text-lg mb-2">No articles yet</p>
            <p class="text-slate-400 text-sm mb-6">Create your first news post to keep parents and students informed.</p>
            <a href="{{ route('admin.news.create') }}"
                class="inline-flex items-center gap-2 bg-navy-900 hover:bg-gold text-white font-bold px-6 py-3 rounded-xl text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Write First Article
            </a>
        </div>
    @endif

@endsection
