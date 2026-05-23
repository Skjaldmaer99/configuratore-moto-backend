<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEngineRequest;
use App\Models\Engine;
use Illuminate\Http\Request;

class EngineVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $engines = Engine::all();

            return response()->json([
                "success" => true,
                "data" => $engines
            ], 200);

        } catch(\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEngineRequest $request)
    {
        try {
            $data = $request->validated();

            $engine = Engine::create([
                'model_id' => $data['model_id'],
                'name' => $data['name'],
                'displacement_cc' => $data['displacement_cc'],
                'cylinders' => $data['cylinders'],
                'engine_type' => $data['engine_type'],
                'horsepower' => $data['horsepower'],
                'gearbox' => $data['gearbox'],
                'fuel_type' => $data['fuel_type'],
                'extra_price' => $data['extra_price']
            ]);

            return response()->json([
                "success" => true,
                "data" => $engine
            ], 201);
        } catch(\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
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
