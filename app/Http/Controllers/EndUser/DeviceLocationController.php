<?php

namespace App\Http\Controllers\EndUser;

use App\Http\Controllers\Controller;
use App\Models\DeviceLocation;
use App\Services\DeviceLocationService;
use App\Services\TelemetryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceLocationController extends Controller
{
    protected $telemetryService;
    protected $deviceLocationService;

    public function __construct()
    {
        $this->telemetryService = new TelemetryService(Auth::user());
        $this->deviceLocationService = new DeviceLocationService(Auth::user());
    }

    //
    public function index(Request $request)
    {
        $request_input = $request->merge(
            ['state' => 'active']
        );
        $device_locations = $this->deviceLocationService->device_locations($request_input)->get();
        $device_locations =
            DeviceLocation::leftJoin('devices', 'device_locations.device_id', 'devices.id')
                ->leftJoin('locations', 'device_locations.location_id', 'locations.id')
                ->select(
                    'device_locations.*',
                    'devices.name as device_name',
                    'devices.type as device_type',
                    'devices.has_ph',
                    'devices.has_tds',
                    'devices.has_tss',
                    'devices.has_velocity',
                    'devices.has_water_height',
                    'devices.has_rainfall',
                    'locations.name as location_name',
                    'locations.city',
                    'locations.district'
                )->where('device_locations.state', 'active')->get();

        return view('end_user.device_locations.index', ['device_locations' => $device_locations]);
    }


}
