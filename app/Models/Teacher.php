<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Teacher extends Model
{
    protected $fillable = [
        'name', 'designation', 'department',
        'email', 'bio', 'photo', 'linkedin',
        'order', 'is_published',
    ];

    protected $casts = ['is_published' => 'boolean'];

    public function scopePublished($q) { return $q->where('is_published', true); }

    // ── Correct photo URL ──────────────────────────────────────────────────────
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo && Storage::disk('public')->exists($this->photo)) {
            return Storage::url($this->photo);
        }
        // Generate a nice initials placeholder
        $initials = collect(explode(' ', $this->name))
            ->map(fn($w) => strtoupper($w[0] ?? ''))
            ->take(2)
            ->implode('+');
        return "https://placehold.co/200x200/1B2A4A/C9A227?text={$initials}";
    }
}