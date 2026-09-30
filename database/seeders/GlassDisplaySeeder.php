<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * Commercial Display Solutions → Glass Displays: explore-page artwork (display cut-out,
 * "where to use" posters and scenes), category card + banner, product gallery and the hero banner.
 *
 * The category and the YE-GD-01 product are created by CategoryArtSeeder (called here if missing).
 * Images are copied from database/seeders/assets/glass-displays.
 * Idempotent: re-running updates the same records.
 *
 * php artisan db:seed --class=GlassDisplaySeeder
 */
class GlassDisplaySeeder extends Seeder
{
    private const ASSETS = __DIR__ . '/assets/glass-displays';

    public function run(): void
    {
        // Renamed from "Industrial Displays": drop the old published files.
        $disk = Storage::disk('public');
        $disk->deleteDirectory('products/industrial-displays');
        $disk->delete(['categories/industrial-displays.jpg', 'categories/banners/industrial-displays-banner.jpg', 'banners/industrial-displays-hero.jpg']);
        Banner::where('image', 'banners/industrial-displays-hero.jpg')->update(['image' => 'banners/glass-displays-hero.jpg']);

        // Images used directly by the /glass-displays explore page.
        foreach ([
            'glass-display-cutout.png',
            'poster-office.jpg', 'poster-meeting.jpg', 'poster-lobby.jpg', 'poster-cafeteria.jpg', 'poster-canteen.jpg', 'poster-exhibition.jpg',
            'scene-office.jpg', 'scene-meeting.jpg', 'scene-lobby.jpg', 'scene-cafeteria.jpg', 'scene-canteen.jpg', 'scene-exhibition.jpg',
        ] as $file) {
            $this->publish($file, "products/glass-displays/{$file}");
        }

        $product = Product::where('sku', 'YE-GD-01')->first();

        if (! $product) {
            $this->call(CategoryArtSeeder::class);
            $product = Product::where('sku', 'YE-GD-01')->firstOrFail();
        }

        Category::where('slug', 'glass-displays')->update([
            'image' => $this->publish('category-card.jpg', 'categories/glass-displays.jpg'),
            'banner' => $this->publish('category-banner.jpg', 'categories/banners/glass-displays-banner.jpg'),
        ]);

        $gallery = [
            'glass-display-front.jpg' => 'Yara Glass Display',
            'glass-display-highlights.jpg' => 'Yara Glass Display – key features',
            'glass-display-installed.jpg' => 'Yara Glass Display, wall-mounted',
            'poster-canteen.jpg' => 'Yara Glass Display in a canteen',
            'poster-meeting.jpg' => 'Yara Glass Display outside a meeting room',
            'poster-office.jpg' => 'Yara Glass Display in a smart office',
            'poster-exhibition.jpg' => 'Yara Glass Display at an exhibition stand',
        ];

        $keep = [];
        foreach (array_keys($gallery) as $order => $file) {
            $path = $this->publish($file, "products/glass-displays/{$file}");
            $keep[] = $path;
            $product->images()->updateOrCreate(
                ['image' => $path],
                ['alt_text' => $gallery[$file], 'sort_order' => $order, 'is_primary' => $order === 0],
            );
        }
        $product->images()->whereNotIn('image', $keep)->delete();

        // Hero banner: slide after the printing kiosk.
        $bannerPath = $this->publish('glass-display-banner.jpg', 'banners/glass-displays-hero.jpg');
        $slide = Banner::firstOrNew(['image' => $bannerPath]);

        if (! $slide->exists) {
            Banner::where('sort_order', '>=', 5)->increment('sort_order');
        }

        $slide->fill([
            'title' => 'Yara Glass Displays',
            'subtitle' => 'Rugged · 24/7 · Custom glass',
            'button_text' => 'Explore Glass Displays',
            'button_link' => '/glass-displays',
            'sort_order' => 5,
            'status' => true,
        ])->save();
    }

    private function publish(string $asset, string $target): string
    {
        Storage::disk('public')->put($target, file_get_contents(self::ASSETS . '/' . $asset));

        return $target;
    }
}
