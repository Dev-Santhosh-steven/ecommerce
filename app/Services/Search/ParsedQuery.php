<?php

namespace App\Services\Search;

/**
 * What the visitor asked for, in structured form. Built by QueryParser, used by SearchEngine.
 *
 * Every constraint has a key (see chips()) so the results page can offer "remove" on each one.
 */
final class ParsedQuery
{
    public string $original = '';

    /** The query after spelling fixes, when it changed ("Showing results for …"). */
    public ?string $corrected = null;

    /** Category slugs (a parent includes its sub-categories). */
    public array $categories = [];

    public ?float $priceMin = null;
    public ?float $priceMax = null;
    public ?float $priceAround = null;

    public ?float $inchMin = null;
    public ?float $inchMax = null;
    public ?float $kgMin = null;
    public ?float $kgMax = null;
    public ?float $tonMin = null;
    public ?float $tonMax = null;
    public ?int $stars = null;

    /** Feature flags, e.g. ['4k', 'google_tv']. */
    public array $features = [];

    /** price_asc | price_desc | newest | popular | null (relevance). */
    public ?string $sort = null;

    /** Free words left after the understood parts, used for text relevance. */
    public array $terms = [];

    /** "For a bedroom", "For classrooms"… */
    public ?string $useLabel = null;

    /** Constraint keys set by the room / use (dropped together with it). */
    public array $useEffects = [];

    /** A product type Yara does not make ("fridge"). */
    public ?string $notSold = null;

    public bool $isQuestion = false;

    /** Labels for the understood parts, keyed by what removing them would drop. */
    public array $labels = [];

    public function hasConstraints(): bool
    {
        return $this->categories || $this->hasPrice() || $this->hasSize() || $this->stars || $this->features;
    }

    public function hasPrice(): bool
    {
        return $this->priceMin !== null || $this->priceMax !== null || $this->priceAround !== null;
    }

    public function hasSize(): bool
    {
        return $this->inchMin !== null || $this->inchMax !== null || $this->kgMin !== null
            || $this->kgMax !== null || $this->tonMin !== null || $this->tonMax !== null;
    }

    public function isEmpty(): bool
    {
        return ! $this->hasConstraints() && ! $this->terms && ! $this->sort && ! $this->notSold;
    }

    /**
     * Remove understood parts the visitor switched off (the × on a chip).
     */
    public function drop(array $keys): void
    {
        foreach ($keys as $key) {
            // A room / use also removes the size, tonnage or categories it implied.
            if ($key === 'use') {
                $effects = $this->useEffects;
                [$this->useLabel, $this->useEffects] = [null, []];
                unset($this->labels['use']);
                $this->drop($effects);

                continue;
            }

            match (true) {
                $key === 'category' => $this->categories = [],
                $key === 'price' => [$this->priceMin, $this->priceMax, $this->priceAround] = [null, null, null],
                $key === 'inch' => [$this->inchMin, $this->inchMax] = [null, null],
                $key === 'kg' => [$this->kgMin, $this->kgMax] = [null, null],
                $key === 'ton' => [$this->tonMin, $this->tonMax] = [null, null],
                $key === 'stars' => $this->stars = null,
                $key === 'sort' => $this->sort = null,
                str_starts_with($key, 'f:') => $this->features = array_values(array_diff($this->features, [substr($key, 2)])),
                default => null,
            };

            unset($this->labels[$key]);
        }
    }

    /**
     * @return array<string, string> key => label, in reading order
     */
    public function chips(): array
    {
        return $this->labels;
    }
}
