<?php

namespace App\Http\Controllers;

use App\Models\{NewsPost, Event, Testimonial, PageBlock, Gallery, SiteSetting};
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // Each block of data is cached separately so clearing one
        // doesn't force a re-fetch of everything else.
        // CACHE_STORE=array in .env means no disk serialisation — no crashes.

        $blocks = $this->safeCache('homepage_blocks', 3600, fn() =>
            PageBlock::whereNull('page_id')
                ->where('is_visible', true)
                ->orderBy('order')
                ->get()
        );

        $latestNews = $this->safeCache('home_news', 1800, fn() =>
            NewsPost::published()
                ->orderByDesc('published_at')
                ->limit(3)
                ->get()
        );

        $upcomingEvents = $this->safeCache('home_events', 1800, fn() =>
            Event::published()
                ->upcoming()
                ->orderBy('start_date')
                ->limit(4)
                ->get()
        );

        $testimonials = $this->safeCache('home_testimonials', 3600, fn() =>
            Testimonial::published()
                ->featured()
                ->orderBy('order')
                ->limit(3)
                ->get()
        );

        // Gallery preview — latest 4 albums with their first image
        $galleries = $this->safeCache('home_galleries', 3600, fn() =>
            Gallery::published()
                ->with(['images' => fn($q) => $q->orderBy('order')->limit(1)])
                ->orderBy('order')
                ->limit(4)
                ->get()
        );

        return view('home', compact(
            'blocks',
            'latestNews',
            'upcomingEvents',
            'testimonials',
            'galleries'
        ));
    }

    // ── Helper: cache with auto-heal on deserialise errors ─────────────────────
    private function safeCache(string $key, int $ttl, \Closure $callback): mixed
    {
        try {
            return Cache::remember($key, $ttl, $callback);
        } catch (\Throwable) {
            Cache::forget($key);
            return $callback();
        }
    }
}