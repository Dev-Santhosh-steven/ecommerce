<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * Commercial Display Solutions → Digital Podium: the Yara 27" all-in-one touchscreen digital podium
 * (one product), its explore-page artwork and category art.
 *
 * Images are copied from database/seeders/assets/digital-podium.
 * Idempotent: re-running updates the same records.
 *
 * php artisan db:seed --class=DigitalPodiumSeeder
 */
class DigitalPodiumSeeder extends Seeder
{
    private const ASSETS = __DIR__ . '/assets/digital-podium';

    public function run(): void
    {
        // Images used directly by the /digital-podium explore page.
        foreach (['podium-auditorium.jpg', 'venue-launch.jpg', 'venue-conference.jpg'] as $file) {
            $this->publish($file, "products/digital-podium/{$file}");
        }

        $parent = Category::where('slug', 'commercial-display-solutions')->first();

        if (! $parent) {
            $this->call(TStandeeSeeder::class);
            $parent = Category::where('slug', 'commercial-display-solutions')->firstOrFail();
        }

        $category = Category::updateOrCreate(
            ['slug' => 'digital-podium'],
            [
                'parent_id' => $parent->id,
                'name' => 'Digital Podium',
                'description' => 'All-in-one 27" touchscreen digital podium with dual wireless gooseneck microphones, height adjustment and seamless connectivity for auditoriums, classrooms, boardrooms and events.',
                'image' => $this->publish('category-card.jpg', 'categories/digital-podium.jpg'),
                'banner' => $this->publish('category-banner.jpg', 'categories/banners/digital-podium-banner.jpg'),
                'status' => true,
                'sort_order' => 7,
            ],
        );

        $product = Product::updateOrCreate(
            ['sku' => 'YE-POD-27'],
            [
                'category_id' => $category->id,
                'name' => 'Yara 27" Touchscreen Digital Podium',
                'slug' => 'yara-27-inch-touchscreen-digital-podium',
                'model_number' => 'YE-POD-27',
                'brand' => 'Yara',
                'short_description' => 'All-in-one 27" touchscreen digital podium with dual wireless gooseneck mics, height adjustment and seamless connectivity.',
                'description' => 'This electric podium features a touch-enabled AIO screen with a 16:9 LED backlight display and Intel i5 processor, 8GB RAM, and 256GB SSD, all powered by Windows 10 OS. '
                    . 'The podium includes dual gooseneck mics, a wireless voice system, height adjustment, and 360° ball-bearing casters for mobility. '
                    . "Stainless steel and aluminum construction, along with side trays for laptops and PCs, make it ideal for professional and educational settings.\n\n"
                    . 'The all-in-one 27" touch screen also comes in an Android 9 configuration with 4GB RAM and 32GB ROM, with USB, HDMI and VGA connectivity, '
                    . 'toughened glass, a stylus in the box and an optional battery for cable-free use.',
                'price' => 0, // Price on request
                'sale_price' => null,
                'stock_quantity' => 5,
                'specifications' => [
                    'Screen' => '27" all-in-one touch screen',
                    'Display' => '16:9 LED backlight',
                    'Android Configuration' => 'Android 9 · 4GB RAM · 32GB ROM',
                    'Windows Configuration' => 'Windows 10 · Intel i5 · 8GB RAM · 256GB SSD',
                    'Connectivity' => 'USB · HDMI · VGA',
                    'Microphones' => 'Wireless gooseneck mic × 2, wireless voice system',
                    'Glass' => 'Toughened glass',
                    'Height' => 'Electric height adjustment',
                    'Mobility' => '360° ball-bearing casters',
                    'Construction' => 'Stainless steel and aluminium',
                    'Side Trays' => 'For laptops and PCs',
                    'Battery' => 'Optional',
                    'In the Box' => 'Stylus included',
                    'Technical Data' => 'Dimensions, weight & power on request',
                ],
                'status' => true,
                'featured' => true,
                'sort_order' => 0,
                'meta_title' => 'Yara 27" Touchscreen Digital Podium | Smart Presentation Podium with Dual Mics',
                'meta_description' => 'Yara 27 inch all-in-one touchscreen digital podium: dual wireless gooseneck mics, electric height adjustment, toughened glass, USB/HDMI/VGA, Android or Windows.',
            ],
        );

        $gallery = [
            'podium-square.jpg' => 'Yara 27" Touchscreen Digital Podium',
            'podium-poster.jpg' => 'Yara Digital Podium: smart presentations made simple',
            'podium-auditorium.jpg' => 'Yara Digital Podium on stage in an auditorium',
        ];
        $keep = [];
        foreach (array_keys($gallery) as $i => $file) {
            $path = $this->publish($file, "products/digital-podium/{$file}");
            $keep[] = $path;
            $product->images()->updateOrCreate(['image' => $path], ['alt_text' => $gallery[$file], 'sort_order' => $i, 'is_primary' => $i === 0]);
        }
        $product->images()->whereNotIn('image', $keep)->delete();

        $product->features()->delete();
        $product->features()->createMany(collect([
            ['monitor-smartphone', '27" all-in-one touch screen', '16:9 LED-backlit display you control with a finger or the stylus.'],
            ['mic', 'Dual wireless gooseneck mics', 'Two microphones and a wireless voice system for clear speech.'],
            ['move-vertical', 'Electric height adjustment', 'Raise or lower the podium to suit every presenter.'],
            ['cpu', 'Android or Windows', 'Android 9 (4GB/32GB) or Windows 10 with Intel i5, 8GB and 256GB SSD.'],
            ['cable', 'Seamless connectivity', 'USB, HDMI and VGA for laptops, cameras and projectors.'],
            ['shield-check', 'Toughened glass', 'A tough, smooth touch surface built for daily use.'],
            ['rotate-3d', '360° ball-bearing casters', 'Roll it from the stage to the classroom with ease.'],
            ['battery-charging', 'Optional battery', 'Present without a cable to the wall.'],
        ])->map(fn ($f, $i) => ['icon' => $f[0], 'title' => $f[1], 'description' => $f[2], 'sort_order' => $i])->all());
    }

    private function publish(string $asset, string $target): string
    {
        Storage::disk('public')->put($target, file_get_contents(self::ASSETS . '/' . $asset));

        return $target;
    }
}
