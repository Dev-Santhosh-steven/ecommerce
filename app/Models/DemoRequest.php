<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DemoRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'organization',
        'category_id',
        'purpose',
        'preferred_date',
        'message',
        'is_read',
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'is_read' => 'boolean',
    ];

    public const PURPOSES = [
        'personal' => 'Personal Use',
        'business' => 'Business / Bulk Purchase',
        'dealer' => 'Dealer / Reseller Inquiry',
        'other' => 'Other',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}
