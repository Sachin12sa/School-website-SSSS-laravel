<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Public gallery listing page — shows all published albums.
     */
    public function index()
    {
        $galleries = Gallery::published()
            ->withCount('images')
            ->orderBy('order')
            ->paginate(12);

        return view('gallery.index', compact('galleries'));
    }

    /**
     * Single album page — shows all photos in the album with lightbox.
     */
    public function show(int $id)
    {
        $gallery = Gallery::published()
            ->with(['images' => fn ($q) => $q->orderBy('order')])
            ->findOrFail($id);

        return view('gallery.show', compact('gallery'));
    }
}