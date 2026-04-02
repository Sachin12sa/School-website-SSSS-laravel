<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class GalleryImage extends Model {
    protected $fillable = ['gallery_id','image_path','caption','order'];
    public function gallery() { return $this->belongsTo(Gallery::class); }
    public function getUrlAttribute(): string { return asset('storage/'.$this->image_path); }
}