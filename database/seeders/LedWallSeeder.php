<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Banner;
use App\Models\Category;
use App\Models\LedModule;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * LED Video Walls category: ten Yara LED wall products (P1.25 indoor fine-pitch to P10 outdoor),
 * their LED modules for the public LED Wall Calculator, filter attributes, category artwork and a
 * home hero banner that opens the calculator.
 *
 * Idempotent: re-running updates the same records (matched by slug / SKU / module name / image path).
 * Images are copied from database/seeders/assets/led-video-walls to the public disk.
 *
 *   php artisan db:seed --class=LedWallSeeder
 */
class LedWallSeeder extends Seeder
{
    private const ASSETS = __DIR__ . '/assets/led-video-walls';

    public function run(): void
    {
        DB::transaction(function () {
            $category = $this->seedCategory();

            $pitchAttr = $this->attribute('pixel-pitch', 'Pixel Pitch', 10);
            $envAttr = $this->attribute('environment', 'Environment', 11);

            foreach ($this->models() as $index => $model) {
                $product = $this->seedProduct($category, $model, $index);
                $this->seedModule($product, $model, $index);

                $product->attributeValues()->syncWithoutDetaching([
                    $pitchAttr->values()->firstOrCreate(['value' => 'P' . $model['pitch']], ['sort_order' => $index])->id,
                    $envAttr->values()->firstOrCreate(
                        ['value' => ucfirst($model['env']) . ($model['rental'] ? ' Rental' : '')],
                        ['sort_order' => $model['env'] === 'indoor' ? 0 : 1],
                    )->id,
                ]);
            }

            $this->seedHomeBanner();
        });
    }

    private function seedCategory(): Category
    {
        return Category::updateOrCreate(
            ['slug' => 'led-video-walls'],
            [
                'parent_id' => null,
                'name' => 'LED Video Walls',
                'description' => 'Seamless Yara LED video walls from P1.25 fine-pitch indoor to P10 outdoor billboards — '
                    . 'any size, sunlight-readable, and planned in seconds with our LED Wall Calculator.',
                'image' => $this->publish('category-card.jpg', 'categories/led-video-walls.jpg'),
                'banner' => $this->publish('category-banner.jpg', 'categories/banners/led-video-walls-banner.jpg'),
                'status' => true,
                'sort_order' => 3,
            ],
        );
    }

    private function seedProduct(Category $category, array $m, int $index): Product
    {
        $pitch = $m['pitch'];
        $kind = $m['rental'] ? ucfirst($m['env']) . ' Rental' : ucfirst($m['env']);

        $product = Product::updateOrCreate(
            ['sku' => $m['sku']],
            [
                'category_id' => $category->id,
                'name' => "Yara P{$pitch} {$kind} LED Video Wall",
                'slug' => "yara-p" . str_replace('.', '-', $pitch) . '-' . $m['env'] . ($m['rental'] ? '-rental' : '') . '-led-video-wall',
                'model_number' => $m['model'],
                'brand' => 'Yara',
                'short_description' => "P{$pitch} {$m['env']} LED wall, {$m['nits']} nits, {$m['refresh']} — {$m['ideal']}. Built to any size.",
                'description' => $this->description($m),
                'price' => $m['price'],
                'sale_price' => $m['sale_price'],
                'price_unit' => 'sq ft',
                'stock_quantity' => 500,
                'warranty_months' => 24,
                'specifications' => $this->specifications($m),
                'status' => true,
                'featured' => in_array($m['sku'], ['YE-LED-P25-IN', 'YE-LED-P391-OR', 'YE-LED-P5-OUT'], true),
                'sort_order' => $index,
                'meta_title' => "Yara P{$pitch} {$kind} LED Video Wall | {$m['nits']} nits LED Display",
                'meta_description' => "Buy the Yara P{$pitch} {$m['env']} LED video wall — {$m['module_w']}×{$m['module_h']} mm modules, "
                    . "{$m['nits']} nits, {$m['refresh']} refresh. Plan your screen size with our free LED Wall Calculator.",
            ],
        );

        $slug = $m['asset'];
        $gallery = [
            'scene' => "Yara P{$pitch} {$kind} LED video wall installed",
            'highlights' => "Yara P{$pitch} LED video wall — key specifications",
            'module' => "Yara P{$pitch} LED module close-up with dimensions",
        ];

        $keep = [];

        foreach (array_keys($gallery) as $order => $view) {
            $path = $this->publish("products/yara-led-{$slug}-{$view}.jpg", "products/led-video-walls/yara-led-{$slug}-{$view}.jpg");
            $keep[] = $path;

            $product->images()->updateOrCreate(
                ['image' => $path],
                ['alt_text' => $gallery[$view], 'sort_order' => $order, 'is_primary' => $order === 0],
            );
        }

        $product->images()->whereNotIn('image', $keep)->where('image', 'like', 'products/led-video-walls/%')->delete();

        $product->features()->delete();
        $product->features()->createMany(
            collect($this->features($m))->map(fn ($f, $i) => $f + ['sort_order' => $i])->all(),
        );

        return $product;
    }

