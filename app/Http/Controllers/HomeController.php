<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Gallery;   // adjust to your actual model name
use App\Models\NewsPost;
use App\Models\PageBlock;
use App\Models\PageHero;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        // ── All homepage blocks ───────────────────────────────────────────────
        $blocks = PageBlock::homepageBlocks();

        // ── Convenience shortcuts (expected by home.blade.php) ────────────────
        $hero  = PageHero::forPage('home');
        $about = $blocks->firstWhere('type', 'about_intro');
        $stats = $blocks->firstWhere('type', 'stats');
        $cta   = $blocks->firstWhere('type', 'cta_banner');

        // ── Latest 3 published news articles ──────────────────────────────────
        $latestNews = NewsPost::query()
            ->where('is_published', true)               // adjust column name to yours
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->take(3)
            ->get();

        // ── Gallery albums (4 shown on homepage) ──────────────────────────────
        $galleryAlbums = Gallery::query()
            ->where('is_published', true)               // adjust to your column
            ->withCount('images')                       // adjust relation name to yours
            ->latest()
            ->take(4)
            ->get();

        // ── Testimonials ──────────────────────────────────────────────────────
        $testimonials = Testimonial::query()
            ->where('is_published', true)               // adjust to your column
            ->orderByDesc('rating')
            ->take(3)
            ->get();

        // ── Upcoming events ───────────────────────────────────────────────────
        $upcomingEvents = Event::query()
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->take(4)
            ->get();

        return view('home', compact(
            'blocks',
            'hero',
            'about',
            'stats',
            'cta',
            'latestNews',
            'galleryAlbums',
            'testimonials',
            'upcomingEvents',
        ));
    }
}
