<?php

namespace App\Http\Controllers;

use App\Models\{Contact, Faq, PageHero, PageSection};
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        // Load FAQs for the accordion at the bottom of the contact page
        $faqs = Faq::published()->orderBy('order')->limit(6)->get();
        $hero = PageHero::forPage('contact');
        $sections = PageSection::forPageCached('contact');

        return view('contact', compact('faqs', 'hero', 'sections'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'nullable|string|max:100',
            'last_name'  => 'nullable|string|max:100',
            'email'      => 'required|email|max:200',
            'phone'      => 'nullable|string|max:30',
            'subject'    => 'nullable|string|max:200',
            'message'    => 'required|string|max:3000',
        ]);

        // Combine first + last name into the 'name' column
        $data['name'] = trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '')) ?: 'Anonymous';
        unset($data['first_name'], $data['last_name']);
        $data['sent_at'] = now();

        Contact::create($data);

        return back()->with('success', 'Thank you! We received your message and will reply within 24 hours.');
    }
}
