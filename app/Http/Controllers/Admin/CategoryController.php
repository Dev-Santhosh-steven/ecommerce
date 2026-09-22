<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display all categories.
     */
    public function index()
    {
        $categories = Category::with('parent')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }


    /**
     * Show create category form.
     */
    public function create()
    {
        $parentCategories = Category::whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return view(
            'admin.categories.create',
            compact('parentCategories')
        );
    }


    /**
     * Store new category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:categories,slug',
            ],

            'parent_id' => [
                'nullable',
                'integer',
                'exists:categories,id',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'status' => [
                'nullable',
                'boolean',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Generate slug automatically if admin leaves it empty
        |--------------------------------------------------------------------------
        */

        $slug = $validated['slug'] ?? null;

        if (!$slug) {
            $slug = Str::slug($validated['name']);
        }

        /*
        |--------------------------------------------------------------------------
        | Make sure generated slug is unique
        |--------------------------------------------------------------------------
        */

        $originalSlug = $slug;
        $counter = 1;

        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }


        /*
        |--------------------------------------------------------------------------
        | Upload image
        |--------------------------------------------------------------------------
        */

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request
                ->file('image')
                ->store('categories', 'public');
        }


        /*
        |--------------------------------------------------------------------------
        | Create category
        |--------------------------------------------------------------------------
        */

        Category::create([
            'parent_id' => $validated['parent_id'] ?? null,
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
            'status' => $request->boolean('status'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);


        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }


    /**
     * Show edit category form.
     */
    public function edit(Category $category)
    {
        $parentCategories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();

        return view(
            'admin.categories.edit',
            compact('category', 'parentCategories')
        );
    }


    /**
     * Update category.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')
                    ->ignore($category->id),
            ],

            'parent_id' => [
                'nullable',
                'integer',
                'exists:categories,id',
                'not_in:' . $category->id,
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'status' => [
                'nullable',
                'boolean',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Generate slug if empty
        |--------------------------------------------------------------------------
        */

        $slug = $validated['slug'] ?? null;

        if (!$slug) {
            $slug = Str::slug($validated['name']);
        }


        /*
        |--------------------------------------------------------------------------
        | Make sure generated slug is unique
        |--------------------------------------------------------------------------
        */

        $originalSlug = $slug;
        $counter = 1;

        while (
            Category::where('slug', $slug)
                ->where('id', '!=', $category->id)
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }


        /*
        |--------------------------------------------------------------------------
        | Upload new image
        |--------------------------------------------------------------------------
        */

        $imagePath = $category->image;

        if ($request->hasFile('image')) {

            $imagePath = $request
                ->file('image')
                ->store('categories', 'public');
        }


        /*
        |--------------------------------------------------------------------------
        | Update category
        |--------------------------------------------------------------------------
        */

        $category->update([
            'parent_id' => $validated['parent_id'] ?? null,
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
            'status' => $request->boolean('status'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);


        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }


    /**
     * Delete category.
     */
    public function destroy(Category $category)
    {
        /*
        |--------------------------------------------------------------------------
        | Prevent deletion when products belong to this category
        |--------------------------------------------------------------------------
        */

        if ($category->products()->exists()) {

            return back()->with(
                'error',
                'This category cannot be deleted because products are assigned to it.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Prevent deletion when subcategories exist
        |--------------------------------------------------------------------------
        */

        if ($category->children()->exists()) {

            return back()->with(
                'error',
                'This category cannot be deleted because it has subcategories.'
            );
        }


        $category->delete();


        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }


    /**
     * Toggle category status.
     */
    public function toggleStatus(Category $category)
    {
        $category->update([
            'status' => !$category->status,
        ]);

        return back()->with(
            'success',
            'Category status updated successfully.'
        );
    }
}