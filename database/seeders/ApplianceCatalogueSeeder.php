<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Yara TV, air-conditioner and washing-machine range from the 2026 specification sheets.
 *
 *  - Televisions: Anti-Glare, Google, QLED, Mini QLED, Smart and Non-Smart sub-categories (49 models)
 *  - Air Conditioners: Inverter AC sub-category (9 models; tonnage and star rating are filters)
 *  - Washing Machines: Fully Automatic, Semi Automatic and Only Washer sub-categories (17 models)
 *
 * Product data comes from database/seeders/data/appliances.json (parsed from the sheets); images from
 * database/seeders/assets/{televisions,air-conditioners,washing-machines}. Idempotent: matched by SKU / slug.
 *
 *   php artisan db:seed --class=ApplianceCatalogueSeeder
 */
class ApplianceCatalogueSeeder extends Seeder
{
    private const ASSETS = __DIR__ . '/assets';

    private array $attributes = [];

    public function run(): void
    {
        $data = json_decode(file_get_contents(__DIR__ . '/data/appliances.json'), true);
        $tvImages = json_decode(file_get_contents(self::ASSETS . '/televisions/images.json'), true);
        $applianceImages = json_decode(file_get_contents(self::ASSETS . '/appliance-images.json'), true);

        DB::transaction(function () use ($data, $tvImages, $applianceImages) {
            $this->publishDir('televisions/anti-glare', 'products/televisions/anti-glare');

            $categories = $this->seedCategories();

            foreach ($data['tv'] as $i => $tv) {
                $product = $this->seedProduct($categories[$tv['category']], $tv, $i, $this->tvDescription($tv),
                    collect($tvImages[$tv['model']] ?? [])->map(fn ($f) => ['televisions/' . $f, 'products/televisions/' . basename($f)])->all());
                $this->tag($product, [
                    ['size', 'Size', "{$tv['inch']}\"", $tv['inch']],
                    ['resolution', 'Resolution', $tv['resolution'], ['HD' => 0, 'Full HD' => 1, '4K UHD' => 2][$tv['resolution']]],
                ]);
            }

            foreach ($data['ac'] as $i => $ac) {
                $product = $this->seedProduct($categories['inverter-ac'], $ac, $i, $this->acDescription($ac),
                    collect($applianceImages['ac'][$ac['model']] ?? [])->map(fn ($f) => ["air-conditioners/products/{$f}", "products/air-conditioners/{$f}"])->all());
                $this->tag($product, [
                    ['energy-rating', 'Energy Rating', "{$ac['star']} Star", $ac['star']],
                    ['ac-capacity', 'Capacity', $ac['ton'], (int) round((float) $ac['ton'] * 10)],
                ]);
            }

            foreach ($data['wm'] as $i => $wm) {
                $product = $this->seedProduct($categories[$wm['category']], $wm, $i, $this->wmDescription($wm),
                    collect($applianceImages['wm'][$wm['model']] ?? [])->map(fn ($f) => ["washing-machines/products/{$f}", "products/washing-machines/{$f}"])->all());
                $this->tag($product, [
                    ['capacity', 'Capacity', "{$wm['capacity']} kg", (int) round((float) $wm['capacity'] * 10)],
                    ['loading', 'Loading', str_starts_with($wm['load'], 'Front') ? 'Front Load' : 'Top Load', str_starts_with($wm['load'], 'Front') ? 1 : 0],
                ]);
            }

            $this->seedHomeBanner();
        });
    }

    // ------------------------------------------------------------------ categories

