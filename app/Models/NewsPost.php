<?php
// app/Models/NewsPost.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class NewsPost extends Model
{
    use HasFactory;
    protected $fillable = ['title','slug','excerpt','body','image','category','is_featured','is_published','published_at','meta_title','meta_description'];
    protected $casts = ['is_featured' => 'boolean', 'is_published' => 'boolean', 'published_at' => 'datetime'];

    protected static function booted(): void
    {
        static::saving(function ($post) {
            if (empty($post->slug)) $post->slug = Str::slug($post->title);
            if (empty($post->published_at)) $post->published_at = now();
        });
        static::saved(fn() => Cache::forget('news_listing'));
        static::deleted(fn() => Cache::forget('news_listing'));
    }

    public function scopePublished($query) { return $query->where('is_published', true); }
    public function getImageUrlAttribute(): string { return $this->image ? asset('storage/'.$this->image) : asset('images/news-placeholder.jpg'); }
}