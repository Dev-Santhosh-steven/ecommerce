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
 * Images are copied from database/seeders/assets/chillers (Yara-branded studio shot, cut-out, posters).
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
        foreach (['chiller-cutout.png', 'chiller-studio.jpg'] as $file) {
            $this->publish($file, "products/chillers/{$file}");
        }

        $category = Category::updateOrCreate(
            ['slug' => 'chillers'],
            [
                'parent_id' => null,
                'name' => 'Chillers',
                'description' => 'Chiller-based air conditioning for malls, offices and large commercial spaces: stronger cooling with smarter energy savings.',
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
                'short_description' => 'Commercial chiller plant with ceiling cassette units: quick chill, steady temperature and up to 50% less power.',
                'description' => 'Upgrade to a chiller-based AC system for stronger cooling with smarter energy savings. '
                    . 'A central Yara chiller produces chilled water that feeds ceiling cassette units across your building, '
                    . "delivering fast, even cooling for busy commercial environments.\n\n"
                    . 'Engineered for malls, offices, showrooms and large spaces that need continuous performance. '
                    . 'Every system is designed around your site: our team surveys the space and recommends the right capacity and layout.',
                'price' => 0, // Price on request: every system is sized for the project.
                'sale_price' => null,
                'stock_quantity' => 1,
                'specifications' => [
                    'System Type' => 'Chiller-based central air conditioning',
                    'Chiller' => 'Air-cooled chiller with dual condenser fans',
                    'Indoor Units' => 'Ceiling cassette units, 4-way air flow',
                    'Cooling' => 'Quick chill with steady temperature control',
                    'Energy' => 'Up to 50% less power than conventional systems*',
                    'Operation' => 'Built for continuous commercial duty',
                    'Applications' => 'Malls, offices, showrooms, hotels & large spaces',
                    'Capacity' => 'Designed to your project (on request)',
                    'Installation' => 'Site survey, design & installation by Yara',
                ],
                'status' => true,
                'featured' => true,
                'sort_order' => 1,
                'meta_title' => 'Yara Chillers | Chiller-Based AC System for Commercial Spaces',
                'meta_description' => 'Yara chiller-based AC systems for malls, offices and commercial buildings: quick chill, steady temperature, built tough and up to 50% less power.',
            ],
        );

        $gallery = [
            'chiller-product.jpg' => 'Yara chiller-based AC system with ceiling cassette unit',
            'chiller-studio.jpg' => 'Yara chiller plant with cassette air distribution',
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
            ['icon' => 'snowflake', 'title' => 'Quick Chill', 'description' => 'Fast cooling performance that brings large spaces to temperature quickly.'],
            ['icon' => 'thermometer', 'title' => 'Steady Temperature', 'description' => 'Smart control keeps every zone comfortable, all day long.'],
            ['icon' => 'zap', 'title' => 'Up to 50% Less Power', 'description' => 'Chiller efficiency with 100% cooling power and smarter energy savings.'],
            ['icon' => 'shield-check', 'title' => 'Built Tough', 'description' => 'Engineered for continuous duty in busy commercial environments.'],
            ['icon' => 'wind', 'title' => '4-Way Cassette Air Flow', 'description' => 'Ceiling cassettes spread cool air evenly without taking up floor space.'],
            ['icon' => 'building', 'title' => 'Commercial-Ready', 'description' => 'Ideal for malls, offices, showrooms, hotels and large halls.'],
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
