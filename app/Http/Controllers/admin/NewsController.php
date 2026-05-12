<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\NewsPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Cache, Storage};
use Illuminate\Support\Str;

class NewsController extends Controller
{
    // ── List ────────────────────────────────────────────────────────────────────
    public function index()
    {
        $news = NewsPost::orderByDesc('created_at')->paginate(15);
        $stats = [
            'total' => NewsPost::count(),
            'published' => NewsPost::where('is_published', true)->count(),
            'drafts' => NewsPost::where('is_published', false)->count(),
            'latest' => NewsPost::whereNotNull('published_at')->max('published_at'),
        ];

        return view('admin.news.index', compact('news', 'stats'));
    }

    // ── Create form ─────────────────────────────────────────────────────────────
    public function create()
    {
        $post = new NewsPost;
        return view('admin.news.form', compact('post'));
    }

    // ── Store new post ──────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $data = $this->validated($request);

        // Auto-generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Set published_at to now if publishing without a date
        if ($data['is_published'] && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        // Handle image upload — FIXED: explicit 'public' disk
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('news', 'public');
        }

        NewsPost::create($data);
        $this->clearCache();

        return redirect()->route('admin.news.index')
            ->with('success', 'News post published successfully.');
    }

    // ── Edit form ───────────────────────────────────────────────────────────────
    public function edit(NewsPost $news)
    {
        $post = $news; // rename for view consistency
        return view('admin.news.form', compact('post'));
    }

    // ── Update ──────────────────────────────────────────────────────────────────
    public function update(Request $request, NewsPost $news)
    {
        $data = $this->validated($request, $news->id);

        // Auto-slug if cleared
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Set published_at when first publishing
        if ($data['is_published'] && empty($news->published_at) && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        // Handle image upload — delete old one first
        if ($request->hasFile('image')) {
            if ($news->image && Storage::disk('public')->exists($news->image)) {
                Storage::disk('public')->delete($news->image);
            }
            $data['image'] = $request->file('image')
                ->store('news', 'public');
        }

        $news->update($data);
        $this->clearCache();

        return redirect()->route('admin.news.index')
            ->with('success', 'News post updated.');
    }

    // ── Delete ──────────────────────────────────────────────────────────────────
    public function destroy(NewsPost $news)
    {
        // Delete image file from disk
        if ($news->image && Storage::disk('public')->exists($news->image)) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();
        $this->clearCache();

        return back()->with('success', 'Post deleted.');
    }

    // ── Validation rules ────────────────────────────────────────────────────────
    private function validated(Request $request, $id = null): array
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'nullable|string|unique:news_posts,slug' . ($id ? ",$id" : ''),
            'excerpt'          => 'nullable|string|max:600',
            'body'             => 'required|string',
            'category'         => 'nullable|string|max:100',
            'published_at'     => 'nullable|date',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'image'            => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:51200',
        ]);

        // Checkboxes come in as '1' or absent — cast manually
        $validated['is_featured']  = $request->boolean('is_featured');
        $validated['is_published'] = $request->boolean('is_published');

        return $validated;
    }

    // ── Clear all news-related caches ───────────────────────────────────────────
    private function clearCache(): void
    {
        foreach (['news_categories', 'news_featured', 'home_news'] as $key) {
            Cache::forget($key);
        }
    }
}
