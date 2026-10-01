<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * Commercial Display Solutions → Double Side Vertical Display: the Yara 43" double side vertical display
 * (one size, one product), its explore-page artwork, category card and banner.
 *
 * Specifications are the Commercial Displays Specification Sheet's, read from
 * database/seeders/data/spec-sheets.json (SpecSheetSeeder links the SKU to that sheet).
 * The model number is deliberately left blank so it never shows on the site.
 *
 * Images are copied from database/seeders/assets/double-side-vertical-display.
 * Idempotent: re-running updates the same records.
 *
 * php artisan db:seed --class=DoubleSideVerticalDisplaySeeder
 */
class DoubleSideVerticalDisplaySeeder extends Seeder
{
    private const ASSETS = __DIR__ . '/assets/double-side-vertical-display';

    private const SHEET = '43DD23H';

    public function run(): void
    {
        // Images used directly by the /double-side-vertical-display explore page.
        foreach ([
            'dsvd-front.png', 'dsvd-angle.png', 'screen-beach.jpg',
            'scene-check-in.jpg', 'scene-lounge.jpg', 'scene-waiting-hall.jpg', 'scene-experience.jpg',
        ] as $file) {
            $this->publish($file, "products/double-side-vertical-display/{$file}");
        }

        $parent = Category::where('slug', 'commercial-display-solutions')->first();

        if (! $parent) {
            $this->call(TStandeeSeeder::class);
            $parent = Category::where('slug', 'commercial-display-solutions')->firstOrFail();
        }

        $category = Category::updateOrCreate(
            ['slug' => 'double-side-vertical-display'],
            [
                'parent_id' => $parent->id,
                'name' => 'Double Side Vertical Display',
                'description' => '43" double side vertical display with a screen on each face: sunlight-readable, built for 24/7 operation and easy to hang in a shop window or from the ceiling. Ideal for retail, showrooms, banks and transit.',
                'image' => $this->publish('category-card.jpg', 'categories/double-side-vertical-display.jpg'),
                'banner' => $this->publish('category-banner.jpg', 'categories/banners/double-side-vertical-display-banner.jpg'),
                'status' => true,
                'sort_order' => 8,
            ],
        );

        $sheets = json_decode(file_get_contents(__DIR__ . '/data/spec-sheets.json'), true);

        $product = Product::updateOrCreate(
            ['sku' => 'YE-HD-43'],
            [
                'category_id' => $category->id,
                'name' => 'Yara 43" Double Side Vertical Display',
                'slug' => 'yara-43-inch-double-side-vertical-display',
                'model_number' => null,
                'brand' => 'Yara',
                'short_description' => '43" double side vertical display: two Full HD screens back to back, sunlight-readable and built for 24/7 operation in shop windows and showrooms.',
                'description' => 'The Yara 43" Double Side Vertical Display puts a Full HD screen on each face, so your message reaches people on both sides: shoppers in the store and passers-by outside the window. '
                    . 'Its ultra-bright, sunlight-readable panel keeps colours vivid and contrast high in a street-facing window, with wide viewing angles for everyone walking past.'
                    . "\n\n"
                    . 'Running Android with a quad-core processor, Wi-Fi, Bluetooth and LAN, it is ready for remote content management. Play pictures and text together, split the screen freely, '
                    . 'switch on and off on a schedule and cut in live content when you need to. The slim white design hangs from the ceiling with the rods, hooks and adjustment knobs in the box, '
                    . 'or mounts on a wall, and it is built for reliable 24/7 operation in retail, showrooms, banks, airports and stations.',
                'price' => 0, // Price on request
                'sale_price' => null,
                'stock_quantity' => 5,
                'specifications' => $sheets[self::SHEET]['specs'],
                'status' => true,
                'featured' => true,
                'sort_order' => 0,
                'meta_title' => 'Yara 43" Double Side Vertical Display | Window & Ceiling Hanging Digital Signage',
                'meta_description' => 'Yara 43 inch double side vertical display: two Full HD screens, sunlight-readable, 24/7 operation, Android with Wi-Fi, for shop windows, showrooms, banks and airports. Price on request.',
            ],
        );

        $gallery = [
            'dsvd-front.jpg' => 'Yara 43" Double Side Vertical Display',
            'dsvd-angle.jpg' => 'Yara 43" Double Side Vertical Display, side view',
            'category-card.jpg' => 'Yara Double Side Vertical Display, front and side',
        ];
        $keep = [];
        foreach (array_keys($gallery) as $i => $file) {
            $path = $this->publish($file, "products/double-side-vertical-display/{$file}");
            $keep[] = $path;
            $product->images()->updateOrCreate(['image' => $path], ['alt_text' => $gallery[$file], 'sort_order' => $i, 'is_primary' => $i === 0]);
        }
        $product->images()->whereNotIn('image', $keep)->delete();

        $product->features()->delete();
        $product->features()->createMany(collect([
            ['sun', 'Ultra-bright, sunlight-readable', 'Stays clear and readable in a street-facing shop window.'],
            ['flip-horizontal-2', 'Two screens, back to back', 'A Full HD screen on each face reaches people on both sides.'],
            ['clock', 'Built for reliable 24/7 operation', 'Designed to run all day, every day, with stable performance and good heat dissipation.'],
            ['cloud-cog', 'Remote content management ready', 'Android with Wi-Fi, Bluetooth and LAN for updating playlists from anywhere.'],
            ['contrast', 'High contrast, vivid visuals', '1400:1 contrast, 1920 × 1080 resolution and 16.7M colours.'],
            ['eye', 'Wide viewing angle visibility', 'Clear from the pavement, the aisle or across the hall.'],
            ['gem', 'Sleek, slim design', 'A 27 mm white frame that suits premium stores and showrooms.'],
            ['panel-top', 'Easy window or wall mounting', 'Hanging rods, hooks and adjustment knobs are in the box.'],
        ])->map(fn ($f, $i) => ['icon' => $f[0], 'title' => $f[1], 'description' => $f[2], 'sort_order' => $i])->all());
    }

    private function publish(string $asset, string $target): string
    {
        Storage::disk('public')->put($target, file_get_contents(self::ASSETS . '/' . $asset));

        return $target;
    }
}
