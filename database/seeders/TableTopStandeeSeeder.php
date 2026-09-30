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
 * Commercial Display Solutions → 10" Table Top Standee: category, the 10" standee,
 * screen renders, location posters and the hero banner.
 *
 * Images are copied from database/seeders/assets/table-top-standee.
 * Idempotent: re-running updates the same records.
 *
 * php artisan db:seed --class=TableTopStandeeSeeder
 */
class TableTopStandeeSeeder extends Seeder
{
    private const ASSETS = __DIR__ . '/assets/table-top-standee';

    public function run(): void
    {
        // Images used directly by the /table-top-standee explore page.
        foreach ([
            'standee-emerald.png', 'standee-earrings.png', 'standee-pearls.png', 'standee-menu.png',
            'standee-pho.png', 'standee-dumplings.png', 'standee-trio.png',
            'screen-emerald.jpg', 'screen-earrings.jpg', 'screen-pearls.jpg', 'screen-pho.jpg', 'screen-dumplings.jpg',
            'poster-jewellery.jpg', 'poster-restaurant.jpg', 'poster-retail.jpg', 'poster-hotel.jpg',
        ] as $file) {
            $this->publish($file, "products/table-top-standee/{$file}");
        }

        $parent = Category::where('slug', 'commercial-display-solutions')->first();

        if (! $parent) {
            $this->call(TStandeeSeeder::class);
            $parent = Category::where('slug', 'commercial-display-solutions')->firstOrFail();
        }

        $category = Category::updateOrCreate(
            ['slug' => 'table-top-standee'],
            [
                'parent_id' => $parent->id,
                'name' => '10" Table Top Standee',
                'description' => 'Compact 10" touchscreen standees for counters and tables: virtual jewellery try-on, digital menus and product promotions.',
                'image' => $this->publish('poster-jewellery.jpg', 'categories/table-top-standee.jpg'),
                'banner' => $this->publish('category-banner.jpg', 'categories/banners/table-top-standee-banner.jpg'),
                'status' => true,
                'sort_order' => 5,
            ],
        );

        $product = Product::updateOrCreate(
            ['sku' => 'YE-TTS-10'],
            [
                'category_id' => $category->id,
                'name' => 'Yara 10" Table Top Standee',
                'slug' => 'yara-10-inch-table-top-standee',
                'model_number' => 'YE-TTS-10',
                'brand' => 'Yara',
                'short_description' => '10" portrait touchscreen standee with front camera for counters and tables: virtual try-on, digital menus and promotions.',
                'description' => 'The Yara 10" Table Top Standee brings a bright portrait touchscreen to any counter or table. '
                    . "Customers try on jewellery virtually with the front camera, browse a digital menu and order, or discover today's offers.\n\n"
                    . 'Its compact angled stand has USB, LAN and power ports in the base, so it sits neatly on jewellery counters, '
                    . 'restaurant tables, billing counters and reception desks. Software and content are configured for your business.',
                'price' => 0, // Price on request
                'sale_price' => null,
                'stock_quantity' => 10,
                'specifications' => [
                    'Screen Size' => '10 inch',
                    'Display' => 'Portrait touchscreen',
                    'Camera' => 'Front camera for virtual try-on & video',
                    'Ports' => 'USB, LAN, power (in the base)',
                    'Form Factor' => 'Table top standee with angled stand',
                    'Finish' => 'Charcoal grey',
                    'Uses' => 'Virtual try-on, digital menus, promotions, feedback',
                    'Software' => 'Configured for your business',
                    'Technical Data' => 'Resolution, OS, processor & connectivity on request',
                ],
                'status' => true,
                'featured' => true,
                'sort_order' => 1,
                'meta_title' => 'Yara 10 inch Table Top Standee | Virtual Try-On & Digital Menu Display',
                'meta_description' => 'Yara 10" table top touchscreen standee with front camera for jewellery virtual try-on, restaurant digital menus and counter promotions.',
            ],
        );

        $gallery = [
            'table-top-standee-10.jpg' => 'Yara 10" Table Top Standee',
            'table-top-standee-range.jpg' => 'Yara Table Top Standee with try-on, menu and promo screens',
            'poster-jewellery.jpg' => 'Yara Table Top Standee for jewellery try-on',
            'poster-restaurant.jpg' => 'Yara Table Top Standee digital menus in restaurants',
            'poster-retail.jpg' => 'Yara Table Top Standee on a retail counter',
            'poster-hotel.jpg' => 'Yara Table Top Standee at a hotel reception',
        ];

        $keep = [];
        foreach (array_keys($gallery) as $order => $file) {
            $path = $this->publish($file, "products/table-top-standee/{$file}");
            $keep[] = $path;
            $product->images()->updateOrCreate(
                ['image' => $path],
                ['alt_text' => $gallery[$file], 'sort_order' => $order, 'is_primary' => $order === 0],
            );
        }
        $product->images()->whereNotIn('image', $keep)->delete();

        $product->features()->delete();
        $product->features()->createMany(collect([
            ['icon' => 'pointer', 'title' => '10" Touchscreen', 'description' => 'Bright portrait screen, sized for counters and tables.'],
            ['icon' => 'camera', 'title' => 'Virtual Try-On', 'description' => 'Front camera lets customers try jewellery on screen.'],
            ['icon' => 'utensils-crossed', 'title' => 'Digital Menus', 'description' => 'Browse dishes and order right from the table.'],
            ['icon' => 'sparkles', 'title' => 'Promotions', 'description' => "Show today's offers and best-sellers at the counter."],
            ['icon' => 'plug', 'title' => 'Ports in the Base', 'description' => 'USB, LAN and power, neatly hidden at the back.'],
            ['icon' => 'settings-2', 'title' => 'Your Software', 'description' => 'Try-on, menu or feedback apps set up for you.'],
        ])->map(fn ($f, $i) => $f + ['sort_order' => $i])->all());

        if ($size = Attribute::where('slug', 'size')->first()) {
            $value = AttributeValue::firstOrCreate(['attribute_id' => $size->id, 'value' => '10"'], ['sort_order' => 10]);
            $product->attributeValues()->syncWithoutDetaching([$value->id]);
        }

        // Hero banner: seventh slide.
        $bannerPath = $this->publish('standee-banner.jpg', 'banners/table-top-standee-hero.jpg');
        $slide = Banner::firstOrNew(['image' => $bannerPath]);

        if (! $slide->exists) {
            Banner::where('sort_order', '>=', 6)->increment('sort_order');
        }

        $slide->fill([
            'title' => 'Yara Table Top Standee',
            'subtitle' => '10" · Try-on · Menus · Promos',
            'button_text' => 'Explore the Standee',
            'button_link' => '/table-top-standee',
            'sort_order' => 6,
            'status' => true,
        ])->save();
    }

    private function publish(string $asset, string $target): string
    {
        Storage::disk('public')->put($target, file_get_contents(self::ASSETS . '/' . $asset));

        return $target;
    }
}
