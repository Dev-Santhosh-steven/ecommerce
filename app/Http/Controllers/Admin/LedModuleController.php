<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LedModule;
use App\Models\Product;
use Illuminate\Http\Request;

class LedModuleController extends Controller
{
    /**
     * Modules shown in the public LED wall calculator.
     */
    public function index()
    {
        $modules = LedModule::with('product')
            ->orderBy('environment')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.led-modules.index', compact('modules'));
    }

    public function create()
    {
        return view('admin.led-modules.create', [
            'module' => new LedModule(),
            'products' => $this->products(),
        ]);
    }

    public function store(Request $request)
    {
        LedModule::create($this->validated($request));

        return redirect()
            ->route('admin.led-modules.index')
            ->with('success', 'LED module created successfully.');
    }

    public function edit(LedModule $ledModule)
    {
        return view('admin.led-modules.edit', [
            'module' => $ledModule,
            'products' => $this->products(),
        ]);
    }

    public function update(Request $request, LedModule $ledModule)
    {
        $ledModule->update($this->validated($request, $ledModule->id));

        return redirect()
            ->route('admin.led-modules.index')
            ->with('success', 'LED module updated successfully.');
    }

    public function destroy(LedModule $ledModule)
    {
        $ledModule->delete();

        return redirect()
            ->route('admin.led-modules.index')
            ->with('success', 'LED module deleted successfully.');
    }

    private function products()
    {
        return Product::orderBy('name')->get(['id', 'name', 'sku']);
    }

    /**
     * Same rules as the ERP module form, plus the store product link and sort order.
     */
    private function validated(Request $request, ?int $id = null): array
    {
        $validated = $request->validate([
            'product_id'           => ['nullable', 'exists:products,id'],
            'name'                 => ['required', 'string', 'max:255', 'unique:led_modules,name' . ($id ? ',' . $id : '')],
            'brand'                => ['nullable', 'string', 'max:255'],
            'model_number'         => ['nullable', 'string', 'max:255'],
            'environment'          => ['required', 'in:indoor,outdoor'],
            'length_mm'            => ['required', 'numeric', 'min:1'],
            'height_mm'            => ['required', 'numeric', 'min:1'],
            'pixel_width'          => ['required', 'integer', 'min:1'],
            'pixel_height'         => ['required', 'integer', 'min:1'],
            'pixel_pitch'          => ['nullable', 'numeric', 'min:0.01'],
            'pixel_config'         => ['nullable', 'string', 'max:50'],
            'weight_per_module_kg' => ['nullable', 'numeric', 'min:0'],
            'refresh_rate'         => ['nullable', 'string', 'max:50'],
            'scan_mode'            => ['nullable', 'string', 'max:50'],
            'brightness_nits'      => ['nullable', 'numeric', 'min:0'],
            'viewing_angle_h'      => ['nullable', 'integer', 'min:0', 'max:360'],
            'viewing_angle_v'      => ['nullable', 'integer', 'min:0', 'max:360'],
            'serviceability'       => ['nullable', 'string', 'max:100'],
            'power_max_wm2'        => ['nullable', 'numeric', 'min:0'],
            'power_avg_wm2'        => ['nullable', 'numeric', 'min:0'],
            'input_voltage'        => ['nullable', 'string', 'max:100'],
            'cabinet_w_mm'         => ['nullable', 'numeric', 'min:0'],
            'cabinet_h_mm'         => ['nullable', 'numeric', 'min:0'],
            'cabinet_d_mm'         => ['nullable', 'numeric', 'min:0'],
            'cabinet_weight_kg'    => ['nullable', 'numeric', 'min:0'],
            'cabinet_material'     => ['nullable', 'string', 'max:100'],
            'sort_order'           => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['pixel_config'] = $validated['pixel_config'] ?? '1R1G1B';

        return $validated;
    }
}
