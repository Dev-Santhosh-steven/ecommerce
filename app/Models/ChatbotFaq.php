<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotFaq extends Model
{
    protected $fillable = [
        'product_id',
        'question',
        'keywords',
        'answer',
        'button_text',
        'button_url',
        'show_as_suggestion',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'show_as_suggestion' => 'boolean',
        'status' => 'boolean',
    ];

    /**
     * Set on answers generated for a single product; the reply then shows that product's card.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true)->orderBy('sort_order');
    }

    /**
     * Keyword phrases as a clean array, e.g. "price, cost , how much" => ['price', 'cost', 'how much'].
     */
    public function keywordList(): array
    {
        return collect(explode(',', (string) $this->keywords))
            ->map(fn ($keyword) => trim(mb_strtolower($keyword)))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
