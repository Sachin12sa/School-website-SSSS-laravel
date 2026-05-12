<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HeroRequest;
use App\Models\PageHero;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HeroController extends Controller
{
    public function index(): View
    {
        $heroes = PageHero::orderBy('page_label')->get();
        return view('admin.heroes.index', compact('heroes'));
    }

    public function edit(PageHero $hero): View
    {
        return view('admin.heroes.edit', compact('hero'));
    }

    public function update(HeroRequest $request, PageHero $hero): RedirectResponse
    {
        $data = $request->validated();

        // ── Image upload ───────────────────────────────────────────────
        if ($request->hasFile('bg_image')) {
            if ($hero->bg_image_path) {
                Storage::disk('public')->delete($hero->bg_image_path);
            }
            $data['bg_image_path'] = $request->file('bg_image')
                ->store("heroes/{$hero->page_slug}", 'public');
        }

        unset($data['bg_image']);

        // ── Checkboxes ─────────────────────────────────────────────────
        $data['show_rings'] = $request->boolean('show_rings');
        $data['is_active']  = $request->boolean('is_active');

        // ── FIX: Clamp opacity to 0–1 regardless of what was submitted ─
        // The old buggy editor could send 22 instead of 0.22.
        // Now the new editor sends the correct float, but we guard here too.
        if (isset($data['bg_image_opacity'])) {
            $op = (float) $data['bg_image_opacity'];
            if ($op > 1) {
                $op = $op / 100; // fix legacy bad value
            }
            $data['bg_image_opacity'] = max(0.0, min(1.0, $op));
        }

        // ── Stats: strip empty rows ────────────────────────────────────
        if (! empty($data['stats'])) {
            $data['stats'] = array_values(
                array_filter($data['stats'], fn ($s) => filled($s['value'] ?? null))
            );
        }

        // Empty stats array → store null
        if (empty($data['stats'])) {
            $data['stats'] = null;
        }

        $hero->update($data);

        return redirect()
            ->route('admin.heroes.index')
            ->with('success', "Hero for \"{$hero->page_label}\" updated successfully.");
    }

    // ── Delete background image only ───────────────────────────────────
    public function removeImage(PageHero $hero): RedirectResponse
    {
        if ($hero->bg_image_path) {
            Storage::disk('public')->delete($hero->bg_image_path);
            $hero->update(['bg_image_path' => null]);
        }

        return back()->with('success', 'Background image removed.');
    }
}