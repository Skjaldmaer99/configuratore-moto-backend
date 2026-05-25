<?php

namespace App\Services;

use App\Models\Color;
use App\Models\Engine;
use App\Models\ModelAccessoryCompatibility;
use App\Models\Modello;
use App\Models\ModelOptionalCompatibility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/* 
{
    "model": {
        "name": "Naked 900",
        "base_price": 12000
    },
    "engine_variants": [
        { "name": "900cc", "price": 0 },
        { "name": "1000cc", "price": 1500 },
        { "name": "1200cc", "price": 3000 }
    ],
    "colors": [
        { "name": "Red", "price": 0 },
        { "name": "Black", "price": 200 }
    ],
    "optionals": [
        { "name": "Sport Pack", "price": 1200 },
        { "name": "Comfort Pack", "price": 900 }
    ]
}
   */

class CatalogCreationService {
    public function create(array $data) {
        return DB::transaction(function () use($data) {
            //modello
            $model = Modello::create([
                'brand' => $data['model']['brand'],
                'name' => $data['model']['name'],
                'category' => $data['model']['category'],
                'base_price' => $data['model']['base_price'],
                'description' => $data['model']['description']
            ]);
             //colors
            foreach ($data['colors'] as $color) {
                $imagePath = null;
                if (isset($color['image'])) {
                    $imagePath = $color['image']->store(
                        'colors',
                        'public'
                    );
                }
                $model->colors()->create([
                    'name' => $color['name'],
                    'hex_code' => $color['hex_code'],
                    'extra_price' => $color['extra_price'],
                    'image' => $imagePath
                ]);
            }
            //engine_variant_1
            foreach($data['engine_variants'] as $engine) {
                $model->engines()->create([
                    'name' => $engine['name'],
                    'displacement_cc' => $engine['displacement_cc'],
                    'cylinders' => $engine['cylinders'],
                    'engine_type' => $engine['engine_type'],
                    'horsepower' => $engine['horsepower'],
                    'gearbox' => $engine['gearbox'],
                    'fuel_type' => $engine['fuel_type'],
                    'extra_price' => $engine['extra_price']
                ]);
            }

            // metti gli optional compatibili con il modello nella pivot
            foreach ($data['model_optional_compatibility'] ?? [] as $row) {
                ModelOptionalCompatibility::firstOrCreate([
                    'model_id' => $model->id,
                    'optional_id' => $row['optional_id'],
                ]);
            }
            //accessori compatibili con il modello nella pivot
            foreach($data['model_accessory_compatibility'] ?? [] as $row) {
                ModelAccessoryCompatibility::firstOrCreate([
                    'model_id' => $model->id,
                    'accessory_id' => $row['accessory_id'],
                ]);
            }

            return $model->load([
                'colors',
                'engines',
            ]);
        });
    }
}