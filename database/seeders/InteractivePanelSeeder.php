<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Interactive Panels category with the 55" – 98" Yara Interactive Flat Panel range,
 * product galleries, highlight features, category artwork and a home hero banner.
 *
 * Idempotent: re-running updates the same records (matched by slug / SKU / image path).
 * Images are copied from database/seeders/assets/interactive-panels to the public disk.
 *
 *   php artisan db:seed --class=InteractivePanelSeeder
 */
class InteractivePanelSeeder extends Seeder
{
    private const ASSETS = __DIR__ . '/assets/interactive-panels';

    public function run(): void
    {
        DB::transaction(function () {
            $category = $this->seedCategory();

            foreach ($this->models() as $index => $model) {
                $this->seedProduct($category, $model, $index);
            }

            $this->seedHomeBanner();
        });
    }

    private function seedCategory(): Category
    {
        return Category::updateOrCreate(
            ['slug' => 'interactive-panels'],
            [
                'parent_id' => null,
                'name' => 'Interactive Panels',
                'description' => 'Yara Interactive Flat Panels in 55" to 98" — 4K UHD, 20-point touch and Android 14 built in. '
                    . 'Made for smart classrooms, boardrooms and training spaces.',
                'image' => $this->publish('category-card.jpg', 'categories/interactive-panels.jpg'),
                'banner' => $this->publish('category-banner.jpg', 'categories/banners/interactive-panels-banner.jpg'),
                'status' => true,
                'sort_order' => 2,
            ],
        );
    }

    private function seedProduct(Category $category, array $model, int $index): void
    {
        $inch = $model['inch'];

        $product = Product::updateOrCreate(
            ['sku' => "YE-IFP-{$inch}"],
            [
                'category_id' => $category->id,
                'name' => "Yara {$inch}\" 4K Interactive Flat Panel",
                'slug' => "yara-{$inch}-inch-4k-interactive-flat-panel",
                'model_number' => "YE-IFP{$inch}-A14",
                'brand' => 'Yara',
                'short_description' => "{$inch}\" 4K UHD interactive display with 20-point touch, Android 14 and wireless screen sharing — {$model['ideal']}.",
                'description' => $this->description($inch, $model['ideal']),
                'price' => $model['price'],
                'sale_price' => $model['sale_price'],
                'stock_quantity' => 10,
                'warranty_months' => 36,
                'specifications' => $this->specifications($model),
                'status' => true,
                'featured' => in_array($inch, [65, 75], true),
                'sort_order' => $index,
                'meta_title' => "Yara {$inch} inch 4K Interactive Flat Panel | Smart Board for Classrooms & Boardrooms",
                'meta_description' => "Buy the Yara {$inch}\" 4K Interactive Flat Panel — 20-point touch, Android 14, 8GB/128GB, "
                    . 'anti-glare glass and wireless screen sharing. Free installation and 3-year warranty.',
            ],
        );

        $gallery = [
            'front' => "Yara {$inch}\" Interactive Flat Panel — front view",
            'angle' => "Yara {$inch}\" Interactive Flat Panel — side angle",
            'stand' => "Yara {$inch}\" Interactive Flat Panel on mobile trolley stand",
            'highlights' => "Yara {$inch}\" Interactive Flat Panel — key highlights",
            'ports' => "Yara {$inch}\" Interactive Flat Panel — front connectivity",
        ];

        $keep = [];

        foreach (array_keys($gallery) as $order => $view) {
            $path = $this->publish("products/yara-ifp-{$inch}-{$view}.jpg", "products/interactive-panels/yara-ifp-{$inch}-{$view}.jpg");
            $keep[] = $path;

            $product->images()->updateOrCreate(
                ['image' => $path],
                ['alt_text' => $gallery[$view], 'sort_order' => $order, 'is_primary' => $order === 0],
            );
        }

        $product->images()->whereNotIn('image', $keep)->where('image', 'like', 'products/interactive-panels/%')->delete();

        $product->features()->delete();
        $product->features()->createMany(
            collect($this->features())->map(fn ($f, $i) => $f + ['sort_order' => $i])->all(),
        );

        $size = AttributeValue::whereHas('attribute', fn ($q) => $q->where('slug', 'size'))
            ->where('value', "{$inch}\"")
            ->first();

        if ($size) {
            $product->attributeValues()->syncWithoutDetaching([$size->id]);
        }
    }

    private function seedHomeBanner(): void
    {
        Banner::updateOrCreate(
            ['image' => $this->publish('home-banner.jpg', 'banners/interactive-panels-hero.jpg')],
            [
                'title' => 'Interactive Flat Panels',
                'subtitle' => 'New · 55" to 98" · 4K Touch',
                'button_text' => 'Explore the Range',
                'button_link' => '/category/interactive-panels',
                'sort_order' => 0,
                'status' => true,
            ],
        );
    }

    /**
     * Copy an asset to the public disk and return its stored path.
     */
    private function publish(string $asset, string $target): string
    {
        Storage::disk('public')->put($target, file_get_contents(self::ASSETS . '/' . $asset));

        return $target;
    }

    private function description(int $inch, string $ideal): string
    {
        return <<<TEXT
        The Yara {$inch}" Interactive Flat Panel brings 4K UHD clarity and ultra-smooth 20-point multi-touch to your {$ideal}. Write, annotate and present naturally with a finger, the magnetic pen or your palm — auto text and auto shape recognition turn rough sketches into clean notes.

        An integrated Android 14 system with a powerful A73 processor, 8 GB RAM and 128 GB storage runs the whiteboard, browser, Google Play apps and built-in PhET simulations without a PC. Need Windows or Linux? Slide an OPS module into the rear slot.

        Share wirelessly from laptops and phones with screen mirroring and reverse mirroring, split the screen for multiple users, and connect over HDMI, USB 3.0, USB-C and LAN. Zero-bonding, 4 mm anti-glare toughened glass and an eye-protective display keep images sharp and comfortable all day.

        Mount it on the wall with the bracket included, or pair it with our mobile trolley stand to move it between rooms.
        TEXT;
    }

