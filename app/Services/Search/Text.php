<?php

namespace App\Services\Search;

/**
 * One way of reading text, shared by the query parser and the indexes so both sides match.
 */
final class Text
{
    /**
     * Lower-case, units and currency spelled out, punctuation stripped.
     * "₹5,000" → "rs 5000", "55"" → "55 inch", "P1.25" → "p125", "Wi-Fi" → "wi fi".
     */
    public static function normalize(string $value): string
    {
        $value = mb_strtolower($value);
        $value = str_replace(['₹', '’', '‘'], [' rs ', "'", "'"], $value);
        $value = preg_replace('/(\d)\s*(?:"|”|″|\'\')/u', '$1 inch ', $value);
        $value = preg_replace('/(\d)\s*-?\s*inch(?:es)?\b/', '$1 inch ', $value);
        // "55in" is inches; "20000 in bedroom" is not.
        $value = preg_replace('/(\d)in\b/', '$1 inch', $value);
        $value = preg_replace('/\bp(\d+)\.(\d+)\b/', 'p$1$2', $value);
        // Indian and western digit grouping: 1,50,000 / 150,000 → 150000
        $value = preg_replace_callback('/\d{1,3}(?:,\d{2,3})+\b/', fn ($m) => str_replace(',', '', $m[0]), $value);
        $value = preg_replace('/[^\p{L}\p{N}.\s]+/u', ' ', $value);
        // Keep decimals (6.5 kg, 1.5 ton) but not sentence full stops.
        $value = preg_replace('/(?<!\d)\.|\.(?!\d)/', ' ', $value);

        return trim(preg_replace('/\s+/', ' ', $value));
    }

    /**
     * Search words: normalized, stop words removed, lightly stemmed ("panels" → "panel").
     */
    public static function tokens(string $value, bool $keepStopWords = false): array
    {
        $words = explode(' ', self::normalize($value));

        if (! $keepStopWords) {
            $words = array_diff($words, Vocabulary::STOP_WORDS);
        }

        return array_values(array_filter(array_map([self::class, 'stem'], $words), fn ($w) => $w !== ''));
    }

    public static function stem(string $word): string
    {
        if (strlen($word) <= 3 || ctype_digit(str_replace('.', '', $word))) {
            return $word;
        }

        if (str_ends_with($word, 'ies') && strlen($word) > 4) {
            return substr($word, 0, -3) . 'y';
        }

        if (preg_match('/(ches|shes|xes|sses)$/', $word)) {
            return substr($word, 0, -2);
        }

        if (str_ends_with($word, 's') && ! preg_match('/(ss|us|is|os)$/', $word)) {
            return substr($word, 0, -1);
        }

        return $word;
    }

    /**
     * "₹8,900" style Indian formatting.
     */
    public static function rupees(float $amount): string
    {
        $amount = (int) round($amount);
        $digits = (string) $amount;

        if (strlen($digits) > 3) {
            $last3 = substr($digits, -3);
            $rest = substr($digits, 0, -3);
            $digits = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $rest) . ',' . $last3;
        }

        return '₹' . $digits;
    }

    /** 6.50 → "6.5", 55.0 → "55". */
    public static function num(float $value): string
    {
        return rtrim(rtrim(number_format($value, 2, '.', ''), '0'), '.');
    }
}
