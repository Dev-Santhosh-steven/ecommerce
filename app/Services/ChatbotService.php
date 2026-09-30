<?php

namespace App\Services;

use App\Models\ChatbotFaq;
use App\Models\ChatbotLog;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Rule-based website assistant.
 *
 * Answers come from two places:
 *  1. The knowledge base (Admin → Chatbot), matched on keyword phrases and question words.
 *  2. The live product catalogue, for questions that name a product, size or category.
 *
 * Every message is logged; unanswered ones show up in the admin so a matching answer can be added.
 */
class ChatbotService
{
    /** Minimum score for a knowledge-base entry to count as a match. */
    private const MIN_SCORE = 3;

    private const STOP_WORDS = [
        'a', 'an', 'the', 'is', 'are', 'am', 'was', 'be', 'to', 'of', 'in', 'on', 'for', 'and', 'or',
        'i', 'me', 'my', 'we', 'our', 'you', 'your', 'it', 'its', 'this', 'that', 'do', 'does', 'did',
        'can', 'could', 'would', 'should', 'will', 'please', 'pls', 'plz', 'want', 'need', 'know',
        'tell', 'about', 'with', 'from', 'at', 'by', 'any', 'have', 'has', 'what', 'which', 'how',
        'there', 'some', 'get', 'give', 'show', 'us', 'sir', 'madam', 'hi', 'hello',
    ];

    /** Words that signal the visitor is asking about products. */
    private const PRODUCT_WORDS = [
        'price', 'cost', 'rate', 'buy', 'model', 'models', 'inch', 'inches', 'tv', 'tvs', 'television',
        'panel', 'panels', 'ifp', 'board', 'smartboard', 'display', 'led', 'wall', 'video', 'ac', 'acs',
        'air', 'conditioner', 'washing', 'machine', 'washer', 'google', 'smart', 'ton', 'kg', 'product', 'products',
    ];

    /** Words too general to pick out a spec row ("technical data", "in", "type"…). */
    private const SPEC_NOISE = [
        'type', 'data', 'technical', 'in', 'out', 'x', 'w', 'h', 'd', 'l', 'yes', 'no', 'mm', 'per', 'max', 'min',
        'specs', 'spec', 'specification', 'specifications', 'features', 'feature', 'details', 'detail', 'full',
        'yara', 'price', 'prices', 'cost', 'rate', 'buy', 'model', 'inch', 'kg', 'ton', 'star', 'size',
    ];

    /** Everyday words for spec names, e.g. "os" → "Operating System". */
    private const SPEC_SYNONYMS = [
        'os' => ['operating'], 'android' => ['operating'], 'memory' => ['ram', 'storage'], 'rom' => ['storage'],
        'screen' => ['screen'], 'big' => ['screen'], 'speaker' => ['audio', 'speaker'], 'speakers' => ['audio', 'speaker'],
        'sound' => ['audio', 'sound'], 'volume' => ['audio'], 'energy' => ['energy', 'iseer'], 'rating' => ['energy'],
        'electricity' => ['power'], 'watt' => ['power'], 'watts' => ['power'], 'consumption' => ['power'],
        'ports' => ['hdmi', 'usb', 'input', 'port', 'lan'], 'port' => ['hdmi', 'usb', 'input', 'port', 'lan'],
        'connectivity' => ['wi', 'bluetooth', 'connectivity'], 'wifi' => ['wi'], 'internet' => ['wi', 'lan'],
        'colour' => ['colour', 'color'], 'color' => ['colour', 'color'], 'dimension' => ['dimension', 'unit'],
        'dimensions' => ['dimension', 'unit'], 'measurements' => ['dimension'], 'weight' => ['weight'],
        'heavy' => ['weight'], 'loud' => ['noise'], 'noisy' => ['noise'], 'quiet' => ['noise'], 'gas' => ['refrigerant'],
        'rpm' => ['speed', 'spin'], 'drum' => ['drum', 'tub'], 'tub' => ['drum', 'tub'], 'apps' => ['app'],
        'netflix' => ['app'], 'youtube' => ['app'], 'processor' => ['processor', 'cpu'], 'cpu' => ['processor'],
        'touch' => ['touch'], 'camera' => ['camera'], 'mic' => ['microphone', 'mic'], 'glass' => ['glass', 'surface'],
    ];

