<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificationController extends Controller
{
    /**
     * Display all certifications.
     */
    public function index()
    {
        $certifications = Certification::orderBy('sort_order')->orderBy('id')->paginate(20);

        return view('admin.certifications.index', compact('certifications'));
    }

    /**
     * Show create certification form.
     */
    public function create()
    {
        return view('admin.certifications.create', ['certification' => new Certification(['status' => true])]);
    }

    /**
     * Store new certification.
     */
    public function store(Request $request)
    {
        Certification::create($this->data($request, new Certification()));

        return redirect()
            ->route('admin.certifications.index')
            ->with('success', 'Certification created successfully.');
    }

    /**
     * Show edit certification form.
     */
    public function edit(Certification $certification)
    {
        return view('admin.certifications.edit', compact('certification'));
    }

    /**
     * Update certification.
     */
    public function update(Request $request, Certification $certification)
    {
        $certification->update($this->data($request, $certification));

        return redirect()
            ->route('admin.certifications.index')
            ->with('success', 'Certification updated successfully.');
    }

    /**
     * Delete certification and its uploaded files.
     */
    public function destroy(Certification $certification)
    {
        foreach ([$certification->file, $certification->logo] as $path) {
            if ($path && ! str_starts_with($path, 'images/')) {
                Storage::disk('public')->delete($path);
            }
        }

        $certification->delete();

        return redirect()
            ->route('admin.certifications.index')
            ->with('success', 'Certification deleted successfully.');
    }

    /**
     * Validated fields, with uploaded logo / document stored (replacing the old upload).
     */
    private function data(Request $request, Certification $certification): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'issuer' => ['nullable', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:40'],
            'description' => ['nullable', 'string', 'max:1000'],
            'icon' => ['nullable', 'string', 'max:60'],
            'logo' => ['nullable', 'image', 'max:4096'],
            'file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:20480'],
            'remove_file' => ['nullable', 'boolean'],
            'status' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data = [
            'title' => $validated['title'],
            'issuer' => $validated['issuer'] ?? null,
            'code' => $validated['code'] ?? null,
            'description' => $validated['description'] ?? null,
            'icon' => $validated['icon'] ?? null,
            'status' => $request->boolean('status'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ];

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('certifications/logos', 'public');
            $this->forget($certification->logo);
        }

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('certifications', 'public');
            $this->forget($certification->file);
        } elseif ($request->boolean('remove_file')) {
            $this->forget($certification->file);
            $data['file'] = null;
        }

        return $data;
    }

    /** Delete an old upload (bundled images under images/ are never deleted). */
    private function forget(?string $path): void
    {
        if ($path && ! str_starts_with($path, 'images/')) {
            Storage::disk('public')->delete($path);
        }
    }
}
