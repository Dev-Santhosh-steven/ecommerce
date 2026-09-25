<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DemoRequest;
use Illuminate\Http\Request;

class DemoRequestController extends Controller
{
    public function create(Request $request)
    {
        $categories = Category::active()->orderBy('sort_order')->orderBy('name')->get();

        // Optional prefill, e.g. from the LED wall calculator's "Request a Demo" button.
        $prefill = [
            'category_id' => $categories->firstWhere('slug', $request->query('category'))?->id,
            'purpose' => array_key_exists($request->query('purpose'), DemoRequest::PURPOSES) ? $request->query('purpose') : null,
            'message' => mb_substr((string) $request->query('message'), 0, 1000),
        ];

        return view('store.book-a-demo', [
            'categories' => $categories,
            'purposes' => DemoRequest::PURPOSES,
            'prefill' => $prefill,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'organization' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'purpose' => ['required', 'string', 'in:' . implode(',', array_keys(DemoRequest::PURPOSES))],
            'preferred_date' => ['nullable', 'date', 'after_or_equal:today'],
            'message' => ['nullable', 'string', 'max:1000'],
        ]);

        DemoRequest::create($validated);

        return redirect()
            ->route('store.demo.create')
            ->with('success', "Thanks, {$validated['name']}! Your demo request has been received. Our team will reach out to you shortly.");
    }
}
