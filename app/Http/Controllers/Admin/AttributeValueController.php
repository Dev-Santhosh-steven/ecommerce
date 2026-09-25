<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    /**
     * Add a new value to an attribute.
     */
    public function store(Request $request, Attribute $attribute)
    {
        $validated = $request->validate([
            'value' => ['required', 'string', 'max:255', 'unique:attribute_values,value,NULL,id,attribute_id,' . $attribute->id],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $attribute->values()->create([
            'value' => $validated['value'],
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()
            ->route('admin.attributes.edit', $attribute)
            ->with('success', 'Value added successfully.');
    }


    /**
     * Delete an attribute value.
     */
    public function destroy(Attribute $attribute, AttributeValue $value)
    {
        abort_unless($value->attribute_id === $attribute->id, 404);

        $value->delete();

        return redirect()
            ->route('admin.attributes.edit', $attribute)
            ->with('success', 'Value deleted successfully.');
    }
}
