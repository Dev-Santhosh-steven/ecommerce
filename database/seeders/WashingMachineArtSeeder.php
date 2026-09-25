<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * Washing machine artwork: home hero slide plus card and banner images for the Washing Machine
 * category and its Fully Automatic sub-category. Built from the Yara top-load, front-load and
 * semi-automatic product photos on the brand backdrop.
 *
 * Idempotent: updates the existing records (matched by category slug / hero button link).
 * Images are copied from database/seeders/assets/washing-machines to the public disk.
 *
 *   php artisan db:seed --class=WashingMachineArtSeeder
 */
class WashingMachineArtSeeder extends Seeder
{
    private const ASSETS = __DIR__ . '/assets/washing-machines';

    public function run(): void
    {
        Category::where('slug', 'washing-machine')->update([
            'image' => $this->publish('category-card.jpg', 'categories/washing-machines.jpg'),
            'banner' => $this->publish('category-banner.jpg', 'categories/banners/washing-machines-banner.jpg'),
        ]);

        Category::where('slug', 'fully_automatic')->update([
            'image' => $this->publish('fully-automatic-card.jpg', 'categories/fully-automatic.jpg'),
            'banner' => $this->publish('fully-automatic-banner.jpg', 'categories/banners/fully-automatic-banner.jpg'),
        ]);

        $hero = $this->publish('home-banner.jpg', 'banners/washing-machines-hero.jpg');

        $banner = Banner::firstOrNew(['button_link' => '/category/washing-machine']);

        $banner->fill([
            'title' => $banner->title ?: 'Washing Machines',
            'subtitle' => 'Top Load · Front Load · Semi-Automatic',
            'image' => $hero,
            'button_text' => 'Shop Washing Machines',
            'status' => true,
        ]);

        if (!$banner->exists) {
            $banner->sort_order = 2;
        }

        $banner->save();
    }

    /**
     * Copy an asset to the public disk and return its stored path.
     */
    private function publish(string $asset, string $target): string
    {
        Storage::disk('public')->put($target, file_get_contents(self::ASSETS . '/' . $asset));

        return $target;
    }
}
