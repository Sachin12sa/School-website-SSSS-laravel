<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('order')->paginate(20);
        $stats = [
            'total' => Faq::count(),
            'published' => Faq::where('is_published', true)->count(),
            'hidden' => Faq::where('is_published', false)->count(),
            'categories' => Faq::whereNotNull('category')->where('category', '!=', '')->distinct('category')->count('category'),
        ];

        return view('admin.faqs.index', compact('faqs', 'stats'));
    }

    public function create()
    {
        return view('admin.faqs.form', ['faq' => new Faq]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'question'     => 'required|string|max:500',
            'answer'       => 'required|string',
            'category'     => 'nullable|string|max:100',
            'order'        => 'nullable|integer',
            'is_published' => 'nullable|boolean',
        ]);
        $data['is_published'] = $request->boolean('is_published');
        Faq::create($data);
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ created.');
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.form', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $data = $request->validate([
            'question'     => 'required|string|max:500',
            'answer'       => 'required|string',
            'category'     => 'nullable|string|max:100',
            'order'        => 'nullable|integer',
            'is_published' => 'nullable|boolean',
        ]);
        $data['is_published'] = $request->boolean('is_published');
        $faq->update($data);
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return back()->with('success', 'FAQ deleted.');
    }
}
