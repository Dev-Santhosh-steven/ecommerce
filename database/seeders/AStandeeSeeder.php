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
 * Commercial Display Solutions → A-Standees: category, 32" / 43" / 55" portable digital posters,
 * location posters and the hero banner.
 *
 * Images are copied from database/seeders/assets/a-standees.
 * Idempotent: re-running updates the same records.
 *
 * php artisan db:seed --class=AStandeeSeeder
 */
class AStandeeSeeder extends Seeder
{
    private const ASSETS = __DIR__ . '/assets/a-standees';

    private const CONTENT = ['perfume-violet', 'perfume-ember', 'berry', 'creative', 'gold'];

    public function run(): void
    {
        // Images used directly by the /a-standees explore page.
        $files = ['a-standee-trio.png', 'poster-mall.jpg', 'poster-beauty.jpg', 'poster-boutique.jpg', 'poster-office.jpg'];
        foreach (self::CONTENT as $name) {
            $files[] = "a-standee-{$name}.png";
            $files[] = "screen-{$name}.jpg";
        }
        foreach ($files as $file) {
            $this->publish($file, "products/a-standees/{$file}");
        }

        $parent = Category::where('slug', 'commercial-display-solutions')->first();

        if (! $parent) {
            $this->call(TStandeeSeeder::class);
            $parent = Category::where('slug', 'commercial-display-solutions')->firstOrFail();
        }

        $category = Category::updateOrCreate(
            ['slug' => 'a-standees'],
            [
                'parent_id' => $parent->id,
                'name' => 'A-Standees',
                'description' => 'Portable A-frame digital posters in 32", 43" and 55": fold, carry and set up anywhere for promotions, launches and announcements.',
                'image' => $this->publish('poster-beauty.jpg', 'categories/a-standees.jpg'),
                'banner' => $this->publish('category-banner.jpg', 'categories/banners/a-standees-banner.jpg'),
                'status' => true,
                'sort_order' => 2,
            ],
        );

        $models = [
            32 => ['ideal' => 'shop counters, cafés and reception desks', 'posters' => ['poster-office.jpg', 'poster-beauty.jpg'], 'featured' => false],
            43 => ['ideal' => 'mall promotions, beauty stores and events', 'posters' => ['poster-beauty.jpg', 'poster-mall.jpg'], 'featured' => true],
            55 => ['ideal' => 'boutique entrances, lobbies and exhibitions', 'posters' => ['poster-boutique.jpg', 'poster-mall.jpg'], 'featured' => false],
        ];
        // Sizes are 32", 43" and 55" (the earlier 49" model is retired).
        Product::where('sku', 'YE-AST-49')->delete();

        $sizeAttribute = Attribute::where('slug', 'size')->first();

        foreach ($models as $inch => $model) {
            $product = Product::updateOrCreate(
                ['sku' => "YE-AST-{$inch}"],
                [
                    'category_id' => $category->id,
                    'name' => "Yara {$inch}\" A-Standee Digital Poster",
                    'slug' => "yara-{$inch}-inch-a-standee",
                    'model_number' => "YE-AST-{$inch}",
                    'brand' => 'Yara',
                    'short_description' => "{$inch}\" portable A-frame digital poster for {$model['ideal']}.",
                    'description' => "The Yara {$inch}\" A-Standee is a digital poster you can set up in seconds. "
                        . "Its fold-out A-frame stand stands firmly on any floor, and the slim portrait screen plays your offers, launches and announcements, ideal for {$model['ideal']}.\n\n"
                        . 'Fold it flat to move between locations, update content in minutes and keep your brand in front of every visitor.',
                    'price' => 0, // Price on request
                    'sale_price' => null,
                    'stock_quantity' => 5,
                    'specifications' => [
                        'Screen Size' => "{$inch} inch",
                        'Orientation' => 'Portrait',
                        'Form Factor' => 'Portable A-frame digital poster',
                        'Stand' => 'Foldable rear support leg',
                        'Finish' => 'White frame',
                        'Content' => 'Images, videos & promotions',
                        'Touch' => 'Touch & non-touch options',
                        'Media Player' => 'Built-in',
                        'Branding' => 'Custom content & branding',
                        'Technical Data' => 'Resolution, brightness & ports on request',
                    ],
                    'status' => true,
                    'featured' => $model['featured'],
                    'sort_order' => $inch,
                    'meta_title' => "Yara {$inch} inch A-Standee | Portable Digital Poster",
                    'meta_description' => "Yara {$inch}\" A-Standee portable digital poster for {$model['ideal']}. Foldable A-frame stand, portrait display, custom branding.",
                ],
            );

            $gallery = [
                "a-standee-{$inch}.jpg" => "Yara {$inch}\" A-Standee",
                $model['posters'][0] => "Yara {$inch}\" A-Standee in use",
                $model['posters'][1] => "Yara {$inch}\" A-Standee in use",
            ];

            $keep = [];
            foreach (array_keys($gallery) as $order => $file) {
                $path = $this->publish($file, "products/a-standees/{$file}");
                $keep[] = $path;
                $product->images()->updateOrCreate(
                    ['image' => $path],
                    ['alt_text' => $gallery[$file], 'sort_order' => $order, 'is_primary' => $order === 0],
                );
            }
            $product->images()->whereNotIn('image', $keep)->delete();

            $product->features()->delete();
            $product->features()->createMany(collect([
                ['icon' => 'move', 'title' => 'Truly Portable', 'description' => 'Fold it flat, carry it and set it up anywhere in seconds.'],
                ['icon' => 'monitor-smartphone', 'title' => 'Bright Portrait Screen', 'description' => 'A digital poster that outshines printed standees.'],
                ['icon' => 'refresh-cw', 'title' => 'Easy Content Updates', 'description' => 'Swap offers and videos in minutes, no reprinting.'],
                ['icon' => 'pointer', 'title' => 'Touch or Non-Touch', 'description' => 'Interactive catalogues or simple looping playback.'],
                ['icon' => 'stamp', 'title' => 'Your Branding', 'description' => 'Custom content and branding for your business.'],
                ['icon' => 'map-pin', 'title' => 'Entrances to Events', 'description' => 'Shops, malls, lobbies, cafés and exhibitions.'],
            ])->map(fn ($f, $i) => $f + ['sort_order' => $i])->all());

            if ($sizeAttribute) {
                $value = AttributeValue::firstOrCreate(['attribute_id' => $sizeAttribute->id, 'value' => "{$inch}\""], ['sort_order' => $inch]);
                $product->attributeValues()->syncWithoutDetaching([$value->id]);
            }
        }

        // Hero banner: fourth slide, after the Centum, Chillers and T-Standees.
        $bannerPath = $this->publish('a-standee-banner.jpg', 'banners/a-standees-hero.jpg');
        $slide = Banner::firstOrNew(['image' => $bannerPath]);

        if (! $slide->exists) {
            Banner::where('sort_order', '>=', 3)->increment('sort_order');
        }

        $slide->fill([
            'title' => 'Yara A-Standees',
            'subtitle' => '32" · 43" · 55" Portable Digital Posters',
            'button_text' => 'Explore A-Standees',
            'button_link' => '/a-standees',
            'sort_order' => 3,
            'status' => true,
        ])->save();
    }

    private function publish(string $asset, string $target): string
    {
        Storage::disk('public')->put($target, file_get_contents(self::ASSETS . '/' . $asset));

        return $target;
    }
}
