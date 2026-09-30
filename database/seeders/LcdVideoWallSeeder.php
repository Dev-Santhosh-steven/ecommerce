<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * LCD Video Walls category: no fixed models. Walls are configured per project in any panel size from 32" to 100"
 * (bezel 3.5 mm to 0.88 mm), so this seeds the category, the explore-page artwork and the home hero banner,
 * and removes the earlier fixed panel products (YE-LCD-*).
 *
 * Images are copied from database/seeders/assets/lcd-video-walls (and the shared video-walls scenes).
 * Idempotent: re-running updates the same records.
 *
 *   php artisan db:seed --class=LcdVideoWallSeeder
 */
class LcdVideoWallSeeder extends Seeder
{
    private const ASSETS = __DIR__ . '/assets/lcd-video-walls';

    public function run(): void
    {
        DB::transaction(function () {
            foreach (glob(self::ASSETS . '/*.{png,jpg}', GLOB_BRACE) as $file) {
                $this->publish(basename($file), 'products/lcd-video-walls/' . basename($file));
            }
            foreach (glob(__DIR__ . '/assets/video-walls/*.{png,jpg}', GLOB_BRACE) as $file) {
                Storage::disk('public')->put('products/video-walls/' . basename($file), file_get_contents($file));
            }

            $category = Category::updateOrCreate(
                ['slug' => 'lcd-video-walls'],
                [
                    'parent_id' => null,
                    'name' => 'LCD Video Walls',
                    'description' => 'Yara LCD video walls, available from 32" to 100" panels with ultra-narrow bezels from 3.5 mm down to 0.88 mm: '
                        . 'Full HD per panel, 24/7 rated, for control rooms, retail, corporate lobbies and broadcast studios. Configured and quoted for your space.',
                    'image' => $this->publish('category-card.jpg', 'categories/lcd-video-walls.jpg'),
                    'banner' => $this->publish('category-banner.jpg', 'categories/banners/lcd-video-walls-banner.jpg'),
                    'status' => true,
                    'sort_order' => Category::where('slug', 'lcd-video-walls')->value('sort_order') ?? 4,
                ],
            );

            // No fixed models any more: remove the old panel products (with their images, features and filters).
            Product::where('sku', 'like', 'YE-LCD-%')->get()->each(function (Product $product) {
                $product->images()->delete();
                $product->features()->delete();
                $product->attributeValues()->detach();
                $product->delete();
            });

            $this->seedHomeBanner();
        });
    }

    private function seedHomeBanner(): void
    {
        $path = $this->publish('home-banner.jpg', 'banners/lcd-video-walls-hero.jpg');
        $led = Banner::where('button_link', '/led-video-walls')->value('sort_order') ?? 7;
        $slide = Banner::firstOrNew(['image' => $path]);

        if (! $slide->exists) {
            Banner::where('sort_order', '>', $led)->increment('sort_order');
        }

        $slide->fill([
            'title' => 'LCD Video Walls',
            'subtitle' => '32" to 100" panels · Bezels from 0.88 mm · Full HD per panel',
            'button_text' => 'Build Your Wall',
            'button_link' => '/lcd-video-walls',
            'sort_order' => $led + 1,
            'status' => true,
        ])->save();
    }

    private function publish(string $asset, string $target): string
    {
        Storage::disk('public')->put($target, file_get_contents(self::ASSETS . '/' . $asset));

        return $target;
    }
}
