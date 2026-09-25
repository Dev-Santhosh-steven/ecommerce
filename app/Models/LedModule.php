<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LedModule extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'brand',
        'model_number',
        'environment',
        'length_mm',
        'height_mm',
        'pixel_width',
        'pixel_height',
        'pixel_pitch',
        'pixel_config',
        'weight_per_module_kg',
        'refresh_rate',
        'scan_mode',
        'brightness_nits',
        'viewing_angle_h',
        'viewing_angle_v',
        'serviceability',
        'power_max_wm2',
        'power_avg_wm2',
        'input_voltage',
        'cabinet_w_mm',
        'cabinet_h_mm',
        'cabinet_d_mm',
        'cabinet_weight_kg',
        'cabinet_material',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'length_mm' => 'float',
        'height_mm' => 'float',
        'pixel_width' => 'integer',
        'pixel_height' => 'integer',
        'pixel_pitch' => 'float',
        'weight_per_module_kg' => 'float',
        'brightness_nits' => 'float',
        'power_max_wm2' => 'float',
        'power_avg_wm2' => 'float',
        'cabinet_w_mm' => 'float',
        'cabinet_h_mm' => 'float',
        'cabinet_d_mm' => 'float',
        'cabinet_weight_kg' => 'float',
        'is_active' => 'boolean',
    ];

    /**
     * The store product this module is sold as.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name');
    }
}
