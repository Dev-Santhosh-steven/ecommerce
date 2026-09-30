<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

/**
 * Specifications from the Yara B2B Catalogue (March 2026), "Product Specifications" pages.
 *
 * Merged into the products by SKU: catalogue values replace the same spec rows, new rows are added,
 * other rows (orientation, uses, branding…) are kept, and "… on request" placeholders are dropped
 * once the catalogue gives the real values. Size-specific values are only applied where the catalogue
 * lists that exact size.
 *
 * Run after the product seeders (their updateOrCreate resets specifications):
 *
 *   php artisan db:seed --class=CatalogueSpecSeeder
 */
class CatalogueSpecSeeder extends Seeder
{
    public function run(): void
    {
        $this->interactivePanels();
        $this->tStandees();
        $this->aStandees();
        $this->commercialDisplays();
        $this->standAloneKiosk();
        $this->printingKiosk();
        $this->digitalPodium();
        $this->tableTopStandee();
        $this->ledModules();
    }

    private function interactivePanels(): void
    {
        $common = [
            'Resolution' => '3840 × 2160 (4K UHD)',
            'Aspect Ratio' => '16:9',
            'Viewing Angle' => '178° (H) / 178° (V)',
            'Backlight' => 'DLED',
            'Touch Technology' => 'Infrared multi-touch',
            'Touch Points' => '20 points',
            'Touch Accuracy' => '± 1 mm',
            'Touch Sensor' => 'Finger, pen, gloved hand or any touch-sensitive medium',
            'Touch Life' => '> 60 million touches in the same spot',
            'Writing Surface' => '4 mm anti-glare glass',
            'Processor' => 'Quad-core ARM Cortex-A73',
            'Operating System' => 'Android 14 (Windows / Linux via OPS)',
            'RAM / Storage' => '8 GB / 128 GB, DDR4',
            'Camera' => '48 MP AI camera with 8-array mic (optional)',
            'Wi-Fi / Bluetooth' => '2.4G + 5G / v5.2',
            'Input Ports' => 'LAN IN × 1, HDMI 2.0 × 2, RS232 × 1, MIC × 1, USB 2.0 × 1, DP × 1, VGA IN × 1',
            'Output Ports' => 'TF card × 1, PC audio × 1, LAN OUT × 1, Coaxial (RCA) × 1, Touch OUT × 1, HDMI OUT (optional)',
            'OPS Slot' => 'Intel OPS-C, JAE 80-pin · OPS size 194.6 × 179.8 × 42 mm (42 or 30 mm) · PC option H81 / H110 / H310 mainboard, 18 V DC',
            'Panel Lifetime' => '50,000 hours',
            'In the Box' => 'Magnetic whiteboard pen × 1, wall-mount bracket × 1 set, power cord × 1, remote control × 1, Wi-Fi antenna × 2',
        ];

        $sizes = [
            55 => ['1209.6 × 680.4 mm', '350 cd/m²', '4000:1', '8 Ω, 10 W × 2', '1271.9 × 769.1 × 85.5 mm', '1380 × 900 × 200 mm', '26 kg / 35 kg', '≤ 150 W'],
            65 => ['1428.48 × 803.52 mm', '350 cd/m²', '4000:1', '8 Ω, 15 W × 2', '1485.2 × 890.8 × 97.8 mm', '1580 × 185 × 1015 mm', '42 kg / 54 kg', '≤ 210 W'],
            75 => ['1650.24 × 928.26 mm', '350 cd/m²', '4000:1', '8 Ω, 15 W × 2', '1707.6 × 1016.55 × 97.8 mm', '1815 × 185 × 1145 mm', '53 kg / 72.3 kg', '≤ 250 W'],
        ];

        foreach ([55, 65, 75, 85, 100] as $inch) {
            $set = $common;

            if (isset($sizes[$inch])) {
                [$area, $nits, $contrast, $audio, $dims, $box, $weight, $watts] = $sizes[$inch];
                $set += [
                    'Display Area' => $area,
                    'Brightness' => $nits,
                    'Contrast Ratio' => $contrast,
                    'Speakers' => $audio,
                    'Power' => "100–240 V, 50/60 Hz · {$watts} (standby ≤ 0.5 W)",
                    'Dimensions (W × H × D)' => $dims,
                    'Package Size' => $box,
                    'Net / Gross Weight' => $weight,
                ];
            }

            $this->merge("YE-IFP-{$inch}", $set);
        }
    }

