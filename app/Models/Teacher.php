<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model {
    use HasFactory;
    protected $fillable = ['name','designation','department','email','bio','photo','linkedin','order','is_published'];
    protected $casts = ['is_published' => 'boolean'];
    public function scopePublished($q) { return $q->where('is_published', true); }
    public function getPhotoUrlAttribute(): string { return $this->photo ? asset('storage/'.$this->photo) : asset('images/teacher-placeholder.jpg'); }
}