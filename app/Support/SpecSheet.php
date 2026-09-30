<?php

namespace App\Support;

use Illuminate\Support\Str;

/**
 * Filters a product's specifications for display and picks a handful of headline figures for the product page.
 */
class SpecSheet
{
    /** Keys never shown to shoppers. */
    private const HIDDEN = ['model number', 'model'];

    /** Spec labels worth a headline tile, in order of preference. */
    private const HEADLINE = [
        'Screen Size', 'Wash Capacity', 'Capacity', 'Pixel Pitch', 'Resolution', 'Energy Rating', 'Type', 'Display Technology',
        'ISEER', 'Brightness', 'Spin Speed', 'Refresh Rate', 'Audio Output', 'Air Circulation', 'Bezel-to-Bezel', 'Operating System', 'Motor', 'RAM',
    ];

    public static function visible(?array $specs): array
    {
        return collect($specs ?? [])
            ->reject(fn ($value, $key) => in_array(Str::lower(trim($key)), self::HIDDEN, true) || blank($value))
            ->all();
    }

    /**
     * Up to four [label, value] headline figures, values trimmed for a big tile.
     */
    public static function headlines(?array $specs, int $limit = 4): array
    {
        $visible = self::visible($specs);

        return collect(self::HEADLINE)
            ->filter(fn ($key) => isset($visible[$key]))
            ->map(fn ($key) => [$key, trim(preg_replace('/\s*\(.*$/', '', (string) $visible[$key]))])
            ->take($limit)
            ->values()
            ->all();
    }
}
