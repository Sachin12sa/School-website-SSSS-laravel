<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model {
    protected $fillable = ['name','description','cover_image','order','is_published'];
    protected $casts = ['is_published' => 'boolean'];
    public function images() { return $this->hasMany(GalleryImage::class)->orderBy('order'); }
    public function scopePublished($q) { return $q->where('is_published', true); }
    public function getCoverUrlAttribute(): string { return $this->cover_image ? asset('storage/'.$this->cover_image) : asset('images/gallery-placeholder.jpg'); }
}