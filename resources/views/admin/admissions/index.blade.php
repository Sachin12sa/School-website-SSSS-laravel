@extends('admin.layouts.admin')
@section('title', 'Admissions')
@section('content')
    <div class="flex gap-2 mb-6 flex-wrap">
        @foreach (['' => 'All', 'new' => 'New', 'reviewed' => 'Reviewed', 'accepted' => 'Accepted', 'rejected' => 'Rejected'] as $val => $label)
            <a href="{{ request()->fullUrlWithQuery(['status' => $val]) }}"
                class="px-4 py-2 rounded-xl text-sm font-semibold transition-colors {{ $filter === $val ? 'bg-navy text-white' : 'bg-white text-navy border border-gray-200 hover:border-navy' }}">{{ $label }}</a>
        @endforeach
    </div>
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-6 py-4 font-semibold text-navy">Applicant</th>
                    <th class="text-left px-6 py-4 font-semibold text-navy hidden md:table-cell">Class</th>
                    <th class="text-left px-6 py-4 font-semibold text-navy hidden lg:table-cell">Submitted</th>
                    <th class="text-left px-6 py-4 font-semibold text-navy">Status</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($admissions as $a)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-medium text-navy">{{ $a->applicant_name }}</div>
                            <div class="text-xs text-gray-400">{{ $a->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-gray-600 hidden md:table-cell">{{ $a->class_applying }}</td>
                        <td class="px-6 py-4 text-gray-400 text-xs hidden lg:table-cell">
                            {{ $a->submitted_at->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4"><span
                                class="text-xs font-bold px-2 py-1 rounded-full capitalize bg-{{ ['new' => 'blue', 'reviewed' => 'yellow', 'accepted' => 'green', 'rejected' => 'red'][$a->status] }}-100 text-{{ ['new' => 'blue', 'reviewed' => 'yellow', 'accepted' => 'green', 'rejected' => 'red'][$a->status] }}-700">{{ $a->status }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.admissions.show', $a) }}"
                                class="text-navy hover:text-gold transition-colors text-xs font-semibold">View →</a>
                        </td>
                    </tr>
                @empty<tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400">No admissions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if ($admissions->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">{{ $admissions->links() }}</div>
        @endif
    </div>
@endsection
