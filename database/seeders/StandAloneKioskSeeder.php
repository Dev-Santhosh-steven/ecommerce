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
 * Commercial Display Solutions → Stand Alone Kiosk: category, 32" / 43" / 55" touch kiosks,
 * kiosk renders, location posters and the hero banner.
 *
 * Images are copied from database/seeders/assets/standalone-kiosk.
 * Idempotent: re-running updates the same records.
 *
 * php artisan db:seed --class=StandAloneKioskSeeder
 */
class StandAloneKioskSeeder extends Seeder
{
    private const ASSETS = __DIR__ . '/assets/standalone-kiosk';

    public function run(): void
    {
        // Images used directly by the /stand-alone-kiosk explore page.
        foreach ([
            'kiosk-white-car.png', 'kiosk-pair.png', 'screen-car.jpg',
            'kiosk-silver-wayfinding.png', 'kiosk-silver-catalogue.png', 'kiosk-white-catalogue.png',
            'kiosk-white-checkin.png', 'kiosk-white-wayfinding.png',
            'poster-mall.jpg', 'poster-showroom.jpg', 'poster-hotel.jpg', 'poster-lobby.jpg',
        ] as $file) {
            $this->publish($file, "products/standalone-kiosk/{$file}");
        }

        $parent = Category::where('slug', 'commercial-display-solutions')->first();

        if (! $parent) {
            $this->call(TStandeeSeeder::class);
            $parent = Category::where('slug', 'commercial-display-solutions')->firstOrFail();
        }

        $category = Category::updateOrCreate(
            ['slug' => 'stand-alone-kiosk'],
            [
                'parent_id' => $parent->id,
                'name' => 'Stand Alone Kiosk',
                'description' => 'Floor-standing touchscreen kiosks with a tilted display for wayfinding, catalogues, check-in and visitor information.',
                'image' => $this->publish('poster-showroom.jpg', 'categories/stand-alone-kiosk.jpg'),
                'banner' => $this->publish('category-banner.jpg', 'categories/banners/stand-alone-kiosk-banner.jpg'),
                'status' => true,
                'sort_order' => 4,
            ],
        );

        $models = [
            32 => [
                'use' => 'check-in desks, queue management and help points',
                'photo' => 'standalone-kiosk-32.jpg',
                'extra' => ['poster-hotel.jpg' => 'Yara Stand Alone Kiosk for hotel & hospital check-in'],
            ],
            43 => [
                'use' => 'mall wayfinding, store directories and information points',
                'photo' => 'standalone-kiosk-43.jpg',
                'extra' => ['poster-mall.jpg' => 'Yara Stand Alone Kiosk for mall wayfinding'],
            ],
            55 => [
                'use' => 'showroom catalogues, experience centres and corporate lobbies',
                'photo' => 'standalone-kiosk-55.jpg',
                'extra' => ['poster-lobby.jpg' => 'Yara Stand Alone Kiosk in a corporate lobby'],
            ],
        ];

        $size = Attribute::where('slug', 'size')->first();

        foreach ($models as $inch => $m) {
            $product = Product::updateOrCreate(
                ['sku' => "YE-SAK-{$inch}"],
                [
                    'category_id' => $category->id,
                    'name' => "Yara {$inch}\" Stand Alone Kiosk",
                    'slug' => "yara-{$inch}-inch-stand-alone-kiosk",
                    'model_number' => "YE-SAK-{$inch}",
                    'brand' => 'Yara',
                    'short_description' => "{$inch}\" floor-standing touchscreen kiosk with a tilted display, ideal for {$m['use']}.",
                    'description' => "The Yara {$inch}\" Stand Alone Kiosk puts a responsive touchscreen at the perfect angle for people standing in front of it. "
                        . "Visitors find stores, browse products, check in or register themselves, with no staff needed.\n\n"
                        . "Its sculpted white metal body stands on a weighted base, so it looks at home in malls, showrooms, hotels, hospitals and corporate lobbies. "
                        . "Ideal for {$m['use']}. Software and content are configured for your business.",
                    'price' => 0, // Price on request
                    'sale_price' => null,
                    'stock_quantity' => 5,
                    'specifications' => [
                        'Screen Size' => "{$inch} inch",
                        'Display' => 'Full HD touchscreen, tilted for standing use',
                        'Touch' => 'Multi-touch (capacitive / IR)',
                        'Form Factor' => 'Floor-standing kiosk with weighted base',
                        'Body' => 'Sculpted metal, white powder-coat finish',
                        'Uses' => 'Wayfinding, catalogues, check-in, visitor info',
                        'Software' => 'Configured for your business',
                        'Technical Data' => 'Resolution, OS, processor & ports on request',
                    ],
                    'status' => true,
                    'featured' => $inch === 43,
                    'sort_order' => $inch,
                    'meta_title' => "Yara {$inch} inch Stand Alone Touch Kiosk | Wayfinding & Information Kiosk",
                    'meta_description' => "Yara {$inch}\" stand alone touchscreen kiosk with a tilted display for {$m['use']}.",
                ],
            );

            $gallery = [
                $m['photo'] => "Yara {$inch}\" Stand Alone Kiosk",
                'standalone-kiosk-in-use.jpg' => 'Customer using the Yara Stand Alone Kiosk',
                'poster-showroom.jpg' => 'Yara Stand Alone Kiosk in a showroom',
            ] + $m['extra'];

            $keep = [];
            foreach (array_keys($gallery) as $order => $file) {
                $path = $this->publish($file, "products/standalone-kiosk/{$file}");
                $keep[] = $path;
                $product->images()->updateOrCreate(
                    ['image' => $path],
                    ['alt_text' => $gallery[$file], 'sort_order' => $order, 'is_primary' => $order === 0],
                );
            }
            $product->images()->whereNotIn('image', $keep)->delete();

            $product->features()->delete();
            $product->features()->createMany(collect([
                ['icon' => 'pointer', 'title' => "{$inch}\" Touchscreen", 'description' => 'Responsive multi-touch screen that anyone can use.'],
                ['icon' => 'monitor', 'title' => 'Tilted Display', 'description' => 'Angled for comfortable use while standing.'],
                ['icon' => 'map', 'title' => 'Wayfinding & Directories', 'description' => 'Maps, store lists and routes at a touch.'],
                ['icon' => 'layout-grid', 'title' => 'Interactive Catalogues', 'description' => 'Let customers browse products on their own.'],
                ['icon' => 'settings-2', 'title' => 'Your Software', 'description' => 'Check-in, registration or info apps set up for you.'],
                ['icon' => 'shield-check', 'title' => 'Sturdy Metal Body', 'description' => 'Sculpted white body on a stable weighted base.'],
            ])->map(fn ($f, $i) => $f + ['sort_order' => $i])->all());

            if ($size) {
                $value = AttributeValue::firstOrCreate(['attribute_id' => $size->id, 'value' => "{$inch}\""], ['sort_order' => $inch]);
                $product->attributeValues()->syncWithoutDetaching([$value->id]);
            }
        }

        // Hero banner: sixth slide.
        $bannerPath = $this->publish('kiosk-banner.jpg', 'banners/stand-alone-kiosk-hero.jpg');
        $slide = Banner::firstOrNew(['image' => $bannerPath]);

        if (! $slide->exists) {
            Banner::where('sort_order', '>=', 5)->increment('sort_order');
        }

        $slide->fill([
            'title' => 'Yara Stand Alone Kiosk',
            'subtitle' => '32" · 43" · 55" · Touch. Find. Explore.',
            'button_text' => 'Explore the Kiosk',
            'button_link' => '/stand-alone-kiosk',
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