    private function seedModule(Product $product, array $m, int $index): void
    {
        LedModule::updateOrCreate(
            ['name' => "Yara P{$m['pitch']} " . ucfirst($m['env']) . ($m['rental'] ? ' Rental' : '')],
            [
                'product_id' => $product->id,
                'brand' => 'Yara',
                'model_number' => $m['model'],
                'environment' => $m['env'],
                'length_mm' => $m['module_w'],
                'height_mm' => $m['module_h'],
                'pixel_width' => $m['px_w'],
                'pixel_height' => $m['px_h'],
                'pixel_pitch' => $m['pitch'],
                'pixel_config' => $m['led'],
                'weight_per_module_kg' => $m['module_kg'],
                'refresh_rate' => $m['refresh'],
                'scan_mode' => $m['scan'] . ' scan',
                'brightness_nits' => $m['nits'],
                'viewing_angle_h' => $m['angle'][0],
                'viewing_angle_v' => $m['angle'][1],
                'serviceability' => $m['service'],
                'power_max_wm2' => $m['power'][0],
                'power_avg_wm2' => $m['power'][1],
                'input_voltage' => 'AC 100–240 V, 50/60 Hz',
                'cabinet_w_mm' => $m['cabinet'][0],
                'cabinet_h_mm' => $m['cabinet'][1],
                'cabinet_d_mm' => $m['cabinet'][2],
                'cabinet_weight_kg' => $m['cabinet'][3],
                'cabinet_material' => $m['cabinet'][4],
                'is_active' => true,
                'sort_order' => $index,
            ],
        );
    }

    private function seedHomeBanner(): void
    {
        Banner::updateOrCreate(
            ['image' => $this->publish('home-banner.jpg', 'banners/led-video-walls-hero.jpg')],
            [
                'title' => 'LED Video Walls',
                'subtitle' => 'New · Indoor & Outdoor · P1.25 to P10',
                'button_text' => 'Explore More',
                'button_link' => '/led-wall-calculator',
                'sort_order' => 0,
                'status' => true,
            ],
        );

        foreach (['home-outdoor', 'home-indoor', 'home-stage'] as $art) {
            $this->publish("{$art}.jpg", "led-video-walls/{$art}.jpg");
        }
    }

    private function attribute(string $slug, string $name, int $sort): Attribute
    {
        return Attribute::firstOrCreate(['slug' => $slug], ['name' => $name, 'sort_order' => $sort]);
    }

    /**
     * Copy an asset to the public disk and return its stored path.
     */
    private function publish(string $asset, string $target): string
    {
        Storage::disk('public')->put($target, file_get_contents(self::ASSETS . '/' . $asset));

        return $target;
    }

    private function description(array $m): string
    {
        $env = $m['env'] === 'outdoor'
            ? "Rated IP65 at the front, it shrugs off monsoon rain, dust and 45 °C summers, while {$m['nits']} nits of brightness keep your content readable in direct sunlight."
            : "At {$m['nits']} nits with a wide {$m['angle'][0]}° viewing angle, colours stay rich and even from every seat — without glare in brightly lit rooms.";

        $build = $m['rental']
            ? "Die-cast {$m['cabinet'][0]} × {$m['cabinet'][1]} mm rental cabinets lock together with quick-release latches and curve-locks, so a crew can build or strike a wall in hours. Corner protectors and a hanging/stacking system make it ready for tours."
            : "{$m['module_w']} × {$m['module_h']} mm modules mount in {$m['cabinet'][0]} × {$m['cabinet'][1]} mm {$m['cabinet'][4]} cabinets with " . strtolower($m['service']) . ", so a single module can be swapped in minutes without taking the wall down.";

        $pitch = $m['pitch'];
        $min = rtrim(rtrim(number_format($pitch, 1), '0'), '.');
        $best = rtrim(rtrim(number_format($pitch * 3, 1), '0'), '.');

        return <<<TEXT
        The Yara P{$pitch} LED Video Wall is built for {$m['ideal']}. With a {$pitch} mm pixel pitch it looks seamless from about {$min} m away and at its very best from around {$best} m — the right balance of sharpness and value for the space.

        {$env} A {$m['refresh']} refresh rate keeps motion smooth and flicker-free on phone cameras and broadcast.

        {$build}

        LED walls are built to your exact space. Use the free LED Wall Calculator to see the screen size, resolution, power and weight for your wall, then request a demo — our engineers handle site survey, structure, controller and installation.
        TEXT;
    }

