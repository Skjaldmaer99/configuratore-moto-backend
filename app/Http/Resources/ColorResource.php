<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ColorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'model_id' => $this->model_id,
            'name' => $this->name,
            'hex_code' => $this->hex_code,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'extra_price' => $this->extra_price
        ];
    }
}
