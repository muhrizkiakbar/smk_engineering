<?php

use App\Http\Controllers\LocationController;
use App\Http\Controllers\DeviceLocationController;
//use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TelemetryController;
use App\Http\Controllers\RealTelemetryController;
use App\Http\Controllers\UndeliveredTelemetryController;
use App\Http\Controllers\EndUser\DeviceLocationController as EndUserDeviceLocationController;
use App\Http\Controllers\EndUser\TelemetryController as EndUserTelemetryController;
use App\Http\Controllers\DeviceLocationWarningController;

Route::middleware('auth:web')->group(function () {
    // Protected routes
    Route::get('/', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::middleware('auth')->group(function () {
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');

        Route::middleware('admin')->group(function () {
            Route::get('/dashboard', function () {
                return view('dashboard');
            })->middleware(['auth', 'verified'])->name('dashboard');


            Route::resource('locations', LocationController::class)->except([
                'show'
            ]);
            Route::resource('devices', DeviceController::class)->except([
                'show'
            ]);
            Route::resource('departments', DepartmentController::class)->except([
                'show'
            ]);
            Route::resource('device_locations', DeviceLocationController::class)->except([
                'show'
            ]);

            Route::resource('device_location_warnings', DeviceLocationWarningController::class);

            Route::resource('users', UserController::class)->except([
                'show'
            ]);

            Route::post('/telemetries/generate', [Telemetrycontroller::class, 'generate'])->name('telemetries.generate');
            Route::post('/telemetries/import', [TelemetryController::class, 'import'])->name('telemetries.import');
            Route::get('/telemetries/export', [TelemetryController::class, 'export'])->name('telemetries.export');

            Route::resource('telemetries', TelemetryController::class)->except([
                'show'
            ]);

            Route::get('/real_telemetries/export', [RealTelemetryController::class, 'export'])->name('real_telemetries.export');
            Route::resource('real_telemetries', RealTelemetryController::class)->except([
                'show', 'new','create','store', 'edit', 'update', 'delete', 'destroy'
            ]);

            Route::resource('undelivered_telemetries', UndeliveredTelemetryController::class)->except([
                'show', 'new','create','store', 'edit', 'update', 'delete', 'destroy'
            ]);
        });

        Route::middleware('admin_client')->group(function () {
            Route::prefix('/enduser')->group(function () {

                Route::get('/device_locations', [EndUserDeviceLocationController::class, 'index'])->name('enduser.device_locations.index');

                Route::get('/device_locations/sensors', [EndUserDeviceLocationController::class, 'sensors'])->name('enduser.device_locations.sensors');
                Route::get('/device_locations/telemetry_sensor', [EndUserDeviceLocationController::class, 'telemetry_sensor'])->name('enduser.device_locations.telemetry_sensor');

                Route::get('/device_locations/{id}/telemetry', [EndUserDeviceLocationController::class, 'telemetry'])->name('enduser.device_locations.telemetry');
                Route::get('/device_locations/{id}/telemetry_json', [EndUserDeviceLocationController::class, 'telemetry_json'])->name('enduser.device_locations.telemetry_json');

                Route::get('/device_locations/{id}/device_photos', [EndUserDeviceLocationController::class, 'device_photos'])->name('enduser.device_locations.device_photos');
                Route::post('/device_locations/{id}/device_photos', [EndUserDeviceLocationController::class, 'create_device_photo'])->name('enduser.device_locations.create_device_photo');
                Route::get('/device_locations/{id}/device_photos/{device_photo_id}/download', [EndUserDeviceLocationController::class, 'download'])->name('enduser.device_locations.download');

            });
        });
    });
});

require __DIR__.'/auth.php';
