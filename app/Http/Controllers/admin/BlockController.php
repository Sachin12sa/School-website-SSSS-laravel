<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageBlock;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function index()
    {
        $blocks = PageBlock::whereNull('page_id')->orderBy('order')->get();
        return view('admin.blocks.index', compact('blocks'));
    }

    public function update(Request $request, $id)
    {
        $block = PageBlock::findOrFail($id);

        $data = $request->validate([
            'title'       => 'nullable|string|max:255',
            'subtitle'    => 'nullable|string',
            'content'     => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'button_url'  => 'nullable|string|max:500',
            'is_visible'  => 'nullable|boolean',
        ]);

        // Extra fields (stats numbers etc.)
        if ($request->has('extra')) {
            $data['extra'] = $request->input('extra');
        }

        $data['is_visible'] = $request->boolean('is_visible');

        // Handle image upload
        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('blocks', 'public');
        }

        $block->update($data);
        return back()->with('success', 'Block updated successfully.');
    }

    public function reorder(Request $request)
    {
        foreach ($request->order as $i => $id) {
            PageBlock::where('id', $id)->update(['order' => $i]);
        }
        return response()->json(['ok' => true]);
    }
}