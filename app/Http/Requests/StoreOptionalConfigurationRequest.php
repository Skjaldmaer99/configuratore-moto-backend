<?php

namespace App\Http\Requests;

use App\Models\OptionalIncompatibility;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreOptionalConfigurationRequest extends FormRequest
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
            'configuration_id' => "'required', 'exists:configurations,id'",
            'optional_ids' => "'required','array'",
            'optional_ids.*' => "'sometimes','exists:optionals,id'"
        ];
    }

    public function withValidator(Validator $validator) {
        $validator->after(function ($validator) {
            $optional_ids = $this->optional_ids;

            foreach($optional_ids as $id1) {
                foreach($optional_ids as $id2) {
                    if($id1 == $id2) continue;

                    $exists = OptionalIncompatibility::query()
                    ->where(function ($query) use ($id1, $id2) {
                    $query->where('optional_1_id', $id1)
                        ->where('optional_2_id', $id2);
                    })
                    ->orWhere(function ($query) use ($id1, $id2) {
                        $query->where('optional_1_id', $id2)
                            ->where('optional_2_id', $id1);
                        })
                        ->exists();

                    if($exists) {
                        $validator->errors()->add(
                        'optional_ids',
                        "Gli optional $id1 e $id2 non sono compatibili."
                    );
                    return;
                    }
                }
            }
        });
    }
}
