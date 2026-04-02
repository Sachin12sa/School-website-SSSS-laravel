<?php namespace App\Http\Controllers;
use App\Models\Event;

class EventController extends Controller {
    public function index() {
        $filter = request('filter', 'upcoming');
        $events = Event::published()
            ->when($filter === 'upcoming', fn($q) => $q->upcoming())
            ->when($filter === 'past', fn($q) => $q->past())
            ->orderBy('start_date', $filter === 'past' ? 'desc' : 'asc')
            ->paginate(9);
        return view('events.index', compact('events', 'filter'));
    }
    public function show(string $slug) {
        $event = Event::published()->where('slug', $slug)->firstOrFail();
        $related = Event::published()->where('id', '!=', $event->id)->upcoming()->orderBy('start_date')->limit(3)->get();
        return view('events.show', compact('event', 'related'));
    }
}