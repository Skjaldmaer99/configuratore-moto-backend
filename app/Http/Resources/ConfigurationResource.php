<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConfigurationResource extends JsonResource
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
            "user_id" => $this->user_id,
            "model_id" => $this->model_id,
            "engine_variant_id" => $this->engine_variant_id,
            "color_id" => $this->color_id,
            "total_price" => $this->total_price,
            "current_step" => $this->current_step,
            "status" => $this->status,

            "model" => new ModelResource($this->model),
            "engine" => $this->engine,
            "color" => new ColorResource($this->color),
            "optionals" => $this->optionals,
            "accessories" => $this->accessories,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
