<?php

use App\Http\Controllers\LocationController;
use App\Http\Controllers\DeviceLocationController;
//use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\TelemetryController;
use App\Http\Controllers\RealTelemetryController;
use App\Http\Controllers\UndeliveredTelemetryController;
use App\Http\Controllers\EndUser\DeviceLocationController as EndUserDeviceLocationController;
use App\Http\Controllers\EndUser\TelemetryController as EndUserTelemetryController;

Route::middleware('auth:web')->group(function () {
    // Protected routes
    Route::get('/', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::middleware('auth')->group(function () {
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');

        Route::get('/dashboard', function () {
            return view('dashboard');
        })->middleware(['auth', 'verified'])->name('dashboard');


        Route::resource('locations', LocationController::class)->except([
            'show'
        ]);
        Route::resource('devices', DeviceController::class)->except([
            'show'
        ]);
        Route::resource('device_locations', DeviceLocationController::class)->except([
            'show'
        ]);
        Route::post('/telemetries/generate', [TelemetryController::class, 'generate'])->name('telemetries.generate');
        Route::resource('telemetries', TelemetryController::class)->except([
            'show'
        ]);

        Route::resource('real_telemetries', RealTelemetryController::class)->except([
            'show', 'new','create','store', 'edit', 'update', 'delete', 'destroy'
        ]);

        Route::resource('undelivered_telemetries', UndeliveredTelemetryController::class)->except([
            'show', 'new','create','store', 'edit', 'update', 'delete', 'destroy'
        ]);

        Route::prefix('/enduser')->group(function () {
            Route::get('/device_locations', [EndUserDeviceLocationController::class, 'index']);
            Route::get('/telemetry/{id}', [EndUserTelemetryController::class, 'index']);
            Route::post('/telemetry/{id}', [EndUserTelemetryController::class, 'create_device_photo'])->name('enduser.telemetry.create_device_photo');
            Route::get('/telemetry/device_location/{device_location_id}', [EndUserTelemetryController::class, 'telemetry'])->name('enduser.telemetry.telemetry');
        });
    });
});

require __DIR__.'/auth.php';
