<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Commercial Display Solutions → Commercial Displays: category and the 32" – 86" Yara
 * commercial (digital signage) display range, with 3D renders in landscape, portrait and angled views.
 *
 * Images are copied from database/seeders/assets/commercial-displays.
 * Idempotent: re-running updates the same records.
 *
 *   php artisan db:seed --class=CommercialDisplaySeeder
 */
class CommercialDisplaySeeder extends Seeder
{
    private const ASSETS = __DIR__ . '/assets/commercial-displays';

    public function run(): void
    {
        DB::transaction(function () {
            // Everything the /commercial-displays explore page and galleries use.
            foreach (glob(self::ASSETS . '/*.{png,jpg}', GLOB_BRACE) as $file) {
                $this->publish(basename($file), 'products/commercial-displays/' . basename($file));
            }

            $parent = Category::where('slug', 'commercial-display-solutions')->first();

            if (! $parent) {
                $this->call(TStandeeSeeder::class);
                $parent = Category::where('slug', 'commercial-display-solutions')->firstOrFail();
            }

            $category = Category::updateOrCreate(
                ['slug' => 'commercial-displays'],
                [
                    'parent_id' => $parent->id,
                    'name' => 'Commercial Displays',
                    'description' => 'Slim 24/7 digital signage displays in 32", 43", 55", 65", 75" and 86": landscape or portrait, '
                        . 'for retail promotions, menu boards, corporate lobbies and transit.',
                    'image' => $this->publish('category-card.jpg', 'categories/commercial-displays.jpg'),
                    'banner' => $this->publish('category-banner.jpg', 'categories/banners/commercial-displays-banner.jpg'),
                    'status' => true,
                    'sort_order' => 0,
                ],
            );

            foreach ($this->models() as $index => $model) {
                $this->seedProduct($category, $model, $index);
            }
        });
    }

    private function seedProduct(Category $category, array $m, int $index): void
    {
        $inch = $m['inch'];

        $product = Product::updateOrCreate(
            ['sku' => "YE-CD-{$inch}"],
            [
                'category_id' => $category->id,
                'name' => "Yara {$inch}\" Commercial Display",
                'slug' => "yara-{$inch}-inch-commercial-display",
                'model_number' => "YE-CD{$inch}-S24",
                'brand' => 'Yara',
                'short_description' => "{$inch}\" slim 24/7 digital signage display for {$m['ideal']}. Landscape or portrait.",
                'description' => "The Yara {$inch}\" Commercial Display is built to run all day, every day. "
                    . "Its {$m['resolution_name']} panel with {$m['brightness']} nits of brightness keeps offers, menus and announcements crisp and vivid, ideal for {$m['ideal']}.\n\n"
                    . 'A built-in Android media player schedules and loops your content from a USB drive or the network, with no PC needed. '
                    . 'Mount it in landscape or portrait on any standard VESA bracket, and the slim, uniform bezel keeps the focus on your message.\n\n'
                    . 'Choose it for retail promotions, restaurant menu boards, corporate lobbies, hotels, clinics and transit spaces.',
                'price' => 0, // Price on request
                'sale_price' => null,
                'stock_quantity' => 10,
                'warranty_months' => 36,
                'specifications' => [
                    'Screen Size' => "{$inch} inch",
                    'Resolution' => $m['resolution'],
                    'Brightness' => "{$m['brightness']} cd/m²",
                    'Aspect Ratio' => '16:9',
                    'Viewing Angle' => '178° (H) / 178° (V)',
                    'Operation' => '24/7 rated',
                    'Orientation' => 'Landscape & portrait',
                    'Surface' => 'Anti-glare, haze 25%',
                    'Media Player' => "Built-in Android 11, {$m['memory']}",
                    'Content' => 'Images, videos, playlists & scheduling (USB / LAN / Wi-Fi)',
                    'Inputs' => 'HDMI × 2, USB 2.0 × 2, LAN, RS232, Audio out',
                    'Speakers' => $m['audio'],
                    'VESA Mount' => $m['vesa'] . ' mm',
                    'Bezel' => 'Slim uniform black bezel',
                    'Technical Data' => 'Dimensions, weight & power on request',
                ],
                'status' => true,
                'featured' => in_array($inch, [43, 55], true),
                'sort_order' => $index,
                'meta_title' => "Yara {$inch} inch Commercial Display | 24/7 Digital Signage",
                'meta_description' => "Yara {$inch}\" commercial display: {$m['resolution_name']}, {$m['brightness']} nits, 24/7 operation, landscape or portrait, built-in media player.",
            ],
        );

        $name = "Yara {$inch}\" Commercial Display";
        $gallery = [
            "cd-front-{$m['content']}.png" => "{$name} — front view",
            "cd-angle-right-{$m['content']}.png" => "{$name} — angled view",
            "cd-angle-left-{$m['alt']}.png" => "{$name} — side angle",
            "cd-portrait-{$m['portrait']}.png" => "{$name} in portrait orientation",
            $m['scene'] => "{$name} in use",
        ];

        $keep = [];
        foreach (array_keys($gallery) as $order => $file) {
            $path = "products/commercial-displays/{$file}";
            $keep[] = $path;
            $product->images()->updateOrCreate(
                ['image' => $path],
                ['alt_text' => $gallery[$file], 'sort_order' => $order, 'is_primary' => $order === 0],
            );
        }
        $product->images()->whereNotIn('image', $keep)->delete();

        $product->features()->delete();
        $product->features()->createMany(collect([
            ['icon' => 'clock', 'title' => 'Built for 24/7', 'description' => 'Commercial-grade panel rated to run all day, every day.'],
            ['icon' => 'sun', 'title' => 'Bright & Anti-Glare', 'description' => 'Up to 500 nits with an anti-glare surface for bright stores and lobbies.'],
            ['icon' => 'rotate-cw', 'title' => 'Landscape or Portrait', 'description' => 'Mount it either way for posters, menus or wide promotions.'],
            ['icon' => 'circle-play', 'title' => 'Built-in Media Player', 'description' => 'Schedule and loop content from USB or the network, no PC needed.'],
            ['icon' => 'scan', 'title' => 'Slim Uniform Bezel', 'description' => 'A clean, modern frame that keeps the focus on your content.'],
            ['icon' => 'wrench', 'title' => 'Easy Installation', 'description' => 'Standard VESA mounting, with installation support from Yara.'],
        ])->map(fn ($f, $i) => $f + ['sort_order' => $i])->all());

        if ($sizeAttribute = Attribute::where('slug', 'size')->first()) {
            $value = AttributeValue::firstOrCreate(['attribute_id' => $sizeAttribute->id, 'value' => "{$inch}\""], ['sort_order' => $inch]);
            $product->attributeValues()->syncWithoutDetaching([$value->id]);
        }
    }

