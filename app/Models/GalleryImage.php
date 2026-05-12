<?php

namespace App\Models;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GalleryImage extends Model
{
    protected $fillable = ['gallery_id', 'image_path', 'media_type', 'caption', 'order'];

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
            // Return relative URL so it works regardless of port/host (8000 vs 8001)
            return parse_url(Storage::url($this->image_path), PHP_URL_PATH);
        }
        return 'https://placehold.co/400x300/1B2A4A/C9A227?text=Photo';
    }

    public function getIsVideoAttribute(): bool
    {
        return $this->media_type === 'video';
    }
}
