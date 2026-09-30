<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    /**
     * Display all testimonials.
     */
    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order')->latest()->paginate(15);

        return view('admin.testimonials.index', compact('testimonials'));
    }


    /**
     * Show create testimonial form.
     */
    public function create()
    {
        return view('admin.testimonials.create', ['testimonial' => new Testimonial(['rating' => 5, 'status' => true])]);
    }


    /**
     * Store new testimonial.
     */
    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('testimonials', 'public');
        }

        Testimonial::create($data);

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'Testimonial created successfully.');
    }


    /**
     * Show edit testimonial form.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }


    /**
     * Update testimonial.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $this->validated($request);

        if ($request->hasFile('photo')) {
            $this->deletePhoto($testimonial);
            $data['photo'] = $request->file('photo')->store('testimonials', 'public');
        } elseif ($request->boolean('remove_photo')) {
            $this->deletePhoto($testimonial);
            $data['photo'] = null;
        }

        $testimonial->update($data);

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'Testimonial updated successfully.');
    }


    /**
     * Delete testimonial.
     */
    public function destroy(Testimonial $testimonial)
    {
        $this->deletePhoto($testimonial);

        $testimonial->delete();

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'Testimonial deleted successfully.');
    }


    private function validated(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:1000'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'status' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        unset($validated['photo']);

        return [
            ...$validated,
            'status' => $request->boolean('status'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ];
    }


    private function deletePhoto(Testimonial $testimonial): void
    {
        if ($testimonial->photo) {
            Storage::disk('public')->delete($testimonial->photo);
        }
    }
}
