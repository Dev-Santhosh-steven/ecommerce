<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * Homepage counters shown until real figures are entered in Admin → Settings.
     */
    public const DEFAULT_STATS = [
        ['value' => 25000, 'suffix' => '+', 'label' => 'Customers Visited', 'icon' => 'users'],
        ['value' => 12500, 'suffix' => '+', 'label' => 'A+ Customer Ratings', 'icon' => 'star'],
        ['value' => 40000, 'suffix' => '+', 'label' => 'Products Delivered', 'icon' => 'package-check'],
        ['value' => 150, 'suffix' => '+', 'label' => 'Cities Served', 'icon' => 'map-pin'],
    ];

    protected $fillable = [
        'logo',
        'stats',
    ];

    protected $casts = [
        'stats' => 'array',
    ];

    /**
     * The single settings row, created on first access.
     */
    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }

    /**
     * Counters for the homepage, falling back to the defaults.
     */
    public function homeStats(): array
    {
        return collect($this->stats ?: self::DEFAULT_STATS)
            ->map(fn ($stat, $i) => [
                ...$stat,
                'icon' => self::DEFAULT_STATS[$i]['icon'] ?? 'sparkles',
            ])
            ->filter(fn ($stat) => filled($stat['label'] ?? null) && (int) ($stat['value'] ?? 0) > 0)
            ->values()
            ->all();
    }
}
