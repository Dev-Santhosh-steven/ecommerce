<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * Commercial Display Solutions → Rotatable Display: the Yara 27" rotatable display on a wheeled stand
 * (one size, one product), its explore-page artwork, category card and banner.
 *
 * Specs are the B2B catalogue's "Rotatable Display" panel. No model number is shown on the site.
 * Images are copied from database/seeders/assets/rotatable-display.
 * Idempotent: re-running updates the same records.
 *
 * php artisan db:seed --class=RotatableDisplaySeeder
 */
class RotatableDisplaySeeder extends Seeder
{
    private const ASSETS = __DIR__ . '/assets/rotatable-display';

    public function run(): void
    {
        // Images used directly by the /rotatable-display explore page.
        foreach (['rd-stand.png', 'rd-landscape.png', 'rd-angle.png', 'screen-city.jpg', 'screen-tigers.jpg', 'screen-horses.jpg'] as $file) {
            $this->publish($file, "products/rotatable-display/{$file}");
        }

        $parent = Category::where('slug', 'commercial-display-solutions')->first();

        if (! $parent) {
            $this->call(TStandeeSeeder::class);
            $parent = Category::where('slug', 'commercial-display-solutions')->firstOrFail();
        }

        $category = Category::updateOrCreate(
            ['slug' => 'rotatable-display'],
            [
                'parent_id' => $parent->id,
                'name' => 'Rotatable Display',
                'description' => '27" Full HD display on a wheeled stand that rotates between landscape and portrait, tilts 20° and runs on a 9600 mAh battery: move it wherever it is needed for presentations, promos, video calls and signage.',
                'image' => $this->publish('category-card.jpg', 'categories/rotatable-display.jpg'),
                'banner' => $this->publish('category-banner.jpg', 'categories/banners/rotatable-display-banner.jpg'),
                'status' => true,
                'sort_order' => 10,
            ],
        );

        $product = Product::updateOrCreate(
            ['sku' => 'YE-RD-27'],
            [
                'category_id' => $category->id,
                'name' => 'Yara 27" Rotatable Display',
                'slug' => 'yara-27-inch-rotatable-display',
                'model_number' => null,
                'brand' => 'Yara',
                'short_description' => '27" Full HD display on a wheeled stand: rotate it from landscape to portrait, tilt it 20° and roll it anywhere on its 9600 mAh battery.',
                'description' => 'The Yara 27" Rotatable Display is a Full HD screen on a slim stand that goes wherever you do. '
                    . 'Turn it 90° either way to switch between landscape and portrait, tilt it 20° forward or back, and roll it on its wheeled base from the meeting room to the showroom floor, reception or any office.'
                    . "\n\n"
                    . 'Inside there is a Google EDLA certified system with an octa-core processor and 6GB + 128GB, a 16MP camera for video calls, 2 × 5W bass stereo speakers and dual-band Wi-Fi. '
                    . 'A 9600 mAh battery means no cable to the wall, and it charges over Type-C. Certified FCC, CE, RoHS, CCC and SRRC.',
                'price' => 0, // Price on request
                'sale_price' => null,
                'stock_quantity' => 5,
                'specifications' => [
                    'Screen Size' => '27 inch',
                    'Aspect Ratio' => '16:9',
                    'Resolution' => '1920 × 1080p',
                    'Brightness' => '250–300 nits',
                    'Refresh Rate' => '60Hz',
                    'Operating System' => 'Google EDLA certified',
                    'Processor' => 'Octa-core',
                    'Configuration' => '6GB + 128GB',
                    'Inbuilt Camera' => '16MP',
                    'Speakers' => '2 × 4Ω 5W bass stereo horn',
                    'Networking' => '2.4G / 5G dual-band Wi-Fi',
                    'Stand Rotation' => '90° clockwise | 90° anticlockwise',
                    'Stand Tilt' => '20° front & back',
                    'Mobility' => 'Wheeled base',
                    'Rear Interface' => 'Type-C charging',
                    'Battery' => '9600mAh, 12V/2.5A',
                    'Certification' => 'FCC, CE, RoHS, CCC, SRRC',
                    'Screen (W × H)' => '625 × 363.5 mm',
                    'Screen Depth' => '16 mm',
                    'Overall Height' => '1162.8 mm',
                    'Base Diameter' => '400 mm',
                ],
                'status' => true,
                'featured' => true,
                'sort_order' => 0,
                'meta_title' => 'Yara 27" Rotatable Display | Portable Rotating Screen on Wheels with Battery',
                'meta_description' => 'Yara 27 inch rotatable display: rotates landscape to portrait, tilts 20°, rolls on a wheeled stand, 9600 mAh battery, Google EDLA, 16MP camera, 6GB+128GB. Price on request.',
            ],
        );

        $gallery = [
            'rd-front.jpg' => 'Yara 27" Rotatable Display',
            'rd-angle.jpg' => 'Yara 27" Rotatable Display, tilted side view',
            'category-card.jpg' => 'Yara Rotatable Display in landscape and portrait',
            'rd-front-side.jpg' => 'Yara Rotatable Display, front and side',
        ];
        $keep = [];
        foreach (array_keys($gallery) as $i => $file) {
            $path = $this->publish($file, "products/rotatable-display/{$file}");
            $keep[] = $path;
            $product->images()->updateOrCreate(['image' => $path], ['alt_text' => $gallery[$file], 'sort_order' => $i, 'is_primary' => $i === 0]);
        }
        $product->images()->whereNotIn('image', $keep)->delete();

        $product->features()->delete();
        $product->features()->createMany(collect([
            ['rotate-cw', 'Rotates 90° both ways', 'Switch between landscape and portrait in a turn of the screen.'],
            ['move', 'Rolls on wheels', 'A wheeled base glides from space to space with no lifting.'],
            ['battery-charging', '9600 mAh battery', 'No cable to the wall; charge it over Type-C.'],
            ['move-vertical', 'Tilts 20° front & back', 'Angle the screen for a standing crowd, a seated meeting or a desk.'],
            ['shield-check', 'Google EDLA certified', 'Octa-core processor with 6GB + 128GB for apps and streaming.'],
            ['camera', '16MP camera', 'Video calls, classes and meetings, built right in.'],
            ['volume-2', '2 × 5W stereo speakers', 'Bass stereo horn speakers for movies and music.'],
            ['wifi', 'Dual-band Wi-Fi', '2.4G and 5G for smooth streaming anywhere in the house.'],
        ])->map(fn ($f, $i) => ['icon' => $f[0], 'title' => $f[1], 'description' => $f[2], 'sort_order' => $i])->all());
    }

    private function publish(string $asset, string $target): string
    {
        Storage::disk('public')->put($target, file_get_contents(self::ASSETS . '/' . $asset));

        return $target;
    }
}
