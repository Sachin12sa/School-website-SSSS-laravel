<?php

namespace App\Http\Controllers;

use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::published()->withCount('images')->orderBy('order')->get();
        return view('gallery.index', compact('galleries'));
    }

    public function show(int $id)
    {
        $gallery = Gallery::published()->with('images')->findOrFail($id);
        return view('gallery.show', compact('gallery'));
    }
}