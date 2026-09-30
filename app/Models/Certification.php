<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Certification extends Model
{
    protected $fillable = [
        'title',
        'issuer',
        'code',
        'description',
        'icon',
        'logo',
        'file',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true)->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Logos are either bundled site images ("images/certifications/bis.png") or uploads on the public disk.
     */
    public function logoUrl(): ?string
    {
        if (! $this->logo) {
            return null;
        }

        return str_starts_with($this->logo, 'images/') ? asset($this->logo) : asset('storage/' . $this->logo);
    }

    public function hasFile(): bool
    {
        return $this->file && Storage::disk('public')->exists($this->file);
    }

    public function fileExtension(): string
    {
        return strtolower(pathinfo((string) $this->file, PATHINFO_EXTENSION));
    }

    public function fileIsImage(): bool
    {
        return in_array($this->fileExtension(), ['jpg', 'jpeg', 'png', 'webp'], true);
    }

    /** "PDF · 1.2 MB" */
    public function fileLabel(): ?string
    {
        if (! $this->hasFile()) {
            return null;
        }

        $bytes = Storage::disk('public')->size($this->file);
        $size = $bytes >= 1048576 ? round($bytes / 1048576, 1) . ' MB' : max(1, round($bytes / 1024)) . ' KB';

        return strtoupper($this->fileExtension()) . ' · ' . $size;
    }

    /** "Yara-ISO-9001-Certificate.pdf" */
    public function downloadName(): string
    {
        return 'Yara-' . Str::slug($this->title, '-') . '.' . $this->fileExtension();
    }
}
