@extends('admin.layouts.admin')
@section('title', 'Message from ' . $contact->name)
@section('content')
    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl shadow-sm p-8 space-y-5">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="font-bold text-navy text-xl">{{ $contact->name }}</h2>
                    <a href="mailto:{{ $contact->email }}" class="text-gold text-sm hover:underline">{{ $contact->email }}</a>
                    @if ($contact->phone)
                        <span class="text-gray-400 text-sm ml-3">{{ $contact->phone }}</span>
                    @endif
                </div>
                <span class="text-xs text-gray-400">{{ $contact->sent_at->format('d M Y, H:i') }}</span>
            </div>
            @if ($contact->subject)
                <div class="border-t border-gray-100 pt-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Subject</p>
                    <p class="text-navy font-medium">{{ $contact->subject }}</p>
                </div>
            @endif
            <div class="border-t border-gray-100 pt-4">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">Message</p>
                <div class="text-gray-700 leading-relaxed whitespace-pre-wrap bg-gray-50 rounded-xl p-4">
                    {{ $contact->message }}</div>
            </div>
            <div class="flex gap-3 pt-2">
                <a href="mailto:{{ $contact->email }}"
                    class="bg-navy hover:bg-gold text-white font-semibold px-6 py-2.5 rounded-xl transition-colors text-sm">Reply
                    via Email</a>
                <a href="{{ route('admin.contacts.index') }}"
                    class="px-6 py-2.5 border border-gray-200 text-gray-600 rounded-xl text-sm hover:bg-gray-50">Back</a>
                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST"
                    onsubmit="return confirm('Delete?')" class="ml-auto">@csrf @method('DELETE')<button
                        class="text-red-400 hover:text-red-600 text-sm px-3 py-2.5">Delete</button></form>
            </div>
        </div>
    </div>
@endsection
