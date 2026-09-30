<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * Yara Centum 100": product, gallery, features, specs and the first hero banner.
 *
 * Images are copied from database/seeders/assets/centum (built from the green-screen TV photo).
 * Idempotent: re-running updates the same records.
 *
 * php artisan db:seed --class=CentumSeeder
 */
class CentumSeeder extends Seeder
{
    private const ASSETS = __DIR__ . '/assets/centum';

    public function run(): void
    {
        // Screen content, logo, the neon-scene layers, the neon TV and leopard TV used by the /centum showcase page.
        foreach ([
            'screen-neon.jpg', 'neon-on.jpg', 'neon-off.jpg', 'neon-tubes.png', 'screen-leopard-swirl.jpg', 'screen-leopard-royal.jpg', 'screen-horses.jpg', 'screen-house.jpg', 'screen-layers.jpg', 'screen-mountain.jpg',
            'screen-mandala.jpg', 'screen-earth.jpg', 'screen-coast.jpg', 'screen-stage.jpg',
            'centum-neon.png', 'centum-leopard-tv.png', 'yara-logo.png', 'yara-logo-light.png',
        ] as $file) {
            $this->publish($file, "products/centum/{$file}");
        }

        $category = Category::where('slug', 'smart-tv')->first()
            ?? Category::where('slug', 'televisions')->firstOrFail();

        $product = Product::updateOrCreate(
            ['sku' => 'YE-CENTUM-100'],
            [
                'category_id' => $category->id,
                'name' => 'Yara Centum 100 4K UHD Smart LED TV',
                'slug' => 'yara-centum-100-4k-uhd-smart-led-tv',
                'model_number' => 'YE-CENTUM-100',
                'brand' => 'Yara',
                'short_description' => '100" 4K UHD Smart LED TV with an A+ grade panel, Android 12, 30W sound and OTT apps onboard.',
                'description' => 'Experience stunning picture quality and lifelike colors with Yara Centum, the 100" 4K LED TV. '
                    . 'It offers a premium viewing experience, while built-in smart features make it easy to stream your favorite shows and movies. '
                    . "With multiple HDMI and USB ports, you can easily connect all your devices. Plus, its energy-efficient operation helps reduce your electricity bill.\n\n"
                    . 'Order now and upgrade your home entertainment system with Yara Centum.',
                'price' => 0, // Price on request (set the real price in Admin → Products).
                'sale_price' => null,
                'stock_quantity' => 5,
                'specifications' => [
                    'Model' => 'Yara Centum 100',
                    'Screen Size' => '100 inch',
                    'Resolution' => '4K UHD (3840 × 2160)',
                    'Aspect Ratio' => '16:9 Wide Screen',
                    'Panel' => 'A+ Grade Panel',
                    'Operating System' => 'Android 12',
                    'Processor' => 'Quad Core',
                    'RAM' => '2 GB',
                    'ROM (Storage)' => '16 GB',
                    'Speakers' => '15W × 2',
                    'Audio' => 'High Quality Audio',
                    'Smart Features' => 'OTT apps onboard',
                    'Wireless' => 'Bluetooth',
                    'HDMI' => 'HDMI ARC',
                    'USB' => 'Yes',
                    'Audio Out' => 'Earphone port, COAX out',
                ],
                'status' => true,
                'featured' => true,
                'sort_order' => 0,
                'meta_title' => 'Yara Centum 100" 4K UHD Smart LED TV | 100 inch TV',
                'meta_description' => 'Yara Centum: a 100 inch 4K UHD Smart LED TV with A+ grade panel, Android 12, quad core processor, 30W speakers, OTT apps, Bluetooth and HDMI ARC.',
            ],
        );

        $gallery = [
            'centum-product.jpg' => 'Yara Centum 100" 4K UHD Smart LED TV',
            'centum-front-leopard-royal.jpg' => 'Yara Centum 100" front view, lifelike detail',
            'centum-front-mandala.jpg' => 'Yara Centum 100" front view, vivid colour',
        ];

        $keep = [];
        foreach (array_keys($gallery) as $order => $file) {
            $path = $this->publish($file, "products/centum/{$file}");
            $keep[] = $path;
            $product->images()->updateOrCreate(
                ['image' => $path],
                ['alt_text' => $gallery[$file], 'sort_order' => $order, 'is_primary' => $order === 0],
            );
        }
        $product->images()->whereNotIn('image', $keep)->delete();

        $product->features()->delete();
        $product->features()->createMany(collect([
            ['icon' => 'monitor', 'title' => '100" 4K UHD Display', 'description' => 'A true cinema-sized screen with 3840 × 2160 resolution and a 16:9 wide format.'],
            ['icon' => 'sparkles', 'title' => 'A+ Grade Panel', 'description' => 'Premium panel for stunning picture quality and lifelike colours.'],
            ['icon' => 'cpu', 'title' => 'Quad Core, Android 12', 'description' => 'Smooth, responsive smart TV experience with 2 GB RAM and 16 GB storage.'],
            ['icon' => 'tv', 'title' => 'OTT Onboard', 'description' => 'Stream your favourite shows and movies straight from built-in apps.'],
            ['icon' => 'volume-2', 'title' => '30W Sound (15W × 2)', 'description' => 'High quality audio that fills the room.'],
            ['icon' => 'bluetooth', 'title' => 'Bluetooth', 'description' => 'Pair wireless headphones, speakers and more.'],
            ['icon' => 'cable', 'title' => 'HDMI ARC · USB · COAX', 'description' => 'Connect soundbars, consoles, set-top boxes and drives, plus an earphone port.'],
            ['icon' => 'leaf', 'title' => 'Energy Efficient', 'description' => 'Efficient operation helps reduce your electricity bill.'],
        ])->map(fn ($f, $i) => $f + ['sort_order' => $i])->all());

        // Size filter: add 100" and tag the product.
        if ($size = Attribute::where('slug', 'size')->first()) {
            $value = AttributeValue::firstOrCreate(
                ['attribute_id' => $size->id, 'value' => '100"'],
                ['sort_order' => 100],
            );
            $product->attributeValues()->syncWithoutDetaching([$value->id]);
        }

        // Centum banner goes first in the hero slider.
        $bannerPath = $this->publish('centum-banner.jpg', 'banners/centum-hero.jpg');
        $banner = Banner::firstOrNew(['image' => $bannerPath]);

        if (! $banner->exists) {
            Banner::query()->increment('sort_order');
        }

        $banner->fill([
            'title' => 'Yara Centum 100"',
            'subtitle' => '100" · 4K UHD Smart LED TV',
            'button_text' => 'Discover Centum',
            'button_link' => '/centum',
            'sort_order' => 0,
            'status' => true,
        ])->save();
    }

    private function publish(string $asset, string $target): string
    {
        Storage::disk('public')->put($target, file_get_contents(self::ASSETS . '/' . $asset));

        return $target;
    }
}
