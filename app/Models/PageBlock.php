<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
class PageBlock extends Model {
    protected $fillable = ['page_id','type','title','subtitle','content','image_path','button_text','button_url','extra','order','is_visible'];
    protected $casts = ['is_visible' => 'boolean', 'extra' => 'array'];
    public function page() { return $this->belongsTo(Page::class); }
    protected static function booted(): void {
        static::saved(fn() => Cache::forget('homepage_blocks'));
        static::deleted(fn() => Cache::forget('homepage_blocks'));
    }
    public function getImageUrlAttribute(): string { return $this->image_path ? asset('storage/'.$this->image_path) : ''; }
}