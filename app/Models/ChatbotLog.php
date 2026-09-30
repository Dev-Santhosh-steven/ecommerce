<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatbotLog extends Model
{
    protected $fillable = [
        'message',
        'chatbot_faq_id',
        'product_count',
        'answered',
    ];

    protected $casts = [
        'answered' => 'boolean',
    ];

    public function faq(): BelongsTo
    {
        return $this->belongsTo(ChatbotFaq::class, 'chatbot_faq_id');
    }
}
