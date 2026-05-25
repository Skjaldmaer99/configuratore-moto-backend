<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccessoryConfigurationRequest;
use App\Models\Configuration;
use App\Models\ConfigurationAccessory;

class AccessoryConfigurationController extends Controller
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
    public function store(StoreAccessoryConfigurationRequest $request)
    {
        try{
            $data = $request->validated();
            $configuration = Configuration::findOrFail($data['configuration_id']);

            $configuration->accessories()->sync([$data['accessory_ids']]);
            $configuration = ConfigurationAccessory::create([
                'configuration_id' => $data['configuration_id'],
                'accessory_id' => $data['accessory_id']
            ]);
            return response()->json([
                "success" => true,
                "message" => "Accessory Configuration aggiunto alla pivot",
                "data" => $configuration->accessories
            ]);
        }catch(\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }
}
