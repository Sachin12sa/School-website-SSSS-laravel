<?php

namespace App\Http\Controllers;

use App\Models\{Page, Teacher, Gallery, PageSection};
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    // Slugs that have dedicated rich template views
    protected array $dedicated = ['about', 'programs', 'life-at-ssss', 'boarding'];

    public function show(string $slug)
    {
        // ── Dedicated templates ──────────────────────────────────────────────
        if (in_array($slug, $this->dedicated) && view()->exists('pages.' . $slug)) {

            $page = Cache::remember("page_{$slug}", 3600, fn() =>
                Page::published()->with('blocks')->where('slug', $slug)->first()
            );

            return match($slug) {

                'about' => view('pages.about', [
                    'page'       => $page,
                    'leadership' => Cache::remember('leaders', 3600, fn() =>
                        Teacher::published()
                            ->whereIn('department', ['Leadership','leadership','Management','Administration'])
                            ->orderBy('order')->get()
                    ),
                ]),

                'life-at-ssss' => view('pages.life-at-ssss', [
                    'page'      => $page,
                    'galleries' => Cache::remember('campus_galleries', 3600, fn() =>
                        Gallery::published()
                            ->with(['images' => fn($q) => $q->orderBy('order')->limit(1)])
                            ->orderBy('order')->limit(4)->get()
                    ),
                ]),

                // Programs and boarding — just pass sections; view handles rendering
                default => view('pages.' . $slug, compact('page')),
            };
        }

        // ── Generic CMS page ─────────────────────────────────────────────────
        $page = Cache::remember("page_{$slug}", 3600, fn() =>
            Page::published()->with('blocks')->where('slug', $slug)->firstOrFail()
        );

        return view('pages.show', compact('page'));
    }
}