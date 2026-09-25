<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
    ];

    /**
     * The single settings row, created on first access.
     */
    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }
}
