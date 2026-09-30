<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Catalogue extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'file',
        'cover',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true)->orderBy('sort_order');
    }

    public function coverUrl(): ?string
    {
        return $this->cover ? asset('storage/' . $this->cover) : null;
    }

    /** "PDF · 3.6 MB" (null when the file is missing). */
    public function sizeLabel(): ?string
    {
        if (! $this->file || ! Storage::disk('public')->exists($this->file)) {
            return null;
        }

        return 'PDF · ' . round(Storage::disk('public')->size($this->file) / 1048576, 1) . ' MB';
    }
}
