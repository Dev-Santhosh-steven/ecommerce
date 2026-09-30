<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Certifications & certificates shown on /certifications, each with an optional downloadable document.
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('issuer')->nullable();
            $table->string('code', 40)->nullable();
            $table->text('description')->nullable();
            $table->string('icon', 60)->nullable();
            $table->string('logo')->nullable();
            $table->string('file')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certifications');
    }
};
