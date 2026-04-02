<?php namespace App\Http\Controllers;
use App\Models\Page;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller {
    public function show(string $slug) {
        $page = Cache::remember("page_{$slug}", 3600, fn() =>
            Page::published()->with('blocks')->where('slug', $slug)->firstOrFail()
        );
        return view('pages.show', compact('page'));
    }
}