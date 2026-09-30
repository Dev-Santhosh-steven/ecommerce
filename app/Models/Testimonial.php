<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'designation',
        'company',
        'message',
        'photo',
        'rating',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'rating' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true)->orderBy('sort_order')->latest();
    }

    /**
     * Initials shown when no photo is uploaded, e.g. "Ravi Kumar" => "RK".
     */
    public function getInitialsAttribute(): string
    {
        return collect(preg_split('/\s+/', trim($this->name)))
            ->filter()
            ->take(2)
            ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
            ->implode('');
    }
}
