<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Faq extends Model {
    protected $fillable = ['question','answer','category','order','is_published'];
    protected $casts = ['is_published' => 'boolean'];
    public function scopePublished($q) { return $q->where('is_published', true); }
}