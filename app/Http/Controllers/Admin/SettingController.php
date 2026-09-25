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
        ]);

        $setting = Setting::current();

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('branding', 'public');

            $setting->logo = self::trimWhitespace($path);
        }

        $setting->save();

        return redirect()
            ->route('admin.settings.edit')
            ->with('success', 'Settings updated successfully.');
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
