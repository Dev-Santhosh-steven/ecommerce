<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\LedModule;
use App\Services\LedCalculationService;
use Illuminate\Http\Request;

class LedWallCalculatorController extends Controller
{
    public function __construct(private LedCalculationService $calculationService)
    {
    }

    public function index()
    {
        $modules = LedModule::active()->with('product.primaryImage')->get();

        $category = Category::active()->where('slug', 'led-video-walls')->first();

        return view('store.led-calculator', [
            'modules' => $modules->map(fn (LedModule $m) => $this->publicModule($m))->values(),
            'category' => $category,
        ]);
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'module_id' => ['required', 'exists:led_modules,id'],
            'width' => ['nullable', 'numeric', 'min:0.1', 'max:100000'],
            'height' => ['nullable', 'numeric', 'min:0.1', 'max:100000'],
            'unit' => ['required', 'in:mm,ft,m,in'],
            'aspect_ratio' => ['nullable', 'in:16:9,9:16,1:1,16:10,21:9,4:3'],
            'lock_axis' => ['nullable', 'in:width,height'],
        ]);

        if (!$request->width || !$request->height) {
            return response()->json(['error' => 'Please enter both the width and the height of your wall space.'], 422);
        }

        $module = LedModule::active()->with('product')->findOrFail($request->module_id);

        $result = $this->calculationService->calculate(
            $module,
            $request->width,
            $request->height,
            $request->unit,
            $request->aspect_ratio,
            $request->lock_axis,
        );

        $unitPrice = $module->product ? (float) ($module->product->sale_price ?: $module->product->price) : null;
        $perSqFt = $module->product?->price_unit === 'sq ft';

        foreach ($result['suggestions'] as &$sc) {
            $sc = $this->calculationService->enrichWithCabinets($sc, $module);
            $sc = $this->calculationService->enrichWithEstimates($sc, $module);

            // Indicative budget for the LED screen only, when the product is priced per sq ft.
            $sc['estimate_inr'] = $unitPrice && $perSqFt && isset($sc['area_sqft'])
                ? round($sc['area_sqft'] * $unitPrice, -2)
                : null;
        }
        unset($sc);

        $result['module'] = $this->publicModule($module);

        return response()->json($result);
    }

    /**
     * Fields the calculator UI needs — keeps internal columns out of the page source.
     */
    private function publicModule(LedModule $m): array
    {
        return [
            'id' => $m->id,
            'name' => $m->name,
            'environment' => $m->environment,
            'pixel_pitch' => $m->pixel_pitch,
            'length_mm' => $m->length_mm,
            'height_mm' => $m->height_mm,
            'pixel_width' => $m->pixel_width,
            'pixel_height' => $m->pixel_height,
            'brightness_nits' => $m->brightness_nits,
            'refresh_rate' => $m->refresh_rate,
            'viewing_angle_h' => $m->viewing_angle_h,
            'viewing_angle_v' => $m->viewing_angle_v,
            'serviceability' => $m->serviceability,
            'cabinet_w_mm' => $m->cabinet_w_mm,
            'cabinet_h_mm' => $m->cabinet_h_mm,
            'cabinet_material' => $m->cabinet_material,
            'product_url' => $m->product?->status ? route('store.product', $m->product) : null,
            'image' => $m->product?->primaryImage ? asset('storage/' . $m->product->primaryImage->image) : null,
        ];
    }
}
