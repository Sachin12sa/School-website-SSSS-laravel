<?php

namespace App\Http\Controllers;

use App\Models\{Event, NewsPost, Gallery};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CalendarController extends Controller
{
    /**
     * Main calendar page
     * URL: /calendar  (or /school-calendar)
     */
    public function index(Request $request)
    {
        $year  = (int) $request->get('year',  now()->year);
        $month = (int) $request->get('month', now()->month);

        // Clamp to valid range
        $year  = max(2020, min(2030, $year));
        $month = max(1,    min(12,   $month));

        $date     = Carbon::create($year, $month, 1);
        $prevDate = $date->copy()->subMonth();
        $nextDate = $date->copy()->addMonth();

        // All events in this month
        $events = Event::published()
            ->whereYear('start_date',  $year)
            ->whereMonth('start_date', $month)
            ->orderBy('start_date')
            ->get();

        // All news published in this month
        $news = NewsPost::published()
            ->whereYear('published_at',  $year)
            ->whereMonth('published_at', $month)
            ->orderBy('published_at')
            ->get();

        // Gallery albums with dates this month
        $galleries = Gallery::published()
            ->whereYear('created_at',  $year)
            ->whereMonth('created_at', $month)
            ->orderBy('created_at')
            ->get();

        // Build a lookup: day → items (for calendar dot rendering)
        $dayMap = $this->buildDayMap($events, $news, $galleries);

        // Upcoming events (next 10 from today, for sidebar)
        $upcoming = Event::published()
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->limit(10)
            ->get();

        // Monthly summary counts
        $summary = [
            'events'    => $events->count(),
            'news'      => $news->count(),
            'galleries' => $galleries->count(),
        ];

        return view('calendar', compact(
            'date', 'prevDate', 'nextDate',
            'dayMap', 'upcoming', 'summary',
            'year', 'month'
        ));
    }

    /**
     * AJAX: items for a specific date (called when user clicks a day)
     * URL: /calendar/day?date=2026-04-12
     */
    public function day(Request $request)
    {
        $date = Carbon::parse($request->get('date', today()));

        $events = Event::published()
            ->whereDate('start_date', $date)
            ->orderBy('start_date')
            ->get()
            ->map(fn($e) => [
                'type'     => 'event',
                'id'       => $e->id,
                'title'    => $e->title,
                'desc'     => $e->description,
                'url'      => route('events.show', $e->slug),
                'location' => $e->location,
                'category' => $e->category ?? 'Event',
                'image'    => $e->image_url,
            ]);

        $news = NewsPost::published()
            ->whereDate('published_at', $date)
            ->orderBy('published_at')
            ->get()
            ->map(fn($n) => [
                'type'     => 'news',
                'id'       => $n->id,
                'title'    => $n->title,
                'desc'     => $n->excerpt,
                'url'      => route('news.show', $n->slug),
                'category' => $n->category ?? 'News',
                'image'    => $n->image_url,
            ]);

        $galleries = Gallery::published()
            ->whereDate('created_at', $date)
            ->get()
            ->map(fn($g) => [
                'type'   => 'gallery',
                'id'     => $g->id,
                'title'  => $g->name,
                'desc'   => $g->description,
                'url'    => route('gallery.show', $g->id),
                'count'  => $g->images()->count(),
                'image'  => $g->cover_url,
            ]);

        $items = $events->concat($news)->concat($galleries)->values();

        return response()->json([
            'date'  => $date->format('F j, Y'),
            'count' => $items->count(),
            'items' => $items,
        ]);
    }

    /**
     * Build a day → items array for dot rendering
     * Returns: ['15' => [['type'=>'event','color'=>'#...'], ...], ...]
     */
    private function buildDayMap($events, $news, $galleries): array
    {
        $map = [];

        foreach ($events as $e) {
            $day = $e->start_date->format('j');
            $map[$day][] = ['type' => 'event', 'color' => '#378ADD'];
        }
        foreach ($news as $n) {
            $day = $n->published_at->format('j');
            $map[$day][] = ['type' => 'news', 'color' => '#E53E3E'];
        }
        foreach ($galleries as $g) {
            $day = $g->created_at->format('j');
            $map[$day][] = ['type' => 'gallery', 'color' => '#9F7AEA'];
        }

        return $map;
    }
}