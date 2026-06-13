<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatalogCreationRequest;
use App\Services\CatalogCreationService;

class CatalogCreationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(CatalogCreationRequest $request, CatalogCreationService $service)
    {
        try {
            $catalog = $service->create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Catalog created successfully',
                'data' => $catalog
            ], 201);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}
