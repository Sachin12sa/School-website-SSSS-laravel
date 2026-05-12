<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BlockController extends Controller
{
    /**
     * All homepage block types recognised by the UI.
     */
    public const BLOCK_TYPES = [
        'hero',
        'stats',
        'about_intro',
        'programs',
        'values',
        'legacy',
        'news_feed',
        'events_feed',
        'gallery_preview',
        'testimonial_slider',
        'contact_strip',
        'cta_banner',
    ];

    public function index()
    {
        if (request()->routeIs('admin.blocks.index')) {
            return redirect()->route('admin.sections.index', 'home');
        }

        // Only global (non-page) blocks, ordered as they appear on the homepage
        $blocks = PageBlock::whereNull('page_id')
            ->orderBy('order')
            ->get();

        return view('admin.blocks.index', compact('blocks'));
    }

    public function update(Request $request, $id)
    {
        $block = PageBlock::findOrFail($id);

        $data = $request->validate([
            'title'       => 'nullable|string|max:255',
            'subtitle'    => 'nullable|string|max:500',
            'content'     => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'button_url'  => 'nullable|string|max:500',
            'is_visible'  => 'nullable|boolean',
            // stats block extras
            'extra'                  => 'nullable|array',
            'extra_json'             => 'nullable|string',
            'extra.students'         => 'nullable|string|max:20',
            'extra.teachers'         => 'nullable|string|max:20',
            'extra.years'            => 'nullable|string|max:20',
            'extra.programmes'       => 'nullable|string|max:20',
            'image_path'             => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:51200',
        ]);

        // Merge extra fields when present (stats counters etc.)
        $extra = $block->extra ?? [];
        if ($request->has('extra')) {
            $extra = array_replace_recursive($extra, $request->input('extra', []));
        }
        if ($request->filled('extra_json')) {
            $decoded = json_decode($request->input('extra_json'), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()
                    ->withErrors(['extra_json' => 'Structured JSON is not valid. Please check commas, quotes, and brackets.'])
                    ->withInput();
            }
            $extra = array_replace_recursive($extra, $decoded ?: []);
        }
        unset($data['extra_json']);
        $data['extra'] = $extra ?: null;

        // Checkbox sends "1" when checked, nothing when unchecked
        $data['is_visible'] = $request->boolean('is_visible');

        // Image upload — store under storage/app/public/blocks/
        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')
                ->store('blocks', 'public');
        }

        $block->update($data);

        // Cache bust is handled by PageBlock::booted(), but clear explicitly
        // in case the model observer runs before the DB write is committed.
        Cache::forget('homepage_blocks');

        return back()->with('success', 'Block updated successfully.');
    }

    /**
     * Quick visibility toggle — called from the eye-icon button in the card header.
     * Accepts a single PUT with `is_visible` only.
     */
    public function toggleVisibility(Request $request, $id)
    {
        $block = PageBlock::findOrFail($id);
        $block->update(['is_visible' => $request->boolean('is_visible')]);
        Cache::forget('homepage_blocks');

        return back()->with('success', 'Visibility updated.');
    }

    /**
     * Drag-and-drop reorder — called by JS fetch with { order: [id, id, …] }.
     */
    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array', 'order.*' => 'integer']);

        foreach ($request->order as $position => $id) {
            PageBlock::where('id', $id)->update(['order' => $position]);
        }

        Cache::forget('homepage_blocks');

        return response()->json(['ok' => true]);
    }
}
