<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_heroes', function (Blueprint $table) {
            $table->id();

            // Which page this hero belongs to — unique slug identifier
            $table->string('page_slug')->unique()->index();
            // Human-readable label for admin panel
            $table->string('page_label');

            // ── Content fields ─────────────────────────────────────────
            $table->string('badge_text')->nullable();          // pill badge above heading
            $table->string('heading')->nullable();             // main H1
            $table->string('subheading')->nullable();          // paragraph below heading
            $table->string('primary_button_text')->nullable();
            $table->string('primary_button_url')->nullable();
            $table->string('secondary_button_text')->nullable();
            $table->string('secondary_button_url')->nullable();

            // ── Background ─────────────────────────────────────────────
            $table->string('bg_image_path')->nullable();       // storage path
            $table->decimal('bg_image_opacity', 3, 2)->default(0.22); // 0.00–1.00
            $table->string('bg_overlay_style')->default('dark');
            // dark | light | gold — maps to predefined gradient in blade

            // ── Appearance ─────────────────────────────────────────────
            $table->string('badge_style')->default('white');   // white | gold
            $table->string('min_height')->default('68vh');     // css min-height
            $table->string('text_align')->default('center');   // center | left
            $table->boolean('show_rings')->default(true);      // decorative ring circles

            // ── Stats strip (JSON array of {value, label} objects) ─────
            $table->json('stats')->nullable();

            // ── SEO ────────────────────────────────────────────────────
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_heroes');
    }
};