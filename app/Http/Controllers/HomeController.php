<?php

namespace App\Http\Controllers;

use App\Models\{NewsPost, Event, Testimonial, PageBlock, SiteSetting};
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $blocks = Cache::remember('homepage_blocks', 3600, fn() =>
            PageBlock::whereNull('page_id')->where('is_visible', true)->orderBy('order')->get()
        );

        $latestNews = Cache::remember('home_news', 1800, fn() =>
            NewsPost::published()->orderByDesc('published_at')->limit(3)->get()
        );

        $upcomingEvents = Cache::remember('home_events', 1800, fn() =>
            Event::published()->upcoming()->orderBy('start_date')->limit(3)->get()
        );

        $testimonials = Cache::remember('home_testimonials', 3600, fn() =>
            Testimonial::published()->featured()->orderBy('order')->get()
        );

        return view('home', compact('blocks', 'latestNews', 'upcomingEvents', 'testimonials'));
    }
}