    private function seedCategories(): array
    {
        $tv = Category::firstOrCreate(['slug' => 'televisions'], ['name' => 'Televisions', 'status' => true, 'sort_order' => 0]);
        if (blank($tv->description) || $tv->description === 'televisions') {
            $tv->update(['description' => 'Yara TVs from 24" to 100": Anti-Glare QLED, Google TV, QLED, Mini QLED, Smart and Non-Smart LED TVs.']);
        }
        $wm = Category::firstOrCreate(['slug' => 'washing-machine'], ['name' => 'Washing Machine', 'status' => true, 'sort_order' => 1]);
        if (blank($wm->description) || $wm->description === 'Washing Machines') {
            $wm->update(['description' => 'Yara washing machines from 6.5 kg to 11 kg: fully automatic front load and top load, semi automatic twin tubs and compact wash-only models.']);
        }
        $ac = Category::firstOrCreate(['slug' => 'air-conditioners'], ['name' => 'Air Conditioners', 'status' => true, 'sort_order' => 1]);

        $defs = [
            // slug => [parent, name, description, art folder, sort]
            'anti-glare-tv' => [$tv, 'Anti-Glare TV', 'Anti-glare QLED TVs in 65", 75", 86" and 100": a matte, anti-reflective screen that stays clear in bright rooms.', 'televisions', 0],
            'google-tv' => [$tv, 'Google TV', 'Yara Google TVs in HD, Full HD and 4K UHD, with Google Play, Chromecast built-in and voice search.', 'televisions', 1],
            'qled-tv' => [$tv, 'QLED TV', 'Quantum-dot QLED TVs from 32" to 85" with over a billion colours and Dolby Audio.', 'televisions', 2],
            'mini-qled-tv' => [$tv, 'Mini QLED TV', 'Flagship Mini QLED Google TVs in 75", 86" and 100", up to 700 nits and 10,000:1 contrast.', 'televisions', 3],
            'smart-tv' => [$tv, 'Smart TV', 'Yara Smart LED TVs from 32" to 98", with streaming apps, screen casting and voice control.', 'televisions', 4],
            'non-smart-tv' => [$tv, 'Non Smart TV', 'Simple plug-and-play HD LED TVs in 24" and 32" with HDMI and USB media playback.', 'televisions', 5],
            'fully_automatic' => [$wm, 'Fully Automatic', 'Fully automatic top-load and front-load washing machines from 6.5 kg to 10 kg.', null, 0],
            'semi-automatic' => [$wm, 'Semi Automatic', 'Semi-automatic twin-tub washing machines from 7 kg to 11 kg, with separate wash and spin tubs.', 'washing-machines', 1],
            'only-washer' => [$wm, 'Only Washer', 'Compact wash-only machines for small homes, paired with any spin dryer.', 'washing-machines', 2],
            'inverter-ac' => [$ac, 'Inverter AC', 'Yara inverter split ACs in 1, 1.5 and 2 ton, 3 star and 5 star: steady cooling, lower bills, 100% copper coils and R-32 refrigerant.', 'air-conditioners', 0],
        ];

        $out = [];
        foreach ($defs as $slug => [$parent, $name, $description, $art, $sort]) {
            $category = Category::firstOrNew(['slug' => $slug]);
            $category->fill(['parent_id' => $parent->id, 'name' => $category->name ?: $name, 'description' => $description, 'status' => true, 'sort_order' => $sort]);
            if ($art) {
                $category->image = $this->publish("{$art}/category-{$slug}.jpg", "categories/{$slug}.jpg");
                $category->banner = $this->publish("{$art}/banner-{$slug}.jpg", "categories/banners/{$slug}-banner.jpg");
            }
            $category->save();
            $out[$slug] = $category;
        }

        // The ACs used to be split by tonnage; they now live in Inverter AC (tonnage and star rating are filters).
        // The old pages stay switched off and redirect (routes/web.php).
        Category::whereIn('slug', ['1-ton-ac', '1-5-ton-ac', '2-ton-ac'])->update(['status' => false]);

        // Parent TV category art only when an admin hasn't uploaded their own.
        if (blank($tv->image)) {
            $tv->update([
                'image' => $this->publish('televisions/category-televisions.jpg', 'categories/televisions.jpg'),
                'banner' => $this->publish('televisions/banner-televisions.jpg', 'categories/banners/televisions-banner.jpg'),
            ]);
        }

        return $out;
    }

    // ------------------------------------------------------------------ products

