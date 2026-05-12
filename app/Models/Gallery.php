<?php

namespace App\Models;

use App\Models\GalleryImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    protected $fillable = ['name', 'description', 'cover_image', 'order', 'is_published'];
    protected $casts    = ['is_published' => 'boolean'];

    public function images()
    {
        return $this->hasMany(GalleryImage::class)->orderBy('order');
    }

    public function scopePublished($q)
    {
        return $q->where('is_published', true);
    }

    /**
     * Use Storage::url() via the facade — it correctly resolves the public disk URL
     * and is recognized by the type system (avoids "Undefined method 'url'" warning).
     */
    public function getCoverUrlAttribute(): string
    {
        if ($this->cover_image && Storage::disk('public')->exists($this->cover_image)) {
            // Return relative URL so it works regardless of port/host (8000 vs 8001)
            return parse_url(Storage::url($this->cover_image), PHP_URL_PATH);
        }

        $firstImage = $this->images()
            ->where('media_type', 'image')
            ->whereNotNull('image_path')
            ->first();

        if ($firstImage) {
            return $firstImage->url;
        }

        return 'https://placehold.co/600x400/1B2A4A/C9A227?text=' . urlencode($this->name);
    }
}
