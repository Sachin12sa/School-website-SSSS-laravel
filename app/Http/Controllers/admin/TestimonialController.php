<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('order')->paginate(15);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.form', ['testimonial' => new Testimonial]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'author_name'  => 'required|string|max:255',
            'author_role'  => 'nullable|string|max:255',
            'content'      => 'required|string',
            'rating'       => 'nullable|integer|min:1|max:5',
            'is_featured'  => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
            'order'        => 'nullable|integer',
        ]);
        $data['is_featured']  = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('testimonials', 'public');
        }
        Testimonial::create($data);
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial saved.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.form', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $request->validate([
            'author_name'  => 'required|string|max:255',
            'author_role'  => 'nullable|string|max:255',
            'content'      => 'required|string',
            'rating'       => 'nullable|integer|min:1|max:5',
            'is_featured'  => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
            'order'        => 'nullable|integer',
        ]);
        $data['is_featured']  = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('testimonials', 'public');
        }
        $testimonial->update($data);
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return back()->with('success', 'Deleted.');
    }
}