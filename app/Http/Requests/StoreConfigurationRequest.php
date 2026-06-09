<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreConfigurationRequest extends FormRequest
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
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'model_id' => ['required', 'integer', 'exists:models,id'],
            'engine_variant_id' => ['nullable', 'integer', 'exists:engine_variants,id'],
            'color_id' => ['nullable', 'integer', 'exists:colors,id'],
            'status' => ['required', 'string'],
            'current_step' => ['required', 'integer'],
            'total_price' => ['nullable','numeric'],
        ];
    }
}
