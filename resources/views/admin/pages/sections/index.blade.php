@extends('admin.layouts.admin')
@section('title', $pageTitle . ' — Sections')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-xs text-slate-400 mb-1">Dynamic Page Content</p>
            <p class="text-sm text-slate-500">
                Changes appear live on
                <a href="{{ $pageKey === 'home' ? url('/') : url('/' . $pageKey) }}" target="_blank"
                    class="text-gold-500 hover:underline font-medium">{{ $pageKey === 'home' ? '/' : '/' . $pageKey }}</a>
            </p>
        </div>
        <a href="{{ route('admin.sections.create', $pageKey) }}"
            class="inline-flex items-center gap-2 bg-navy-900 hover:bg-gold-500 text-white font-bold px-5 py-2.5 rounded-xl text-sm transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Section
        </a>
    </div>

    @if ($sections->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-16 text-center text-slate-400">
            <svg class="w-14 h-14 mx-auto mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
            </svg>
            <p class="font-semibold text-slate-500 text-lg">No sections yet</p>
            <p class="text-sm mt-1 mb-6">Add sections to build the {{ $pageTitle }} page content.</p>
            <a href="{{ route('admin.sections.create', $pageKey) }}"
                class="inline-block bg-navy-900 hover:bg-gold-500 text-white font-bold px-6 py-3 rounded-xl text-sm transition-colors">
                Add First Section →
            </a>
        </div>
    @else
        <div class="space-y-3" id="sections-list">
            @foreach ($sections as $section)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden"
                    data-id="{{ $section->id }}">

                    <div class="flex items-start gap-4 p-5">
                        {{-- Drag handle --}}
                        <div class="text-slate-300 hover:text-slate-500 cursor-grab mt-1 shrink-0" title="Drag to reorder">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M7 2a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 2zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 8zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 14zm6-8a2 2 0 1 0-.001-4.001A2 2 0 0 0 13 6zm0 2a2 2 0 1 0 .001 4.001A2 2 0 0 0 13 8zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 13 14z" />
                            </svg>
                        </div>

                        {{-- Thumbnail --}}
                        <div class="w-20 h-16 rounded-xl overflow-hidden bg-slate-100 shrink-0">
                            @if ($section->image_url)
                                <img src="{{ $section->image_url }}" alt="{{ $section->title }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap mb-1">
                                <h3 class="font-semibold text-navy-900 text-base truncate">
                                    {{ $section->title ?? '(No title)' }}
                                </h3>
                                @if ($section->badge_text)
                                    <span class="text-[10px] font-bold text-white px-2 py-0.5 rounded-full"
                                        style="background:{{ $section->badge_color ?? '#C9A227' }}">
                                        {{ $section->badge_text }}
                                    </span>
                                @endif
                            </div>
                            @if ($section->subtitle)
                                <p class="text-slate-400 text-xs mb-2 truncate">{{ $section->subtitle }}</p>
                            @endif
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-[10px] bg-slate-100 text-slate-500 font-mono px-2 py-0.5 rounded">
                                    layout: {{ $section->layout }}
                                </span>
                                <span
                                    class="text-[10px] px-2 py-0.5 rounded font-bold {{ $section->is_published ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-400' }}">
                                    {{ $section->is_published ? '● Published' : '○ Hidden' }}
                                </span>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-1 shrink-0">
                            {{-- Toggle visibility --}}
                            <form action="{{ route('admin.sections.toggle', [$pageKey, $section]) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    title="{{ $section->is_published ? 'Hide section' : 'Show section' }}"
                                    class="p-2 rounded-lg transition-colors {{ $section->is_published ? 'text-emerald-500 hover:bg-emerald-50' : 'text-slate-300 hover:bg-slate-50' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="{{ $section->is_published ? 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z' : 'M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21' }}" />
                                    </svg>
                                </button>
                            </form>

                            {{-- Edit --}}
                            <a href="{{ route('admin.sections.edit', [$pageKey, $section]) }}"
                                class="p-2 text-slate-400 hover:text-navy-900 hover:bg-slate-100 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route('admin.sections.destroy', [$pageKey, $section]) }}" method="POST"
                                onsubmit="return confirm('Delete this section?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Preview link --}}
        <div class="mt-6 text-center">
            <a href="{{ $pageKey === 'home' ? url('/') : url('/' . $pageKey) }}" target="_blank"
                class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-navy-900 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                Preview {{ $pageTitle }} page
            </a>
        </div>
    @endif

@endsection
