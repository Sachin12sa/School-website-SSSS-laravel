<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{SiteSetting, PageBlock};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Cache, Storage};

class SettingsController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all_settings();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // ── 1. Simple key/value settings ─────────────────────────────────────
        $textFields = [
            'school_name', 'school_tagline', 'established_year', 'about_short',
            'phone', 'email', 'address', 'map_embed',
            'mission', 'vision', 'history_intro', 'about_content', 'hero_subtitle',
            'facebook', 'twitter', 'instagram', 'youtube',
            'meta_description', 'ga_id','popup_badge_text',   
    'popup_subtitle',  
    'popup_deadline', 'popup_mode', 'popup_image_link',
        ];

        \App\Models\SiteSetting::set('popup_enabled', $request->has('popup_enabled') ? '1' : '0');

        foreach ($textFields as $field) {
            if ($request->has($field)) {
                SiteSetting::set($field, $request->input($field));
            }
        }

        // ── 1.5. Popup Image upload ──────────────────────────────────────────
        if ($request->hasFile('popup_image')) {
            $request->validate(['popup_image' => 'image|max:3072']);
            $old = SiteSetting::get('popup_image');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            $path = $request->file('popup_image')->store('settings', 'public');
            SiteSetting::set('popup_image', $path);
        } elseif ($request->input('delete_popup_image') === '1') {
            // Handle delete popup image only if no new image is provided
            $old = SiteSetting::get('popup_image');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            SiteSetting::set('popup_image', null);
        }

        // ── 2. Logo upload ───────────────────────────────────────────────────
        if ($request->hasFile('logo')) {
            $request->validate(['logo' => 'image|max:2048']);
            // Delete old logo
            $old = SiteSetting::get('logo');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            $path = $request->file('logo')->store('settings', 'public');
            SiteSetting::set('logo', $path);
        }

        // ── 3. Favicon upload ────────────────────────────────────────────────
        if ($request->hasFile('favicon')) {
            $request->validate(['favicon' => 'image|max:512']);
            $old = SiteSetting::get('favicon');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            $path = $request->file('favicon')->store('settings', 'public');
            SiteSetting::set('favicon', $path);
        }

        // ── 4. Update the homepage STATS block (extra JSON) ──────────────────
        $statsBlock = PageBlock::whereNull('page_id')->where('type', 'stats')->first();
        if ($statsBlock) {
            $extra = $statsBlock->extra ?? [];

            if ($request->filled('stats_students'))   $extra['students']   = $request->input('stats_students');
            if ($request->filled('stats_teachers'))   $extra['teachers']   = $request->input('stats_teachers');
            if ($request->filled('stats_years'))      $extra['years']      = $request->input('stats_years');
            if ($request->filled('stats_programmes')) $extra['programmes'] = $request->input('stats_programmes');

            $statsBlock->update(['extra' => $extra]);
        }

        // ── 5. Update the HERO block ──────────────────────────────────────────
        $heroBlock = PageBlock::whereNull('page_id')->where('type', 'hero')->first();
        if ($heroBlock) {
            $heroData = [];

            if ($request->filled('hero_title'))          $heroData['title']    = $request->input('hero_title');
            if ($request->filled('hero_subtitle_block')) $heroData['subtitle'] = $request->input('hero_subtitle_block');

            if ($request->hasFile('hero_image')) {
                $request->validate(['hero_image' => 'image|max:5120']);
                $old = $heroBlock->image_path;
                if ($old && Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }
                $heroData['image_path'] = $request->file('hero_image')->store('blocks', 'public');
            }

            if (!empty($heroData)) {
                $heroBlock->update($heroData);
            }
        }

        // ── 6. Update the CTA block ───────────────────────────────────────────
        $ctaBlock = PageBlock::whereNull('page_id')->where('type', 'cta_banner')->first();
        if ($ctaBlock) {
            $ctaData = [];
            if ($request->filled('cta_title'))    $ctaData['title']    = $request->input('cta_title');
            if ($request->filled('cta_subtitle'))  $ctaData['subtitle'] = $request->input('cta_subtitle');
            if (!empty($ctaData)) $ctaBlock->update($ctaData);
        }

        // ── 7. Clear all caches ───────────────────────────────────────────────
        foreach ([
            'site_settings', 'nav_pages', 'homepage_blocks',
            'home_news', 'home_events', 'home_testimonials',
            'home_galleries', 'news_categories', 'news_featured',
            'leaders', 'campus_galleries',
        ] as $key) {
            Cache::forget($key);
        }

        $tab = $request->input('active_tab', 'identity');
        return redirect()->to(route('admin.settings.index') . '#' . $tab)
            ->with('success', 'All settings saved successfully.');
    }
}