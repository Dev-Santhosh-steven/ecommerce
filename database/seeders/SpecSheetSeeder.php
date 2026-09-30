<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

/**
 * Product specifications exactly as Yara's specification sheets list them, and nothing else:
 *
 *  - Specification Sheet (TVs, ACs, washing machines, home theatre), one page per model
 *  - Air Conditioners Catalogue (the BS25E / PD25E models)
 *
 * Data: database/seeders/data/spec-sheets.json ({model: {sheet, page, specs}}), read from those PDFs.
 * Products are matched by model number; products with no sheet keep their specifications.
 *
 * Run after the product seeders (they reset specifications):
 *
 *   php artisan db:seed --class=SpecSheetSeeder
 */
class SpecSheetSeeder extends Seeder
{
    /** Products whose model number differs from the sheet's. */
    private const ALIASES = [
        'YE-HA-TT01' => 'T21SUPER-KING', // Twin Tower Multimedia Speaker
        'YE-HA-ST01' => 'T23-KING',      // Single Tower Speaker
    ];

    public function run(): void
    {
        $sheets = json_decode(file_get_contents(__DIR__ . '/data/spec-sheets.json'), true);
        $updated = 0;

        foreach (Product::all() as $product) {
            $model = self::ALIASES[$product->sku] ?? strtoupper(str_replace(' ', '', (string) $product->model_number));

            if (! isset($sheets[$model])) {
                continue;
            }

            $product->update(['specifications' => $sheets[$model]['specs']]);
            $updated++;
        }

        $this->command?->info("{$updated} products now show only their specification-sheet specs.");
    }
}
