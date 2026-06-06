<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ModelResource extends JsonResource
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
            'brand' => $this->brand,
            'name' => $this->name,
            'category' => $this->category,
            'base_price' => $this->base_price,
            'description' => $this->description,
            'colors' => ColorResource::collection($this->colors),
            'engine_variants' => $this->engines,
            'optionals' => $this->optionals,
            'accessories' => $this->accessories
        ];
    }
}
