<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class Event extends Model
{
    use HasFactory;
    protected $fillable = ['title','slug','description','body','image','start_date','end_date','location','organizer','is_published','meta_title','meta_description'];
    protected $casts = ['is_published' => 'boolean', 'start_date' => 'datetime', 'end_date' => 'datetime'];

    protected static function booted(): void
    {
        static::saving(function ($event) {
            if (empty($event->slug)) $event->slug = Str::slug($event->title);
        });
        static::saved(fn() => Cache::forget('events_listing'));
        static::deleted(fn() => Cache::forget('events_listing'));
    }

    public function scopePublished($query) { return $query->where('is_published', true); }
    public function scopeUpcoming($query) { return $query->where('start_date', '>=', now()); }
    public function scopePast($query) { return $query->where('start_date', '<', now()); }
    public function getImageUrlAttribute(): string { return $this->image ? asset('storage/'.$this->image) : asset('images/event-placeholder.jpg'); }
}