    private function publish(string $asset, string $target): string
    {
        Storage::disk('public')->put($target, file_get_contents(self::ASSETS . '/' . $asset));

        return $target;
    }

    /**
     * content / alt = landscape screen content, portrait = portrait render, scene = in-use photo.
     */
    private function models(): array
    {
        return [
            ['inch' => 32, 'ideal' => 'counters, cafés and menu boards', 'content' => 'menu', 'alt' => 'sale', 'portrait' => 'sale', 'scene' => 'scene-retail.jpg',
                'resolution' => '1920 × 1080 (Full HD)', 'resolution_name' => 'Full HD', 'brightness' => 350, 'memory' => '2 GB / 16 GB', 'audio' => '2 × 8 W', 'vesa' => '200 × 200'],
            ['inch' => 43, 'ideal' => 'retail promotions and shop windows', 'content' => 'sale', 'alt' => 'menu', 'portrait' => 'honey', 'scene' => 'scene-retail.jpg',
                'resolution' => '3840 × 2160 (4K UHD)', 'resolution_name' => '4K UHD', 'brightness' => 400, 'memory' => '2 GB / 16 GB', 'audio' => '2 × 10 W', 'vesa' => '300 × 300'],
            ['inch' => 55, 'ideal' => 'showrooms, brand stores and malls', 'content' => 'aurora', 'alt' => 'vivera', 'portrait' => 'vivera', 'scene' => 'scene-transit.jpg',
                'resolution' => '3840 × 2160 (4K UHD)', 'resolution_name' => '4K UHD', 'brightness' => 450, 'memory' => '4 GB / 32 GB', 'audio' => '2 × 10 W', 'vesa' => '400 × 400'],
            ['inch' => 65, 'ideal' => 'lobbies, hotels and transit spaces', 'content' => 'vivera', 'alt' => 'aurora', 'portrait' => 'aurora', 'scene' => 'scene-transit.jpg',
                'resolution' => '3840 × 2160 (4K UHD)', 'resolution_name' => '4K UHD', 'brightness' => 500, 'memory' => '4 GB / 32 GB', 'audio' => '2 × 12 W', 'vesa' => '400 × 400'],
            ['inch' => 75, 'ideal' => 'corporate receptions and large stores', 'content' => 'lobby', 'alt' => 'opening', 'portrait' => 'sale', 'scene' => 'scene-retail.jpg',
                'resolution' => '3840 × 2160 (4K UHD)', 'resolution_name' => '4K UHD', 'brightness' => 500, 'memory' => '4 GB / 32 GB', 'audio' => '2 × 12 W', 'vesa' => '600 × 400'],
            ['inch' => 86, 'ideal' => 'atriums, auditoriums and flagship stores', 'content' => 'opening', 'alt' => 'lobby', 'portrait' => 'vivera', 'scene' => 'scene-transit.jpg',
                'resolution' => '3840 × 2160 (4K UHD)', 'resolution_name' => '4K UHD', 'brightness' => 500, 'memory' => '4 GB / 32 GB', 'audio' => '2 × 15 W', 'vesa' => '800 × 600'],
        ];
    }
}
