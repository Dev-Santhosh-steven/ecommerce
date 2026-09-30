<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Answers generated for one product (see ProductChatbotFaqSeeder). Removed with the product.
        Schema::table('chatbot_faqs', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('chatbot_faqs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('product_id');
        });
    }
};
