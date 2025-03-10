<?php

use App\Http\Controllers\Api\DevicePhotoController;
use App\Http\Controllers\Api\TelemetryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTAuthController;

Route::post('login', [JWTAuthController::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [JWTAuthController::class, 'logout']);

    // List request photo
    Route::get('/device_photos/{device_location_id}', [DevicePhotoController::class, 'index']);
    // Pengiriman berdasarkan request photo id = device_photo_id
    Route::post('/device_photos/{id}', [DevicePhotoController::class, 'update']);
    // Kirim Foto
    Route::post('/device_photo/store', [DevicePhotoController::class, 'store']);

    //Kirim data dari raspberry
    Route::post('/telemetry', [TelemetryController::class, 'store']);
});
