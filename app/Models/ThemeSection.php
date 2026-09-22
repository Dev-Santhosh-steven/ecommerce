<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThemeSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'page',
        'name',
        'type',
        'position',
        'status',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
        'status' => 'boolean',
    ];

    /**
     * Scope active sections for a specific page.
     */
    public function scopeActiveForPage($query, string $page = 'homepage')
    {
        return $query
            ->where('page', $page)
            ->where('status', true)
            ->orderBy('position');
    }
}