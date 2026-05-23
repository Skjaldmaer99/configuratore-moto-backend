<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEngineRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'model_id' => ['required', 'exists:models,id'],
            'variant_name' => ['required', 'string', 'max:100'],
            'displacement_cc' => ['required', 'integer', 'min:50'],
            'cylinders' => ['required', 'integer', 'min:1'],
            'engine_type' => ['required', 'string', 'max:100'],
            'horsepower' => ['required', 'integer', 'min:1'],
            'gearbox' => ['required', 'in:manuale,semi-automatico,automatico,dct'],
            'fuel_type' => ['required', 'in:benzina,diesel,elettrica'],
            'extra_price' => ['required', 'numeric', 'min:0']
        ];
    }
}
