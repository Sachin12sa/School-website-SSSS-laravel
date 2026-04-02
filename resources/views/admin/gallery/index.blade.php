@extends('admin.layouts.admin')
@section('title', 'Gallery')
@section('content')
    <div class="flex justify-end mb-6">
        <a href="{{ route('admin.gallery.create') }}"
            class="inline-flex items-center gap-2 bg-navy-900 hover:bg-gold-500 text-white font-semibold px-5 py-2.5 rounded-xl transition-colors text-sm shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>New Album
        </a>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($galleries as $gallery)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="aspect-video overflow-hidden bg-slate-100 relative">
                    @if ($gallery->cover_image)
                        <img src="{{ $gallery->cover_url }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center"><svg class="w-12 h-12 text-slate-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg></div>
                    @endif
                    <div class="absolute top-2 right-2 bg-black/50 text-white text-xs font-bold px-2 py-1 rounded-lg">
                        {{ $gallery->images_count }} photos</div>
                </div>
                <div class="p-5">
                    <h3 class="font-display font-bold text-navy-900 text-lg">{{ $gallery->name }}</h3>
                    @if ($gallery->description)
                        <p class="text-slate-400 text-sm mt-1 line-clamp-2">{{ $gallery->description }}</p>
                    @endif
                    <div class="flex items-center gap-2 mt-4">
                        <a href="{{ route('admin.gallery.edit', $gallery) }}"
                            class="flex-1 text-center border border-slate-200 text-slate-600 hover:bg-slate-50 py-2 rounded-xl text-xs font-semibold transition-colors">Manage
                            Photos</a>
                        <form action="{{ route('admin.gallery.destroy', $gallery) }}" method="POST"
                            onsubmit="return confirm('Delete this album and all its photos?')">@csrf
                            @method('DELETE')<button
                                class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-colors"><svg
                                    class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg></button></form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white rounded-2xl border border-slate-100 p-16 text-center text-slate-400">
                <p class="text-lg font-medium">No albums yet.</p><a href="{{ route('admin.gallery.create') }}"
                    class="mt-2 inline-block text-gold-500 hover:underline text-sm font-medium">Create the first album →</a>
            </div>
        @endforelse
    </div>
@endsection
