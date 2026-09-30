<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'excerpt',
        'content',
        'cover_image',
        'author',
        'meta_title',
        'meta_description',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Tags allowed in post content (what the admin editor produces).
     */
    public const ALLOWED_TAGS = '<p><br><div><h1><h2><h3><h4><strong><b><em><i><del><u><a><ul><ol><li><blockquote><pre><code><figure><figcaption><img><hr><span><table><thead><tbody><tr><th><td>';

    protected static function booted(): void
    {
        static::saving(function (Post $post) {
            $post->slug = static::uniqueSlug($post->slug ?: $post->title, $post->id);

            $post->content = strip_tags((string) $post->content, self::ALLOWED_TAGS);

            if ($post->is_published && ! $post->published_at) {
                $post->published_at = now();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Posts visible on the website.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->where('published_at', '<=', now())
            ->latest('published_at');
    }

    /**
     * Short summary: the excerpt, or the start of the content.
     */
    public function getSummaryAttribute(): string
    {
        return $this->excerpt ?: Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($this->content))), 160);
    }

    public function getReadingTimeAttribute(): int
    {
        return max(1, (int) ceil(str_word_count(strip_tags($this->content)) / 200));
    }

    public function isLive(): bool
    {
        return $this->is_published && $this->published_at?->isPast();
    }

    public static function uniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $base = Str::slug($value) ?: 'post';
        $slug = $base;
        $i = 2;

        while (static::where('slug', $slug)->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
