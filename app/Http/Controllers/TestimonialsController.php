<?php

namespace App\Http\Controllers;

use App\Models\PageHero;
use App\Models\Testimonial;

class TestimonialsController extends Controller
{
    public function index()
    {
        $hero = PageHero::forPage('testimonials');

        $testimonials = Testimonial::query()
            ->published()
            ->orderByDesc('is_featured')
            ->orderByDesc('rating')
            ->orderBy('order')
            ->paginate(12);

        return view('testimonials', compact('hero', 'testimonials'));
    }
}