    private const BUYING_WORDS = ['price', 'prices', 'cost', 'rate', 'buy', 'purchase', 'model', 'models', 'inch', 'ton', 'kg'];

    public function reply(string $message): array
    {
        $message = Str::limit(trim($message), 300, '');
        $text = $this->normalize($message);
        $tokens = $this->tokens($text);

        [$faq, $score] = $this->bestFaq($text, $tokens);
        $products = $this->matchProducts($tokens);

        // "price", "buy", or a size like "65" means the visitor wants to see actual products.
        $wantsProducts = (bool) array_intersect($tokens, self::BUYING_WORDS) || (bool) preg_grep('/^\d{2,3}$/', $tokens);

        // Knowledge-base answers win unless it's a buying question with a weak match.
        // A product's own answer (matched on its model or name) always wins: it shows that product's card.
        $useFaq = $faq && ($score >= 6 || $faq->product || ! $wantsProducts || $products->isEmpty());

        // Product cards go under category answers ("do you sell TVs?") and buying questions only,
        // not under e.g. warranty or repair answers.
        $attachProducts = $useFaq && ! $faq->product && $products->isNotEmpty()
            && ($wantsProducts || str_starts_with((string) $faq->button_url, '/category/'));

        $response = match (true) {
            $useFaq && $faq->product => $this->productFaqResponse($faq, $tokens),
            $attachProducts => $this->faqResponse($faq, $products),
            $useFaq => $this->faqResponse($faq),
            $products->isNotEmpty() => $this->productResponse($products),
            default => $this->fallbackResponse(),
        };

        if ($useFaq) {
            $faq->increment('hits');
        }

        ChatbotLog::create([
            'message' => $message,
            'chatbot_faq_id' => $useFaq ? $faq->id : null,
            'product_count' => $products->count(),
            'answered' => $useFaq || $products->isNotEmpty(),
        ]);

        $response['suggestions'] = $this->suggestions($useFaq ? $faq->id : null);

        return $response;
    }

    /**
     * Quick-reply chips shown under the welcome message and after each answer.
     */
    public function suggestions(?int $exceptId = null): array
    {
        return ChatbotFaq::active()
            ->where('show_as_suggestion', true)
            ->when($exceptId, fn ($query) => $query->whereKeyNot($exceptId))
            ->limit(4)
            ->pluck('question')
            ->all();
    }

    /**
     * A general knowledge-base answer (delivery, warranty, demo…) for the site search.
     * Product answers are left out (search shows the products themselves), and it is not logged.
     */
    public function knowledgeAnswer(string $message): ?ChatbotFaq
    {
        $text = $this->normalize(Str::limit(trim($message), 300, ''));
        [$faq, $score] = $this->bestFaq($text, $this->tokens($text), false);

        // Greetings and small talk are chat-only.
        // One keyword plus the same word in the question (e.g. "warranty") is enough here.
        return $faq && $score >= 4 && ! in_array($faq->question, ['Hi', 'Thank you', 'Bye'], true) ? $faq : null;
    }

