<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateConfigurationRequest extends FormRequest
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
            'user_id' => ['sometimes', 'integer', 'exists:users,id'],
            'model_id' => ['sometimes', 'integer', 'exists:models,id'],
            'engine_variant_id' => ['sometimes', 'integer', 'exists:engine_variants,id'],
            'color_id' => ['sometimes', 'integer', 'exists:colors,id'],
            'status' => ['sometimes', 'string'],
            'current_step' => ['sometimes', 'integer'],
            'total_price' => ['sometimes', 'numeric'],
            'optional_ids' => ['sometimes', 'array'],
            'optional_ids.*' => ['integer'],
            'accessory_ids' => ['sometimes', 'array'],
            'accessory_ids.*' => ['integer'],
        ];
    }
}
