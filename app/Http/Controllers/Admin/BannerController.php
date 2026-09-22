<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display all banners.
     */
    public function index()
    {
        $banners = Banner::orderBy('sort_order')->paginate(15);

        return view('admin.banners.index', compact('banners'));
    }


    /**
     * Show create banner form.
     */
    public function create()
    {
        return view('admin.banners.create');
    }


    /**
     * Store new banner.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_link' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $imagePath = $request->file('image')->store('banners', 'public');

        Banner::create([
            'title' => $validated['title'] ?? null,
            'subtitle' => $validated['subtitle'] ?? null,
            'image' => $imagePath,
            'button_text' => $validated['button_text'] ?? null,
            'button_link' => $validated['button_link'] ?? null,
            'status' => $request->boolean('status'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner created successfully.');
    }


    /**
     * Show edit banner form.
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }


    /**
     * Update banner.
     */
    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_link' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $imagePath = $banner->image;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('banners', 'public');
        }

        $banner->update([
            'title' => $validated['title'] ?? null,
            'subtitle' => $validated['subtitle'] ?? null,
            'image' => $imagePath,
            'button_text' => $validated['button_text'] ?? null,
            'button_link' => $validated['button_link'] ?? null,
            'status' => $request->boolean('status'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner updated successfully.');
    }


    /**
     * Delete banner.
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();

        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner deleted successfully.');
    }
}
