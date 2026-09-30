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
     * Products with their own showcase page (features first) instead of the standard product page.
     */
    public const SHOWCASE_ROUTES = [
        'YE-CENTUM-100' => 'store.centum',
        'YE-CHILLER-AC' => 'store.chillers',
    ];

    /**
     * Anti-glare QLED TVs, showcased on the /anti-glare-tv explore page.
     */
    public const ANTI_GLARE_SKUS = ['YE-TV-65SQ25S', 'YE-TV-75SQ25S', 'YE-TV-85SQ25S', 'YE-TV-98SQ25S'];

    /**
     * Product families with an explore page. Links to these products open the explore page first;
     * the explore page then lists the products and links to their product pages ("View details").
     */
    public const EXPLORE_ROUTES = [
        'YE-TST-' => 'store.tstandees',
        'YE-AST-' => 'store.astandees',
        'YE-IFP-' => 'store.interactivepanels',
        'YE-CD-' => 'store.commercialdisplays',
        'YE-HA-' => 'store.homeaudio',
        'YE-LED-' => 'store.ledwalls',
        'YE-LCD-' => 'store.lcdwalls',
        // Anti-glare QLED TVs (exact SKUs, see ANTI_GLARE_SKUS; the rest of the TV range has no explore page)
        'YE-TV-65SQ25S' => 'store.antiglare',
        'YE-TV-75SQ25S' => 'store.antiglare',
        'YE-TV-85SQ25S' => 'store.antiglare',
        'YE-TV-98SQ25S' => 'store.antiglare',
        'YE-KIOSK-' => 'store.printingkiosk',
        'YE-SAK-' => 'store.standalonekiosk',
        'YE-TTS-' => 'store.tabletopstandee',
        'YE-GD-' => 'store.glassdisplays',
        'YE-CWM-' => 'store.commercialwashers',
        'YE-POD-' => 'store.digitalpodium',
    ];

    /**
     * The showcase / explore page for this product, if it has one.
     */
    public function exploreUrl(): ?string
    {
        if (isset(self::SHOWCASE_ROUTES[$this->sku])) {
            return route(self::SHOWCASE_ROUTES[$this->sku]);
        }

        foreach (self::EXPLORE_ROUTES as $prefix => $route) {
            if (str_starts_with((string) $this->sku, $prefix)) {
                return route($route);
            }
        }

        return null;
    }

    /**
     * Where links to this product should go: its explore/showcase page first, otherwise the product page.
     */
    public function url(): string
    {
        return $this->exploreUrl() ?? route('store.product', $this);
    }

    /**
     * False for "price on request" products (price saved as 0), e.g. the Centum or project items.
     */
    public function hasPrice(): bool
    {
        return (float) $this->price > 0;
    }

    /**
     * The price a customer pays for one unit: the sale price when it is lower, otherwise the MRP.
     */
    public function unitPrice(): float
    {
        $sale = (float) $this->sale_price;

        return $sale > 0 && $sale < (float) $this->price ? $sale : (float) $this->price;
    }

    /**
     * Can go in the cart: active, priced (not "price on request") and in stock.
     */
    public function isPurchasable(): bool
    {
        return $this->status && $this->hasPrice() && $this->stock_quantity > 0;
    }

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