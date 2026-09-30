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
 * Commercial Display Solutions → T-Standees: categories, 55" / 65" / 75" products,
 * location posters and the hero banner.
 *
 * Images are copied from database/seeders/assets/t-standees.
 * Idempotent: re-running updates the same records.
 *
 * php artisan db:seed --class=TStandeeSeeder
 */
class TStandeeSeeder extends Seeder
{
    private const ASSETS = __DIR__ . '/assets/t-standees';

    public function run(): void
    {
        // Images used directly by the /t-standees explore page.
        foreach (['t-standee-trio.png', 'standee-car.png', 'poster-mall.jpg', 'poster-fashion.jpg', 'poster-auto.jpg', 'poster-lobby.jpg', 't-standee-angle.jpg',
            'screen-sale.jpg', 'screen-fashion.jpg', 'screen-fashion-red.jpg', 'screen-bike.jpg', 'screen-bike-red.jpg', 'screen-car.jpg', 'screen-lake.jpg'] as $file) {
            $this->publish($file, "products/t-standees/{$file}");
        }

        $banner = $this->publish('category-banner.jpg', 'categories/banners/t-standees-banner.jpg');

        $parent = Category::updateOrCreate(
            ['slug' => 'commercial-display-solutions'],
            [
                'parent_id' => null,
                'name' => 'Commercial Display Solutions',
                'description' => 'Digital signage for business: T-Standees and display solutions for malls, showrooms, lobbies and retail.',
                'image' => $this->publish('poster-auto.jpg', 'categories/commercial-display-solutions.jpg'),
                'banner' => $banner,
                'status' => true,
                'sort_order' => Category::where('slug', 'commercial-display-solutions')->value('sort_order')
                    ?? (Category::whereNull('parent_id')->max('sort_order') + 1),
            ],
        );

        $category = Category::updateOrCreate(
            ['slug' => 't-standees'],
            [
                'parent_id' => $parent->id,
                'name' => 'T-Standees',
                'description' => 'Floor-standing digital standees in 55", 65" and 75": eye-catching portrait displays for promotions, catalogues and wayfinding.',
                'image' => $this->publish('poster-mall.jpg', 'categories/t-standees.jpg'),
                'banner' => $banner,
                'status' => true,
                'sort_order' => 1,
            ],
        );

        $models = [
            55 => ['ideal' => 'store entrances, boutiques and reception areas', 'posters' => ['poster-fashion.jpg', 'poster-lobby.jpg'], 'featured' => false],
            65 => ['ideal' => 'malls, supermarkets and showroom floors', 'posters' => ['poster-mall.jpg', 'poster-auto.jpg'], 'featured' => true],
            75 => ['ideal' => 'large showrooms, atriums and airport-style spaces', 'posters' => ['poster-auto.jpg', 'poster-mall.jpg'], 'featured' => false],
        ];

        $sizeAttribute = Attribute::where('slug', 'size')->first();

        foreach ($models as $inch => $model) {
            $product = Product::updateOrCreate(
                ['sku' => "YE-TST-{$inch}"],
                [
                    'category_id' => $category->id,
                    'name' => "Yara {$inch}\" T-Standee Digital Signage",
                    'slug' => "yara-{$inch}-inch-t-standee",
                    'model_number' => "YE-TST-{$inch}",
                    'brand' => 'Yara',
                    'short_description' => "{$inch}\" floor-standing digital standee for {$model['ideal']}.",
                    'description' => "The Yara {$inch}\" T-Standee turns any floor space into a bright, eye-catching digital billboard. "
                        . "Its slim portrait display plays your images, videos and offers all day, perfect for {$model['ideal']}.\n\n"
                        . 'Update content in minutes, choose touch or non-touch, and add your own branding. '
                        . 'The sturdy weighted base lets you place it anywhere and move it whenever your layout changes.',
                    'price' => 0, // Price on request
                    'sale_price' => null,
                    'stock_quantity' => 5,
                    'specifications' => [
                        'Screen Size' => "{$inch} inch",
                        'Orientation' => 'Portrait',
                        'Form Factor' => 'Floor-standing T-Standee',
                        'Display' => 'Commercial-grade LED-backlit panel',
                        'Content' => 'Images, videos & promotions',
                        'Touch' => 'Touch & non-touch options',
                        'Media Player' => 'Built-in',
                        'Base' => 'Weighted, freestanding',
                        'Branding' => 'Custom content & branding',
                        'Technical Data' => 'Resolution, brightness & ports on request',
                    ],
                    'status' => true,
                    'featured' => $model['featured'],
                    'sort_order' => $inch,
                    'meta_title' => "Yara {$inch} inch T-Standee | Digital Signage Standee",
                    'meta_description' => "Yara {$inch}\" T-Standee digital signage for {$model['ideal']}. Portrait display, touch & non-touch options, custom branding.",
                ],
            );

            $gallery = [
                "t-standee-{$inch}.jpg" => "Yara {$inch}\" T-Standee",
                't-standee-angle.jpg' => "Yara {$inch}\" T-Standee, side view",
                $model['posters'][0] => "Yara {$inch}\" T-Standee in use",
                $model['posters'][1] => "Yara {$inch}\" T-Standee in use",
            ];

            $keep = [];
            foreach (array_keys($gallery) as $order => $file) {
                $path = $this->publish($file, "products/t-standees/{$file}");
                $keep[] = $path;
                $product->images()->updateOrCreate(
                    ['image' => $path],
                    ['alt_text' => $gallery[$file], 'sort_order' => $order, 'is_primary' => $order === 0],
                );
            }
            $product->images()->whereNotIn('image', $keep)->delete();

            $product->features()->delete();
            $product->features()->createMany(collect([
                ['icon' => 'monitor-smartphone', 'title' => 'Eye-Catching Portrait Display', 'description' => 'A tall, bright screen that draws attention from across the floor.'],
                ['icon' => 'refresh-cw', 'title' => 'Easy Content Updates', 'description' => 'Change offers, videos and menus in minutes.'],
                ['icon' => 'pointer', 'title' => 'Touch or Non-Touch', 'description' => 'Interactive catalogues and wayfinding, or simple playback.'],
                ['icon' => 'shield-check', 'title' => 'Slim & Sturdy', 'description' => 'Commercial-grade build on a stable weighted base.'],
                ['icon' => 'stamp', 'title' => 'Your Branding', 'description' => 'Custom content and branding for your business.'],
                ['icon' => 'map-pin', 'title' => 'Place It Anywhere', 'description' => 'Malls, showrooms, lobbies, restaurants and events.'],
            ])->map(fn ($f, $i) => $f + ['sort_order' => $i])->all());

            if ($sizeAttribute) {
                $value = AttributeValue::firstOrCreate(['attribute_id' => $sizeAttribute->id, 'value' => "{$inch}\""], ['sort_order' => $inch]);
                $product->attributeValues()->syncWithoutDetaching([$value->id]);
            }
        }

        // Hero banner: third slide, after the Centum and Chillers.
        $bannerPath = $this->publish('t-standee-banner.jpg', 'banners/t-standees-hero.jpg');
        $slide = Banner::firstOrNew(['image' => $bannerPath]);

        if (! $slide->exists) {
            Banner::where('sort_order', '>=', 2)->increment('sort_order');
        }

        $slide->fill([
            'title' => 'Yara T-Standees',
            'subtitle' => '55" · 65" · 75" Digital Signage',
            'button_text' => 'Explore T-Standees',
            'button_link' => '/t-standees',
            'sort_order' => 2,
            'status' => true,
        ])->save();
    }

    private function publish(string $asset, string $target): string
    {
        Storage::disk('public')->put($target, file_get_contents(self::ASSETS . '/' . $asset));

        return $target;
    }
}
