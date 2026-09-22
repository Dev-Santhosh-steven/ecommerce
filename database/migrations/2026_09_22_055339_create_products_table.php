<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')
                ->constrained('categories')
                ->restrictOnDelete();

            $table->string('name');
            $table->string('slug')->unique();

            $table->string('sku')->unique();
            $table->string('model_number')->nullable()->index();

            $table->string('brand')->nullable();

            $table->string('short_description')->nullable();
            $table->longText('description')->nullable();

            $table->decimal('price', 12, 2);
            $table->decimal('sale_price', 12, 2)->nullable();

            $table->unsignedInteger('stock_quantity')->default(0);

            $table->unsignedInteger('warranty_months')->nullable();

            $table->json('specifications')->nullable();

            $table->boolean('status')->default(true);
            $table->boolean('featured')->default(false);

            $table->unsignedInteger('sort_order')->default(0);

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};