    /**
     * @return array{0: ?ChatbotFaq, 1: int}
     */
    private function bestFaq(string $text, array $tokens, bool $productAnswers = true): array
    {
        $best = null;
        $bestScore = 0;
        $padded = " {$text} ";

        foreach (ChatbotFaq::active()->with('product')->get() as $faq) {
            $score = 0;

            // Answers for a product that has since been hidden or deleted.
            if ($faq->product_id && (! $productAnswers || ! $faq->product?->status)) {
                continue;
            }

            // Keyword phrases: longer phrases are more specific, so they weigh more.
            foreach ($faq->keywordList() as $keyword) {
                $keyword = $this->normalize($keyword);

                if ($keyword !== '' && str_contains($padded, " {$keyword} ")) {
                    $score += 3 * count(explode(' ', $keyword));
                }
            }

            $exact = $this->normalize($faq->question) === $text;

            // Product answers need their model or name in the message; sharing words like "55 inch tv"
            // with the question is not enough (that is left to the product search).
            if ($faq->product_id && $score === 0 && ! $exact) {
                continue;
            }

            // A model number or product name is more specific than a general topic like "price".
            if ($faq->product_id && $score > 0) {
                $score += 3;
            }

            // Shared meaningful words with the stored question.
            $score += count(array_intersect($tokens, $this->tokens($this->normalize($faq->question))));

            // Exact question (e.g. a tapped suggestion chip) always wins.
            if ($exact) {
                $score += 100;
            }

            if ($score > $bestScore) {
                $best = $faq;
                $bestScore = $score;
            }
        }

        return $bestScore >= self::MIN_SCORE ? [$best, $bestScore] : [null, 0];
    }

    private function matchProducts(array $tokens): Collection
    {
        $productTokens = array_values(array_filter($tokens, fn ($token) => strlen($token) > 1));

        if (! array_intersect($productTokens, self::PRODUCT_WORDS) && ! preg_grep('/^\d{2,3}$/', $productTokens)) {
            return collect();
        }

        return Product::query()
            ->where('status', true)
            ->with(['primaryImage', 'category.parent'])
            ->get()
            ->map(function (Product $product) use ($productTokens) {
                // Name, model and category only; descriptions mention too many other things.
                $haystack = ' ' . $this->normalize(implode(' ', [
                    $product->name,
                    $product->model_number,
                    $product->category?->name,
                    $product->category?->parent?->name,
                ])) . ' ';

                $score = 0;

                foreach ($productTokens as $token) {
                    // Words shared by too many unrelated products ("LED TV" vs LED walls, which are sold on quote).
                    if (in_array($token, [...self::BUYING_WORDS, 'product', 'products', 'smart', 'sell', 'have', 'working', 'led', 'wall', 'walls', 'video'], true)) {
                        continue;
                    }

                    // Whole words, plural-tolerant: "panels" matches "panel", "tvs" matches "tv".
                    $stem = preg_quote(rtrim($token, 's'), '/');

                    if ($stem !== '' && preg_match("/ {$stem}(s|es)? /", $haystack)) {
                        // Sizes like "65" are very specific.
                        $score += ctype_digit($token) ? 3 : 1;
                    }
                }

                return ['product' => $product, 'score' => $score];
            })
            ->filter(fn ($row) => $row['score'] >= 1)
            ->sortByDesc('score')
            ->take(3)
            ->pluck('product')
            ->values();
    }

    private function faqResponse(ChatbotFaq $faq, ?Collection $products = null): array
    {
        return [
            'reply' => $faq->answer,
            'links' => $faq->button_text && $faq->button_url
                ? [['label' => $faq->button_text, 'url' => $faq->button_url]]
                : [],
            'products' => $products ? $this->productCards($products) : [],
        ];
    }

    /**
     * A product's own answer, with its card. If the visitor asked for particular specs
     * ("55SU23G brightness", "power consumption of AS123BS24E") only those rows are returned.
     */
    private function productFaqResponse(ChatbotFaq $faq, array $tokens): array
    {
        $product = $faq->product;
        $specs = $this->askedSpecs($product, $tokens);

        $reply = $specs
            ? "{$product->name}\n\n" . collect($specs)->map(fn ($value, $key) => "• {$key}: {$value}")->implode("\n")
                . "\n\nAsk for \"specifications\" with the model to see the full spec sheet."
            : $faq->answer;

        return [
            'reply' => $reply,
            'links' => [['label' => 'View product', 'url' => $product->url()]],
            'products' => $this->productCards(collect([$product])),
        ];
    }

