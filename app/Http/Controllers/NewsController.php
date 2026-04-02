<?php namespace App\Http\Controllers;
use App\Models\NewsPost;

class NewsController extends Controller {
    public function index() {
        $news = NewsPost::published()->orderByDesc('published_at')->paginate(9);
        $featured = NewsPost::published()->where('is_featured', true)->orderByDesc('published_at')->first();
        return view('news.index', compact('news', 'featured'));
    }
    public function show(string $slug) {
        $post = NewsPost::published()->where('slug', $slug)->firstOrFail();
        $related = NewsPost::published()->where('id', '!=', $post->id)->orderByDesc('published_at')->limit(3)->get();
        return view('news.show', compact('post', 'related'));
    }
}