<?php

namespace App\Services;

use App\Models\LedModule;

/**
 * LED wall sizing — same algorithm as the ERP (erp.yaraelectronics.com), so a wall planned on the
 * website matches what the sales team quotes.
 */
class LedCalculationService
{
    private function convertToMm($value, $unit)
    {
        if (empty($value)) return null;
        switch (strtolower($unit)) {
            case 'ft': case 'feet':   return $value * 304.8;
            case 'm':  case 'meter':  case 'metres': return $value * 1000;
            case 'in': case 'inch':   case 'inches': return $value * 25.4;
            default:   return $value;
        }
    }

    private function convertFromMm($valueMm, $unit)
    {
        if (empty($valueMm)) return null;
        switch (strtolower($unit)) {
            case 'ft': case 'feet':   return $valueMm / 304.8;
            case 'm':  case 'meter':  case 'metres': return $valueMm / 1000;
            case 'in': case 'inch':   case 'inches': return $valueMm / 25.4;
            default:   return $valueMm;
        }
    }

    /**
     * Calculate LED wall configurations.
     * Returns at most 2 suggestions: 'recommended' (always fits) and
     * 'aspect_match' (only when aspect_ratio is set and gives different tiles).
     * Neither result will ever exceed the given max width or max height — not even by 1 mm.
     */
    public function calculate(LedModule $module, $inputWidth, $inputHeight, $unit = 'mm', $aspectRatio = null, $lockAxis = null)
    {
        $targetWidthMm  = $this->convertToMm($inputWidth,  $unit);
        $targetHeightMm = $this->convertToMm($inputHeight, $unit);

        // Keep original user inputs so we can cap AR-derived values below
        $maxWidthMm  = $targetWidthMm;
        $maxHeightMm = $targetHeightMm;

        // Derive missing dimension from aspect ratio
        if ($aspectRatio) {
            $parts = explode(':', $aspectRatio);
            if (count($parts) === 2 && is_numeric($parts[0]) && is_numeric($parts[1])) {
                $ratioW = (float) $parts[0];
                $ratioH = (float) $parts[1];

                if ($lockAxis === 'width' && $targetWidthMm) {
                    $derived = $targetWidthMm * ($ratioH / $ratioW);
                    // If the derived height fits within the user's stated max, use it;
                    // otherwise the height constraint is binding — shrink the width instead.
                    if ($maxHeightMm && $derived > $maxHeightMm) {
                        $targetHeightMm = $maxHeightMm;
                        $targetWidthMm  = min($maxHeightMm * ($ratioW / $ratioH), $maxWidthMm);
                    } else {
                        $targetHeightMm = $derived;
                    }
                } elseif ($lockAxis === 'height' && $targetHeightMm) {
                    $derived = $targetHeightMm * ($ratioW / $ratioH);
                    // Symmetric: if derived width exceeds user's max, use max width and shrink height.
                    if ($maxWidthMm && $derived > $maxWidthMm) {
                        $targetWidthMm  = $maxWidthMm;
                        $targetHeightMm = min($maxWidthMm * ($ratioH / $ratioW), $maxHeightMm);
                    } else {
                        $targetWidthMm  = $derived;
                    }
                } elseif ($targetWidthMm && !$targetHeightMm) {
                    $targetHeightMm = $targetWidthMm * ($ratioH / $ratioW);
                } elseif ($targetHeightMm && !$targetWidthMm) {
                    $targetWidthMm  = $targetHeightMm * ($ratioW / $ratioH);
                }
            }
        }

        $suggestions = [];

        if ($targetWidthMm && $targetHeightMm) {
            // Max integer tiles that fit — using floor() guarantees we never exceed even 1 mm
            $maxTilesX = max(1, (int) floor($targetWidthMm  / $module->length_mm));
            $maxTilesY = max(1, (int) floor($targetHeightMm / $module->height_mm));

            // PRIMARY: best fill within the given space (always safe)
            $suggestions['recommended'] = $this->buildScenario(
                $module, $maxTilesX, $maxTilesY, $targetWidthMm, $targetHeightMm, $unit
            );

            // SECONDARY: closest aspect-ratio match, still within max bounds
            if ($aspectRatio) {
                $parts       = explode(':', $aspectRatio);
                $ratioW      = (float) $parts[0];
                $ratioH      = (float) $parts[1];
                $targetRatio = $ratioW / $ratioH;

                // If recommended already achieves the target ratio closely (within 2%),
                // there is no point showing a smaller wall at the same ratio.
                $recRatio = ($maxTilesX * $module->length_mm) / ($maxTilesY * $module->height_mm);

                if (abs($recRatio - $targetRatio) > 0.02) {
                    $bestDiff = PHP_FLOAT_MAX;
                    $bestX = $maxTilesX;
                    $bestY = $maxTilesY;

                    $range = 8;
                    for ($x = max(1, $maxTilesX - $range); $x <= $maxTilesX; $x++) {
                        for ($y = max(1, $maxTilesY - $range); $y <= $maxTilesY; $y++) {
                            $wallWidth  = $x * $module->length_mm;
                            $wallHeight = $y * $module->height_mm;
                            // Hard constraint: never exceed given dimensions
                            if ($wallWidth > $targetWidthMm || $wallHeight > $targetHeightMm) continue;
                            $currentRatio = $wallWidth / $wallHeight;
                            $diff = abs($currentRatio - $targetRatio);
                            if ($diff < $bestDiff) {
                                $bestDiff = $diff;
                                $bestX = $x;
                                $bestY = $y;
                            }
                        }
                    }

                    // Only emit if it differs from the recommended result
                    if ($bestX !== $maxTilesX || $bestY !== $maxTilesY) {
                        $suggestions['aspect_match'] = $this->buildScenario(
                            $module, $bestX, $bestY, $targetWidthMm, $targetHeightMm, $unit
                        );
                    }
                }
            }

        } elseif ($targetWidthMm) {
            $tilesX = max(1, (int) floor($targetWidthMm / $module->length_mm));
            $suggestions['recommended'] = [
                'type'             => 'Width Only',
                'tiles_x'          => $tilesX,
                'wall_width_mm'    => $tilesX * $module->length_mm,
                'wall_width_display' => round($this->convertFromMm($tilesX * $module->length_mm, $unit), 2) . ' ' . $unit,
            ];
        } elseif ($targetHeightMm) {
            $tilesY = max(1, (int) floor($targetHeightMm / $module->height_mm));
            $suggestions['recommended'] = [
                'type'              => 'Height Only',
                'tiles_y'           => $tilesY,
                'wall_height_mm'    => $tilesY * $module->height_mm,
                'wall_height_display' => round($this->convertFromMm($tilesY * $module->height_mm, $unit), 2) . ' ' . $unit,
            ];
        }

        return [
            'target_input' => [
                'width'        => $inputWidth,
                'height'       => $inputHeight,
                'unit'         => $unit,
                'aspect_ratio' => $aspectRatio,
                'width_mm'     => $targetWidthMm,
                'height_mm'    => $targetHeightMm,
            ],
            'module'      => $module->toArray(),
            'suggestions' => $suggestions,
        ];
    }

