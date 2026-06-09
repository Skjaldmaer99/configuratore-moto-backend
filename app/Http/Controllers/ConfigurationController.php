<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConfigurationRequest;
use App\Http\Requests\UpdateConfigurationRequest;
use App\Http\Resources\ConfigurationResource;
use App\Models\Configuration;
use App\Models\Modello;
use Illuminate\Support\Facades\Auth;

// abbiamo configurations, optional_compatibility, model_optional_incompatibility, configuration_optionals, configuration_accessories, model_accessory_compatibility, quotes

// -> /configurations/{id}/color
// -> /configurations/{id}/engine
// -> /configurations/{id}/optionals
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
                'current_step' => 1,
                'total_price' => $model->base_price
            ]);

            return response()->json([
                "success" => true,
                "message" => "Configuration creata con successo",
                "data" => $configuration
            ], 201);
        } catch(\Exception $e) {
            return response()->json([
                    "success" => false,
                    "message" => $e->getMessage(),
                ], 500);
            }
    }

    /* public function update(UpdateConfigurationRequest $request, string $id)
    {
        try {
            $data = $request->validated();

            $configuration = Configuration::findOrFail($id);

            // 1. aggiorna campi normali
            $configuration->update([
                'color_id' => $data['color_id'] ?? $configuration->color_id,
                'engine_variant_id' => $data['engine_variant_id'] ?? $configuration->engine_variant_id,
                'current_step' => $data['current_step'] ?? $configuration->current_step,
                'total_price' => $data['total_price'] ?? $configuration->total_price,
                'status' => $data['status'] ?? $configuration->status,
            ]);

            // 2. pivot optionals
            if (isset($data['optional_ids'])) {
                $configuration->optionals()->sync($data['optional_ids']);
            }

            // 3. pivot accessories
            if (isset($data['accessory_ids'])) {
                $configuration->accessories()->sync($data['accessory_ids']);
            }

            return response()->json([
                "success" => true,
                "message" => "Configuration aggiornata con successo",
                "data" => $configuration->fresh(['optionals', 'accessories'])
            ], 200);

        } catch(\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
            ], 500);
        }
    } */

    public function update(UpdateConfigurationRequest $request, string $id)
{
    $data = $request->validated();

    $configuration = Configuration::findOrFail($id);

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
        //
    }
}

