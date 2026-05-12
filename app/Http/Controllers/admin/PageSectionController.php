<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PageSectionController extends Controller
{
    // Pages that use the sections system
    protected array $managedPages = [
        'home'        => 'Home Page',
        'programs'    => 'Academic Programs',
        'life-at-ssss'=> 'Life at SSSS',
        'boarding'    => 'Boarding',
        'about'       => 'About Us',
        'transport'   => 'Transportation',
        'contact'     => 'Contact',
        'admissions'  => 'Admissions',
    ];

    public function index(string $pageKey)
    {
        abort_unless(array_key_exists($pageKey, $this->managedPages), 404);
        $pageTitle = $this->managedPages[$pageKey];
        $sections = PageSection::forPage($pageKey)->orderBy('order')->get();
        return view('admin.pages.sections.index', compact('sections', 'pageKey', 'pageTitle'));
    }

    public function create(string $pageKey)
    {
        abort_unless(array_key_exists($pageKey, $this->managedPages), 404);
        $pageTitle = $this->managedPages[$pageKey];
        $section = new PageSection(['page_key' => $pageKey]);
        return view('admin.pages.sections.form', compact('section', 'pageKey', 'pageTitle'));
    }

    public function store(Request $request, string $pageKey)
    {
        abort_unless(array_key_exists($pageKey, $this->managedPages), 404);

        $data = $request->validate([
            'title'        => 'nullable|string|max:255',
            'subtitle'     => 'nullable|string|max:500',
            'content'      => 'nullable|string',
            'badge_text'   => 'nullable|string|max:100',
            'badge_color'  => 'nullable|string|max:20',
            'items_json'   => 'nullable|string',
            'settings_json'=> 'nullable|string',
            'layout'       => 'required|in:default,image-left,image-right,full-image,cards,program-cards,list,stats,timeline,cta,program-tabs,steps,routes,video',
            'button_text'  => 'nullable|string|max:100',
            'button_url'   => 'nullable|string|max:500',
            'order'        => 'nullable|integer',
            'is_published' => 'nullable|boolean',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:51200',
        ]);

        $data = $this->decodeStructuredFields($data);
        $data['page_key']     = $pageKey;
        $data['is_published'] = $request->boolean('is_published');
        $data['order']        = $data['order'] ?? PageSection::forPage($pageKey)->count();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store("sections/{$pageKey}", 'public');
        }

        PageSection::create($data);

        return redirect()->route('admin.sections.index', $pageKey)
            ->with('success', 'Section added.');
    }

    public function edit(string $pageKey, PageSection $section)
    {
        abort_unless($section->page_key === $pageKey, 404);
        $pageTitle = $this->managedPages[$pageKey] ?? $pageKey;
        return view('admin.pages.sections.form', compact('section', 'pageKey', 'pageTitle'));
    }

    public function update(Request $request, string $pageKey, PageSection $section)
    {
        abort_unless($section->page_key === $pageKey, 404);

        $data = $request->validate([
            'title'        => 'nullable|string|max:255',
            'subtitle'     => 'nullable|string|max:500',
            'content'      => 'nullable|string',
            'badge_text'   => 'nullable|string|max:100',
            'badge_color'  => 'nullable|string|max:20',
            'items_json'   => 'nullable|string',
            'settings_json'=> 'nullable|string',
            'layout'       => 'required|in:default,image-left,image-right,full-image,cards,program-cards,list,stats,timeline,cta,program-tabs,steps,routes,video',
            'button_text'  => 'nullable|string|max:100',
            'button_url'   => 'nullable|string|max:500',
            'order'        => 'nullable|integer',
            'is_published' => 'nullable|boolean',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:51200',
        ]);

        $data = $this->decodeStructuredFields($data);
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($section->image && Storage::disk('public')->exists($section->image)) {
                Storage::disk('public')->delete($section->image);
            }
            $data['image'] = $request->file('image')
                ->store("sections/{$pageKey}", 'public');
        }

        $section->update($data);

        return redirect()->route('admin.sections.index', $pageKey)
            ->with('success', 'Section updated.');
    }

    public function destroy(string $pageKey, PageSection $section)
    {
        abort_unless($section->page_key === $pageKey, 404);

        if ($section->image && Storage::disk('public')->exists($section->image)) {
            Storage::disk('public')->delete($section->image);
        }
        $section->delete();

        return back()->with('success', 'Section deleted.');
    }

    public function reorder(Request $request, string $pageKey)
    {
        foreach ($request->input('order', []) as $i => $id) {
            PageSection::where('id', $id)->where('page_key', $pageKey)->update(['order' => $i]);
        }
        return response()->json(['ok' => true]);
    }

    public function toggle(string $pageKey, PageSection $section)
    {
        $section->update(['is_published' => !$section->is_published]);
        return back()->with('success', 'Visibility updated.');
    }

    protected function decodeStructuredFields(array $data): array
    {
        foreach (['items_json' => 'items', 'settings_json' => 'settings'] as $input => $column) {
            $raw = trim((string) ($data[$input] ?? ''));
            unset($data[$input]);

            if ($raw === '') {
                $data[$column] = null;
                continue;
            }

            $decoded = json_decode($raw, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw ValidationException::withMessages([
                    $input => 'Please enter valid JSON.',
                ]);
            }

            $data[$column] = $decoded;
        }

        return $data;
    }
}
