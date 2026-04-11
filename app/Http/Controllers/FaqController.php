<?php

namespace App\Http\Controllers;

use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        // All published FAQs, grouped by category
        // FAQs with no category go into '' key and show without a section heading
        $faqs = Faq::published()
            ->orderByRaw("CASE WHEN category IS NULL OR category = '' THEN 1 ELSE 0 END")
            ->orderBy('order')
            ->get()
            ->groupBy('category');

        return view('faq', compact('faqs'));
    }
}