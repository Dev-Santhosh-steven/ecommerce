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
 * Washing Machine → Commercial Washing Machine: the Yara Fully Automatic Commercial Washer (SWQ-10 … SWQ-25),
 * data from the "Yara Commercial Washer Catalog", explore-page artwork and the hero banner.
 *
 * Images are copied from database/seeders/assets/commercial-washers.
 * Idempotent: re-running updates the same records.
 *
 * php artisan db:seed --class=CommercialWasherSeeder
 */
class CommercialWasherSeeder extends Seeder
{
    private const ASSETS = __DIR__ . '/assets/commercial-washers';

    /** Technical parameters from the catalogue. */
    private const MODELS = [
        10 => ['drum' => 100, 'motor' => '1.2', 'dimension' => '880 × 830 × 1300', 'weight' => 250],
        12 => ['drum' => 120, 'motor' => '1.5', 'dimension' => '880 × 830 × 1300', 'weight' => 280],
        15 => ['drum' => 150, 'motor' => '1.5', 'dimension' => '800 × 1000 × 1300', 'weight' => 300],
        20 => ['drum' => 200, 'motor' => '1.5', 'dimension' => '880 × 1030 × 1350', 'weight' => 420],
        25 => ['drum' => 250, 'motor' => '2.2', 'dimension' => '900 × 1100 × 1350', 'weight' => 500],
    ];

