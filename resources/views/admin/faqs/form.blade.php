@extends('admin.layouts.admin')
@section('title', $faq->exists ? 'Edit FAQ' : 'Add FAQ')
@section('content')
    <div class="max-w-2xl">
        <form action="{{ $faq->exists ? route('admin.faqs.update', $faq) : route('admin.faqs.store') }}" method="POST">
            @csrf @if ($faq->exists)
                @method('PUT')
            @endif
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-5">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Question <span
                            class="text-red-400">*</span></label>
                    <input type="text" name="question" value="{{ old('question', $faq->question) }}" required
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30 focus:border-gold-500">
                    @error('question')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Answer <span
                            class="text-red-400">*</span></label>
                    <textarea name="answer" rows="6" required
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-gold-500/30">{{ old('answer', $faq->answer) }}</textarea>
                    @error('answer')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Category</label>
                        <input type="text" name="category" value="{{ old('category', $faq->category) }}"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30"
                            placeholder="e.g. Admissions, General">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Display
                            Order</label>
                        <input type="number" name="order" value="{{ old('order', $faq->order ?? 0) }}"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                    </div>
                </div>
                <div class="flex items-center gap-3 pt-1">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_published" value="1"
                            {{ old('is_published', $faq->is_published ?? true) ? 'checked' : '' }} class="sr-only peer">
                        <div
                            class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full after:absolute after:top-0.5 after:left-0.5 after:bg-white after:w-5 after:h-5 after:rounded-full after:transition-all peer-checked:bg-navy-900">
                        </div>
                    </label>
                    <label class="text-sm font-medium text-slate-700">Published</label>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="bg-navy-900 hover:bg-gold-500 text-white font-semibold px-6 py-3 rounded-xl transition-colors text-sm shadow-sm">
                        {{ $faq->exists ? 'Update FAQ' : 'Add FAQ' }}
                    </button>
                    <a href="{{ route('admin.faqs.index') }}"
                        class="px-5 py-3 border border-slate-200 text-slate-600 rounded-xl text-sm hover:bg-slate-50 transition-colors">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
