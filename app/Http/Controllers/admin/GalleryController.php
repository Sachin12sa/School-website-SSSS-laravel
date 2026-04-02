<?php namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Gallery, GalleryImage};
use Illuminate\Http\Request;

class GalleryController extends Controller {
    public function index() { $galleries = Gallery::withCount('images')->orderBy('order')->paginate(15); return view('admin.gallery.index', compact('galleries')); }
    public function create() { return view('admin.gallery.form', ['gallery' => new Gallery]); }
    public function store(Request $request) {
        $data = $request->validate(['name' => 'required|string|max:255', 'description' => 'nullable|string', 'order' => 'nullable|integer', 'is_published' => 'boolean']);
        if ($request->hasFile('cover_image')) $data['cover_image'] = $request->file('cover_image')->store('galleries', 'public');
        Gallery::create($data);
        return redirect()->route('admin.gallery.index')->with('success', 'Gallery created.');
    }
    public function edit(Gallery $gallery) { return view('admin.gallery.form', ['gallery' => $gallery->load('images')]); }
    public function update(Request $request, Gallery $gallery) {
        $data = $request->validate(['name' => 'required|string|max:255', 'description' => 'nullable|string', 'order' => 'nullable|integer', 'is_published' => 'boolean']);
        if ($request->hasFile('cover_image')) $data['cover_image'] = $request->file('cover_image')->store('galleries', 'public');
        $gallery->update($data);
        return redirect()->route('admin.gallery.index')->with('success', 'Gallery updated.');
    }
    public function destroy(Gallery $gallery) { $gallery->delete(); return back()->with('success', 'Gallery deleted.'); }
    public function uploadImages(Request $request, Gallery $gallery) {
        $request->validate(['images.*' => 'required|image|max:5120']);
        foreach ($request->file('images', []) as $i => $file) {
            $path = $file->store('galleries/'.$gallery->id, 'public');
            GalleryImage::create(['gallery_id' => $gallery->id, 'image_path' => $path, 'caption' => $request->captions[$i] ?? '', 'order' => $gallery->images()->count()]);
        }
        return back()->with('success', 'Images uploaded.');
    }
    public function deleteImage(GalleryImage $image) { $image->delete(); return back()->with('success', 'Image deleted.'); }
}