    public function enrichWithCabinets(array $sc, LedModule $module): array
    {
        if ($module->cabinet_w_mm && $module->cabinet_h_mm && isset($sc['wall_width_mm'], $sc['wall_height_mm'])) {
            $cabW = (int) floor($sc['wall_width_mm']  / $module->cabinet_w_mm);
            $cabH = (int) floor($sc['wall_height_mm'] / $module->cabinet_h_mm);
            $sc['cabinets_x']     = $cabW;
            $sc['cabinets_y']     = $cabH;
            $sc['total_cabinets'] = $cabW * $cabH;
        } else {
            $sc['cabinets_x']     = null;
            $sc['cabinets_y']     = null;
            $sc['total_cabinets'] = null;
        }
        return $sc;
    }

    /**
     * Area, diagonal, power draw and weight for a full-wall scenario — the figures a buyer needs
     * to plan electrical supply and mounting structure.
     */
    public function enrichWithEstimates(array $sc, LedModule $module): array
    {
        if (!isset($sc['wall_width_mm'], $sc['wall_height_mm'])) {
            return $sc;
        }

        $areaM2 = ($sc['wall_width_mm'] / 1000) * ($sc['wall_height_mm'] / 1000);

        $sc['area_m2']     = round($areaM2, 2);
        $sc['area_sqft']   = round($areaM2 * 10.7639, 1);
        $sc['diagonal_in'] = round(hypot($sc['wall_width_mm'], $sc['wall_height_mm']) / 25.4, 1);

        $sc['power_max_kw'] = $module->power_max_wm2 ? round($areaM2 * $module->power_max_wm2 / 1000, 2) : null;
        $sc['power_avg_kw'] = $module->power_avg_wm2 ? round($areaM2 * $module->power_avg_wm2 / 1000, 2) : null;

        $sc['weight_kg'] = $module->weight_per_module_kg
            ? round($sc['total_tiles'] * $module->weight_per_module_kg, 1)
            : null;

        return $sc;
    }

