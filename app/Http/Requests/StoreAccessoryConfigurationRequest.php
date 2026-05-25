<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAccessoryConfigurationRequest extends FormRequest
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
            'configuration_id' => ['required', 'exists:configuraion_id'],
            'accessory_ids' => ['required', 'array'],
            'accessory_ids.*' => ['sometimes','exists:accessories,id'],
        ];
    }
}
