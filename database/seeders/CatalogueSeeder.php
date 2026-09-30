<?php

namespace Database\Seeders;

use App\Models\Catalogue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * The downloadable catalogues on /catalogue, with a cover image (the PDF's first page) for each.
 * The larger PDFs were re-saved with images at 200 dpi, which looks the same on screen and in print
 * at a fraction of the size (the Dec 2025 brochure went from 67 MB to 23 MB).
 *
 * Idempotent: matched by title (the first upload, titled "b2b_catalouge", is renamed).
 * Files are copied from database/seeders/assets/catalogues to the public disk.
 *
 *   php artisan db:seed --class=CatalogueSeeder
 */
class CatalogueSeeder extends Seeder
{
    private const ASSETS = __DIR__ . '/assets/catalogues';

    public function run(): void
    {
        $catalogues = [
            ['B2B Display Solutions Catalogue 2026', 'b2b-catalogue-2026.pdf', 'b2b-catalogue-cover.jpg', ['b2b_catalouge']],
            ['Yara Brochure (December 2025)', 'yara-brochure-dec-2025.pdf', 'yara-brochure-dec-2025-cover.jpg', []],
            ['Interactive Flat Panel Catalogue 2025', 'interactive-flat-panel-catalogue-2025.pdf', 'interactive-flat-panel-catalogue-2025-cover.jpg', []],
            ['Air Conditioners Catalogue', 'ac-catalogue.pdf', 'ac-catalogue-cover.jpg', []],
            ['Specification Sheet: TVs, ACs, Washing Machines & Home Theatre', 'home-products-specification-sheet.pdf', 'home-products-specification-sheet-cover.jpg', []],
            ['Specification Sheet: Kiosks, Standees, Podiums & Interactive Panels', 'commercial-displays-specification-sheet.pdf', 'commercial-displays-specification-sheet-cover.jpg', []],
        ];

        foreach ($catalogues as $i => [$title, $file, $cover, $oldTitles]) {
            $catalogue = Catalogue::whereIn('title', [$title, ...$oldTitles])->first() ?? new Catalogue(['status' => true]);

            $catalogue->fill([
                'title' => $title,
                'file' => $this->publish($file, "catalogues/{$file}"),
                'cover' => $this->publish($cover, "catalogues/covers/{$cover}"),
                'sort_order' => $i + 1,
            ])->save();
        }
    }

    private function publish(string $asset, string $target): string
    {
        Storage::disk('public')->put($target, file_get_contents(self::ASSETS . '/' . $asset));

        return $target;
    }
}