    private function seedProduct(Category $category, array $p, int $index, string $description, array $images): Product
    {
        $name = $p['name'];

        $product = Product::updateOrCreate(
            ['sku' => $p['sku']],
            [
                'category_id' => $category->id,
                'name' => $name,
                // Pinned in the JSON: names no longer include the OS, so several models share one and the
                // name can't produce a unique slug (and existing product URLs must not change).
                'slug' => $p['slug'] ?? Str::slug(str_replace(['"', '.', '·'], [' inch', '-', ' '], $name)),
                'model_number' => $p['model'],
                'brand' => 'Yara',
                'short_description' => $p['short'],
                'description' => $description,
                'price' => $p['mrp'],
                'sale_price' => null,
                'stock_quantity' => 20,
                'specifications' => $p['specs'],
                'status' => true,
                'featured' => in_array($p['sku'], Product::ANTI_GLARE_SKUS, true) || in_array($p['model'], ['55SU23G', '65SQ24G', '75SQM25G', 'AS185PD25E', 'WF80J1GB', 'WA85K1BS'], true),
                'sort_order' => $index,
                'meta_title' => Str::limit("{$name} | Yara", 250, ''),
                'meta_description' => Str::limit($p['short'] . ' MRP ₹' . number_format($p['mrp']) . '.', 300),
            ],
        );

        $keep = [];
        foreach ($images as $order => [$asset, $target]) {
            $path = $this->publish($asset, $target);
            $keep[] = $path;
            $product->images()->updateOrCreate(
                ['image' => $path],
                ['alt_text' => str_replace(" ({$p['model']})", '', $name) . $this->imageLabel($asset), 'sort_order' => $order, 'is_primary' => $order === 0],
            );
        }
        $product->images()->whereNotIn('image', $keep)->delete();

        $product->features()->delete();
        $product->features()->createMany(
            collect($p['features'])->map(fn ($f, $i) => ['icon' => $f[0], 'title' => $f[1], 'description' => $f[2], 'sort_order' => $i])->all(),
        );

        return $product;
    }

    private function imageLabel(string $asset): string
    {
        return match (true) {
            str_contains($asset, '-info') => ' — key features',
            str_contains($asset, '-antiglare') => ' — glossy vs anti-glare screen',
            str_contains($asset, '-indoor') => ' — indoor unit',
            str_contains($asset, '-outdoor') => ' — outdoor unit',
            str_contains($asset, '-highlights') => ' — highlights',
            str_contains($asset, '-front') => ' — front view',
            default => '',
        };
    }

    /** Attach filter values (attribute slug, attribute name, value, sort). */
    private function tag(Product $product, array $values): void
    {
        $ids = [];
        foreach ($values as [$slug, $name, $value, $sort]) {
            $attribute = $this->attributes[$slug] ??= Attribute::firstOrCreate(['slug' => $slug], ['name' => $name, 'sort_order' => 20 + count($this->attributes)]);
            $ids[] = AttributeValue::firstOrCreate(['attribute_id' => $attribute->id, 'value' => $value], ['sort_order' => $sort])->id;
        }
        $product->attributeValues()->syncWithoutDetaching($ids);
    }

    // ------------------------------------------------------------------ descriptions

    private function tvDescription(array $t): string
    {
        $s = $t['specs'];
        $title = str_replace(" ({$t['model']})", '', $t['name']);
        $lines = [];

        $lines[] = "The {$title} brings " . match ($t['resolution']) {
            '4K UHD' => 'crisp 4K Ultra HD (3840 × 2160) detail',
            'Full HD' => 'sharp Full HD (1920 × 1080) pictures',
            default => 'clear HD (1280 × 720) pictures',
        } . ' to your home, with ' . ($s['Display Colours'] ?? '16.7 million') . ' colours, ' . ($s['Contrast Ratio'] ?? '') . ' contrast and ' . ($s['Viewing Angle'] ?? 'wide') . ' viewing angles'
            . ($t['mini'] ? ', powered by a Mini QLED backlight for deeper blacks and brighter highlights.' : ($t['qled'] ? ', with quantum-dot QLED colour that stays rich and vivid.' : '.'));

        if ($t['anti_glare']) {
            $lines[] = 'Its anti-glare, anti-reflective matte screen scatters light from windows and lamps into a soft, even haze instead of a mirror image, so the picture stays clear in bright living rooms, daytime sport and offices, and is easier on the eyes.';
        }

        $lines[] = $t['smart']
            ? ($t['google'] ? 'Google TV' : 'The smart platform') . (! empty($s['Operating System']) ? " ({$s['Operating System']})" : '') . ' puts ' . ($s['Apps & Casting'] ?? 'your favourite apps') . ' a click away'
                . ($t['voice'] ? ', and the voice remote lets you search and play just by speaking.' : '.')
            : 'No setup needed: plug in your set-top box or play movies and music straight from a USB drive.';

        $lines[] = "{$t['watts']}W " . ($t['dolby'] ? 'Dolby Audio' : 'stereo') . ' sound (' . ($s['Audio Output'] ?? '') . ') fills the room'
            . (! empty($s['HDR']) ? ", and {$s['HDR']} support lifts every HDR scene." : '.')
            . ' Connect everything with ' . collect(['HDMI' => 'HDMI', 'USB' => 'USB', 'Optical Audio Out' => 'optical', 'LAN (RJ45)' => 'LAN'])->filter(fn ($l, $k) => ! empty($s[$k]))->implode(', ')
            . (! empty($s['Wi-Fi']) ? ', Wi-Fi' : '') . (! empty($s['Bluetooth']) ? ' and Bluetooth' : '') . '.';

        return implode("\n\n", $lines);
    }

