<?php

use App\Http\Controllers\AccessoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogCreationController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\EngineVariantController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\OptionalController;
use Illuminate\Support\Facades\Route;

Route::get('models', [ModelController::class, 'index']);

Route::controller(AuthController::class)->group(function() {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    // creati dall'admin
    Route::apiResource('models', ModelController::class);
    Route::apiResource('engine-variants', EngineVariantController::class);
    Route::apiResource('optionals', OptionalController::class);
    Route::apiResource('accessories', AccessoryController::class);
    Route::apiResource('colors', ColorController::class);

    // per creare tutto quello di sopra in blocco
    Route::post('/admin/models/full-create', [CatalogCreationController::class, 'store']);



    // creati dal customer
    Route::apiResource('configurations', ConfigurationController::class);
    // -> /configurations/{id}/color
    // -> /configurations/{id}/engine
    // -> /configurations/{id}/optionals

});