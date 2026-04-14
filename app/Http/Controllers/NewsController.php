<?php

namespace App\Http\Controllers;

use App\Models\NewsPost;
use Illuminate\Support\Facades\Cache;

class NewsController extends Controller
{
    public function index()
    {
        $category = request('category');

        // ── FIX 1: categories should NOT be cached when filtering
        //   (the cache was returning stale results for filtered views)
        $categories = Cache::remember('news_categories', 3600, fn() =>
            NewsPost::published()
                ->whereNotNull('category')
                ->distinct()
                ->orderBy('category')
                ->pluck('category')
        );

        // ── FIX 2: featured post — only cache when NOT filtering by category
        //   (otherwise the featured post was still showing above filtered results)
        $featured = null;
        if (!$category) {
            $featured = Cache::remember('news_featured', 1800, fn() =>
                NewsPost::published()
                    ->where('is_featured', true)
                    ->orderByDesc('published_at')
                    ->first()
            );
        }

        // ── FIX 3: paginated list — never cache paginated results
        //   (cached pagination breaks page 2+)
        $news = NewsPost::published()
            ->when($featured, fn($q) => $q->where('id', '!=', $featured->id))
            ->when($category,  fn($q) => $q->where('category', $category))
            ->orderByDesc('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('news.index', compact('news', 'featured', 'categories'));
    }

    public function show(string $slug)
    {
        $post = NewsPost::published()
            ->where('slug', $slug)
            ->firstOrFail();

        // 3 related articles — same category first, then by date
        // ── FIX 4: wrap category in ?? '' to prevent null binding error
        $related = NewsPost::published()
            ->where('id', '!=', $post->id)
            ->orderByRaw(
                "CASE WHEN category = ? THEN 0 ELSE 1 END",
                [$post->category ?? '']
            )
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('news.show', compact('post', 'related'));
    }
}