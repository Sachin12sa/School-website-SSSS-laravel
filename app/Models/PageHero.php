<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PageHero extends Model
{
    protected $fillable = [
        'page_slug',
        'page_label',
        'badge_text',
        'heading',
        'subheading',
        'primary_button_text',
        'primary_button_url',
        'secondary_button_text',
        'secondary_button_url',
        'bg_image_path',
        'bg_image_opacity',
        'bg_overlay_style',
        'badge_style',
        'min_height',
        'text_align',
        'show_rings',
        'stats',
        'meta_title',
        'meta_description',
        'is_active',
    ];

    protected $casts = [
        'stats'            => 'array',
        'show_rings'       => 'boolean',
        'is_active'        => 'boolean',
        'bg_image_opacity' => 'float',
    ];

    // ── Cache key ──────────────────────────────────────────────────────
    public static function cacheKey(string $slug): string
    {
        return "page_hero:{$slug}";
    }

    // ── Fetch with 6h cache ────────────────────────────────────────────
    public static function forPage(string $slug): ?self
    {
        return Cache::remember(
            static::cacheKey($slug),
            now()->addHours(6),
            fn () => static::where('page_slug', $slug)->where('is_active', true)->first()
        );
    }

    // ── Auto-clear cache on save/delete ───────────────────────────────
    protected static function booted(): void
    {
        $clear = fn (self $m) => Cache::forget(static::cacheKey($m->page_slug));
        static::saved($clear);
        static::deleted($clear);
    }

    // ── Background image public URL ────────────────────────────────────
    public function bgImageUrl(): ?string
    {
        if (! $this->bg_image_path) return null;
        
        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('public');
        
        return $disk->url($this->bg_image_path);
    }

    // ── Overlay gradient CSS string ────────────────────────────────────
    public function overlayGradient(): string
    {
        return match ($this->bg_overlay_style) {
            'light' => 'linear-gradient(135deg,rgba(255,255,255,0.65) 0%,rgba(255,255,255,0.4) 55%,rgba(201,162,39,0.05) 100%)',
            'gold'  => 'linear-gradient(135deg,rgba(201,162,39,0.92) 0%,rgba(183,140,10,0.75) 55%,rgba(13,27,46,0.5) 100%)',
            default => 'linear-gradient(135deg,rgba(6,14,28,0.96) 0%,rgba(13,27,46,0.85) 55%,rgba(201,162,39,0.07) 100%)',
        };
    }

    // ── Badge inline style ─────────────────────────────────────────────
    public function badgeStyle(): string
    {
        return $this->badge_style === 'gold'
            ? 'background:rgba(201,162,39,0.12);border:1px solid rgba(201,162,39,0.28);color:var(--gold)'
            : 'background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.14);color:rgba(255,255,255,0.88)';
    }

    /**
     * FIX: Safe opacity accessor.
     * Guards against values > 1 that were stored by the buggy old editor
     * (which multiplied 0.22 × 100 = 22 before saving).
     */
    public function getSafeOpacityAttribute(): float
    {
        $v = (float) $this->bg_image_opacity;
        // If someone accidentally stored 22 instead of 0.22, correct it for rendering
        if ($v > 1) {
            $v = $v / 100;
        }
        return max(0.0, min(1.0, $v));
    }
}