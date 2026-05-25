<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CatalogCreationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
            return [
            'model.brand' => 'required|string|max:255',
            'model.name' => 'required|string|max:255',
            'model.category' => 'required|string|max:255',
            'model.base_price' => 'required|numeric|min:0',
            'model.description' => 'nullable|string',

            'colors' => 'required|array|min:1',
            'colors.*.name' => 'required|string|max:255',
            'colors.*.hex_code' => [ 'required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'colors.*.extra_price' => 'required|numeric|min:0',
            'colors.*.image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

            'engine_variants' => 'required|array|min:1',
            'engine_variants.*.name' => 'required|string|max:255',
            'engine_variants.*.displacement_cc' => 'required|integer|min:1',
            'engine_variants.*.cylinders' => 'required|integer|min:1',
            'engine_variants.*.engine_type' => 'required|string|max:255',
            'engine_variants.*.horsepower' => 'required|integer|min:1',
            'engine_variants.*.gearbox' => 'required|string|max:255',
            'engine_variants.*.fuel_type' => 'required|string|max:255',
            'engine_variants.*.extra_price' => 'required|numeric|min:0',

            'model_optional_compatibility' => 'nullable|array',
            'model_optional_compatibility.*.optional_id' => 'required|exists:optionals,id',
            
            'model_accessory_compatibility'=> 'nullable|array',
            'model_accessory_compatibility.*.accessory_id'=> 'required|exists:accessories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'model.brand.required' => 'The brand field is required.',
            'model.name.required' => 'The model name field is required.',
            'model.base_price.required' => 'The base price field is required.',

            'colors.required' => 'At least one color is required.',
            'colors.*.hex_code.regex' => 'The color hex code format is invalid.',

            'engine_variants.required' => 'At least one engine variant is required.',
        ];
    }
}
