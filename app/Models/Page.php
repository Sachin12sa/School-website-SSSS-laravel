<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Page extends Model {
    protected $fillable = ['title','slug','content','hero_image','hero_title','hero_subtitle','meta_title','meta_description','is_published','order'];
    protected $casts = ['is_published' => 'boolean'];
    public function blocks() { return $this->hasMany(PageBlock::class)->orderBy('order'); }
    public function scopePublished($q) { return $q->where('is_published', true); }
    protected static function booted(): void {
        static::saved(fn($p) => Cache::forget('page_'.$p->slug));
        static::deleted(fn($p) => Cache::forget('page_'.$p->slug));
    }
}