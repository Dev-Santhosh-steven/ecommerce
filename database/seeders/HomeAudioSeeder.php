<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Home Audio category with its sub-categories (Twin Tower Multimedia Speakers, Single Tower Speakers,
 * Soundbars with Subwoofer), one Yara product in each, and the /home-audio explore page artwork.
 *
 * Images are copied from database/seeders/assets/home-audio.
 * Idempotent: re-running updates the same records.
 *
 *   php artisan db:seed --class=HomeAudioSeeder
 */
class HomeAudioSeeder extends Seeder
{
    private const ASSETS = __DIR__ . '/assets/home-audio';

    public function run(): void
    {
        DB::transaction(function () {
            foreach (glob(self::ASSETS . '/*.{png,jpg}', GLOB_BRACE) as $file) {
                $this->publish(basename($file), 'products/home-audio/' . basename($file));
            }

            $parent = Category::updateOrCreate(
                ['slug' => 'home-audio'],
                [
                    'parent_id' => null,
                    'name' => 'Home Audio',
                    'description' => 'Yara home audio: twin tower multimedia speakers, single tower speakers and soundbars with subwoofer, '
                        . 'with Bluetooth and USB playback and deep bass for music, movies and parties.',
                    'image' => $this->publish('category-home-audio.jpg', 'categories/home-audio.jpg'),
                    'banner' => $this->publish('banner-home-audio.jpg', 'categories/banners/home-audio-banner.jpg'),
                    'status' => true,
                    'sort_order' => Category::where('slug', 'home-audio')->value('sort_order')
                        ?? (Category::whereNull('parent_id')->max('sort_order') + 1),
                ],
            );

            foreach ($this->families() as $index => $family) {
                $category = Category::updateOrCreate(
                    ['slug' => $family['slug']],
                    [
                        'parent_id' => $parent->id,
                        'name' => $family['category'],
                        'description' => $family['category_description'],
                        'image' => $this->publish("category-{$family['art']}.jpg", "categories/{$family['slug']}.jpg"),
                        'banner' => $this->publish("banner-{$family['art']}.jpg", "categories/banners/{$family['slug']}-banner.jpg"),
                        'status' => true,
                        'sort_order' => $index,
                    ],
                );

                $this->seedProduct($category, $family, $index);
            }
        });
    }

    private function seedProduct(Category $category, array $f, int $index): void
    {
        $product = Product::updateOrCreate(
            ['sku' => $f['sku']],
            [
                'category_id' => $category->id,
                'name' => $f['name'],
                'slug' => $f['product_slug'],
                'model_number' => $f['sku'],
                'brand' => 'Yara',
                'short_description' => $f['short'],
                'description' => $f['description'],
                'price' => 0, // Price on request
                'sale_price' => null,
                'stock_quantity' => 25,
                'warranty_months' => 12,
                'specifications' => $f['specs'],
                'status' => true,
                'featured' => true,
                'sort_order' => $index,
                'meta_title' => "{$f['name']} | Yara Home Audio",
                'meta_description' => $f['short'],
            ],
        );

        $keep = [];
        foreach ($f['gallery'] as $order => [$file, $alt]) {
            $path = "products/home-audio/{$file}";
            $keep[] = $path;
            $product->images()->updateOrCreate(
                ['image' => $path],
                ['alt_text' => $alt, 'sort_order' => $order, 'is_primary' => $order === 0],
            );
        }
        $product->images()->whereNotIn('image', $keep)->delete();

        $product->features()->delete();
        $product->features()->createMany(
            collect($f['features'])->map(fn ($x, $i) => ['icon' => $x[0], 'title' => $x[1], 'description' => $x[2], 'sort_order' => $i])->all(),
        );
    }

    private function publish(string $asset, string $target): string
    {
        Storage::disk('public')->put($target, file_get_contents(self::ASSETS . '/' . $asset));

        return $target;
    }

