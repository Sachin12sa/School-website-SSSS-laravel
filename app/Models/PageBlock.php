<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PageBlock extends Model
{
    protected $fillable = [
        'page_id',
        'type',
        'title',
        'subtitle',
        'content',
        'image_path',
        'button_text',
        'button_url',
        'extra',
        'order',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'extra'      => 'array',
    ];

    // ── Relationships ──────────────────────────────────────────────────────────

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    // ── Cache invalidation ─────────────────────────────────────────────────────

    protected static function booted(): void
    {
        static::saved(fn ()   => Cache::forget('homepage_blocks'));
        static::deleted(fn () => Cache::forget('homepage_blocks'));
    }

    // ── Accessors ──────────────────────────────────────────────────────────────

    /**
     * Full public URL for the block image (empty string when none).
     */
    public function getImageUrlAttribute(): string
    {
        return $this->image_path
            ? asset('storage/' . $this->image_path)
            : '';
    }

    /**
     * True when a stored image file actually exists on disk.
     */
    public function getImageExistsAttribute(): bool
    {
        return $this->image_path
            && Storage::disk('public')->exists($this->image_path);
    }

    /**
     * Convenience: return a specific key from the extra JSON column,
     * or $default when the key is absent.
     *
     * Usage: $block->extra('students', '500+')
     */
    public function extra(string $key, mixed $default = null): mixed
    {
        return data_get($this->extra, $key, $default);
    }

    // ── Scopes ─────────────────────────────────────────────────────────────────

    /**
     * Only visible blocks.
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * Homepage (global) blocks — no page_id.
     */
    public function scopeHomepage($query)
    {
        return $query->whereNull('page_id')->orderBy('order');
    }

    // ── Static helpers ─────────────────────────────────────────────────────────

    /**
     * Cached homepage block collection (15-minute TTL).
     * Returns ALL blocks so the controller/view can filter by type.
     */
    public static function cachedHomepageBlocks()
    {
        return Cache::remember('homepage_blocks', now()->addMinutes(15), function () {
            return static::homepage()->get();
        });
    }
}