<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('theme_sections', function (Blueprint $table) {
            $table->id();

            /*
             * Example:
             * homepage
             * about
             * catalogue
             */
            $table->string('page')->default('homepage');

            /*
             * Admin-friendly internal name.
             *
             * Example:
             * Main Hero
             * Featured Products
             * Commercial Solutions
             */
            $table->string('name');

            /*
             * Section renderer.
             *
             * Examples:
             * hero
             * categories
             * products
             * image_text
             * promo_banner
             * benefits
             */
            $table->string('type');

            $table->unsignedInteger('position')->default(0);

            $table->boolean('status')->default(true);

            /*
             * Flexible section-specific configuration.
             */
            $table->json('settings')->nullable();

            $table->timestamps();

            $table->index(['page', 'status', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('theme_sections');
    }
};