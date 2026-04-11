<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class NewsPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'excerpt', 'body',
        'image', 'category',
        'is_featured', 'is_published', 'published_at',
        'meta_title', 'meta_description',
    ];

    protected $casts = [
        'is_featured'  => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    // ── Auto-generate slug before saving ──────────────────────────────────────
    protected static function booted(): void
    {
        static::saving(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            if (empty($post->published_at)) {
                $post->published_at = now();
            }
        });

        // Clear homepage cache when any post changes
        static::saved(fn()   => Cache::forget('home_news'));
        static::deleted(fn() => Cache::forget('home_news'));
    }

    // ── Scopes ─────────────────────────────────────────────────────────────────
    public function scopePublished($q)
    {
        return $q->where('is_published', true)
                 ->where('published_at', '<=', now());
    }

    // ── Image URL accessor — THE FIX ──────────────────────────────────────────
    // Storage::url() correctly builds the public URL for any stored file.
    // It reads FILESYSTEM_DISK from .env automatically.
    // Result: /storage/news/abc123.jpg
    public function getImageUrlAttribute(): string
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return Storage::url($this->image);
        }
        // Fallback placeholder (use a real placeholder image in production)
        return 'https://placehold.co/800x450/1B2A4A/C9A227?text=News';
    }
}