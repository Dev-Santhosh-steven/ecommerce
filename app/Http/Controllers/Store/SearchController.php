<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Search\SearchEngine;
use App\Services\Search\Text;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class SearchController extends Controller
{
    private const PER_PAGE = 12;

    private const SORTS = ['relevance' => 'Best match', 'popular' => 'Most popular', 'price_asc' => 'Price: low to high', 'price_desc' => 'Price: high to low', 'newest' => 'Newest'];

    public function __construct(private SearchEngine $engine)
    {
    }

    /**
     * Full search results page. Understands everyday language: "tv under 20k", "ac for bedroom",
     * "washing machine for family of 5", "cheapest 55 inch smart tv".
     */
    public function index(Request $request)
    {
        $query = trim((string) $request->input('q'));
        $drop = array_values(array_filter((array) $request->input('drop', []), 'is_string'));
        $sort = array_key_exists((string) $request->input('sort'), self::SORTS) ? $request->input('sort') : null;
        $category = $request->filled('category') ? (string) $request->input('category') : null;

        $result = $this->engine->search($query, $drop, $sort, $category);

        $page = LengthAwarePaginator::resolveCurrentPage();
        $pageIds = array_slice($result->ids, ($page - 1) * self::PER_PAGE, self::PER_PAGE);

        $products = new LengthAwarePaginator(
            $this->load($pageIds),
            count($result->ids),
            self::PER_PAGE,
            $page,
            ['path' => $request->url(), 'query' => $request->query()],
        );

        return view('store.search', [
            'products' => $products,
            'query' => $query,
            'result' => $result,
            'sorts' => self::SORTS,
            'currentSort' => $sort ?? ($result->parsed->sort ?? 'relevance'),
            'drop' => $drop,
            'category' => $category,
        ]);
    }

    /**
     * Instant suggestions (JSON) for the header search box: what we understood, products and pages.
     */
    public function suggest(Request $request)
    {
        $query = trim((string) $request->input('q'));

        if (mb_strlen($query) < 2) {
            return response()->json(['products' => [], 'chips' => [], 'pages' => [], 'notes' => []]);
        }

        $result = $this->engine->search($query);

        return response()->json([
            'chips' => array_values($result->parsed->chips()),
            'corrected' => $result->parsed->corrected,
            'notes' => $result->fallback ? [] : array_slice($result->notes, 0, 1),
            'total' => $result->fallback ? 0 : count($result->ids),
            'products' => $result->fallback ? [] : $this->load(array_slice($result->ids, 0, 6))->map(fn (Product $product) => [
                'name' => $product->name,
                'url' => $product->url(),
                'image' => $product->primaryImage ? asset('storage/' . $product->primaryImage->image) : null,
                'price' => $product->hasPrice() ? Text::rupees($product->unitPrice()) : null,
                'category' => $product->category?->name,
            ])->values(),
            'pages' => array_slice($result->pages, 0, 3),
            'answer' => $result->answer ? ['question' => $result->answer->question, 'url' => $result->answer->button_url] : null,
        ]);
    }

    /**
     * Products in the given order, with what the cards need.
     */
    private function load(array $ids): Collection
    {
        if (! $ids) {
            return collect();
        }

        $products = Product::whereIn('id', $ids)->with(['primaryImage', 'category'])->get()->keyBy('id');

        return collect($ids)->map(fn ($id) => $products[$id] ?? null)->filter()->values();
    }
}
