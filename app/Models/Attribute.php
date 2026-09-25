<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'sort_order',
    ];

    /**
     * Values belonging to this attribute (e.g. 24", 32", 43" for "Size").
     */
    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class)
            ->orderBy('sort_order');
    }
}
