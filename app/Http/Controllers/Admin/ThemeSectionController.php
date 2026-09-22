<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThemeSection;
use Illuminate\Http\Request;

class ThemeSectionController extends Controller
{
    public function index()
    {
        $themeSections = ThemeSection::orderBy('page')->orderBy('position')->get();

        return view('admin.theme-sections.index', compact('themeSections'));
    }

    public function create()
    {
        return view('admin.theme-sections.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'page' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'position' => ['nullable', 'integer', 'min:0'],
            'status' => ['boolean'],
            'settings' => ['nullable', 'array'],
        ]);

        ThemeSection::create($validated);

        return redirect()->route('admin.theme-sections.index')->with('success', 'Theme section created successfully.');
    }

    public function edit(ThemeSection $themeSection)
    {
        return view('admin.theme-sections.edit', compact('themeSection'));
    }

    public function update(Request $request, ThemeSection $themeSection)
    {
        $validated = $request->validate([
            'page' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'position' => ['nullable', 'integer', 'min:0'],
            'status' => ['boolean'],
            'settings' => ['nullable', 'array'],
        ]);

        $themeSection->update($validated);

        return redirect()->route('admin.theme-sections.index')->with('success', 'Theme section updated successfully.');
    }

    public function destroy(ThemeSection $themeSection)
    {
        $themeSection->delete();

        return redirect()->route('admin.theme-sections.index')->with('success', 'Theme section deleted successfully.');
    }
}
