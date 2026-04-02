@extends('admin.layouts.admin')
@section('title', 'Faculty Members')
@section('content')
    <div class="flex justify-end mb-6">
        <a href="{{ route('admin.teachers.create') }}"
            class="inline-flex items-center gap-2 bg-navy-900 hover:bg-gold-500 text-white font-semibold px-5 py-2.5 rounded-xl transition-colors text-sm shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>Add Teacher
        </a>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50/50">
                    <th class="text-left px-6 py-4 font-semibold text-navy-900 text-xs uppercase tracking-wide">Teacher</th>
                    <th
                        class="text-left px-6 py-4 font-semibold text-navy-900 text-xs uppercase tracking-wide hidden md:table-cell">
                        Department</th>
                    <th
                        class="text-left px-6 py-4 font-semibold text-navy-900 text-xs uppercase tracking-wide hidden lg:table-cell">
                        Order</th>
                    <th class="text-left px-6 py-4 font-semibold text-navy-900 text-xs uppercase tracking-wide">Status</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($teachers as $teacher)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $teacher->photo_url }}" alt="{{ $teacher->name }}"
                                    class="w-9 h-9 rounded-full object-cover shrink-0 bg-slate-100">
                                <div>
                                    <div class="font-medium text-navy-900">{{ $teacher->name }}</div>
                                    <div class="text-slate-400 text-xs">{{ $teacher->designation }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-500 hidden md:table-cell">{{ $teacher->department ?? '—' }}</td>
                        <td class="px-6 py-4 text-slate-400 hidden lg:table-cell">{{ $teacher->order }}</td>
                        <td class="px-6 py-4"><span
                                class="text-xs font-bold px-2.5 py-1 rounded-full {{ $teacher->is_published ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">{{ $teacher->is_published ? 'Published' : 'Hidden' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1 justify-end">
                                <a href="{{ route('admin.teachers.edit', $teacher) }}"
                                    class="p-2 text-slate-400 hover:text-navy-900 hover:bg-slate-100 rounded-lg transition-colors"><svg
                                        class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg></a>
                                <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST"
                                    onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button
                                        class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"><svg
                                            class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg></button></form>
                            </div>
                        </td>
                    </tr>
                @empty<tr>
                        <td colspan="5" class="px-6 py-16 text-center text-slate-400">No teachers yet. <a
                                href="{{ route('admin.teachers.create') }}" class="text-gold-500 hover:underline">Add the
                                first one.</a></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if ($teachers->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">{{ $teachers->links() }}</div>
        @endif
    </div>
@endsection