    private function specifications(array $m): array
    {
        $area = ($m['module_w'] / 1000) * ($m['module_h'] / 1000);
        $density = (int) round(($m['px_w'] * $m['px_h']) / $area);

        return [
            'Pixel Pitch' => "{$m['pitch']} mm",
            'Application' => ucfirst($m['env']) . ($m['rental'] ? ' rental / staging' : ' fixed installation'),
            'LED Type' => $m['led_type'],
            'Pixel Configuration' => $m['led'],
            'Module Size' => "{$m['module_w']} × {$m['module_h']} mm",
            'Module Resolution' => "{$m['px_w']} × {$m['px_h']} px",
            'Pixel Density' => number_format($density) . ' dots/m²',
            'Cabinet Size' => "{$m['cabinet'][0]} × {$m['cabinet'][1]} × {$m['cabinet'][2]} mm",
            'Cabinet Material' => $m['cabinet'][4],
            'Cabinet Weight' => "{$m['cabinet'][3]} kg",
            'Brightness' => number_format($m['nits']) . ' cd/m²',
            'Refresh Rate' => $m['refresh'],
            'Scan Mode' => $m['scan'],
            'Grey Scale' => $m['env'] === 'outdoor' ? '14–16 bit' : '16 bit',
            'Viewing Angle' => "{$m['angle'][0]}° (H) / {$m['angle'][1]}° (V)",
            'Min. Viewing Distance' => "{$m['pitch']} m",
            'Power Consumption' => "Max {$m['power'][0]} W/m² · Avg {$m['power'][1]} W/m²",
            'Input Voltage' => 'AC 100–240 V, 50/60 Hz',
            'Maintenance' => $m['service'],
            'Ingress Protection' => $m['env'] === 'outdoor' ? 'IP65 front / IP54 rear' : 'IP30',
            'Operating Temperature' => $m['env'] === 'outdoor' ? '-20 °C to +50 °C' : '-10 °C to +40 °C',
            'Control System' => 'Synchronous / asynchronous (NovaStar compatible)',
            'Lifetime' => '100,000 hours',
            'Pricing' => 'Per sq ft of LED panel (controller, structure & installation quoted separately)',
        ];
    }

    private function features(array $m): array
    {
        $shared = [
            ['icon' => 'scan', 'title' => "P{$m['pitch']} Pixel Pitch", 'description' => "Seamless from {$m['pitch']} m, best from " . ($m['pitch'] * 3) . ' m away.'],
            ['icon' => 'sun', 'title' => number_format($m['nits']) . ' nits Brightness', 'description' => $m['env'] === 'outdoor' ? 'Sunlight-readable, with auto-dimming at night.' : 'Vivid in bright rooms without glare.'],
            ['icon' => 'video', 'title' => "{$m['refresh']} Refresh", 'description' => 'Smooth, flicker-free video on cameras and broadcast.'],
        ];

        $specific = $m['env'] === 'outdoor'
            ? [['icon' => 'cloud-rain', 'title' => 'IP65 Weatherproof', 'description' => 'Sealed against monsoon rain and dust.']]
            : [['icon' => 'eye', 'title' => "{$m['angle'][0]}° Viewing Angle", 'description' => 'Even colour and brightness from every seat.']];

        $build = $m['rental']
            ? [['icon' => 'boxes', 'title' => 'Tool-less Rental Cabinets', 'description' => 'Quick-lock die-cast frames for fast build and strike.']]
            : [['icon' => 'wrench', 'title' => $m['service'], 'description' => 'Swap a module in minutes without dismantling the wall.']];

        return array_merge($shared, $specific, $build, [
            ['icon' => 'ruler', 'title' => 'Built to Your Size', 'description' => 'Any width and height — plan it with the LED Wall Calculator.'],
        ]);
    }

