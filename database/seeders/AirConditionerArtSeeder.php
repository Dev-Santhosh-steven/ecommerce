<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * Air conditioner artwork: the Air Conditioners category (card + banner) and a home hero slide,
 * built from the Yara split and inverter AC product photos on the brand backdrop.
 *
 * Idempotent: matched by category slug / hero button link.
 * Images are copied from database/seeders/assets/air-conditioners to the public disk.
 *
 *   php artisan db:seed --class=AirConditionerArtSeeder
 */
class AirConditionerArtSeeder extends Seeder
{
    private const ASSETS = __DIR__ . '/assets/air-conditioners';

    public function run(): void
    {
        $category = Category::firstOrNew(['slug' => 'air-conditioners']);

        $category->fill([
            'name' => $category->name ?: 'Air Conditioners',
            'description' => $category->description ?: 'Yara split and inverter air conditioners — fast, quiet cooling for homes and offices.',
            'image' => $this->publish('category-card.jpg', 'categories/air-conditioners.jpg'),
            'banner' => $this->publish('category-banner.jpg', 'categories/banners/air-conditioners-banner.jpg'),
        ]);

        if (!$category->exists) {
            $category->parent_id = null;
            $category->status = true;
            $category->sort_order = 1;
        }

        $category->save();

        $banner = Banner::firstOrNew(['button_link' => '/category/air-conditioners']);

        $banner->fill([
            'title' => $banner->title ?: 'Air Conditioners',
            'subtitle' => 'Split & Inverter ACs',
            'image' => $this->publish('home-banner.jpg', 'banners/air-conditioners-hero.jpg'),
            'button_text' => 'Shop Air Conditioners',
            'status' => true,
        ]);

        if (!$banner->exists) {
            $banner->sort_order = 3;
        }

        $banner->save();
    }

    /**
     * Copy an asset to the public disk and return its stored path.
     */
    private function publish(string $asset, string $target): string
    {
        Storage::disk('public')->put($target, file_get_contents(self::ASSETS . '/' . $asset));

        return $target;
    }
}
