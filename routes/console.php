<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('app:seed-demo-if-empty', function () {
    if (! Schema::hasTable('users')) {
        $this->warn('Users table does not exist yet. Run migrations first.');

        return self::FAILURE;
    }

    if (\App\Models\User::query()->exists()) {
        $this->info('Demo seed skipped because users already exist.');

        return self::SUCCESS;
    }

    $this->call('db:seed', ['--force' => true]);
    $this->info('Demo seed completed.');

    return self::SUCCESS;
})->purpose('Seed demo data once when the production database is empty');
