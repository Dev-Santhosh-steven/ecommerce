<?php

namespace Database\Seeders;

use App\Models\ChatbotFaq;
use App\Models\Product;
use App\Services\ChatbotService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Chatbot answers for every live product, built from the catalogue:
 *
 *  - "Tell me about the …"          overview with the key specs
 *  - "What are the specifications …" the full spec sheet
 *
 * Keywords are the model number, SKU and name phrases that belong to that product only
 * (a phrase two products share, like "55 inch tv", is left to the normal product search).
 * Questions about one spec ("55SU23G brightness") are answered from the same product by ChatbotService.
 *
 * Re-run after adding or editing products. Idempotent: rows are linked by product_id,
 * so hit counts are kept, and answers for removed or hidden products are deleted.
 *
 *   php artisan db:seed --class=ProductChatbotFaqSeeder
 */
class ProductChatbotFaqSeeder extends Seeder
{
    private const SORT_FROM = 1000;

    /** Key specs shown in the overview answer. */
    private const OVERVIEW_SPECS = 8;

    /** Spec rows that add nothing to a chat answer. */
    private const SKIP_SPECS = ['Model', 'Technical Data'];

    private ChatbotService $bot;

    public function run(): void
    {
        $this->bot = app(ChatbotService::class);

        $products = Product::where('status', true)->with('category.parent')->orderBy('category_id')->orderBy('sort_order')->get();
        $keywords = $this->uniqueKeywords($products);

        ChatbotFaq::whereNotNull('product_id')->whereNotIn('product_id', $products->modelKeys())->delete();

        foreach ($products->values() as $i => $product) {
            $identity = $keywords[$product->id];
            $specs = $this->specs($product);

            $entries = [[
                'question' => "Tell me about the {$product->name}",
                'keywords' => $identity,
                'answer' => $this->overview($product, $specs),
            ]];

            if ($specs) {
                $entries[] = [
                    'question' => "What are the specifications of the {$product->name}?",
                    'keywords' => $this->specKeywords($identity),
                    'answer' => $this->fullSpecs($product, $specs),
                ];
            }

            $this->sync($product, $entries, self::SORT_FROM + $i * 2);
        }

        $this->command?->info(ChatbotFaq::whereNotNull('product_id')->count() . " product answers for {$products->count()} products.");
    }

    /**
     * Update this product's rows in place (keeps hits), create missing ones, drop extras.
     */
    private function sync(Product $product, array $entries, int $sort): void
    {
        $rows = ChatbotFaq::where('product_id', $product->id)->orderBy('id')->get();

        foreach ($entries as $n => $entry) {
            $row = $rows->get($n) ?? new ChatbotFaq(['product_id' => $product->id]);

            $row->fill([
                ...$entry,
                'keywords' => implode(', ', $entry['keywords']),
                'button_text' => null,
                'button_url' => null,
                'show_as_suggestion' => false,
                'status' => true,
                'sort_order' => $sort + $n,
            ])->save();
        }

        $rows->slice(count($entries))->each->delete();
    }

    // ------------------------------------------------------------------ answers

    private function overview(Product $product, array $specs): string
    {
        $lines = [$product->name];

        if ($product->short_description) {
            $lines[] = trim($product->short_description);
        }

        if ($specs) {
            $lines[] = "Key specs:\n" . $this->bullets(array_slice($specs, 0, self::OVERVIEW_SPECS, true));
        }

        $lines[] = $specs
            ? "Ask me for \"{$this->shortId($product)} specifications\" to see the full spec sheet, or tap the product for the price and photos."
            : 'Tap the product for the price, photos and full details.';

        return implode("\n\n", $lines);
    }

    private function fullSpecs(Product $product, array $specs): string
    {
        return "{$product->name}: full specifications\n\n" . $this->bullets($specs)
            . "\n\nWant a demo or a quotation? Just ask, or tap the product below.";
    }

    private function bullets(array $specs): string
    {
        return collect($specs)->map(fn ($value, $key) => "• {$key}: {$value}")->implode("\n");
    }

