@extends('admin.layouts.admin')
@section('title', 'News Posts')
@section('content')
    <div class="flex items-center justify-between mb-6">
        <div></div>
        <a href="{{ route('admin.news.create') }}"
            class="bg-navy hover:bg-gold text-white font-semibold px-5 py-2.5 rounded-xl transition-colors text-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>New Post
        </a>
    </div>
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-6 py-4 font-semibold text-navy">Title</th>
                    <th class="text-left px-6 py-4 font-semibold text-navy hidden md:table-cell">Category</th>
                    <th class="text-left px-6 py-4 font-semibold text-navy hidden lg:table-cell">Published</th>
                    <th class="text-left px-6 py-4 font-semibold text-navy">Status</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($news as $post)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-medium text-navy">{{ Str::limit($post->title, 50) }}</div>
                            @if ($post->is_featured)
                                <span
                                    class="text-xs bg-gold/10 text-gold font-semibold px-2 py-0.5 rounded-full mt-1 inline-block">Featured</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-500 hidden md:table-cell">{{ $post->category ?? '—' }}</td>
                        <td class="px-6 py-4 text-gray-500 hidden lg:table-cell">
                            {{ $post->published_at?->format('d M Y') ?? '—' }}</td>
                        <td class="px-6 py-4"><span
                                class="text-xs font-bold px-2 py-1 rounded-full {{ $post->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $post->is_published ? 'Published' : 'Draft' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2 justify-end">
                                <a href="{{ route('admin.news.edit', $post) }}"
                                    class="text-navy hover:text-gold transition-colors p-1"><svg class="w-4 h-4"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg></a>
                                <form action="{{ route('admin.news.destroy', $post) }}" method="POST"
                                    onsubmit="return confirm('Delete this post?')">
                                    <@csrf @method('DELETE')<button type="submit"
                                        class="text-red-400 hover:text-red-600 transition-colors p-1"><svg class="w-4 h-4"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty<tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400">No news posts yet. <a
                                href="{{ route('admin.news.create') }}" class="text-gold hover:underline">Create the first
                                one.</a></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if ($news->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">{{ $news->links() }}</div>
        @endif
    </div>
@endsection