    private function tStandees(): void
    {
        $common = [
            'Display Type' => 'E-LED',
            'Aspect Ratio' => '9:16',
            'Resolution' => '1080 × 1920 / 2160 × 3840',
            'Contrast Ratio' => '1200:1',
            'Viewing Angle' => '178°',
            'Display Colours' => '16.7 million',
            'Response Time' => '6.5 ms',
            'Touch' => 'Multi-touch display (optional)',
            'Tempered Glass' => 'High permeability (3 mm)',
            'Camera' => '13 MP HDR (optional)',
            'CPU' => 'RK3566S',
            'Operating System' => 'Android 11',
            'RAM / Storage' => '4 GB / 32 GB eMMC',
            'Wi-Fi' => 'Yes',
            'Ports' => 'USB 2.0 × 2, LAN × 1',
            'Backlight Lifetime' => '≥ 50,000 hours',
            'Standby Power' => '≤ 0.5 W',
            'Power Requirement' => 'AC 100–240 V, 50/60 Hz',
            'Operating Temperature' => '0–40 °C',
            'Working Humidity' => '10%–90%',
        ];

        $sizes = [
            55 => ['766 × 460 × 1900 mm', '≤ 75 W', '8 Ω, 5 W × 2', '320 cd/m²'],
            65 => ['890 × 520 × 2050 mm', '≤ 135 W', '8 Ω, 5 W × 2', '350 cd/m²'],
        ];

        foreach ([55, 65, 75] as $inch) {
            $set = $common;
            $drop = [];

            if (isset($sizes[$inch])) {
                [$dims, $watts, $audio, $nits] = $sizes[$inch];
                $set += ['Brightness' => $nits, 'Audio' => $audio, 'Avg Power Consumption' => $watts, 'Dimensions' => $dims];
                $drop = ['Technical Data'];
            } else {
                $set['Technical Data'] = 'Dimensions, brightness & power on request';
            }

            $this->merge("YE-TST-{$inch}", $set, $drop);
        }
    }

    private function aStandees(): void
    {
        $common = [
            'Panel & Backlight' => 'D-LED',
            'Aspect Ratio' => '9:16',
            'Brightness' => '220–270 nits',
            'Viewing Angle' => '±176°',
            'CPU' => 'A53',
            'Operating System' => 'Android 9',
            'Audio' => '2 × 10 W',
            'Wi-Fi' => 'Available',
            'HDMI / USB' => 'Available',
            'Remote Control' => 'Available',
            'Power Consumption' => '≤ 50 W (avg)',
        ];

        $this->merge('YE-AST-32', $common + [
            'Resolution' => '720 × 1280',
            'RAM / Storage' => '1 GB / 8 GB',
            'Dimensions' => '1470 × 160 × 535 mm',
            'Gross Weight' => '26.9 kg',
        ], ['Technical Data']);

        $this->merge('YE-AST-43', $common + [
            'Resolution' => '1080 × 1920',
            'RAM / Storage' => '2 GB / 16 GB',
        ], ['Technical Data']);
    }

