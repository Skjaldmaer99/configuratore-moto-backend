<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModelRequest;
use App\Http\Resources\ModelResource;
use App\Models\Modello;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $query = Modello::query();

            if($request->has('search') && !empty($request->input('search'))) {
                $searchTerm = $request->input('search');
                $query->where('name', 'iLIKE', $searchTerm . '%')->orWhere('brand', 'iLIKE', $searchTerm . '%');
            }

            $modelli = $query->paginate(12);

            return response()->json([
                "success" => true,
                "data" => ModelResource::collection($modelli) //->items()
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
    public function store(StoreModelRequest $request)
    {
        try {
            $data = $request->validated();

            $modello = Modello::create([
                'brand' => $data['brand'],
                'name' => $data['name'],
                'category' => $data['category'],
                'base_price' => $data['base_price'],
                'image' => $data['image'],
                'description' => $data['description']
            ]);

            return response()->json([
                "success" => true,
                "data" => $modello
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
        $model = Modello::findOrFail($id);
        return response()->json([
                "success" => true,
                "data" => new ModelResource($model)
            ], 200);
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
