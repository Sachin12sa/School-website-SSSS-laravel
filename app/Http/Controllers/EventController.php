<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $filter = request('filter', 'upcoming');

        $events = Event::published()
            ->when($filter === 'upcoming', fn($q) => $q->upcoming()->orderBy('start_date'))
            ->when($filter === 'past',     fn($q) => $q->past()->orderByDesc('start_date'))
            ->paginate(9)
            ->withQueryString();

        return view('events.index', compact('events', 'filter'));
    }

    public function show(string $slug)
    {
        $event = Event::published()->where('slug', $slug)->firstOrFail();

        $related = Event::published()
            ->where('id', '!=', $event->id)
            ->upcoming()
            ->orderBy('start_date')
            ->limit(3)
            ->get();

        return view('events.show', compact('event', 'related'));
    }
}