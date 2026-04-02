@extends('admin.layouts.admin')
@section('title', 'Navigation Menus')
@section('content')
    <div class="space-y-8">

        {{-- Create new menu --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h2 class="font-display font-bold text-navy-900 text-lg mb-5">Create New Menu</h2>
            <form action="{{ route('admin.menus.store') }}" method="POST" class="flex flex-wrap gap-4 items-end">
                @csrf
                <div class="flex-1 min-w-[180px]">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Menu Name</label>
                    <input type="text" name="name" required placeholder="e.g. Main Menu"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                </div>
                <div class="flex-1 min-w-[140px]">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Location</label>
                    <select name="location"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                        <option value="header">Header</option>
                        <option value="footer">Footer</option>
                    </select>
                </div>
                <button type="submit"
                    class="bg-navy-900 hover:bg-gold-500 text-white font-semibold px-6 py-3 rounded-xl text-sm transition-colors shadow-sm whitespace-nowrap">Create
                    Menu</button>
            </form>
        </div>

        {{-- Existing menus --}}
        @forelse($menus as $menu)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <div>
                        <h3 class="font-display font-bold text-navy-900">{{ $menu->name }}</h3>
                        <span class="text-xs text-slate-400 font-medium uppercase tracking-wide">{{ $menu->location }}
                            navigation</span>
                    </div>
                    <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST"
                        onsubmit="return confirm('Delete this menu and all its items?')">
                        @csrf @method('DELETE')
                        <button class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                </div>

                {{-- Existing items --}}
                <div class="divide-y divide-slate-50">
                    @forelse($menu->allItems as $item)
                        <div class="flex items-center gap-3 px-6 py-3 hover:bg-slate-50/50 group" x-data="{ editing: false }">
                            @if ($item->parent_id)
                                <div class="w-6 shrink-0"></div>
                                <div class="w-4 h-4 shrink-0 opacity-30"><svg fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg></div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <div x-show="!editing" class="flex items-center gap-2">
                                    <span class="font-medium text-navy-900 text-sm">{{ $item->title }}</span>
                                    <span
                                        class="text-slate-400 text-xs font-mono truncate">{{ $item->url ?? $item->route_name }}</span>
                                    @if ($item->parent_id)
                                        <span
                                            class="text-[10px] bg-slate-100 text-slate-500 px-1.5 py-0.5 rounded font-medium">child</span>
                                    @endif
                                </div>
                                <div x-show="editing" x-cloak class="flex gap-2 items-center flex-wrap">
                                    <form action="{{ route('admin.menu-items.update', $item) }}" method="POST"
                                        class="flex gap-2 items-center flex-wrap w-full">
                                        @csrf @method('PUT')
                                        <input type="text" name="title" value="{{ $item->title }}"
                                            class="border border-slate-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30 w-36">
                                        <input type="text" name="url" value="{{ $item->url }}"
                                            placeholder="URL or /path"
                                            class="border border-slate-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30 flex-1 min-w-[160px]">
                                        <input type="number" name="order" value="{{ $item->order }}"
                                            class="border border-slate-200 rounded-lg px-3 py-1.5 text-sm w-16 focus:outline-none">
                                        <button type="submit"
                                            class="bg-navy-900 text-white text-xs font-bold px-3 py-1.5 rounded-lg hover:bg-gold-500 transition-colors">Save</button>
                                        <button type="button" @click="editing=false"
                                            class="text-slate-400 text-xs px-2 py-1.5">Cancel</button>
                                    </form>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button @click="editing=!editing"
                                    class="p-1.5 text-slate-400 hover:text-navy-900 hover:bg-slate-100 rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <form action="{{ route('admin.menu-items.destroy', $item) }}" method="POST"
                                    onsubmit="return confirm('Remove item?')">@csrf @method('DELETE')
                                    <button
                                        class="p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"><svg
                                            class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg></button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-4 text-slate-400 text-sm italic">No items yet — add one below.</div>
                    @endforelse
                </div>

                {{-- Add item form --}}
                <div class="border-t border-slate-100 px-6 py-5 bg-slate-50/30" x-data="{ show: false }">
                    <button @click="show=!show"
                        class="flex items-center gap-2 text-sm font-semibold text-navy-900 hover:text-gold-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Item
                    </button>
                    <form x-show="show" x-cloak x-transition action="{{ route('admin.menu-items.store') }}"
                        method="POST" class="mt-4 grid sm:grid-cols-2 lg:grid-cols-4 gap-3 items-end">
                        @csrf
                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-1.5">Label
                                <span class="text-red-400">*</span></label>
                            <input type="text" name="title" required placeholder="e.g. About Us"
                                class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-1.5">URL or
                                Path</label>
                            <input type="text" name="url" placeholder="e.g. /about or https://…"
                                class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-1.5">Parent
                                (for dropdown)
                            </label>
                            <select name="parent_id"
                                class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-gold-500/30">
                                <option value="">Top-level item</option>
                                @foreach ($menu->allItems->whereNull('parent_id') as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-1.5">Order</label>
                            <div class="flex gap-2">
                                <input type="number" name="order" value="0"
                                    class="w-20 border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none">
                                <button type="submit"
                                    class="flex-1 bg-navy-900 hover:bg-gold-500 text-white font-semibold py-2.5 rounded-xl text-sm transition-colors">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-slate-100 p-16 text-center text-slate-400">
                <p class="text-lg font-medium">No menus yet.</p>
                <p class="text-sm mt-1">Create one using the form above.</p>
            </div>
        @endforelse
    </div>
@endsection
