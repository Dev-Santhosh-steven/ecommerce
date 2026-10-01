<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * Commercial Display Solutions → Industrial Displays: the Yara 8" Industrial Display (one size, one product),
 * a frameless metal-body Android touch panel with industrial I/O, plus its explore-page artwork and category art.
 *
 * Not to be confused with Glass Displays (the red scanner display), which used to be called "Industrial Displays".
 * Specs come from Yara's new-product specification sheet; the main board details and the model number are
 * deliberately left off the site.
 *
 * Images are copied from database/seeders/assets/industrial-displays.
 * Idempotent: re-running updates the same records.
 *
 * php artisan db:seed --class=IndustrialDisplaySeeder
 */
class IndustrialDisplaySeeder extends Seeder
{
    private const ASSETS = __DIR__ . '/assets/industrial-displays';

    public function run(): void
    {
        // Images used directly by the /industrial-displays explore page.
        foreach (['ind-front.png', 'ind-rear.png'] as $file) {
            $this->publish($file, "products/industrial-displays/{$file}");
        }

        $parent = Category::where('slug', 'commercial-display-solutions')->first();

        if (! $parent) {
            $this->call(TStandeeSeeder::class);
            $parent = Category::where('slug', 'commercial-display-solutions')->firstOrFail();
        }

        $category = Category::updateOrCreate(
            ['slug' => 'industrial-displays'],
            [
                'parent_id' => $parent->id,
                'name' => 'Industrial Displays',
                'description' => '8" frameless metal-body Android touch display with industrial I/O (USB, HDMI, LAN and Phoenix terminal connectors) for machines, factory floors, control points and automation.',
                'image' => $this->publish('category-card.jpg', 'categories/industrial-displays.jpg'),
                'banner' => $this->publish('category-banner.jpg', 'categories/banners/industrial-displays-banner.jpg'),
                'status' => true,
                'sort_order' => 9,
            ],
        );

        $product = Product::updateOrCreate(
            ['sku' => 'YE-IND-08'],
            [
                'category_id' => $category->id,
                'name' => 'Yara 8" Industrial Display',
                'slug' => 'yara-8-inch-industrial-display',
                'model_number' => null,
                'brand' => 'Yara',
                'short_description' => '8" frameless metal-body touch display with USB, HDMI, LAN and Phoenix terminal connectors for machines, factories and control points.',
                'description' => 'The Yara 8" Industrial Display is a compact Android 11 touch panel built into a frameless metal body. '
                    . 'Mount it on a wall, a machine or a control cabinet and use it to run an app, show live status or take operator input right where the work happens.'
                    . "\n\n"
                    . 'Industrial I/O is built in: four USB ports, HDMI out, a LAN (RJ45) port, an earphone output and four green Phoenix terminal connectors for wiring into your equipment. '
                    . 'It runs on 12V DC power and comes with its adapter and a wall mount, so it is ready to install out of the box.',
                'price' => 0, // Price on request
                'sale_price' => null,
                'stock_quantity' => 5,
                'specifications' => [
                    'Screen Size' => '8 inch',
                    'Bezel Type' => 'Frameless metal body',
                    'Touch' => 'Yes',
                    'Operating System' => 'Android 11',
                    'RAM' => '2 GB',
                    'Storage' => '16 GB',
                    'USB' => '4',
                    'HDMI' => '1',
                    'LAN (RJ45)' => '1',
                    'Earphone Out' => '1',
                    'Phoenix Connectors' => '4 (green)',
                    'Power' => 'DC 12V, 2A',
                    'In the Box' => 'Unit, adapter (12V), wall mount',
                    'Product Dimensions (L × W × H)' => '186 × 40 × 120 mm',
                    'Box Dimensions' => '294 × 222 × 143 mm',
                    'Net / Gross Weight' => '0.7 kg / 1.1 kg',
                ],
                'status' => true,
                'featured' => true,
                'sort_order' => 0,
                'meta_title' => 'Yara 8" Industrial Display | Android Touch Panel with Industrial I/O',
                'meta_description' => 'Yara 8 inch industrial display: frameless metal-body Android 11 touch panel with 4 USB, HDMI, LAN and Phoenix connectors, 12V DC, wall mount included. Price on request.',
            ],
        );

        $gallery = [
            'ind-front.jpg' => 'Yara 8" Industrial Display',
            'ind-rear.jpg' => 'Yara 8" Industrial Display, I/O ports',
            'category-card.jpg' => 'Yara Industrial Display',
        ];
        $keep = [];
        foreach (array_keys($gallery) as $i => $file) {
            $path = $this->publish($file, "products/industrial-displays/{$file}");
            $keep[] = $path;
            $product->images()->updateOrCreate(['image' => $path], ['alt_text' => $gallery[$file], 'sort_order' => $i, 'is_primary' => $i === 0]);
        }
        $product->images()->whereNotIn('image', $keep)->delete();

        $product->features()->delete();
        $product->features()->createMany(collect([
            ['shield', 'Frameless metal body', 'A tough, flush metal housing made for machines and shop floors.'],
            ['pointer', '8" touch screen', 'Operators tap and swipe right on the display, no keyboard needed.'],
            ['smartphone', 'Android 11', 'Run your own app, a dashboard or a web page on a familiar platform.'],
            ['usb', '4 × USB ports', 'Connect scanners, printers, keyboards and other devices.'],
            ['plug-zap', 'Phoenix terminal connectors', 'Four green screw terminals for wiring straight into your equipment.'],
            ['network', 'LAN and HDMI', 'Wired network for reliability, plus HDMI out to a bigger screen.'],
            ['zap', '12V DC power', 'Runs on a 12V, 2A supply; the adapter is in the box.'],
            ['panel-top', 'Wall mount included', 'Mounts on a wall, a machine or a cabinet door.'],
        ])->map(fn ($f, $i) => ['icon' => $f[0], 'title' => $f[1], 'description' => $f[2], 'sort_order' => $i])->all());
    }

    private function publish(string $asset, string $target): string
    {
        Storage::disk('public')->put($target, file_get_contents(self::ASSETS . '/' . $asset));

        return $target;
    }
}