    private function families(): array
    {
        $onRequest = 'Output power, driver sizes & dimensions on request';

        return [
            [
                'slug' => 'twin-tower-speakers',
                'category' => 'Twin Tower Multimedia Speakers',
                'category_description' => 'Yara twin tower multimedia speakers: a matched pair of floor-standing towers with side-firing bass for room-filling stereo sound.',
                'art' => 'twin-tower',
                'sku' => 'YE-HA-TT01',
                'name' => 'Yara Twin Tower Multimedia Speaker',
                'product_slug' => 'yara-twin-tower-multimedia-speaker',
                'short' => 'Matched pair of tower speakers with true stereo separation, side-firing bass and Bluetooth & USB playback.',
                'description' => "Two towers, true stereo. The Yara Twin Tower Multimedia Speaker places a full-range driver and tweeter in each tower for clear vocals and crisp highs, while a large side-firing bass driver and front bass port on each tower deliver deep, room-filling bass.\n\n"
                    . "Stream from your phone over Bluetooth or play straight from a USB drive using the illuminated control panel on the right tower. The textured cabinets with a gloss-black driver panel look at home in any living room.\n\n"
                    . 'Ideal for music, TV and movie nights, and house parties.',
                'specs' => [
                    'Type' => '2.0 twin tower multimedia speaker',
                    'Drivers (per tower)' => 'Full-range driver + tweeter',
                    'Bass' => 'Side-firing bass driver + front bass reflex port (each tower)',
                    'Connectivity' => 'Bluetooth, USB, AUX',
                    'Controls' => 'Front control panel: Mode, Prev / Next, Play / Pause, Volume',
                    'Finish' => 'Textured cabinet with gloss-black driver panel',
                    'Technical Data' => $onRequest,
                ],
                'features' => [
                    ['speaker', 'True Stereo', 'Two matched towers for real left-right separation.'],
                    ['audio-waveform', 'Side-Firing Bass', 'A large side bass driver on each tower fills the room.'],
                    ['bluetooth', 'Bluetooth Streaming', 'Play from your phone, tablet or laptop, wire-free.'],
                    ['usb', 'USB Playback', 'Plug in a pen drive and play your music directly.'],
                    ['sliders-horizontal', 'Easy Front Controls', 'Mode, track and volume controls right on the tower.'],
                    ['sofa', 'Living-Room Design', 'Textured cabinets with a gloss-black driver panel.'],
                ],
                'gallery' => [
                    ['cut-twin-tower.png', 'Yara Twin Tower Multimedia Speaker'],
                    ['life-twin-vinyl.jpg', 'Yara Twin Tower Multimedia Speaker — music'],
                    ['life-twin-bass.jpg', 'Yara Twin Tower Multimedia Speaker — deep bass'],
                    ['detail-twin-drivers.jpg', 'Yara Twin Tower — driver and tweeter'],
                    ['detail-twin-controls.jpg', 'Yara Twin Tower — control panel with USB'],
                ],
            ],
            [
                'slug' => 'single-tower-speakers',
                'category' => 'Single Tower Speakers',
                'category_description' => 'Yara single tower speakers: one slim floor-standing tower with LED display, twin drivers and side-firing bass.',
                'art' => 'single-tower',
                'sku' => 'YE-HA-ST01',
                'name' => 'Yara Single Tower Speaker',
                'product_slug' => 'yara-single-tower-speaker',
                'short' => 'Slim tower speaker with LED display, twin drivers, side-firing woofer and Bluetooth & USB playback.',
                'description' => "Big sound from a slim footprint. The Yara Single Tower Speaker stacks twin front drivers above a bass port, with a side-firing woofer for deep, punchy bass that fills the room.\n\n"
                    . "The LED display shows the active source at a glance, and the metal volume knob, USB port and control keys sit right on the top panel. Pair over Bluetooth in seconds or play straight from a pen drive.\n\n"
                    . 'Perfect for bedrooms, living rooms and small gatherings.',
                'specs' => [
                    'Type' => 'Single tower speaker',
                    'Drivers' => '2 × front drivers',
                    'Bass' => 'Side-firing woofer + front bass reflex port',
                    'Display' => 'LED source display',
                    'Connectivity' => 'Bluetooth, USB, AUX',
                    'Controls' => 'Top panel keys + metal volume knob',
                    'Finish' => 'Black cabinet',
                    'Technical Data' => $onRequest,
                ],
                'features' => [
                    ['speaker', 'Twin Front Drivers', 'Two drivers for clear, balanced sound.'],
                    ['audio-waveform', 'Side-Firing Woofer', 'Punchy bass from a slim tower.'],
                    ['monitor-dot', 'LED Display', 'See the active source at a glance.'],
                    ['bluetooth', 'Bluetooth Streaming', 'Pair your phone in seconds.'],
                    ['usb', 'USB Playback', 'Play music straight from a pen drive.'],
                    ['disc-3', 'Metal Volume Knob', 'Precise, satisfying volume control.'],
                ],
                'gallery' => [
                    ['cut-single-tower.png', 'Yara Single Tower Speaker'],
                    ['life-single-dj.jpg', 'Yara Single Tower Speaker — party'],
                    ['life-single-cosmos.jpg', 'Yara Single Tower Speaker — music'],
                    ['detail-single-panel.jpg', 'Yara Single Tower — LED display, USB and volume knob'],
                    ['detail-single-drivers.jpg', 'Yara Single Tower — twin front drivers'],
                ],
            ],
            [
                'slug' => 'soundbars',
                'category' => 'Soundbars with Subwoofer',
                'category_description' => 'Yara soundbars with subwoofer: a slim TV soundbar paired with a powerful wired subwoofer for cinematic sound.',
                'art' => 'soundbar',
                'sku' => 'YE-HA-SB01',
                'name' => 'Yara Soundbar with Subwoofer',
                'product_slug' => 'yara-soundbar-with-subwoofer',
                'short' => 'Slim TV soundbar with a dedicated subwoofer for clear dialogue and cinematic bass.',
                'description' => "Upgrade your TV to a home theatre. The slim Yara soundbar sits neatly under your TV for clear dialogue and wide sound, while the dedicated subwoofer, with a side-firing woofer and front bass port, adds the deep bass that brings movies, sport and music to life.\n\n"
                    . "Controls sit on the subwoofer's front panel, and Bluetooth lets you stream music from your phone when the TV is off.\n\n"
                    . 'Made for movie nights, match days and everyday TV.',
                'specs' => [
                    'Type' => '2.1 soundbar with subwoofer',
                    'Soundbar' => 'Slim bar for under-TV placement',
                    'Subwoofer' => 'Side-firing woofer + front bass reflex port',
                    'Connectivity' => 'Bluetooth, USB, AUX',
                    'Controls' => 'Subwoofer front panel',
                    'Finish' => 'Black',
                    'Technical Data' => $onRequest,
                ],
                'features' => [
                    ['tv', 'Made for Your TV', 'A slim bar that fits neatly under any TV.'],
                    ['audio-waveform', 'Dedicated Subwoofer', 'Side-firing woofer and bass port for cinematic lows.'],
                    ['message-square-text', 'Clear Dialogue', 'Hear every word in movies and shows.'],
                    ['bluetooth', 'Bluetooth Streaming', 'Play music from your phone when the TV is off.'],
                    ['usb', 'USB Playback', 'Play music straight from a pen drive.'],
                    ['clapperboard', 'Movie Nights', 'Wide, room-filling sound for films and sport.'],
                ],
                'gallery' => [
                    ['cut-soundbar.png', 'Yara Soundbar with Subwoofer'],
                    ['life-soundbar-cinema.jpg', 'Yara Soundbar with Subwoofer — movies'],
                    ['life-soundbar-city.jpg', 'Yara Soundbar with Subwoofer — music'],
                ],
            ],
        ];
    }
}
