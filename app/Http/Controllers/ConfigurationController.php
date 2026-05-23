<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Modello;
use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
        try {
            $data = $request->validated();
    
            $model = Modello::findOrFail($data["model_id"]);
    
            $configuration = Configuration::create([
                'user_id' => Auth::id(),
                'model_id' => $request->model_id,
                'status' => 'draft',
                'current_step' => 1,
                //  dopo ogni step ricalcolare tutto da zero Per evitare bug quando un optional viene rimosso, un colore cambia, un engine cambia, cambiano compatibilità
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
