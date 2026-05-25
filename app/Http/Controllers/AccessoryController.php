<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccessoryRequest;
use App\Models\Accessory;
use Illuminate\Http\Request;

class AccessoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $optionals = Accessory::all();

            return response()->json([
                "success" => true,
                "data" => $optionals
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
    public function store(StoreAccessoryRequest $request)
    {
        try {
            $data = $request->validated();

            $optional = Accessory::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => $data['price'],
                'category' => $data['category']
            ]);

            return response()->json([
                "success" => true,
                "data" => $optional
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
