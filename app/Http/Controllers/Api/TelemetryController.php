<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DevicePhotoService;
use App\Services\DeviceLocationService;
use App\Http\Requests\TelemetryRequest;
use App\Services\TelemetryService;
use App\Services\RealTelemetryService;
use App\Services\UndeliveredTelemetryService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\Telemetries\Api\CreateRequest;
use App\Models\Device;
use App\Models\DeviceLocation;

class TelemetryController extends Controller
{
    protected $telemetryService;
    protected $realTelemetryService;
    protected $undeliveredTelemetryService;
    protected $deviceLocationService;
    protected $devicePhotoService;


    public function __construct()
    {
        $this->telemetryService = new TelemetryService(Auth::user());
        $this->deviceLocationService = new DeviceLocationService(Auth::user());
        $this->devicePhotoService = new DevicePhotoService(Auth::user());
        $this->realTelemetryService = new RealTelemetryService(Auth::user());
        $this->undeliveredTelemetryService = new UndeliveredTelemetryService(Auth::user());
    }

    public function store(CreateRequest $request)
    {
        $phone_number = $this->formatPhoneNumber($request->phone_number);

        $device = Device::where('phone_number', $phone_number)->first();
        if ($device == null) {
            $this->undeliveredTelemetryService->create($request->all());
            return response()->json([]);
        }

        $device_location = DeviceLocation::where('state', 'active')->where('device_id', $device->id)->first();
        $request_input = ($request->merge([
            'device_location_id' => $device_location->id
        ])->except(['phone_number']));
        $this->realTelemetryService->create($request_input);

        $velocity = $device_location->formula ? $this->calculate_velocity($device_location->formula, $request_input['water_height']) : 0;
        $request_input['velocity'] = $velocity;

        return response()->json($this->telemetryService->create($request_input));
    }
}
