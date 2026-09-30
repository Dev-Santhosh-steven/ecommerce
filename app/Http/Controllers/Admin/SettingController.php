<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        $setting = Setting::current();

        return view('admin.settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg,webp', 'max:2048'],
            'stats' => ['nullable', 'array', 'max:4'],
            'stats.*.value' => ['nullable', 'integer', 'min:0', 'max:999999999'],
            'stats.*.suffix' => ['nullable', 'string', 'max:5'],
            'stats.*.label' => ['nullable', 'string', 'max:40'],
        ]);

        $setting = Setting::current();

        if ($request->has('stats')) {
            $setting->stats = collect($validated['stats'])
                ->map(fn ($stat) => [
                    'value' => (int) ($stat['value'] ?? 0),
                    'suffix' => $stat['suffix'] ?? '',
                    'label' => $stat['label'] ?? '',
                ])
                ->values()
                ->all();
        }

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('branding', 'public');

            $setting->logo = self::trimWhitespace($path);

            self::makeLightVariant($setting->logo);
        }

        $setting->save();

        return redirect()
            ->route('admin.settings.edit')
            ->with('success', 'Settings updated successfully.');
    }

    /**
     * Path of the white-on-transparent logo used on dark backgrounds (header, footer).
     */
    public static function lightVariantPath(string $path): string
    {
        return preg_replace('/\.[^.]+$/', '', $path) . '-light.png';
    }

    /**
     * Create a version of the logo for dark backgrounds: the white background becomes
     * transparent, black/grey artwork becomes white, and coloured (red) parts keep their colour.
     * Returns the new path, or null when it can't be made (SVG, no GD).
     */
    public static function makeLightVariant(string $path): ?string
    {
        $disk = Storage::disk('public');

        if (! function_exists('imagecreatefromstring') || str_ends_with(strtolower($path), '.svg') || ! $disk->exists($path)) {
            return null;
        }

        $source = @imagecreatefromstring($disk->get($path));

        if (! $source) {
            return null;
        }

        imagepalettetotruecolor($source);

        $width = imagesx($source);
        $height = imagesy($source);

        $light = imagecreatetruecolor($width, $height);
        imagealphablending($light, false);
        imagesavealpha($light, true);

        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $rgba = imagecolorat($source, $x, $y);
                $alphaIn = 1 - (($rgba >> 24) & 0x7F) / 127;
                $r = ($rgba >> 16) & 0xFF;
                $g = ($rgba >> 8) & 0xFF;
                $b = $rgba & 0xFF;

                $max = max($r, $g, $b);
                $min = min($r, $g, $b);

                // How far the pixel is from white = how much "ink" it has.
                $ink = (255 - $min) / 255 * $alphaIn;

                if ($max - $min > 60) {
                    // Coloured artwork (the red accents): keep the colour, drop the white behind it.
                    $colour = [$r, $g, $b];

                    if ($ink > 0) {
                        $colour = array_map(fn ($c) => (int) round(255 - (255 - $c) / max($ink, 0.01)), $colour);
                        $colour = array_map(fn ($c) => max(0, min(255, $c)), $colour);
                    }
                } else {
                    // Black / grey artwork turns white. Logo "black" is usually a dark grey
                    // (~85% ink), so scale it up to fully opaque white.
                    $colour = [255, 255, 255];
                    $ink = $ink / 0.85;
                }

                $alpha = 127 - (int) round(min(1, $ink) * 127);

                imagesetpixel($light, $x, $y, imagecolorallocatealpha($light, $colour[0], $colour[1], $colour[2], $alpha));
            }
        }

        ob_start();
        imagepng($light);
        $png = ob_get_clean();

        $lightPath = self::lightVariantPath($path);
        $disk->put($lightPath, $png);

        return $lightPath;
    }

    /**
     * Crop the empty border (white or transparent) around a raster logo so it
     * fills the header height. Returns the path of the trimmed PNG, or the
     * original path when trimming isn't possible (SVG, no GD, nothing to trim).
     */
    public static function trimWhitespace(string $path): string
    {
        $disk = Storage::disk('public');

        if (! function_exists('imagecropauto') || str_ends_with(strtolower($path), '.svg')) {
            return $path;
        }

        $image = @imagecreatefromstring($disk->get($path));

        if (! $image) {
            return $path;
        }

        imagepalettetotruecolor($image);

        $corner = imagecolorat($image, 0, 0);
        $isTransparent = (($corner >> 24) & 0x7F) > 0;

        $cropped = $isTransparent
            ? imagecropauto($image, IMG_CROP_TRANSPARENT)
            : imagecropauto($image, IMG_CROP_THRESHOLD, 15, $corner);

        if (! $cropped) {
            return $path;
        }

        // Keep a small breathing space around the artwork.
        $padding = (int) round(max(imagesx($cropped), imagesy($cropped)) * 0.02);
        $canvas = imagecreatetruecolor(imagesx($cropped) + $padding * 2, imagesy($cropped) + $padding * 2);
        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);
        imagefill($canvas, 0, 0, $isTransparent ? imagecolorallocatealpha($canvas, 0, 0, 0, 127) : $corner);
        imagecopy($canvas, $cropped, $padding, $padding, 0, 0, imagesx($cropped), imagesy($cropped));

        ob_start();
        imagepng($canvas);
        $png = ob_get_clean();

        $trimmedPath = preg_replace('/\.[^.]+$/', '', $path) . '-trimmed.png';
        $disk->put($trimmedPath, $png);

        return $trimmedPath;
    }
}
