<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // ── Register Cache::safeRemember() macro ──────────────────────────────
        // Fixes the "incomplete object / unserialize" crash that happens with
        // the default FILE cache driver. Auto-heals stale cache entries.
        Cache::macro('safeRemember', function (string $key, int $ttl, \Closure $callback) {
            try {
                return Cache::remember($key, $ttl, $callback);
            } catch (\Throwable) {
                // Corrupt or stale entry — delete and rebuild fresh
                Cache::forget($key);
                $fresh = $callback();
                try { Cache::put($key, $fresh, $ttl); } catch (\Throwable) {}
                return $fresh;
            }
        });
    }
}