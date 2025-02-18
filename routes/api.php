<?php

use App\Http\Controllers\Api\DevicePhotoController;
use App\Http\Controllers\Api\TelemetryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTAuthController;
use App\Http\Middleware\JwtMiddleware;

Route::post('login', [JWTAuthController::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [JWTAuthController::class, 'logout']);

    Route::get('/device_photos/{device_location_id}', [DevicePhotoController::class, 'index']);
    Route::post('/device_photos/{id}', [DevicePhotoController::class, 'update']);

    Route::post('/telemetry', [TelemetryController::class, 'store']);
});
