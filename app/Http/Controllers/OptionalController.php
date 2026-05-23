<?php

namespace App\Http\Controllers;

use App\Models\Optional;
use Illuminate\Http\Request;

class OptionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $optionals = Optional::all();

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
    public function store(Request $request)
    {
        try {
            $data = $request->validated();

            $optional = Optional::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => $data['price'],
                'type' => $data['type']
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
