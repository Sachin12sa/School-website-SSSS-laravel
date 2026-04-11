<?php

namespace App\Models;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GalleryImage extends Model
{
    protected $fillable = ['gallery_id', 'image_path', 'caption', 'order'];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    /**
     * Use Storage::url() via the facade — it correctly resolves the public disk URL
     * and is recognized by the type system (avoids "Undefined method 'url'" warning).
     */
    public function getUrlAttribute(): string
    {
        if ($this->image_path && Storage::disk('public')->exists($this->image_path)) {
            return Storage::url($this->image_path);
        }
        return 'https://placehold.co/400x300/1B2A4A/C9A227?text=Photo';
    }
}