<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = ['user_id', 'guest_token', 'product_id', 'quantity', 'saved_for_later'];

    protected $casts = [
        'quantity' => 'integer',
        'saved_for_later' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function lineTotal(): float
    {
        return $this->product->unitPrice() * $this->quantity;
    }
}
