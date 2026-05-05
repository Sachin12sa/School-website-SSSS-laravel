@extends('admin.layouts.admin')
@section('title', 'Admission Application')
@section('content')
    <div class="max-w-3xl grid gap-6">
        <div class="bg-white rounded-2xl shadow-sm p-8">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h2 class="font-display font-bold text-navy text-2xl">{{ $admission->applicant_name }}</h2>
                    <p class="text-gray-400 text-sm mt-1">Submitted {{ $admission->submitted_at->format('d M Y, H:i') }}</p>
                </div>
                <span
                    class="text-sm font-bold px-3 py-1 rounded-full capitalize bg-{{ ['new' => 'blue', 'reviewed' => 'yellow', 'accepted' => 'green', 'rejected' => 'red'][$admission->status] }}-100 text-{{ ['new' => 'blue', 'reviewed' => 'yellow', 'accepted' => 'green', 'rejected' => 'red'][$admission->status] }}-700">{{ $admission->status }}</span>
            </div>
            <dl class="grid sm:grid-cols-2 gap-4">
                @foreach (['Parent/Guardian' => $admission->parent_name, 'Date of Birth' => $admission->dob?->format('d M Y'), 'Class Applying' => $admission->class_applying, 'Email' => $admission->email, 'Phone' => $admission->phone] as $label => $val)
                    <div class="bg-gray-50 rounded-xl p-4">
                        <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide">{{ $label }}</dt>
                        <dd class="text-navy font-medium mt-1">{{ $val ?? '—' }}</dd>
                    </div>
                @endforeach
            </dl>
            @if (!empty($admission->extra_data))
                <div class="mt-4 grid sm:grid-cols-2 gap-4">
                    @foreach ($admission->extra_data as $label => $val)
                        <div class="bg-gray-50 rounded-xl p-4">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide">{{ str($label)->replace('_', ' ')->title() }}</dt>
                            <dd class="text-navy font-medium mt-1">{{ $val ?? '—' }}</dd>
                        </div>
                    @endforeach
                </div>
            @endif
            @if ($admission->message)
                <div class="mt-4 bg-gray-50 rounded-xl p-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Message</p>
                    <p class="text-navy text-sm leading-relaxed">{{ $admission->message }}</p>
                </div>
            @endif
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="font-bold text-navy mb-4">Update Status</h3>
            <form action="{{ route('admin.admissions.status', $admission) }}" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div class="grid sm:grid-cols-2 gap-4">
                    <div><label class="block text-sm font-semibold text-navy mb-2">Status</label>
                        <select name="status"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold/40 bg-white">
                            @foreach (['new', 'reviewed', 'accepted', 'rejected'] as $s)
                                <option value="{{ $s }}" {{ $admission->status === $s ? 'selected' : '' }}
                                    class="capitalize">{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div><label class="block text-sm font-semibold text-navy mb-2">Internal Notes</label>
                    <textarea name="admin_notes" rows="3"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold/40 resize-none">{{ $admission->admin_notes }}</textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit"
                        class="bg-navy hover:bg-gold text-white font-semibold px-6 py-2.5 rounded-xl transition-colors text-sm">Update</button>
                    <a href="{{ route('admin.admissions.index') }}"
                        class="px-6 py-2.5 border border-gray-200 text-gray-600 rounded-xl text-sm hover:bg-gray-50">Back</a>
                </div>
            </form>
        </div>
    </div>
@endsection