    private function specifications(array $m): array
    {
        return [
            'Screen Size' => "{$m['inch']} inch",
            'Display Area' => $m['display_area'] . ' mm',
            'Resolution' => '3840 × 2160 (4K UHD)',
            'Aspect Ratio' => '16:9',
            'Brightness' => $m['brightness'] . ' cd/m²',
            'Contrast Ratio' => '4000:1',
            'Viewing Angle' => '178° (H) / 178° (V)',
            'Backlight' => 'DLED',
            'Touch Technology' => 'Infrared multi-touch',
            'Touch Points' => '20 points',
            'Touch Accuracy' => '± 1 mm',
            'Writing Surface' => '4 mm anti-glare toughened glass',
            'Processor' => 'Quad-core ARM Cortex-A73 with GPU',
            'Operating System' => 'Android 14 (Windows / Linux via OPS)',
            'RAM / Storage' => '8 GB / 128 GB',
            'Camera' => '48 MP AI camera with 8-array mic (optional)',
            'Wi-Fi / Bluetooth' => '2.4G + 5G / v5.2',
            'Speakers' => $m['audio'],
            'Input Ports' => 'HDMI 2.0 × 2, DP × 1, VGA × 1, USB 2.0 / 3.0, USB-C, LAN, RS232, MIC, TF card',
            'Output Ports' => 'HDMI out, Audio out, Coaxial (RCA), Touch USB',
            'OPS Slot' => 'Intel OPS-C, JAE 80-pin',
            'Panel Lifetime' => '50,000 hours',
            'Power' => '100–240 V, 50/60 Hz · ≤ ' . $m['power'] . ' W (standby ≤ 0.5 W)',
            'Dimensions (W × H × D)' => $m['dimensions'] . ' mm',
            'Net / Gross Weight' => $m['weight'],
            'In the Box' => 'Magnetic pen, wall-mount bracket, power cord, remote control',
        ];
    }

    private function features(): array
    {
        return [
            ['icon' => 'monitor', 'title' => '4K Ultra HD Clarity', 'description' => '3840 × 2160 resolution with zero-bonding for crisp text and vivid video.'],
            ['icon' => 'hand', 'title' => '20-Point Multi-Touch', 'description' => 'Ultra-smooth writing with finger, pen or palm — ± 1 mm accuracy.'],
            ['icon' => 'cpu', 'title' => 'Android 14 Built-in', 'description' => 'A73 processor, 8 GB / 128 GB and Google Play — no PC required.'],
            ['icon' => 'cast', 'title' => 'Wireless Screen Sharing', 'description' => 'Mirror and reverse-mirror laptops and phones in seconds.'],
            ['icon' => 'shield-check', 'title' => 'Anti-Glare Toughened Glass', 'description' => '4 mm tempered glass with an eye-protective display.'],
            ['icon' => 'camera', 'title' => '48 MP AI Camera (Optional)', 'description' => 'Built-in camera with 8-array mic for hybrid classes and meetings.'],
        ];
    }

    /**
     * Size-specific figures. 55" – 75" follow the Yara B2B Catalogue 2026; 85" and 98" are scaled from the 86" model.
     */
    private function models(): array
    {
        return [
            ['inch' => 55, 'ideal' => 'classrooms and huddle rooms', 'price' => 125000, 'sale_price' => 98500,
                'display_area' => '1209.6 × 680.4', 'brightness' => 350, 'audio' => '2 × 10 W', 'power' => 150,
                'dimensions' => '1271.9 × 769.1 × 85.5', 'weight' => '26 kg / 35 kg'],
            ['inch' => 65, 'ideal' => 'classrooms and meeting rooms', 'price' => 155000, 'sale_price' => 124900,
                'display_area' => '1428.5 × 803.5', 'brightness' => 350, 'audio' => '2 × 15 W', 'power' => 210,
                'dimensions' => '1485.2 × 890.8 × 97.8', 'weight' => '42 kg / 54 kg'],
            ['inch' => 75, 'ideal' => 'large classrooms and boardrooms', 'price' => 199000, 'sale_price' => 159900,
                'display_area' => '1650.2 × 928.3', 'brightness' => 350, 'audio' => '2 × 15 W', 'power' => 250,
                'dimensions' => '1707.6 × 1016.6 × 97.8', 'weight' => '53 kg / 72.3 kg'],
            ['inch' => 85, 'ideal' => 'boardrooms and training halls', 'price' => 265000, 'sale_price' => 214900,
                'display_area' => '1872.0 × 1053.0', 'brightness' => 450, 'audio' => '2 × 15 W', 'power' => 340,
                'dimensions' => '1930.5 × 1142.0 × 98.0', 'weight' => '60 kg / 86 kg'],
            ['inch' => 98, 'ideal' => 'auditoriums, lecture halls and command centres', 'price' => 475000, 'sale_price' => 389900,
                'display_area' => '2158.8 × 1214.3', 'brightness' => 450, 'audio' => '2 × 20 W', 'power' => 450,
                'dimensions' => '2211.0 × 1283.0 × 98.0', 'weight' => '95 kg / 125 kg'],
        ];
    }
}
