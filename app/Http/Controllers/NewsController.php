<?php

namespace App\Http\Controllers;

use App\Models\NewsPost;
use Illuminate\Support\Facades\Cache;

class NewsController extends Controller
{
    public function index()
    {
        $category = request('category');

        // All unique categories for filter tabs
        $categories = Cache::remember('news_categories', 3600, fn() =>
            NewsPost::published()->whereNotNull('category')->distinct()->pluck('category')
        );

        // Featured: most recent post with is_featured = true
        $featured = Cache::remember('news_featured', 1800, fn() =>
            NewsPost::published()->where('is_featured', true)->orderByDesc('published_at')->first()
        );

        // Paginated list (filtered by category if provided)
        $news = NewsPost::published()
            ->when($featured, fn($q) => $q->where('id', '!=', $featured->id))
            ->when($category, fn($q) => $q->where('category', $category))
            ->orderByDesc('published_at')
            ->paginate(9)
            ->withQueryString(); // keeps ?category= when paginating

        return view('news.index', compact('news', 'featured', 'categories'));
    }

    public function show(string $slug)
    {
        $post = NewsPost::published()->where('slug', $slug)->firstOrFail();

        // 3 related articles (same category first, then any)
        $related = NewsPost::published()
            ->where('id', '!=', $post->id)
            ->orderByRaw("CASE WHEN category = ? THEN 0 ELSE 1 END", [$post->category ?? ''])
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('news.show', compact('post', 'related'));
    }
}