    /**
     * Spec rows whose name matches a word in the message, ignoring words that just name the product.
     */
    private function askedSpecs(Product $product, array $tokens): array
    {
        $specs = collect($product->specifications ?: [])->filter(fn ($value) => is_scalar($value) && trim((string) $value) !== '');

        if ($specs->isEmpty()) {
            return [];
        }

        $identity = $this->tokens($this->normalize(implode(' ', [
            $product->name, $product->model_number, $product->sku, $product->category?->name,
        ])));

        $asked = collect(array_diff($tokens, $identity, self::SPEC_NOISE))
            ->flatMap(fn ($token) => [$token, ...(self::SPEC_SYNONYMS[$token] ?? [])])
            ->map(fn ($token) => rtrim($token, 's'))
            ->filter(fn ($token) => strlen($token) > 1)
            ->unique();

        if ($asked->isEmpty()) {
            return [];
        }

        return $specs
            ->filter(function ($value, $key) use ($asked) {
                $words = collect($this->tokens($this->normalize((string) $key)))
                    ->reject(fn ($word) => in_array($word, self::SPEC_NOISE, true))
                    ->map(fn ($word) => rtrim($word, 's'));

                return $words->intersect($asked)->isNotEmpty();
            })
            ->map(fn ($value) => trim((string) $value))
            ->all();
    }

    private function productResponse(Collection $products): array
    {
        $reply = $products->count() === 1
            ? 'Here is a product that matches what you asked about:'
            : 'Here are some products that match what you asked about:';

        return [
            'reply' => $reply . "\n\nTap a product for full specifications, or ask me about delivery, warranty or a free demo.",
            'links' => [['label' => 'Browse all products', 'url' => route('store.search')]],
            'products' => $this->productCards($products),
        ];
    }

    private function fallbackResponse(): array
    {
        return [
            'reply' => "Sorry, I don't have an answer for that yet. I've noted your question for our team.\n\nYou can talk to a person on WhatsApp or by phone, or try asking about our products, prices, delivery or warranty.",
            'links' => [
                ['label' => 'Chat on WhatsApp', 'url' => 'https://wa.me/' . config('services.chatbot.whatsapp')],
                ['label' => 'Call us', 'url' => 'tel:+' . config('services.chatbot.whatsapp')],
            ],
            'products' => [],
        ];
    }

    private function productCards(Collection $products): array
    {
        return $products->map(function (Product $product) {
            $price = $product->sale_price && (float) $product->sale_price < (float) $product->price
                ? $product->sale_price
                : $product->price;

            return [
                'name' => $product->name,
                'url' => $product->url(),
                'image' => $product->primaryImage ? asset('storage/' . $product->primaryImage->image) : null,
                'price' => $product->hasPrice()
                    ? '₹' . number_format((float) $price) . ($product->price_unit ? ' / ' . $product->price_unit : '')
                    : 'Price on request',
            ];
        })->all();
    }

    /**
     * Lower-case, "55"" → "55 inch", punctuation stripped. Also used to build keywords (ProductChatbotFaqSeeder).
     */
    public function normalize(string $value): string
    {
        $value = mb_strtolower($value);
        $value = str_replace(['"', '”', '″'], ' inch ', $value);
        $value = preg_replace('/(\d+)\s*(inch|inches|in)\b/', '$1 inch', $value);
        // Pixel pitch stays one word: "P1.25" → "p125", not "p1" + "25" (which would match "25 kg").
        $value = preg_replace('/\bp(\d+)\.(\d+)\b/', 'p$1$2', $value);
        $value = preg_replace('/[^a-z0-9\s]/', ' ', $value);

        return trim(preg_replace('/\s+/', ' ', $value));
    }

    private function tokens(string $text): array
    {
        return array_values(array_unique(array_diff(explode(' ', $text), self::STOP_WORDS, [''])));
    }
}
