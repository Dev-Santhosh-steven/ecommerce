<?php

namespace App\Services\Search;

use App\Models\ChatbotFaq;

/**
 * Everything the results page and the instant suggestions need.
 */
final class SearchResult
{
    /** Matching product ids, best first. */
    public array $ids = [];

    /** Plain-language notes: what was relaxed, what we don't sell… */
    public array $notes = [];

    /** Constraint groups relaxed to find results (features, size, price…). */
    public array $relaxed = [];

    /** Nothing matched: showing popular products instead. */
    public bool $fallback = false;

    /** Words that matched nothing in the catalogue. */
    public array $ignoredTerms = [];

    /** Matching pages, guides and articles. */
    public array $pages = [];

    /** A knowledge-base answer for questions ("how long does delivery take?"). */
    public ?ChatbotFaq $answer = null;

    /** [['slug', 'name', 'count'], …] to narrow the results by category. */
    public array $facets = [];

    public function __construct(public ParsedQuery $parsed)
    {
    }
}
