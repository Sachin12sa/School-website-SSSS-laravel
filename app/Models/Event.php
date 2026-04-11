<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'body',
        'image', 'start_date', 'end_date',
        'location', 'organizer',
        'is_published', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'start_date'   => 'datetime',
        'end_date'     => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function ($e) {
            if (empty($e->slug)) $e->slug = Str::slug($e->title);
        });
        static::saved(fn()   => Cache::forget('home_events'));
        static::deleted(fn() => Cache::forget('home_events'));
    }

    public function scopePublished($q) { return $q->where('is_published', true); }
    public function scopeUpcoming($q)  { return $q->where('start_date', '>=', now()); }
    public function scopePast($q)      { return $q->where('start_date', '<',  now()); }

    // ── Correct image URL ──────────────────────────────────────────────────────
    public function getImageUrlAttribute(): string
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return Storage::url($this->image);
        }
        return 'https://placehold.co/800x450/1B2A4A/C9A227?text=Event';
    }
}