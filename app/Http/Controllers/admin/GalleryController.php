<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::withCount('images')->orderBy('order')->paginate(15);
        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.gallery.form', ['gallery' => new Gallery]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'order'       => 'nullable|integer',
        ]);
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')
                ->store('galleries/covers', 'public');
        }

        $gallery = Gallery::create($data);

        return redirect()->route('admin.gallery.edit', $gallery)
            ->with('success', 'Album created. Now add photos below.');
    }

    public function edit(Gallery $gallery)
    {
        $gallery->load('images');
        return view('admin.gallery.form', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'order'       => 'nullable|integer',
        ]);
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('cover_image')) {
            // Delete old cover image from disk
            if ($gallery->cover_image && Storage::disk('public')->exists($gallery->cover_image)) {
                Storage::disk('public')->delete($gallery->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')
                ->store('galleries/covers', 'public');
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.edit', $gallery)
            ->with('success', 'Album updated.');
    }

    public function destroy(Gallery $gallery)
    {
        // Delete all gallery image files from disk
        foreach ($gallery->images as $img) {
            if (Storage::disk('public')->exists($img->image_path)) {
                Storage::disk('public')->delete($img->image_path);
            }
        }

        // Delete cover image
        if ($gallery->cover_image && Storage::disk('public')->exists($gallery->cover_image)) {
            Storage::disk('public')->delete($gallery->cover_image);
        }

        $gallery->delete();

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Album deleted.');
    }

    /**
     * Upload images into an existing gallery album.
     */
    public function uploadImages(Request $request, Gallery $gallery)
    {
        $request->validate([
            'images'   => 'required|array|max:20',
            'images.*' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:10240', // Max 10MB per file before compress
        ]);

        $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
        $uploaded = 0;

        foreach ($request->file('images', []) as $i => $file) {
            // Generate a unique filename and set a path
            $filename = uniqid('img_') . '.webp';
            $path = 'galleries/' . $gallery->id . '/' . $filename;

            // Read the image, resize proportionally if it's too big, and convert to WebP
            $image = $manager->decode($file->getRealPath());
            $image->scaleDown(width: 1920, height: 1920);

            // Store the optimized WebP image
            $encoded = $image->encode(new \Intervention\Image\Encoders\WebpEncoder(80));
            Storage::disk('public')->put($path, (string) $encoded);

            GalleryImage::create([
                'gallery_id' => $gallery->id,
                'image_path' => $path,
                'caption'    => $request->input("captions.{$i}", ''),
                'order'      => $gallery->images()->count(),
            ]);
            $uploaded++;
        }

        return back()->with('success', "{$uploaded} photo(s) optimized and uploaded successfully.");
    }

    /**
     * Delete a single gallery image.
     */
    public function deleteImage(GalleryImage $image)
    {
        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }
        $image->delete();

        return back()->with('success', 'Photo deleted.');
    }
}