    /**
     * Spec rows with a readable value, in catalogue order.
     */
    private function specs(Product $product): array
    {
        return collect($product->specifications ?: [])
            ->filter(fn ($value, $key) => is_scalar($value) && trim((string) $value) !== '' && ! in_array($key, self::SKIP_SPECS, true))
            ->map(fn ($value) => trim(preg_replace('/\s+/', ' ', (string) $value)))
            ->all();
    }

    /**
     * What the visitor can type to ask for the full sheet, e.g. "55SU23G" or "Yara Glass Display".
     */
    private function shortId(Product $product): string
    {
        return $product->model_number && preg_match('/\d/', $product->model_number) && ! str_contains($product->model_number, ' ')
            ? $product->model_number
            : $this->baseName($product);
    }

    // ------------------------------------------------------------------ keywords

    /**
     * Keyword phrases per product, keeping only phrases no other product also produces.
     *
     * @return array<int, string[]>
     */
    private function uniqueKeywords(Collection $products): array
    {
        $candidates = $products->mapWithKeys(fn (Product $product) => [$product->id => $this->candidates($product)]);
        $counts = $candidates->flatten()->countBy();

        return $candidates->map(fn (array $phrases) => array_values(array_filter($phrases, fn ($phrase) => $counts[$phrase] === 1)))->all();
    }

    private function candidates(Product $product): array
    {
        $name = $product->name;
        $category = $this->singular($product->category?->name);
        $phrases = [$product->model_number, $product->sku, $name, $this->baseName($product)];

        $size = $this->size($product);
        if ($size && $category) {
            $phrases[] = "{$size} inch {$category}";
        }

        if (preg_match('/(\d+(?:\.\d+)?)\s*Ton\b.*?(\d)\s*Star/i', $name, $ac)) {
            $phrases[] = "{$ac[1]} ton {$ac[2]} star ac";
            $phrases[] = "{$ac[1]} ton {$ac[2]} star inverter ac";
        }

        if (preg_match('/(\d+(?:\.\d+)?)\s*kg\b/i', $name, $kg) && $category) {
            $phrases[] = "{$kg[1]} kg {$category}";
        }

        if (preg_match('/\bP(\d+(?:\.\d+)?)\b.*?\b(Indoor|Outdoor)\b/i', $name, $pitch)) {
            $phrases[] = "p{$pitch[1]} {$pitch[2]}";
            $phrases[] = "p{$pitch[1]} {$pitch[2]} led wall";
        }

        return collect($phrases)
            ->filter()
            ->map(fn ($phrase) => $this->bot->normalize(str_replace(',', ' ', (string) $phrase)))
            ->filter(fn ($phrase) => strlen($phrase) >= 4 && ! ctype_digit(str_replace(' ', '', $phrase)))
            ->unique()
            ->values()
            ->all();
    }

    /**
     * "model specs", "specifications of model", … for each identity phrase.
     */
    private function specKeywords(array $identity): array
    {
        return collect($identity)
            ->flatMap(fn ($id) => [
                "{$id} specs", "{$id} specifications", "{$id} specification", "{$id} spec", "{$id} full specs",
                "{$id} features", "{$id} details", "specs of {$id}", "specifications of {$id}", "features of {$id}",
            ])
            ->all();
    }

    /**
     * Name without the brand or the trailing variant, e.g. "Yara 6.5 kg Only Washer – Pink Flower" → "6.5 kg Only Washer".
     */
    private function baseName(Product $product): string
    {
        $base = preg_split('/\s+[–·-]\s+|\s*\(/u', $product->name)[0];

        return trim(preg_replace('/^Yara\s+/i', '', $base));
    }

    private function size(Product $product): ?string
    {
        $spec = (string) ($product->specifications['Screen Size'] ?? '');

        if (preg_match('/(\d+(?:\.\d+)?)/', $spec, $m) || preg_match('/(\d+(?:\.\d+)?)\s*(?:"|inch)/i', $product->name, $m)) {
            return $m[1];
        }

        return null;
    }

    private function singular(?string $name): ?string
    {
        if (! $name) {
            return null;
        }

        $name = preg_replace('/^\d+(\.\d+)?"\s*/', '', $name);

        return Str::endsWith($name, 's') && ! Str::endsWith($name, 'ss') ? substr($name, 0, -1) : $name;
    }
}
