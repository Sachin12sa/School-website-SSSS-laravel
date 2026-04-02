@extends('admin.layouts.admin')
@section('title', 'Messages')
@section('content')
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-6 py-4 font-semibold text-navy">From</th>
                    <th class="text-left px-6 py-4 font-semibold text-navy hidden md:table-cell">Subject</th>
                    <th class="text-left px-6 py-4 font-semibold text-navy hidden lg:table-cell">Received</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($contacts as $c)
                    <tr class="{{ !$c->is_read ? 'bg-blue-50/50' : '' }} hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                @if (!$c->is_read)
                                    <span class="w-2 h-2 bg-blue-500 rounded-full shrink-0"></span>
                                @endif
                                <div>
                                    <div class="font-medium text-navy">{{ $c->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $c->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600 hidden md:table-cell">
                            {{ $c->subject ?? Str::limit($c->message, 45) }}</td>
                        <td class="px-6 py-4 text-gray-400 text-xs hidden lg:table-cell">
                            {{ $c->sent_at->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4 text-right"><a href="{{ route('admin.contacts.show', $c) }}"
                                class="text-navy hover:text-gold transition-colors text-xs font-semibold">View →</a></td>
                    </tr>
                @empty<tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-400">No messages yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if ($contacts->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">{{ $contacts->links() }}</div>
        @endif
    </div>
@endsection
