@extends('admin.layouts.admin')
@section('title', $user->exists ? 'Edit User' : 'Add User')
@section('content')
    <div class="max-w-lg">
        <form action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}" method="POST">
            @csrf @if ($user->exists)
                @method('PUT')
            @endif
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-5">

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Full Name <span
                            class="text-red-400">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Email Address <span
                            class="text-red-400">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Role <span
                            class="text-red-400">*</span></label>
                    <select name="role"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                        <option value="editor" {{ old('role', $user->role) === 'editor' ? 'selected' : '' }}>Editor — Can
                            manage content</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin — Full
                            access</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">
                        Password {{ $user->exists ? '(leave blank to keep current)' : '' }} <span
                            class="text-red-400">{{ $user->exists ? '' : '*' }}</span>
                    </label>
                    <input type="password" name="password" {{ $user->exists ? '' : 'required' }} minlength="8"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Confirm
                        Password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="bg-navy-900 hover:bg-gold-500 text-white font-semibold px-6 py-3 rounded-xl transition-colors text-sm shadow-sm">
                        {{ $user->exists ? 'Update User' : 'Create User' }}
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                        class="px-5 py-3 border border-slate-200 text-slate-600 rounded-xl text-sm hover:bg-slate-50 transition-colors">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