    public function run(): void
    {
        // Images used directly by the /commercial-washing-machines explore page.
        foreach (['washer-cutout.png', 'washer-hero.png', 'catalogue-specs.jpg'] as $file) {
            $this->publish($file, "products/commercial-washers/{$file}");
        }

        $parent = Category::firstOrCreate(['slug' => 'washing-machine'], ['name' => 'Washing Machine', 'status' => true, 'sort_order' => 1]);

        $category = Category::updateOrCreate(
            ['slug' => 'commercial-washing-machine'],
            [
                'parent_id' => $parent->id,
                'name' => 'Commercial Washing Machine',
                'description' => 'Fully automatic commercial washers from 10 kg to 25 kg for hotels, hospitals, laundries, hostels and institutions: stainless steel drum, programmable controls and 1150 rpm extraction.',
                'image' => $this->publish('category-card.jpg', 'categories/commercial-washing-machine.jpg'),
                'banner' => $this->publish('category-banner.jpg', 'categories/banners/commercial-washing-machine-banner.jpg'),
                'status' => true,
                'sort_order' => 3,
            ],
        );

        $capacity = Attribute::firstOrCreate(['slug' => 'capacity'], ['name' => 'Capacity', 'sort_order' => 20]);

        $order = 0;
        foreach (self::MODELS as $kg => $m) {
            $sku = "YE-CWM-SWQ{$kg}";

            $product = Product::updateOrCreate(
                ['sku' => $sku],
                [
                    'category_id' => $category->id,
                    'name' => "Yara {$kg} kg Fully Automatic Commercial Washing Machine",
                    'slug' => "yara-{$kg}-kg-fully-automatic-commercial-washing-machine",
                    'model_number' => "SWQ-{$kg}",
                    'brand' => 'Yara',
                    'short_description' => "{$kg} kg fully automatic commercial washer with a {$m['drum']} L stainless steel drum, 1150 rpm extraction and programmable controls, for hotels, hospitals and laundries.",
                    'description' => 'The Fully Automatic Commercial Washing Machine is built for high-performance laundry operations. '
                        . 'Designed with a durable stainless steel drum, programmable controls, and optimized drainage, it ensures efficient, '
                        . "reliable, and fabric-friendly cleaning—ideal for hotels, hospitals, laundries, and institutions.\n\n"
                        . "The SWQ-{$kg} washes {$kg} kg per load in a {$m['drum']} litre drum, turning gently at 50 rpm while washing and extracting at up to 1150 rpm, "
                        . "so linen comes out ready for drying faster. A {$m['motor']} kW washing motor runs on a standard 220 V supply.\n\n"
                        . 'It is installed as a hard-wired fixed unit, with an optional coin-operated mode for self-service laundries, a built-in detergent box that protects fabrics from corrosion, '
                        . 'and a safety door latch linked to the controls so the door stays locked while the drum is running.',
                    'price' => 0, // Price on request
                    'sale_price' => null,
                    'stock_quantity' => 5,
                    'specifications' => [
                        'Model' => "SWQ-{$kg}",
                        'Type' => 'Fully Automatic Commercial Washer',
                        'Heating Type' => 'Electricity',
                        'Washing Capacity' => "{$kg} kg",
                        'Washing Drum Dimension' => "{$m['drum']} L",
                        'Washing Speed' => '50 r/min',
                        'High Extract Speed' => '1150 r/min',
                        'Rated Voltage' => '220 V',
                        'Washing Motor Power' => "{$m['motor']} kW",
                        'Dimension' => "{$m['dimension']} mm",
                        'Gross Weight' => "{$m['weight']} kg",
                        'Drum' => 'Large stainless steel drum',
                        'Control' => 'Programmable computer control system',
                        'Installation' => 'Hard-wired fixed installation',
                        'Coin Operation' => 'Optional',
                        'Ideal For' => 'Hotels, laundries, hostels, hospitals & institutions',
                    ],
                    'status' => true,
                    'featured' => $kg === 15,
                    'sort_order' => $order,
                    'meta_title' => "Yara SWQ-{$kg} {$kg} kg Commercial Washing Machine | Hotels, Hospitals & Laundries",
                    'meta_description' => "Yara SWQ-{$kg} fully automatic commercial washer: {$kg} kg capacity, {$m['drum']} L stainless steel drum, 1150 rpm extract, programmable controls, optional coin operation.",
                ],
            );

            $gallery = [
                "washer-swq-{$kg}.jpg" => "Yara SWQ-{$kg} {$kg} kg Commercial Washing Machine",
                'catalogue-specs.jpg' => 'Yara Fully Automatic Commercial Washer: key features and technical parameters',
                'catalogue-cover.jpg' => 'Yara Commercial Washer range',
            ];
            $keep = [];
            foreach (array_keys($gallery) as $i => $file) {
                $path = $this->publish($file, "products/commercial-washers/{$file}");
                $keep[] = $path;
                $product->images()->updateOrCreate(['image' => $path], ['alt_text' => $gallery[$file], 'sort_order' => $i, 'is_primary' => $i === 0]);
            }
            $product->images()->whereNotIn('image', $keep)->delete();

            $product->features()->delete();
            $product->features()->createMany(collect([
                ['cylinder', 'Large stainless steel drum', "{$m['drum']} litres for gentle garment handling and long life."],
                ['cpu', 'Programmable computer control', 'Set wash, rinse and extract programmes for every fabric.'],
                ['gauge', '1150 rpm high extract', 'Spins linen drier so drying takes less time and energy.'],
                ['droplets', 'Optimized drainage', 'Drains fast and clean for hygienic, back-to-back loads.'],
                ['flask-conical', 'Built-in detergent box', 'Doses detergent safely and prevents corrosion of fabrics.'],
                ['lock', 'Safety door latch', 'Door and controls are linked: it stays locked while running.'],
                ['coins', 'Optional coin operation', 'Turn it into a self-service washer for laundromats and hostels.'],
                ['plug-zap', 'Hard-wired fixed installation', 'Installed permanently for stable, vibration-free operation.'],
            ])->map(fn ($f, $i) => ['icon' => $f[0], 'title' => $f[1], 'description' => $f[2], 'sort_order' => $i])->all());

            $value = AttributeValue::firstOrCreate(['attribute_id' => $capacity->id, 'value' => "{$kg} kg"], ['sort_order' => $kg * 10]);
            $product->attributeValues()->syncWithoutDetaching([$value->id]);

            $order++;
        }

        // Hero banner: flagship slide near the front of the slider.
        $bannerPath = $this->publish('washer-banner.jpg', 'banners/commercial-washer-hero.jpg');
        Banner::updateOrCreate(
            ['image' => $bannerPath],
            [
                'title' => 'Yara Commercial Washers',
                'subtitle' => '10 – 25 kg · Stainless steel drum · 1150 rpm',
                'button_text' => 'Explore Commercial Washers',
                'button_link' => '/commercial-washing-machines',
                'sort_order' => 1,
                'status' => true,
            ],
        );
    }

    private function publish(string $asset, string $target): string
    {
        Storage::disk('public')->put($target, file_get_contents(self::ASSETS . '/' . $asset));

        return $target;
    }
}