    private function acDescription(array $a): string
    {
        $s = $a['specs'];
        $title = str_replace(" ({$a['model']})", '', $a['name']);

        return implode("\n\n", [
            "The {$title} cools fast and runs efficiently: its high-performance inverter compressor adjusts speed to the room, so the temperature stays steady and the bills stay low. It is BEE {$a['star']}-star rated with an ISEER of {$a['iseer']}.",
            'A 100% copper condenser coil with Bluefin anti-corrosion fins lasts longer in coastal and humid weather, and eco-friendly R-32 refrigerant cools efficiently. The PM 2.5 filter traps fine dust for cleaner air.',
            'BLDC fan motors keep it quiet' . (! empty($s['Air Circulation']) ? " while moving up to {$s['Air Circulation']}" : '') . ', and the ' . str_replace('Display', 'display', $a['display']) . ' shows the set temperature at a glance'
                . (! empty($s['Modes']) ? '. Modes: ' . strtolower($s['Modes']) . '.' : '.'),
        ]);
    }

    private function wmDescription(array $w): string
    {
        $title = str_replace(" ({$w['model']})", '', $w['name']);

        return implode("\n\n", array_filter([
            "The {$title} handles {$w['capacity']} kg of laundry per wash. " . match ($w['kind']) {
                'Fully Automatic Front Load' => 'Its gentle tumble action cleans thoroughly while using less water and detergent, and the BLDC inverter motor spins at up to ' . ($w['specs']['Spin Speed'] ?? '') . '.',
                'Fully Automatic Top Load' => 'Load it, choose a programme and walk away: it fills, washes, rinses and spins by itself in a hygienic stainless steel drum.',
                'Semi Automatic Top Load' => 'Separate wash and spin tubs let you wash one load while the previous one spins dry, with simple timer knobs anyone can use.',
                default => 'A simple, compact wash-only machine for small homes and hostels, easy to pair with a spin dryer.',
            },
            ! empty($w['specs']['Features']) ? 'Features: ' . strtolower($w['specs']['Features']) . '.' : null,
            "Finished in {$w['colour']}" . (! empty($w['specs']['Cabinet']) ? ' with a ' . str_replace('Stainless Steel', 'stainless steel', $w['specs']['Cabinet']) . ' cabinet' : '') . '.',
        ]));
    }

    // ------------------------------------------------------------------ banner & files

    private function seedHomeBanner(): void
    {
        $path = $this->publish('televisions/home-banner-anti-glare.jpg', 'banners/anti-glare-tv-hero.jpg');
        $slide = Banner::firstOrNew(['image' => $path]);

        if (! $slide->exists) {
            Banner::where('sort_order', '>=', 1)->increment('sort_order');
            $slide->sort_order = 1;
        }

        $slide->fill([
            'title' => 'Anti-Glare QLED TVs',
            'subtitle' => 'New · 65" to 100" · No reflections, even in daylight',
            'button_text' => 'See the difference',
            'button_link' => '/anti-glare-tv',
            'status' => true,
        ])->save();
    }

    private function publishDir(string $from, string $to): void
    {
        foreach (glob(self::ASSETS . "/{$from}/*.{png,jpg}", GLOB_BRACE) as $file) {
            Storage::disk('public')->put("{$to}/" . basename($file), file_get_contents($file));
        }
    }

    private function publish(string $asset, string $target): string
    {
        Storage::disk('public')->put($target, file_get_contents(self::ASSETS . '/' . $asset));

        return $target;
    }
}
