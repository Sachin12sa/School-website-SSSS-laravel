<?php namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller {
    public function index() {
        $events = Event::orderByDesc('start_date')->paginate(15);
        $stats = [
            'total' => Event::count(),
            'published' => Event::where('is_published', true)->count(),
            'upcoming' => Event::whereDate('start_date', '>=', now())->count(),
            'past' => Event::whereDate('start_date', '<', now())->count(),
        ];

        return view('admin.events.index', compact('events', 'stats'));
    }
    public function create() { return view('admin.events.form', ['event' => new Event]); }
    public function store(Request $request) {
        $data = $this->validated($request);
        if ($request->hasFile('image')) $data['image'] = $request->file('image')->store('events', 'public');
        Event::create($data);
        return redirect()->route('admin.events.index')->with('success', 'Event created.');
    }
    public function edit(Event $event) { return view('admin.events.form', compact('event')); }
    public function update(Request $request, Event $event) {
        $data = $this->validated($request, $event->id);
        if ($request->hasFile('image')) $data['image'] = $request->file('image')->store('events', 'public');
        $event->update($data);
        return redirect()->route('admin.events.index')->with('success', 'Event updated.');
    }
    public function destroy(Event $event) { $event->delete(); return back()->with('success', 'Event deleted.'); }
    private function validated(Request $request, $id = null): array {
        return $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:events,slug'.($id ? ",".$id : ''),
            'description' => 'nullable|string|max:500',
            'body' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'organizer' => 'nullable|string|max:255',
            'is_published' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:51200',
        ]);
    }
}
