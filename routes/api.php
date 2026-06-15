<?php

use App\Http\Controllers\AccessoryConfigurationController;
use App\Http\Controllers\AccessoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogCreationController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\EngineVariantController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\OptionalConfigurationController;
use App\Http\Controllers\OptionalController;
use App\Http\Controllers\OptionalIncompatibilityController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::get('models', [ModelController::class, 'index']);

Route::controller(AuthController::class)->group(function() {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});
    
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify'); // creato nel config/auth

Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend']); // metodo da implementare sul controller EmailVerificationController
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::middleware(['verified'])->group(function () {
            Route::get('user', [AuthController::class, 'user']);
            Route::apiResource('users', UserController::class);
            // creati dall'admin
            Route::post('models', [ModelController::class, 'store']);
            Route::get('models/{id}', [ModelController::class, 'show']);
            Route::apiResource('engine-variants', EngineVariantController::class);
            Route::apiResource('optionals', OptionalController::class);
            Route::apiResource('accessories', AccessoryController::class);
            Route::apiResource('colors', ColorController::class);
    
            // aggiungere optional incompatibilities
            Route::apiResource('optional-incompatibilities', OptionalIncompatibilityController::class);
    
            // per creare tutto quello di sopra in blocco, tranne accessories e optionals
            Route::post('/full-create', [CatalogCreationController::class, 'store']);
    
            // creati dal customer
            Route::apiResource('configurations', ConfigurationController::class);
            Route::get('configurations/{id}', [ConfigurationController::class, "show"]);
            Route::patch('configurations/{id}', [ConfigurationController::class, "update"]);
            Route::apiResource('configuration-optionals', OptionalConfigurationController::class);
            Route::apiResource('configuration-accessories', AccessoryConfigurationController::class);
    
            Route::post('/configurations/{configuration}/quote',[QuoteController::class, 'generate']);
            Route::get('/quotes/{quote}/download',[QuoteController::class, 'download']);
        });
});

Route::controller(ResetPasswordController::class)->group(function () {
    Route::post('/forgot-password', 'forgotPassword');
    Route::post('/reset-password', 'resetPassword');
})->middleware(['verified']);