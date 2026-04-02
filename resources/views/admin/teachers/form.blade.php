@extends('admin.layouts.admin')
@section('title', $teacher->exists ? 'Edit Teacher' : 'Add Teacher')
@section('content')
    <div class="max-w-3xl">
        <form action="{{ $teacher->exists ? route('admin.teachers.update', $teacher) : route('admin.teachers.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf @if ($teacher->exists)
                @method('PUT')
            @endif
            <div class="grid lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-5">
                        <div class="grid sm:grid-cols-2 gap-5">
                            <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Full Name
                                    <span class="text-red-400">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $teacher->name) }}" required
                                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div><label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Designation
                                    <span class="text-red-400">*</span></label>
                                <input type="text" name="designation"
                                    value="{{ old('designation', $teacher->designation) }}" required
                                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                                @error('designation')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="grid sm:grid-cols-2 gap-5">
                            <div><label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Department</label>
                                <input type="text" name="department"
                                    value="{{ old('department', $teacher->department) }}"
                                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30"
                                    placeholder="e.g. Mathematics">
                            </div>
                            <div><label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Email</label>
                                <input type="email" name="email" value="{{ old('email', $teacher->email) }}"
                                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                            </div>
                        </div>
                        <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Bio</label>
                            <textarea name="bio" rows="5"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-gold-500/30"
                                placeholder="Short biography displayed on the Faculty page…">{{ old('bio', $teacher->bio) }}</textarea>
                        </div>
                        <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">LinkedIn
                                URL</label>
                            <input type="url" name="linkedin" value="{{ old('linkedin', $teacher->linkedin) }}"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30"
                                placeholder="https://linkedin.com/in/…">
                        </div>
                    </div>
                </div>
                <div class="space-y-5">
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                        <h3 class="font-display font-bold text-navy-900 mb-4">Photo</h3>
                        @if ($teacher->photo)
                            <img src="{{ $teacher->photo_url }}" class="w-full aspect-square rounded-xl object-cover mb-3">
                        @endif
                        <input type="file" name="photo" accept="image/*"
                            class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-navy-900 file:text-white file:text-xs file:font-semibold hover:file:bg-gold-500 file:transition-colors cursor-pointer">
                    </div>
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-4">
                        <h3 class="font-display font-bold text-navy-900">Settings</h3>
                        <div><label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Display
                                Order</label>
                            <input type="number" name="order" value="{{ old('order', $teacher->order ?? 0) }}"
                                class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                        </div>
                        <div class="flex items-center justify-between"><label
                                class="text-sm font-medium text-slate-700">Published</label>
                            <label class="relative inline-flex items-center cursor-pointer"><input type="checkbox"
                                    name="is_published" value="1"
                                    {{ old('is_published', $teacher->is_published ?? true) ? 'checked' : '' }}
                                    class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full after:absolute after:top-0.5 after:left-0.5 after:bg-white after:w-5 after:h-5 after:rounded-full after:transition-all peer-checked:bg-navy-900">
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit"
                            class="flex-1 bg-navy-900 hover:bg-gold-500 text-white font-semibold py-3 rounded-xl transition-colors text-sm">{{ $teacher->exists ? 'Update' : 'Add Teacher' }}</button>
                        <a href="{{ route('admin.teachers.index') }}"
                            class="px-4 py-3 border border-slate-200 text-slate-600 rounded-xl text-sm hover:bg-slate-50">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
