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
 * Commercial Display Solutions → Printing Kiosk: category, the 21.5" printing kiosk,
 * location posters and the hero banner.
 *
 * Images are copied from database/seeders/assets/printing-kiosk.
 * Idempotent: re-running updates the same records.
 *
 * php artisan db:seed --class=PrintingKioskSeeder
 */
class PrintingKioskSeeder extends Seeder
{
    private const ASSETS = __DIR__ . '/assets/printing-kiosk';

    public function run(): void
    {
        // Images used directly by the /printing-kiosk explore page.
        foreach ([
            'kiosk-pair.png', 'kiosk-menu.png', 'kiosk-burger.png', 'kiosk-chicken.png', 'kiosk-shawarma.png',
            'screen-menu.jpg', 'poster-restaurant.jpg', 'poster-foodcourt.jpg', 'poster-retail.jpg', 'poster-tokens.jpg',
        ] as $file) {
            $this->publish($file, "products/printing-kiosk/{$file}");
        }

        $parent = Category::where('slug', 'commercial-display-solutions')->first();

        if (! $parent) {
            $this->call(TStandeeSeeder::class);
            $parent = Category::where('slug', 'commercial-display-solutions')->firstOrFail();
        }

        $category = Category::updateOrCreate(
            ['slug' => 'printing-kiosk'],
            [
                'parent_id' => $parent->id,
                'name' => 'Printing Kiosk',
                'description' => 'Self-service touchscreen kiosks with a built-in printer: self-ordering, billing, receipts and token printing.',
                'image' => $this->publish('poster-foodcourt.jpg', 'categories/printing-kiosk.jpg'),
                'banner' => $this->publish('category-banner.jpg', 'categories/banners/printing-kiosk-banner.jpg'),
                'status' => true,
                'sort_order' => 3,
            ],
        );

        $product = Product::updateOrCreate(
            ['sku' => 'YE-KIOSK-215'],
            [
                'category_id' => $category->id,
                'name' => 'Yara 21.5" Printing Kiosk',
                'slug' => 'yara-21-5-inch-printing-kiosk',
                'model_number' => 'YE-KIOSK-215',
                'brand' => 'Yara',
                'short_description' => '21.5" self-service touchscreen kiosk with built-in printer for self-ordering, billing, receipts and tokens.',
                'description' => 'The Yara 21.5" Printing Kiosk lets customers serve themselves: browse the menu or catalogue, place an order, '
                    . "and collect a printed receipt or token, all without waiting at the counter.\n\n"
                    . 'Its clean white floor-standing design fits restaurants, cafés, food courts, retail stores, clinics and offices, '
                    . 'with a built-in printer and scanner for smooth, queue-free service. Software and payment options are configured for your business.',
                'price' => 0, // Price on request
                'sale_price' => null,
                'stock_quantity' => 5,
                'specifications' => [
                    'Screen Size' => '21.5 inch',
                    'Display' => 'Touchscreen, portrait',
                    'Printer' => 'Built-in receipt & token printer',
                    'Scanner' => 'QR / barcode scanner',
                    'Audio' => 'Built-in speaker',
                    'Form Factor' => 'Floor-standing kiosk with weighted base',
                    'Finish' => 'White',
                    'Uses' => 'Self-ordering, billing, receipts, tokens & tickets',
                    'Software & Payments' => 'Configured for your business',
                    'Technical Data' => 'Resolution, OS, printer & ports on request',
                ],
                'status' => true,
                'featured' => true,
                'sort_order' => 1,
                'meta_title' => 'Yara 21.5 inch Printing Kiosk | Self-Order & Token Printing Kiosk',
                'meta_description' => 'Yara 21.5" printing kiosk with touchscreen, built-in receipt/token printer and QR scanner for restaurants, food courts, retail and clinics.',
            ],
        );

        $gallery = [
            'printing-kiosk-21-5.jpg' => 'Yara 21.5" Printing Kiosk',
            'poster-restaurant.jpg' => 'Yara Printing Kiosk in a restaurant',
            'poster-foodcourt.jpg' => 'Yara Printing Kiosks at a mall food court',
            'poster-retail.jpg' => 'Yara Printing Kiosk for retail billing',
            'poster-tokens.jpg' => 'Yara Printing Kiosk for tokens and queues',
        ];

        $keep = [];
        foreach (array_keys($gallery) as $order => $file) {
            $path = $this->publish($file, "products/printing-kiosk/{$file}");
            $keep[] = $path;
            $product->images()->updateOrCreate(
                ['image' => $path],
                ['alt_text' => $gallery[$file], 'sort_order' => $order, 'is_primary' => $order === 0],
            );
        }
        $product->images()->whereNotIn('image', $keep)->delete();

        $product->features()->delete();
        $product->features()->createMany(collect([
            ['icon' => 'pointer', 'title' => '21.5" Touchscreen', 'description' => 'Large, responsive portrait screen that anyone can use.'],
            ['icon' => 'printer', 'title' => 'Built-in Printer', 'description' => 'Prints receipts, order tokens and tickets instantly.'],
            ['icon' => 'scan-line', 'title' => 'QR / Barcode Scanner', 'description' => 'Scan coupons, loyalty codes and product barcodes.'],
            ['icon' => 'timer', 'title' => 'Shorter Queues', 'description' => 'Customers order themselves while staff focus on service.'],
            ['icon' => 'settings-2', 'title' => 'Your Software', 'description' => 'Menus, catalogues and payments set up for your business.'],
            ['icon' => 'shield-check', 'title' => 'Sturdy & Clean Design', 'description' => 'Floor-standing white body on a stable weighted base.'],
        ])->map(fn ($f, $i) => $f + ['sort_order' => $i])->all());

        if ($size = Attribute::where('slug', 'size')->first()) {
            $value = AttributeValue::firstOrCreate(['attribute_id' => $size->id, 'value' => '21.5"'], ['sort_order' => 21]);
            $product->attributeValues()->syncWithoutDetaching([$value->id]);
        }

        // Hero banner: fifth slide.
        $bannerPath = $this->publish('kiosk-banner.jpg', 'banners/printing-kiosk-hero.jpg');
        $slide = Banner::firstOrNew(['image' => $bannerPath]);

        if (! $slide->exists) {
            Banner::where('sort_order', '>=', 4)->increment('sort_order');
        }

        $slide->fill([
            'title' => 'Yara Printing Kiosk',
            'subtitle' => '21.5" · Order · Pay · Print',
            'button_text' => 'Explore the Kiosk',
            'button_link' => '/printing-kiosk',
            'sort_order' => 4,
            'status' => true,
        ])->save();
    }

    private function publish(string $asset, string $target): string
    {
        Storage::disk('public')->put($target, file_get_contents(self::ASSETS . '/' . $asset));

        return $target;
    }
}
