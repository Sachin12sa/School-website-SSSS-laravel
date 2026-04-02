<?php

namespace App\Http\Controllers;

use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::published()->orderBy('order')->get()->groupBy('category');
        return view('faq', compact('faqs'));
    }
}