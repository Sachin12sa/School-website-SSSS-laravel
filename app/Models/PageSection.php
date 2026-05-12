<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\{Storage, Cache};

class PageSection extends Model
{
    protected $fillable = [
        'page_key', 'title', 'subtitle', 'content',
        'items', 'image', 'badge_text', 'badge_color', 'layout',
        'button_text', 'button_url', 'settings', 'order', 'is_published',
    ];

    protected $casts = [
        'items'        => 'array',
        'settings'     => 'array',
        'is_published' => 'boolean',
    ];

    // ── Scopes ─────────────────────────────────────────────────────────────────
    public function scopePublished($q) { return $q->where('is_published', true); }
    public function scopeForPage($q, string $key) { return $q->where('page_key', $key); }

    // ── Image URL ─────────────────────────────────────────────────────────────
    public function getImageUrlAttribute(): ?string
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return Storage::url($this->image);
        }
        return null;
    }

    // ── Cache invalidation ────────────────────────────────────────────────────
    protected static function booted(): void
    {
        static::saved(fn($s)   => Cache::forget("sections_{$s->page_key}"));
        static::deleted(fn($s) => Cache::forget("sections_{$s->page_key}"));
    }

    // ── Helper: get all published sections for a page ─────────────────────────
    public static function forPageCached(string $pageKey): \Illuminate\Support\Collection
    {
        Cache::forget("sections_{$pageKey}");

        return static::published()->forPage($pageKey)->orderBy('order')->get();
    }
}
