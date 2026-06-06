<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOptionalConfigurationRequest;
use App\Models\Configuration;
use App\Models\ConfigurationOptional;
use Illuminate\Http\Request;

class OptionalConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOptionalConfigurationRequest $request)
    {
        try{
            $data = $request->validated();

            $configuration = Configuration::findOrFail($data['configuration_id']);

            // $configuration->optionals()->sync(['optional_ids']);
            $configuration->accessories()->sync($data['accessory_ids']);

            return response()->json([
                "success" => true,
                "message" => "Optionals sincronizzati",
                "data" => $configuration->optionals
            ]);

        }catch(\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }
}
