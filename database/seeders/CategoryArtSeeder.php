<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * One consistent card + banner for every category (built from the product artwork already on the site),
 * plus the Commercial Display Solutions → Glass Displays sub-category and its product.
 *
 * Images come from database/seeders/assets/category-banners and assets/glass-displays.
 * Idempotent. Run after the product seeders (it only updates categories that exist, plus Glass Displays).
 *
 *   php artisan db:seed --class=CategoryArtSeeder
 */
class CategoryArtSeeder extends Seeder
{
    private const ASSETS = __DIR__ . '/assets';

    public function run(): void
    {
        DB::transaction(function () {
            $this->seedGlassDisplays();

            foreach (glob(self::ASSETS . '/category-banners/banner-*.jpg') as $file) {
                $slug = substr(basename($file, '.jpg'), strlen('banner-'));
                $category = Category::where('slug', $slug)->first();
                if (! $category) {
                    continue;
                }
                $category->update([
                    'banner' => $this->publish("category-banners/banner-{$slug}.jpg", "categories/banners/{$slug}-banner.jpg"),
                    'image' => $this->publish("category-banners/card-{$slug}.jpg", "categories/{$slug}.jpg"),
                ]);
            }
        });
    }

    private function seedGlassDisplays(): void
    {
        $parent = Category::where('slug', 'commercial-display-solutions')->first();
        if (! $parent) {
            return;
        }

        // Renamed from "Industrial Displays": move the existing rows so links, carts and orders keep working.
        if (! Category::where('slug', 'glass-displays')->exists()) {
            Category::where('slug', 'industrial-displays')->update(['slug' => 'glass-displays']);
        }
        if (! Product::where('sku', 'YE-GD-01')->exists()) {
            Product::where('sku', 'YE-IND-01')->update(['sku' => 'YE-GD-01']);
        }

        $category = Category::updateOrCreate(
            ['slug' => 'glass-displays'],
            [
                'parent_id' => $parent->id,
                'name' => 'Glass Displays',
                'description' => 'Rugged touch displays with a sleek glass front and built-in scanner for offices, canteens, retail and commercial spaces: built for 24/7 operation and mission-critical use.',
                'status' => true,
                'sort_order' => 6,
            ],
        );

        $product = Product::updateOrCreate(
            ['sku' => 'YE-GD-01'],
            [
                'category_id' => $category->id,
                'name' => 'Yara Glass Display',
                'slug' => 'yara-glass-display',
                'model_number' => 'YE-GD-01',
                'brand' => 'Yara',
                'short_description' => 'Rugged glass-front touch display with built-in scanner for 24/7 operation in offices, canteens, retail and commercial spaces.',
                'description' => "Glass Displays are engineered for high-performance usage in challenging and mission-critical environments. Designed with a sleek glass front, robust build quality, high-brightness panels and advanced display technology, they ensure clear visibility and durability for continuous operation.\n\n"
                    . "Ideal for industries, control rooms, retail environments and commercial spaces, these displays support seamless integration, energy efficiency and long-term reliability.\n\n"
                    . 'With options for customisation and scalable deployment, they provide a dependable solution for modern industrial and professional applications.',
                'price' => 0, // Price on request
                'sale_price' => null,
                'stock_quantity' => 10,
                'specifications' => [
                    'Construction' => 'Rugged industrial-grade build, durable metal housing options',
                    'Operation' => 'Designed for 24/7 continuous use',
                    'Operating Temperature' => 'Wide operating temperature range',
                    'Front Glass' => 'Custom design glass panel',
                    'Touch' => 'Responsive touch interface',
                    'Display' => 'High-brightness panel, clear visuals for monitoring',
                    'Cooling' => 'Efficient heat dissipation',
                    'Integration' => 'Easy integration with automation and control systems',
                    'Connectivity' => 'Multiple connectivity options',
                    'Design' => 'Compact industrial design',
                    'Maintenance' => 'Low-maintenance operation, long-life components',
                    'Customisation' => 'Size, glass, branding and housing on request',
                    'Technical Data' => 'Screen size, resolution, brightness & ports on request',
                ],
                'status' => true,
                'featured' => false,
                'sort_order' => 0,
                'meta_title' => 'Yara Glass Display | Rugged 24/7 Glass-Front Touch Display',
                'meta_description' => 'Yara Glass Displays: rugged glass-front touch displays with built-in scanner for offices, canteens and retail, built for 24/7 operation and wide temperatures.',
            ],
        );

        $gallery = [
            'glass-display-front.jpg' => 'Yara Glass Display',
            'glass-display-highlights.jpg' => 'Yara Glass Display – key features',
            'glass-display-installed.jpg' => 'Yara Glass Display, wall-mounted',
            // Scene posters (same list as GlassDisplaySeeder, which also builds the explore page)
            'poster-canteen.jpg' => 'Yara Glass Display in a canteen',
            'poster-meeting.jpg' => 'Yara Glass Display outside a meeting room',
            'poster-office.jpg' => 'Yara Glass Display in a smart office',
            'poster-exhibition.jpg' => 'Yara Glass Display at an exhibition stand',
        ];
        $keep = [];
        foreach (array_keys($gallery) as $order => $file) {
            $path = $this->publish("glass-displays/{$file}", "products/glass-displays/{$file}");
            $keep[] = $path;
            $product->images()->updateOrCreate(['image' => $path], ['alt_text' => $gallery[$file], 'sort_order' => $order, 'is_primary' => $order === 0]);
        }
        $product->images()->whereNotIn('image', $keep)->delete();

        $product->features()->delete();
        $product->features()->createMany(collect([
            ['shield', 'Rugged industrial-grade construction', 'Built to take knocks, dust and vibration on the shop floor.'],
            ['thermometer', 'Wide operating temperature', 'Works reliably in hot and cold industrial environments.'],
            ['clock', 'Designed for 24/7 operation', 'Commercial-grade panel for continuous, round-the-clock use.'],
            ['square-pen', 'Custom design glass panel', 'Front glass designed around your brand and application.'],
            ['pointer', 'Responsive touch interface', 'Fast, accurate touch for operators and customers.'],
            ['plug-zap', 'Easy integration with systems', 'Connects to your automation, PLC and control software.'],
            ['box', 'Compact industrial design', 'Space-saving footprint for panels, walls and machines.'],
            ['gauge', 'Ideal for control environments', 'Clear visuals for monitoring processes and dashboards.'],
            ['badge-check', 'Reliable long-life components', 'Industrial parts chosen for years of dependable service.'],
            ['cable', 'Multiple connectivity options', 'Flexible inputs for PCs, controllers and networks.'],
            ['shield-check', 'Durable metal housing options', 'Metal enclosures for demanding locations.'],
            ['wrench', 'Low maintenance operation', 'Designed to keep running with minimal upkeep.'],
            ['fan', 'Efficient heat dissipation', 'Stays cool under continuous heavy use.'],
            ['cpu', 'Suitable for automation systems', 'A dependable HMI for modern automated lines.'],
            ['monitor', 'Clear visuals for monitoring', 'High-brightness panel readable at a glance.'],
        ])->map(fn ($f, $i) => ['icon' => $f[0], 'title' => $f[1], 'description' => $f[2], 'sort_order' => $i])->all());
    }

    private function publish(string $asset, string $target): string
    {
        Storage::disk('public')->put($target, file_get_contents(self::ASSETS . '/' . $asset));

        return $target;
    }
}