    private function commercialDisplays(): void
    {
        $common = [
            'Panel Type' => 'A+ grade commercial',
            'Backlight' => 'ELED',
            'Aspect Ratio' => '9:16 / 16:9',
            'Response Time' => '8 ms',
            'Refresh Rate' => '60 Hz',
            'Viewing Angle' => '±178° / ±178°',
            'HDR' => 'Supported',
            'Speakers' => '2 × 5 W (8 Ω)',
            'Media Player' => 'Built-in Android 14, 4 GB DDR / 32 GB',
            'Wi-Fi / Bluetooth' => 'Wi-Fi · Bluetooth (optional)',
            'Inputs' => 'HDMI, RJ45 × 1, TF card × 1, USB 3.0 × 1, AUX × 1, USB OTG × 1',
            'SIM Card Slot' => 'Optional',
            'Tempered Glass' => 'Optional',
            'Format Support' => '480p, 720p, 1080p',
            'Power Requirement' => 'AC 100–220 V, 50/60 Hz',
            'Operating Temperature' => '-10 °C to 50 °C',
            'Working Humidity' => '20%–85%',
            'Colour' => 'Black',
        ];

        $sizes = [
            32 => ['1920 × 1080 (Full HD)', '280 cd/m²', 'RK3566', '≤ 45 W', '721 × 415 × 58 mm', '795 × 490 × 135 mm', '9.5 kg / 11 kg'],
            43 => ['3840 × 2160 (4K UHD)', '350 cd/m²', 'RK3576', '≤ 60 W', '1006 × 598 × 61 mm', '1070 × 650 × 145 mm', '16.4 kg / 18.3 kg'],
            55 => ['3840 × 2160 (4K UHD)', '450 cd/m²', 'RK3576', '≤ 75 W', '1285 × 756 × 61 mm', '1355 × 825 × 157 mm', '26.3 kg / 29.5 kg'],
            65 => ['3840 × 2160 (4K UHD)', '500 cd/m²', 'RK3576', '≤ 90 W', '1516 × 882 × 63 mm', '1655 × 1062 × 180 mm', '36 kg / 42 kg'],
            75 => ['3840 × 2160 (4K UHD)', '500 cd/m²', 'RK3576', '≤ 120 W', '1775 × 1048 × 65 mm', '1945 × 1258 × 215 mm', '47 kg / 57 kg'],
        ];

        foreach ([32, 43, 55, 65, 75, 86] as $inch) {
            $set = $common;
            $drop = [];

            if (isset($sizes[$inch])) {
                [$res, $nits, $cpu, $watts, $dims, $box, $weight] = $sizes[$inch];
                $set += [
                    'Resolution' => $res,
                    'Brightness' => $nits,
                    'Processor' => $cpu,
                    'Avg Power Consumption' => $watts,
                    'Dimensions' => $dims,
                    'Box Dimensions' => $box,
                    'Net / Gross Weight' => $weight,
                ];
                $drop = ['Technical Data'];
            }

            $this->merge("YE-CD-{$inch}", $set, $drop);
        }
    }

    private function standAloneKiosk(): void
    {
        $this->merge('YE-SAK-32', [
            'Panel & Backlight' => 'LED',
            'Resolution' => '1920 × 1080',
            'Aspect Ratio' => '16:9',
            'Response Time' => '8 ms',
            'Touch' => 'Infrared touch',
            'CPU' => 'V100 octa-core',
            'RAM / Storage' => '4 GB / 32 GB',
            'Operating System' => 'Android 12',
            'Audio' => '5 W',
            'Connectivity' => 'Wi-Fi, RJ45, HDMI, VGA, USB',
            'TF Card Support' => 'Yes',
            'Power Consumption' => '105 W (max)',
            'Power Requirement' => 'AC 100–240 V, 50/60 Hz',
            'Dimensions' => '850 × 160 × 580 mm',
            'Gross Weight' => '26.9 kg',
        ], ['Technical Data']);
    }

    private function printingKiosk(): void
    {
        $this->merge('YE-KIOSK-215', [
            'Display' => '21.5" touchscreen, 1920 × 1080, 300 nits, 10-point touch',
            'Operating System' => 'Android',
            'CPU' => 'RK3576',
            'RAM / Storage' => '4 GB / 32 GB',
            'Printer' => '80 mm thermal printer (NP80A), 203 dpi',
            'Scanner' => 'QR code scanner with LED light source, 640 × 480 CMOS sensor',
            'Face Recognition' => 'HDR 1080p × 2 cameras, 60 cm focus',
            'Communication' => 'RJ45 × 1, USB 2.0 × 2',
            'Kiosk Cabinet' => 'Moisture-proof, anti-rust, anti-acid, static-free',
            'Power Supply' => '100–240 V AC, 50–60 Hz',
        ], ['Technical Data']);
    }

