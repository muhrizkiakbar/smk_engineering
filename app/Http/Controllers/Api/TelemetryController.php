<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DevicePhotoService;
use App\Services\DeviceLocationService;
use App\Http\Requests\TelemetryRequest;
use App\Services\TelemetryService;
use Illuminate\Support\Facades\Auth;

class TelemetryController extends Controller
{
    protected $telemetryService;
    protected $deviceLocationService;
    protected $devicePhotoService;


    public function __construct()
    {
        $this->telemetryService = new TelemetryService(Auth::user());
        $this->deviceLocationService = new DeviceLocationService(Auth::user());
        $this->devicePhotoService = new DevicePhotoService(Auth::user());
    }

    public function store(TelemetryRequest $request)
    {
        return response()->json($this->telemetryService->create($request->all()));
    }
}
