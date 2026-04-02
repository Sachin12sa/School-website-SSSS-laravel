@extends('admin.layouts.admin')
@section('title', 'Site Settings')
@section('content')
    <div class="max-w-3xl">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @foreach ([
            ['title' => 'School Identity', 'fields' => [['name' => 'school_name', 'label' => 'School Name', 'type' => 'text'], ['name' => 'school_tagline', 'label' => 'Tagline', 'type' => 'text'], ['name' => 'established_year', 'label' => 'Established Year', 'type' => 'text'], ['name' => 'about_short', 'label' => 'Short About (footer)', 'type' => 'textarea'], ['name' => 'logo', 'label' => 'Logo', 'type' => 'file'], ['name' => 'favicon', 'label' => 'Favicon', 'type' => 'file']]],
            ['title' => 'Contact Information', 'fields' => [['name' => 'address', 'label' => 'Address', 'type' => 'textarea'], ['name' => 'phone', 'label' => 'Phone', 'type' => 'text'], ['name' => 'email', 'label' => 'Email', 'type' => 'email'], ['name' => 'map_embed', 'label' => 'Google Maps Embed (iframe HTML)', 'type' => 'textarea']]],
            ['title' => 'Social Media', 'fields' => [['name' => 'facebook', 'label' => 'Facebook URL', 'type' => 'url'], ['name' => 'twitter', 'label' => 'Twitter URL', 'type' => 'url'], ['name' => 'instagram', 'label' => 'Instagram URL', 'type' => 'url'], ['name' => 'youtube', 'label' => 'YouTube URL', 'type' => 'url']]],
            ['title' => 'SEO Defaults', 'fields' => [['name' => 'meta_description', 'label' => 'Default Meta Description', 'type' => 'textarea']]],
        ] as $section)
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h2 class="font-bold text-navy text-lg mb-5">{{ $section['title'] }}</h2>
                    <div class="space-y-4">
                        @foreach ($section['fields'] as $f)
                            <div>
                                <label class="block text-sm font-semibold text-navy mb-2">{{ $f['label'] }}</label>
                                @if ($f['type'] === 'textarea')
                                    <textarea name="{{ $f['name'] }}" rows="3"
                                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold/40 resize-none">{{ $settings[$f['name']] ?? '' }}</textarea>
                                @elseif($f['type'] === 'file')
                                    @if (!empty($settings[$f['name']]))
                                        <img src="{{ asset('storage/' . $settings[$f['name']]) }}"
                                            class="h-12 rounded mb-2 object-contain">
                                    @endif
                                    <input type="file" name="{{ $f['name'] }}"
                                        class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-navy file:text-white file:text-sm file:font-semibold hover:file:bg-gold file:transition-colors cursor-pointer">
                                @else
                                    <input type="{{ $f['type'] }}" name="{{ $f['name'] }}"
                                        value="{{ $settings[$f['name']] ?? '' }}"
                                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gold/40">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
            <button type="submit"
                class="bg-navy hover:bg-gold text-white font-bold px-8 py-3 rounded-xl transition-colors shadow-md">Save All
                Settings</button>
        </form>
    </div>
@endsection
