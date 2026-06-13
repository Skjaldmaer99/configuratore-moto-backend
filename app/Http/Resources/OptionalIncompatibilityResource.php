<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OptionalIncompatibilityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "optional_1_id" => $this->optional_1_id,
            "optional_2_id" => $this->optional_2_id,
            "optional1" => $this->optional1,
            "optional2" => $this->optional2,
        ];
    }
}
