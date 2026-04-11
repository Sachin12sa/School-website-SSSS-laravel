<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value'];

    // ── Get one setting value ──────────────────────────────────────────────────
    public static function get(string $key, $default = null): mixed
    {
        try {
            $settings = Cache::remember('site_settings', 3600, function () {
                return static::all()->pluck('value', 'key')->toArray();
            });
            return $settings[$key] ?? $default;
        } catch (\Throwable) {
            Cache::forget('site_settings');
            return static::where('key', $key)->value('value') ?? $default;
        }
    }

    // ── Set one setting ────────────────────────────────────────────────────────
    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('site_settings');
    }

    // ── Set many settings at once ──────────────────────────────────────────────
    public static function setMany(array $data): void
    {
        foreach ($data as $key => $value) {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        Cache::forget('site_settings');
    }

    // ── Get all settings as array ──────────────────────────────────────────────
    public static function all_settings(): array
    {
        try {
            return Cache::remember('site_settings', 3600, function () {
                return static::all()->pluck('value', 'key')->toArray();
            });
        } catch (\Throwable) {
            Cache::forget('site_settings');
            return static::all()->pluck('value', 'key')->toArray();
        }
    }

    // ── Get the logo public URL ────────────────────────────────────────────────
    // Use this in views: SiteSetting::logoUrl()
    public static function logoUrl(): ?string
    {
        $logo = static::get('logo');
        if (!$logo) return null;
        if (Storage::disk('public')->exists($logo)) {
            return Storage::url($logo);
        }
        return null;
    }

    // ── Get the favicon public URL ─────────────────────────────────────────────
    public static function faviconUrl(): string
    {
        $fav = static::get('favicon');
        if ($fav && Storage::disk('public')->exists($fav)) {
            return Storage::url($fav);
        }
        return asset('favicon.ico');
    }
}