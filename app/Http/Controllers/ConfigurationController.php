<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConfigurationRequest;
use App\Http\Requests\UpdateConfigurationRequest;
use App\Http\Resources\ConfigurationResource;
use App\Models\Configuration;
use App\Models\Modello;
use App\Models\OptionalIncompatibility;
use Illuminate\Support\Facades\Auth;

class ConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Configuration::all();
    }

    public function show(string $id)
    {
        $configuration = Configuration::findOrFail($id);
        return response()->json([
                "success" => true,
                "data" => new ConfigurationResource($configuration)
            ], 200);
    }

    public function store(StoreConfigurationRequest $request)
    {
        try {
            $data = $request->validated();
    
            $model = Modello::findOrFail($data["model_id"]);

            $configuration = Configuration::create([
                'user_id' => Auth::id(),
                'model_id' => $data['model_id'],

                'color_id' => $data['color_id'] ?? null,
                'engine_variant_id' => null,

                'status' => 'draft',
                'current_step' => $data['current_step'],
                'total_price' => $model->base_price
            ]);

            return response()->json([
                "success" => true,
                "message" => "Configuration creata con successo",
                "data" => new ConfigurationResource($configuration)
            ], 201);
        } catch(\Exception $e) {
            return response()->json([
                    "success" => false,
                    "message" => $e->getMessage(),
                ], 500);
            }
    }

    public function update(UpdateConfigurationRequest $request, string $id)
    {
        $data = $request->validated();

        $configuration = Configuration::findOrFail($id);

        if (isset($data['optional_ids'])) {
            $optional_ids = $data['optional_ids'];

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
                        return response()->json([
                        'success' => false,
                        'message' => "Gli optional $id1 e $id2 non sono compatibili."
                    ], 422);
                    }
                }
            }
        }

        $configuration->update([
            'color_id' => $data['color_id'] ?? $configuration->color_id,
            'engine_variant_id' => $data['engine_variant_id'] ?? $configuration->engine_variant_id,
            'current_step' => $data['current_step'] ?? $configuration->current_step,
            'status' => $data['status'] ?? $configuration->status,
        ]);

        if (isset($data['optional_ids'])) {
            $configuration->optionals()->sync($data['optional_ids']);
        }

        if (isset($data['accessory_ids'])) {
            $configuration->accessories()->sync($data['accessory_ids']);
        }

        $configuration->load([
            'model',
            'color',
            'engine',
            'optionals',
            'accessories'
        ]);

        $totalPrice = $configuration->model->base_price;

        if ($configuration->color) {
            $totalPrice += $configuration->color->extra_price;
        }

        if ($configuration->engineVariant) {
            $totalPrice += $configuration->engineVariant->extra_price;
        }

        $totalPrice += $configuration->optionals->sum('price');

        $totalPrice += $configuration->accessories->sum('price');

        $configuration->update([
            'total_price' => $totalPrice
        ]);

        return response()->json([
            "success" => true,
            "message" => "Configuration aggiornata con successo",
            "data" => $configuration->fresh([
                'optionals',
                'accessories'
            ])
        ]);
    }

        
    public function destroy(string $id)
    {
        $configuration = Configuration::findOrFail($id);

        $configuration->delete();
    }
}

