@php
    $input = 'w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-slate-500 focus:outline-none';
    $label = 'mb-1 block text-sm font-medium text-slate-700';

    $fields = [
        'Module' => [
            ['name', 'Name', 'text', 'e.g. Yara P2.5 Indoor', true],
            ['brand', 'Brand', 'text', 'Yara'],
            ['model_number', 'Model Number', 'text', 'YE-LED-P25-IN'],
            ['length_mm', 'Module Width (mm)', 'number:0.01', '320', true],
            ['height_mm', 'Module Height (mm)', 'number:0.01', '160', true],
            ['pixel_width', 'Pixels (W)', 'number:1', '128', true],
            ['pixel_height', 'Pixels (H)', 'number:1', '64', true],
            ['pixel_pitch', 'Pixel Pitch (mm)', 'number:0.0001', '2.5'],
            ['pixel_config', 'Pixel Config', 'text', '1R1G1B'],
        ],
        'Technical' => [
            ['weight_per_module_kg', 'Weight / Module (kg)', 'number:0.001', '0.4'],
            ['refresh_rate', 'Refresh Rate', 'text', 'e.g. ≥3840Hz'],
            ['scan_mode', 'Scan Mode', 'text', 'e.g. 1/32 scan'],
            ['brightness_nits', 'Brightness (cd/m²)', 'number:0.01', 'e.g. 800'],
            ['viewing_angle_h', 'Viewing Angle H (°)', 'number:1', '160'],
            ['viewing_angle_v', 'Viewing Angle V (°)', 'number:1', '140'],
            ['input_voltage', 'Input Voltage', 'text', '220V ± 10%'],
            ['power_max_wm2', 'Max Power (W/m²)', 'number:0.01', 'e.g. 600'],
            ['power_avg_wm2', 'Avg Power (W/m²)', 'number:0.01', 'e.g. 200'],
        ],
        'Cabinet' => [
            ['cabinet_w_mm', 'Cabinet Width (mm)', 'number:0.01', 'e.g. 640'],
            ['cabinet_h_mm', 'Cabinet Height (mm)', 'number:0.01', 'e.g. 480'],
            ['cabinet_d_mm', 'Cabinet Depth (mm)', 'number:0.01', 'e.g. 75'],
            ['cabinet_weight_kg', 'Cabinet Weight (kg)', 'number:0.01', 'e.g. 7.5'],
            ['cabinet_material', 'Cabinet Material', 'text', 'Die-cast aluminium'],
        ],
    ];
@endphp

@if ($errors->any())
    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        Please fix the highlighted fields below.
    </div>
@endif

<div class="grid gap-5 md:grid-cols-3">
    <div>
        <label class="{{ $label }}">Environment <span class="text-red-500">*</span></label>
        <select name="environment" class="{{ $input }}" required>
            @foreach (['indoor' => 'Indoor', 'outdoor' => 'Outdoor'] as $value => $text)
                <option value="{{ $value }}" @selected(old('environment', $module->environment ?? 'indoor') === $value)>{{ $text }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="{{ $label }}">Serviceability</label>
        <select name="serviceability" class="{{ $input }}">
            <option value="">— Select —</option>
            @foreach (['Front maintenance', 'Rear maintenance', 'Front & rear maintenance'] as $option)
                <option value="{{ $option }}" @selected(old('serviceability', $module->serviceability) === $option)>{{ $option }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="{{ $label }}">Store Product</label>
        <select name="product_id" class="{{ $input }}">
            <option value="">— Not linked —</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}" @selected((string) old('product_id', $module->product_id) === (string) $product->id)>
                    {{ $product->name }} ({{ $product->sku }})
                </option>
            @endforeach
        </select>
        <p class="mt-1 text-xs text-slate-500">Links calculator results to the product page and its per-sq-ft price.</p>
        @error('product_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

@foreach ($fields as $section => $rows)
    <h3 class="mb-4 mt-8 border-b border-slate-200 pb-2 text-sm font-semibold uppercase tracking-wider text-slate-500">{{ $section }}</h3>

    <div class="grid gap-5 md:grid-cols-3">
        @foreach ($rows as $row)
            @php
                [$name, $text, $type, $placeholder] = $row;
                $required = $row[4] ?? false;
                [$type, $step] = array_pad(explode(':', $type), 2, null);
            @endphp
            <div>
                <label class="{{ $label }}">{{ $text }} @if ($required)<span class="text-red-500">*</span>@endif</label>
                <input
                    type="{{ $type }}"
                    name="{{ $name }}"
                    @if ($step) step="{{ $step }}" min="0" @endif
                    value="{{ old($name, $module->{$name}) }}"
                    placeholder="{{ $placeholder }}"
                    class="{{ $input }} @error($name) border-red-400 @enderror"
                    @required($required)
                >
                @error($name) <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        @endforeach
    </div>
@endforeach

<div class="mt-8 grid gap-5 md:grid-cols-3">
    <div>
        <label class="{{ $label }}">Sort Order</label>
        <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $module->sort_order ?? 0) }}" class="{{ $input }}">
    </div>

    <label class="flex items-center gap-3 self-end pb-2 text-sm font-medium text-slate-700">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" class="h-4 w-4 rounded border-slate-300" @checked(old('is_active', $module->exists ? $module->is_active : true))>
        Show in public calculator
    </label>
</div>
