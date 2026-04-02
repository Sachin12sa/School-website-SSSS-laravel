<?php namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\NewsPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller {
    public function index() {
        $news = NewsPost::orderByDesc('created_at')->paginate(15);
        return view('admin.news.index', compact('news'));
    }
    public function create() { return view('admin.news.form', ['post' => new NewsPost]); }
    public function store(Request $request) {
        $data = $this->validated($request);
        if ($request->hasFile('image')) $data['image'] = $request->file('image')->store('news', 'public');
        NewsPost::create($data);
        return redirect()->route('admin.news.index')->with('success', 'Post created.');
    }
    public function edit(NewsPost $news) { return view('admin.news.form', ['post' => $news]); }
    public function update(Request $request, NewsPost $news) {
        $data = $this->validated($request, $news->id);
        if ($request->hasFile('image')) $data['image'] = $request->file('image')->store('news', 'public');
        $news->update($data);
        return redirect()->route('admin.news.index')->with('success', 'Post updated.');
    }
    public function destroy(NewsPost $news) {
        $news->delete();
        return back()->with('success', 'Post deleted.');
    }
    private function validated(Request $request, $id = null): array {
        return $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:news_posts,slug'.($id ? ",".$id : ''),
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string',
            'category' => 'nullable|string|max:100',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);
    }
}