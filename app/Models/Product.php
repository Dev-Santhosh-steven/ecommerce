<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'sku',
        'model_number',
        'brand',
        'short_description',
        'description',
        'price',
        'sale_price',
        'price_unit',
        'stock_quantity',
        'warranty_months',
        'specifications',
        'status',
        'featured',
        'sort_order',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'specifications' => 'array',
        'status' => 'boolean',
        'featured' => 'boolean',
    ];

    /**
     * Product category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Product images.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)
            ->orderBy('sort_order');
    }

    /**
     * Primary product image.
     */
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)
            ->where('is_primary', true);
    }

    /**
     * Attribute values assigned to this product (e.g. Size: 55", AC Ton: 1.5 Ton).
     */
    public function attributeValues(): BelongsToMany
    {
        return $this->belongsToMany(AttributeValue::class);
    }

    /**
     * LED module used by the LED wall calculator, for LED wall products.
     */
    public function ledModule(): HasOne
    {
        return $this->hasOne(LedModule::class);
    }

    /**
     * Marketing highlight features (icon + title + short description).
     */
    public function features(): HasMany
    {
        return $this->hasMany(ProductFeature::class)
            ->orderBy('sort_order');
    }
}