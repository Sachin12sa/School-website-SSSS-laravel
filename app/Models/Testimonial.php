<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Casts\Attribute;
class Testimonial extends Model {
    protected $fillable = ['author_name','author_role','content','photo','rating','is_featured','is_published','order'];
    protected $casts = ['is_featured' => 'boolean', 'is_published' => 'boolean'];
    public function scopePublished($q) { return $q->where('is_published', true); }
    public function scopeFeatured($q) { return $q->where('is_featured', true); }
    protected function photoUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->photo ? asset('storage/' . $this->photo) : null,
        );
    }
}