    /**
     * Yara LED range. Module / cabinet figures follow common industry standards for each pitch
     * (320×160 mm fixed modules, 250×250 mm rental modules). Prices are indicative per sq ft.
     */
    private function models(): array
    {
        $indoorCab = [640, 480, 68, 7.5, 'Die-cast aluminium'];
        $outdoorCab = [960, 960, 120, 26, 'Aluminium, IP65 sealed'];

        return [
            ['sku' => 'YE-LED-P125-IN', 'model' => 'YE-LED-P1.25-IN', 'asset' => 'p1-25-indoor', 'pitch' => 1.25, 'env' => 'indoor', 'rental' => false,
                'ideal' => 'boardrooms, control rooms and TV studios', 'module_w' => 320, 'module_h' => 160, 'px_w' => 256, 'px_h' => 128,
                'nits' => 600, 'refresh' => '3840 Hz', 'scan' => '1/64', 'angle' => [160, 140], 'service' => 'Front maintenance',
                'power' => [480, 160], 'module_kg' => 0.45, 'led' => '1R1G1B', 'led_type' => 'SMD 1010 black-face',
                'cabinet' => $indoorCab, 'price' => 4950, 'sale_price' => 4250],
            ['sku' => 'YE-LED-P153-IN', 'model' => 'YE-LED-P1.53-IN', 'asset' => 'p1-53-indoor', 'pitch' => 1.53, 'env' => 'indoor', 'rental' => false,
                'ideal' => 'corporate lobbies, studios and experience centres', 'module_w' => 320, 'module_h' => 160, 'px_w' => 208, 'px_h' => 104,
                'nits' => 600, 'refresh' => '3840 Hz', 'scan' => '1/52', 'angle' => [160, 140], 'service' => 'Front maintenance',
                'power' => [450, 150], 'module_kg' => 0.45, 'led' => '1R1G1B', 'led_type' => 'SMD 1212 black-face',
                'cabinet' => $indoorCab, 'price' => 3650, 'sale_price' => 3150],
            ['sku' => 'YE-LED-P186-IN', 'model' => 'YE-LED-P1.86-IN', 'asset' => 'p1-86-indoor', 'pitch' => 1.86, 'env' => 'indoor', 'rental' => false,
                'ideal' => 'conference rooms, training halls and showrooms', 'module_w' => 320, 'module_h' => 160, 'px_w' => 172, 'px_h' => 86,
                'nits' => 700, 'refresh' => '3840 Hz', 'scan' => '1/43', 'angle' => [160, 140], 'service' => 'Front maintenance',
                'power' => [450, 150], 'module_kg' => 0.42, 'led' => '1R1G1B', 'led_type' => 'SMD 1515 black-face',
                'cabinet' => $indoorCab, 'price' => 2550, 'sale_price' => 2190],
            ['sku' => 'YE-LED-P25-IN', 'model' => 'YE-LED-P2.5-IN', 'asset' => 'p2-5-indoor', 'pitch' => 2.5, 'env' => 'indoor', 'rental' => false,
                'ideal' => 'retail stores, malls, auditoriums and places of worship', 'module_w' => 320, 'module_h' => 160, 'px_w' => 128, 'px_h' => 64,
                'nits' => 800, 'refresh' => '3840 Hz', 'scan' => '1/32', 'angle' => [160, 140], 'service' => 'Front maintenance',
                'power' => [400, 130], 'module_kg' => 0.4, 'led' => '1R1G1B', 'led_type' => 'SMD 2121',
                'cabinet' => $indoorCab, 'price' => 1450, 'sale_price' => 1190],
            ['sku' => 'YE-LED-P26-IR', 'model' => 'YE-LED-P2.6-IR', 'asset' => 'p2-6-indoor-rental', 'pitch' => 2.6, 'env' => 'indoor', 'rental' => true,
                'ideal' => 'events, weddings, conferences and stage backdrops', 'module_w' => 250, 'module_h' => 250, 'px_w' => 96, 'px_h' => 96,
                'nits' => 900, 'refresh' => '3840 Hz', 'scan' => '1/32', 'angle' => [160, 140], 'service' => 'Front & rear maintenance',
                'power' => [500, 170], 'module_kg' => 0.5, 'led' => '1R1G1B', 'led_type' => 'SMD 2121',
                'cabinet' => [500, 500, 80, 7.5, 'Die-cast aluminium'], 'price' => 1950, 'sale_price' => 1690],
            ['sku' => 'YE-LED-P391-OR', 'model' => 'YE-LED-P3.91-OR', 'asset' => 'p3-91-outdoor-rental', 'pitch' => 3.91, 'env' => 'outdoor', 'rental' => true,
                'ideal' => 'concerts, sports events, rallies and open-air stages', 'module_w' => 250, 'module_h' => 250, 'px_w' => 64, 'px_h' => 64,
                'nits' => 4500, 'refresh' => '3840 Hz', 'scan' => '1/16', 'angle' => [140, 120], 'service' => 'Front & rear maintenance',
                'power' => [700, 240], 'module_kg' => 0.6, 'led' => '1R1G1B', 'led_type' => 'SMD 1921',
                'cabinet' => [500, 1000, 85, 12, 'Die-cast aluminium, IP65'], 'price' => 2450, 'sale_price' => 2090],
            ['sku' => 'YE-LED-P4-OUT', 'model' => 'YE-LED-P4-OUT', 'asset' => 'p4-outdoor', 'pitch' => 4, 'env' => 'outdoor', 'rental' => false,
                'ideal' => 'storefronts, building facades and mall exteriors', 'module_w' => 320, 'module_h' => 160, 'px_w' => 80, 'px_h' => 40,
                'nits' => 5500, 'refresh' => '3840 Hz', 'scan' => '1/10', 'angle' => [140, 120], 'service' => 'Front maintenance',
                'power' => [750, 250], 'module_kg' => 0.5, 'led' => '1R1G1B', 'led_type' => 'SMD 1921',
                'cabinet' => $outdoorCab, 'price' => 2050, 'sale_price' => 1750],
            ['sku' => 'YE-LED-P5-OUT', 'model' => 'YE-LED-P5-OUT', 'asset' => 'p5-outdoor', 'pitch' => 5, 'env' => 'outdoor', 'rental' => false,
                'ideal' => 'campuses, showrooms, hospitals and township gates', 'module_w' => 320, 'module_h' => 160, 'px_w' => 64, 'px_h' => 32,
                'nits' => 6000, 'refresh' => '1920 Hz', 'scan' => '1/8', 'angle' => [140, 120], 'service' => 'Front maintenance',
                'power' => [700, 230], 'module_kg' => 0.5, 'led' => '1R1G1B', 'led_type' => 'SMD 2727',
                'cabinet' => $outdoorCab, 'price' => 1690, 'sale_price' => 1450],
            ['sku' => 'YE-LED-P8-OUT', 'model' => 'YE-LED-P8-OUT', 'asset' => 'p8-outdoor', 'pitch' => 8, 'env' => 'outdoor', 'rental' => false,
                'ideal' => 'roadside billboards and junction advertising', 'module_w' => 320, 'module_h' => 160, 'px_w' => 40, 'px_h' => 20,
                'nits' => 6500, 'refresh' => '1920 Hz', 'scan' => '1/4', 'angle' => [140, 120], 'service' => 'Rear maintenance',
                'power' => [650, 220], 'module_kg' => 0.55, 'led' => '1R1G1B', 'led_type' => 'SMD 3535',
                'cabinet' => $outdoorCab, 'price' => 1250, 'sale_price' => 1050],
            ['sku' => 'YE-LED-P10-OUT', 'model' => 'YE-LED-P10-OUT', 'asset' => 'p10-outdoor', 'pitch' => 10, 'env' => 'outdoor', 'rental' => false,
                'ideal' => 'highway hoardings, stadium scoreboards and large facades', 'module_w' => 320, 'module_h' => 160, 'px_w' => 32, 'px_h' => 16,
                'nits' => 7000, 'refresh' => '1920 Hz', 'scan' => '1/2', 'angle' => [140, 120], 'service' => 'Rear maintenance',
                'power' => [600, 200], 'module_kg' => 0.55, 'led' => '1R1G1B', 'led_type' => 'SMD 3535',
                'cabinet' => $outdoorCab, 'price' => 990, 'sale_price' => 850],
        ];
    }
}
