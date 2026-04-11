<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * page_sections — powers any fully-dynamic page.
     *
     * Each row is one visual section on a page.
     * The 'page_key' ties sections to a page (e.g. 'programs', 'life-at-ssss', 'boarding').
     * Admin can add/edit/delete/reorder sections from the admin panel.
     */
    public function up(): void
    {
        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();

            // Which page does this section belong to?
            // e.g. 'programs', 'life-at-ssss', 'boarding', 'about'
            $table->string('page_key');

            // Section display
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->longText('content')->nullable();  // Rich HTML content
            $table->string('image')->nullable();       // Uploaded image path (storage/app/public/)
            $table->string('badge_text')->nullable();  // Small badge above title e.g. "Grades 1-5"
            $table->string('badge_color')->default('#C9A227'); // Badge background color

            // Layout hint for the frontend template
            // 'default'     = text only
            // 'image-left'  = image on left, text on right
            // 'image-right' = image on right, text on left
            // 'full-image'  = full-width image with overlay text
            // 'cards'       = content rendered as a card grid
            // 'list'        = content rendered as a bullet list
            $table->string('layout')->default('image-right');

            // Optional call-to-action
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();

            // Ordering and visibility
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_published')->default(true);

            $table->timestamps();

            $table->index(['page_key', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_sections');
    }
};