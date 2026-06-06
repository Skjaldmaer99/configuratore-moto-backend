<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConfigurationRequest;
use App\Http\Requests\UpdateConfigurationRequest;
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreConfigurationRequest $request)
    {
        try {
            $data = $request->validated();
    
            $model = Modello::findOrFail($data["model_id"]);
    
            /* $configuration = Configuration::create([
                'user_id' => Auth::id(),
                'model_id' => $request->model_id,
                'status' => 'draft',
                'current_step' => 1,
                //  dopo ogni step ricalcolare tutto da zero Per evitare bug quando un optional viene rimosso, un colore cambia, un engine cambia, cambiano compatibilità
                'total_price' => $model->base_price
            ]); */

            $configuration = Configuration::create([
                'user_id' => Auth::id(),
                'model_id' => $data['model_id'],

                'color_id' => $data['color_id'] ?? null,
                'engine_variant_id' => null,

                'status' => 'draft',
                'current_step' => 1,
                'total_price' => $data['total_price'],
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

    public function update(UpdateConfigurationRequest $request, string $id)
    {
        try {
            $data = $request->validated();

            $configuration = Configuration::findOrFail($id);

            // 1. aggiorna campi normali
            $configuration->update([
                'color_id' => $data['color_id'] ?? $configuration->color_id,
                'engine_variant_id' => $data['engine_variant_id'] ?? $configuration->engine_variant_id,
                'current_step' => $data['current_step'] ?? $configuration->current_step,
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
    }

        
    public function destroy(string $id)
    {
        //
    }
}

