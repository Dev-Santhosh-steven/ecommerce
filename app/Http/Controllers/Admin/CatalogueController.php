<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use Illuminate\Http\Request;

class CatalogueController extends Controller
{
    /**
     * Display all catalogues.
     */
    public function index()
    {
        $catalogues = Catalogue::orderBy('sort_order')->paginate(15);

        return view('admin.catalogues.index', compact('catalogues'));
    }


    /**
     * Show create catalogue form.
     */
    public function create()
    {
        return view('admin.catalogues.create');
    }


    /**
     * Store new catalogue.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'file' => ['required', 'file', 'mimes:pdf', 'max:20480'],
            'status' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $filePath = $request->file('file')->store('catalogues', 'public');

        Catalogue::create([
            'title' => $validated['title'],
            'file' => $filePath,
            'status' => $request->boolean('status'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()
            ->route('admin.catalogues.index')
            ->with('success', 'Catalogue created successfully.');
    }


    /**
     * Show edit catalogue form.
     */
    public function edit(Catalogue $catalogue)
    {
        return view('admin.catalogues.edit', compact('catalogue'));
    }


    /**
     * Update catalogue.
     */
    public function update(Request $request, Catalogue $catalogue)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'file' => ['nullable', 'file', 'mimes:pdf', 'max:20480'],
            'status' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $filePath = $catalogue->file;

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('catalogues', 'public');
        }

        $catalogue->update([
            'title' => $validated['title'],
            'file' => $filePath,
            'status' => $request->boolean('status'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()
            ->route('admin.catalogues.index')
            ->with('success', 'Catalogue updated successfully.');
    }


    /**
     * Delete catalogue.
     */
    public function destroy(Catalogue $catalogue)
    {
        $catalogue->delete();

        return redirect()
            ->route('admin.catalogues.index')
            ->with('success', 'Catalogue deleted successfully.');
    }
}
