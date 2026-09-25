<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * LED modules used by the public LED wall calculator.
     * Mirrors the ERP's led_modules table, plus a link to the store product it is sold as.
     */
    public function up(): void
    {
        Schema::create('led_modules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->nullable()
                ->constrained('products')
                ->nullOnDelete();

            $table->string('name')->unique();
            $table->string('brand')->nullable();
            $table->string('model_number')->nullable();

            $table->enum('environment', ['indoor', 'outdoor'])->default('indoor');

            // Module size and resolution
            $table->decimal('length_mm', 10, 2);
            $table->decimal('height_mm', 10, 2);
            $table->integer('pixel_width');
            $table->integer('pixel_height');
            $table->decimal('pixel_pitch', 8, 4)->nullable();

            // Module technical spec
            $table->string('pixel_config', 50)->default('1R1G1B');
            $table->decimal('weight_per_module_kg', 8, 3)->nullable();
            $table->string('refresh_rate', 50)->nullable();
            $table->string('scan_mode', 50)->nullable();
            $table->decimal('brightness_nits', 10, 2)->nullable()->comment('cd/m²');
            $table->integer('viewing_angle_h')->nullable();
            $table->integer('viewing_angle_v')->nullable();
            $table->string('serviceability', 100)->nullable();
            $table->decimal('power_max_wm2', 10, 2)->nullable()->comment('Max power W/m²');
            $table->decimal('power_avg_wm2', 10, 2)->nullable()->comment('Avg power W/m²');
            $table->string('input_voltage', 100)->nullable();

            // Cabinet spec
            $table->decimal('cabinet_w_mm', 10, 2)->nullable();
            $table->decimal('cabinet_h_mm', 10, 2)->nullable();
            $table->decimal('cabinet_d_mm', 10, 2)->nullable();
            $table->decimal('cabinet_weight_kg', 8, 2)->nullable();
            $table->string('cabinet_material', 100)->nullable();

            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('led_modules');
    }
};
