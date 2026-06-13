<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOptionalIncompatibilityRequest;
use App\Http\Resources\OptionalIncompatibilityResource;
use App\Models\OptionalIncompatibility;
use Illuminate\Http\Request;

class OptionalIncompatibilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incompatibilities = OptionalIncompatibility::all(); 
        return OptionalIncompatibilityResource::collection($incompatibilities);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOptionalIncompatibilityRequest $request)
    {
        try {
            $data = $request->validated();
            
            $optionalIncompatibility = OptionalIncompatibility::create([
                "optional_1_id" => $data["optional_1_id"],
                "optional_2_id" => $data["optional_2_id"],
            ]);

            return response()->json([
                "success" => true,
                "data" => $optionalIncompatibility
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