    private function buildScenario($module, $tilesX, $tilesY, $targetWidthMm, $targetHeightMm, $unit)
    {
        $tilesX = max(1, (int) $tilesX);
        $tilesY = max(1, (int) $tilesY);

        $wallWidthMm  = $tilesX * $module->length_mm;
        $wallHeightMm = $tilesY * $module->height_mm;

        $pixelWidth  = $tilesX * $module->pixel_width;
        $pixelHeight = $tilesY * $module->pixel_height;

        $diffWidthMm  = $targetWidthMm  ? $wallWidthMm  - $targetWidthMm  : 0;
        $diffHeightMm = $targetHeightMm ? $wallHeightMm - $targetHeightMm : 0;

        $pixelPitch = $module->pixel_pitch ?? 1.0;
        $mvd = $pixelPitch * 1;
        $ovd = $pixelPitch * 3;
        $xvd = ($wallHeightMm / 1000) * 30;

        return [
            'tiles_x'              => $tilesX,
            'tiles_y'              => $tilesY,
            'total_tiles'          => $tilesX * $tilesY,
            'wall_width_mm'        => $wallWidthMm,
            'wall_height_mm'       => $wallHeightMm,
            'wall_width_ft'        => round($this->convertFromMm($wallWidthMm,  'ft'), 2),
            'wall_height_ft'       => round($this->convertFromMm($wallHeightMm, 'ft'), 2),
            'wall_width_display'   => round($this->convertFromMm($wallWidthMm,  $unit), 2) . ' ' . $unit,
            'wall_height_display'  => round($this->convertFromMm($wallHeightMm, $unit), 2) . ' ' . $unit,
            'pixel_width'          => $pixelWidth,
            'pixel_height'         => $pixelHeight,
            'total_pixels'         => $pixelWidth * $pixelHeight,
            'diff_width_mm'        => $diffWidthMm,
            'diff_height_mm'       => $diffHeightMm,
            // convertFromMm() returns null for 0 (exact fit) — PHP 8.1+ deprecates round(null).
            'diff_width_display'   => round($this->convertFromMm($diffWidthMm,  $unit) ?? 0, 2) . ' ' . $unit,
            'diff_height_display'  => round($this->convertFromMm($diffHeightMm, $unit) ?? 0, 2) . ' ' . $unit,
            'viewing_distance'     => [
                'min_m'     => round($mvd, 2),
                'optimal_m' => round($ovd, 2),
                'max_m'     => round($xvd, 2),
            ],
        ];
    }
}
