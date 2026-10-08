<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * Yara Chillers: category, the chiller-based AC system product, gallery and hero banner.
 *
 * Content and specifications follow the Yara Chiller Catalogue (ECGC, ECHC and ECAS series, AHU/FCU air
 * distribution). Images are copied from database/seeders/assets/chillers (Yara-branded studio shot, cut-out,
 * posters, and the series / air-distribution photos from the catalogue).
 * Idempotent: re-running updates the same records.
 *
 * php artisan db:seed --class=ChillerSeeder
 */
class ChillerSeeder extends Seeder
{
    private const ASSETS = __DIR__ . '/assets/chillers';

    public function run(): void
    {
        // Images used directly by the /chillers showcase page.
        foreach ([
            'chiller-cutout.png', 'chiller-studio.jpg',
            'series-ecgc.jpg', 'series-echc-wc.jpg', 'series-echc-ac.jpg',
            'ahu.jpg', 'fcu-split.jpg', 'fcu-cassette.jpg', 'fcu-horizontal.jpg',
        ] as $file) {
            $this->publish($file, "products/chillers/{$file}");
        }

        $category = Category::updateOrCreate(
            ['slug' => 'chillers'],
            [
                'parent_id' => null,
                'name' => 'Chillers',
                'description' => 'Centralised chiller cooling for hospitals, schools, colleges, retail stores and malls: 50% less energy, 100% cooling performance.',
                'image' => $this->publish('poster-office-smart-cooling.jpg', 'categories/chillers.jpg'),
                'banner' => $this->publish('category-banner.jpg', 'categories/banners/chillers-banner.jpg'),
                'status' => true,
                'sort_order' => Category::where('slug', 'chillers')->value('sort_order') ?? (Category::whereNull('parent_id')->max('sort_order') + 1),
            ],
        );

        $product = Product::updateOrCreate(
            ['sku' => 'YE-CHILLER-AC'],
            [
                'category_id' => $category->id,
                'name' => 'Yara Chiller-Based AC System',
                'slug' => 'yara-chiller-based-ac-system',
                'model_number' => 'YE-CHILLER-AC',
                'brand' => 'Yara',
                'short_description' => 'Centralised chiller cooling from 2 TR to 500 TR for hospitals, schools, colleges, retail stores and malls: up to 40–50% lower energy use.',
                'description' => 'A chiller system is a centralised cooling solution designed to efficiently cool large buildings and multi-room facilities. '
                    . 'Instead of multiple individual air conditioners, a Yara chiller produces chilled water which is circulated through '
                    . "Air Handling Units (AHUs) or Fan Coil Units (FCUs: split or cassette type) to provide consistent cooling across the building.

"
                    . 'The chiller removes heat from water using a refrigeration cycle; the chilled water is pumped through insulated pipes across the building; '
                    . 'AHUs or FCUs use it to cool the air and distribute it evenly; and the warm water returns to the chiller to be cooled again. '
                    . "This centralised approach gives stable temperature control, higher efficiency and better reliability for large facilities.

"
                    . 'Choose from the ECGC series (12.5 TR to 45 TR general-purpose chillers), the ECHC series (higher-capacity air-cooled and water-cooled chillers up to 500 TR) '
                    . 'and the ECAS series (custom, application-specific chillers from -50 °C to +20 °C). Every system is designed for your building after a site survey.',
                'price' => 0, // Price on request: every system is sized for the project.
                'sale_price' => null,
                'stock_quantity' => 1,
                'specifications' => [
                    'System Type' => 'Centralised chiller cooling (chilled water)',
                    'Series' => 'ECGC, ECHC (air- & water-cooled), ECAS (application-specific)',
                    'Capacity Range' => '2 TR (7 kW) to 500 TR (1750 kW)',
                    'ECGC Series' => '12.5 TR / 44 kW to 45 TR / 158 kW',
                    'Compressor (ECGC)' => 'Scroll, 1 or 2 compressors',
                    'Heat Exchanger (ECGC)' => 'BTHE (brazed plate)',
                    'Condenser' => 'Air-cooled or water-cooled',
                    'Refrigerant (ECGC)' => 'R407C',
                    'Controls' => 'DTC (digital temperature controller) / PLC',
                    'Chilled Water' => '7 °C nominal, adjustable -7 °C to 20 °C (ECGC)',
                    'Air Distribution' => 'AHUs, or FCUs: split (up to 2 TR), cassette & horizontal cassette (up to 4 TR)',
                    'Energy' => 'Up to 40–50% lower energy use than conventional split ACs*',
                    'Applications' => 'Hospitals, schools, colleges, retail stores, malls & large facilities',
                    'Installation' => 'Site survey, design & installation by Yara',
                ],
                'status' => true,
                'featured' => true,
                'sort_order' => 1,
                'meta_title' => 'Yara Chillers | Centralised Chiller Cooling Systems, 2 TR to 500 TR',
                'meta_description' => 'Yara chiller cooling systems for hospitals, schools, colleges, retail stores and malls: ECGC, ECHC and ECAS series from 2 TR to 500 TR, with AHU and FCU air distribution and up to 40–50% lower energy use.',
            ],
        );

        $gallery = [
            'chiller-product.jpg' => 'Yara chiller-based AC system with ceiling cassette unit',
            'chiller-studio.jpg' => 'Yara chiller plant with cassette air distribution',
            'series-echc-ac.jpg' => 'Yara ECHC-AC air-cooled chillers, 2 TR to 200 TR',
            'series-ecgc.jpg' => 'Yara ECGC series chillers, 12.5 TR to 45 TR',
            'series-echc-wc.jpg' => 'Yara ECHC-WC water-cooled chillers, 10 TR to 500 TR',
            'ahu.jpg' => 'Air handling unit fed by a Yara chiller, custom made for the site',
            'poster-workspace-less-power.jpg' => '50% less power, 100% cooling power: Yara chillers in an office',
            'poster-mall-quick-chill.jpg' => 'Quick chill, built tough: Yara chillers in a shopping mall',
            'poster-office-smart-cooling.jpg' => 'Smart cooling, steady temperature: Yara chillers in a corporate office',
            'poster-rotunda-energy-saver.jpg' => 'Future cooling, energy saver: Yara chillers in a mall rotunda',
        ];

        $keep = [];
        foreach (array_keys($gallery) as $order => $file) {
            $path = $this->publish($file, "products/chillers/{$file}");
            $keep[] = $path;
            $product->images()->updateOrCreate(
                ['image' => $path],
                ['alt_text' => $gallery[$file], 'sort_order' => $order, 'is_primary' => $order === 0],
            );
        }
        $product->images()->whereNotIn('image', $keep)->delete();

        $product->features()->delete();
        $product->features()->createMany(collect([
            ['icon' => 'leaf', 'title' => 'Energy Efficient Cooling', 'description' => 'Advanced compressor technology and optimised heat exchangers give maximum cooling with lower energy consumption.'],
            ['icon' => 'building-2', 'title' => 'Built for Large Spaces', 'description' => 'Made for schools, colleges, hospitals, malls, textile showrooms and commercial buildings that need centralised cooling.'],
            ['icon' => 'blocks', 'title' => 'Modular & Scalable Design', 'description' => 'Systems can be expanded or customised for the building size and cooling demand.'],
            ['icon' => 'wrench', 'title' => 'Easy Maintenance', 'description' => 'Water-based chilled circulation makes leaks simple to detect and servicing faster, reducing downtime.'],
            ['icon' => 'drafting-compass', 'title' => 'Custom Engineered Systems', 'description' => 'Each installation is designed for the building layout, airflow requirement and cooling load.'],
            ['icon' => 'shield-check', 'title' => 'Reliable Performance', 'description' => 'Designed for continuous operation with industrial-grade components for a long operational life.'],
        ])->map(fn ($f, $i) => $f + ['sort_order' => $i])->all());

        // Hero banner: second slide, right after the Centum.
        $bannerPath = $this->publish('chiller-banner.jpg', 'banners/chillers-hero.jpg');
        $banner = Banner::firstOrNew(['image' => $bannerPath]);

        if (! $banner->exists) {
            Banner::where('sort_order', '>=', 1)->increment('sort_order');
        }

        $banner->fill([
            'title' => 'Yara Chillers',
            'subtitle' => '50% Less Power · 100% Cooling Power',
            'button_text' => 'Explore Chillers',
            'button_link' => '/chillers',
            'sort_order' => 1,
            'status' => true,
        ])->save();
    }

    private function publish(string $asset, string $target): string
    {
        Storage::disk('public')->put($target, file_get_contents(self::ASSETS . '/' . $asset));

        return $target;
    }
}
