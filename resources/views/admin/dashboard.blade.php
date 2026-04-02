@extends('admin.layouts.admin')
@section('title', 'Dashboard')
@section('content')
    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
        @foreach ([
            ['label' => 'News Posts', 'value' => $stats['news'], 'color' => 'blue', 'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z', 'route' => 'admin.news.index'],
            ['label' => 'Events', 'value' => $stats['events'], 'color' => 'purple', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'route' => 'admin.events.index'],
            ['label' => 'Teachers', 'value' => $stats['teachers'], 'color' => 'green', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'route' => 'admin.teachers.index'],
            ['label' => 'Galleries', 'value' => $stats['galleries'], 'color' => 'yellow', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z', 'route' => 'admin.gallery.index'],
            ['label' => 'New Admissions', 'value' => $stats['new_admissions'], 'color' => 'orange', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'route' => 'admin.admissions.index'],
            ['label' => 'Unread Messages', 'value' => $stats['unread_contacts'], 'color' => 'red', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'route' => 'admin.contacts.index'],
        ] as $card)
            <a href="{{ route($card['route']) }}"
                class="bg-white rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow flex flex-col gap-3 card-hover">
                <div class="w-10 h-10 bg-{{ $card['color'] }}-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-{{ $card['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}" />
                    </svg>
                </div>
                <div>
                    <div class="font-bold text-2xl text-navy">{{ $card['value'] }}</div>
                    <div class="text-gray-500 text-xs mt-0.5">{{ $card['label'] }}</div>
                </div>
            </a>
        @endforeach
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        {{-- Recent Admissions --}}
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-bold text-navy text-lg">Recent Admissions</h2>
                <a href="{{ route('admin.admissions.index') }}" class="text-gold text-sm font-medium hover:underline">View
                    all →</a>
            </div>
            <div class="space-y-3">
                @forelse($recentAdmissions as $a)
                    <a href="{{ route('admin.admissions.show', $a) }}"
                        class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition-colors">
                        <div>
                            <div class="font-semibold text-navy text-sm">{{ $a->applicant_name }}</div>
                            <div class="text-gray-400 text-xs mt-0.5">{{ $a->class_applying }} ·
                                {{ $a->submitted_at->diffForHumans() }}</div>
                        </div>
                        <span
                            class="text-xs font-bold px-2 py-1 rounded-full bg-{{ ['new' => 'blue', 'reviewed' => 'yellow', 'accepted' => 'green', 'rejected' => 'red'][$a->status] ?? 'gray' }}-100 text-{{ ['new' => 'blue', 'reviewed' => 'yellow', 'accepted' => 'green', 'rejected' => 'red'][$a->status] ?? 'gray' }}-700 capitalize">{{ $a->status }}</span>
                    </a>
                @empty<p class="text-gray-400 text-sm text-center py-4">No admissions yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Recent Messages --}}
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-bold text-navy text-lg">Recent Messages</h2>
                <a href="{{ route('admin.contacts.index') }}" class="text-gold text-sm font-medium hover:underline">View
                    all →</a>
            </div>
            <div class="space-y-3">
                @forelse($recentContacts as $c)
                    <a href="{{ route('admin.contacts.show', $c) }}"
                        class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors {{ !$c->is_read ? 'bg-blue-50' : '' }}">
                        <div
                            class="w-9 h-9 bg-navy rounded-full flex items-center justify-center text-white font-bold text-sm shrink-0">
                            {{ substr($c->name, 0, 1) }}</div>
                        <div class="flex-1 min-w-0">
                            <div class="font-semibold text-navy text-sm flex items-center gap-1.5">{{ $c->name }}
                                @if (!$c->is_read)
                                    <span class="w-2 h-2 bg-blue-500 rounded-full inline-block"></span>
                                @endif
                            </div>
                            <div class="text-gray-400 text-xs truncate">{{ $c->subject ?? Str::limit($c->message, 40) }}
                            </div>
                        </div>
                        <span class="text-xs text-gray-400 shrink-0">{{ $c->sent_at->diffForHumans(null, true) }}</span>
                    </a>
                @empty<p class="text-gray-400 text-sm text-center py-4">No messages yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    <style>
        .card-hover {
            transition: transform .2s, box-shadow .2s;
        }

        .card-hover:hover {
            transform: translateY(-2px);
        }
    </style>
@endsection