    private function digitalPodium(): void
    {
        $this->merge('YE-POD-27', [
            'Screen' => '27" all-in-one touch screen',
            'Resolution' => '3840 × 2160',
            'Touch' => '20-point PCAP touch with on-stage annotation',
            'Processor' => 'ARM octa-core (A76 + A55 × 4)',
            'RAM / Storage' => '8 GB / 64 GB',
            'Operating System' => 'Android 13',
            'Wi-Fi / Bluetooth' => 'Wi-Fi · Bluetooth supported',
            'Microphones' => '2 × gooseneck microphones',
            'Height' => '1130–1326 mm, electrically adjustable (1–1.2 m travel)',
            'Battery' => 'Optional 13,000 mAh (about 5 hours backup)',
        ], ['Android Configuration']);
    }

    private function tableTopStandee(): void
    {
        $this->merge('YE-TTS-10', [
            'Screen Size' => '10.1 inch',
            'Display' => 'LED portrait touchscreen',
            'Resolution' => '800 × 1280',
            'Aspect Ratio' => '16:9',
            'Brightness' => '250 nits',
            'Viewing Angle' => '176°',
            'Display Colours' => '16.7 million',
            'Response Time' => '6.5 ms',
            'CPU' => 'RK3568',
            'RAM / Storage' => '4 GB / 32 GB',
            'Operating System' => 'Android 11',
            'Ports' => 'Wi-Fi, LAN, HDMI, USB 2.0 × 2, 3.5 mm earphone out',
            'Audio' => '2 W (max)',
            'Battery' => 'Optional 6,000 mAh',
        ], ['Technical Data']);
    }

    /**
     * Indoor (P1.25–P3.91) and outdoor (P2.5–P6) 320 × 160 mm modules. Only fixed-install walls built
     * on that module get these values; rental cabinets and P8 / P10 use other modules.
     */
    private function ledModules(): void
    {
        $shared = [
            'Pixel Configuration' => '1R1G1B',
            'Module Size' => '320 × 160 mm',
            'Module Weight' => '0.4 kg',
            'Refresh Rate' => 'Up to 7680 Hz',
            'Viewing Angle' => '110°',
            'Operating Temperature' => '-20 °C to +80 °C',
            'Working Humidity' => '10%–90% RH',
            'Module Locking' => 'Magnetic / screw lock',
            'BIS Certified' => 'Yes',
            'Lifetime' => '80,000 hours',
            'Input Voltage' => '220 V ±10%',
        ];

        $indoor = $shared + [
            'Brightness' => '500 cd/m²',
            'Scan Mode' => '1/43',
            'Power Consumption' => 'Max 300 W/m² · Avg 120 W/m²',
        ];

        $outdoor = $shared + [
            'Brightness' => '5,000 cd/m²',
            'Scan Mode' => '1/20',
            'Power Consumption' => 'Max 600 W/m² · Avg 270 W/m²',
            'Maintenance' => 'Rear maintenance',
        ];

        $modules = [
            'YE-LED-P125-IN' => [$indoor, null],
            'YE-LED-P153-IN' => [$indoor, '209 × 105 px'],
            'YE-LED-P186-IN' => [$indoor, '172 × 86 px'],
            'YE-LED-P25-IN' => [$indoor, '128 × 64 px'],
            'YE-LED-P4-OUT' => [$outdoor, '80 × 40 px'],
            'YE-LED-P5-OUT' => [$outdoor, null],
        ];

        foreach ($modules as $sku => [$set, $resolution]) {
            if ($resolution) {
                $set['Module Resolution'] = $resolution;
            }

            $this->merge($sku, $set);
        }
    }

    /**
     * Replace / add spec rows (existing rows keep their position) and drop the listed rows.
     */
    private function merge(string $sku, array $set, array $drop = []): void
    {
        $product = Product::where('sku', $sku)->first();

        if (! $product) {
            $this->command?->warn("Skipped {$sku}: product not found.");

            return;
        }

        $specs = $product->specifications ?: [];

        // The LED set is for walls built on the 320 × 160 mm module only.
        if (str_starts_with($sku, 'YE-LED-') && ($specs['Module Size'] ?? '') !== '320 × 160 mm') {
            $this->command?->warn("Skipped {$sku}: different module ({$specs['Module Size']}).");

            return;
        }

        foreach ($set as $key => $value) {
            $specs[$key] = $value;
        }

        $product->update(['specifications' => array_diff_key($specs, array_flip($drop))]);
    }
}
