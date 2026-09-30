<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Knowledge base the chatbot answers from ("training" data).
        Schema::create('chatbot_faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('keywords')->nullable();
            $table->text('answer');
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();
            $table->boolean('show_as_suggestion')->default(false);
            $table->boolean('status')->default(true);
            $table->integer('sort_order')->default(0);
            $table->unsignedInteger('hits')->default(0);
            $table->timestamps();
        });

        // Every visitor message, so unanswered ones can be turned into new answers.
        Schema::create('chatbot_logs', function (Blueprint $table) {
            $table->id();
            $table->string('message', 500);
            $table->foreignId('chatbot_faq_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedTinyInteger('product_count')->default(0);
            $table->boolean('answered')->default(false);
            $table->timestamps();

            $table->index(['answered', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chatbot_logs');
        Schema::dropIfExists('chatbot_faqs');
    }
};
