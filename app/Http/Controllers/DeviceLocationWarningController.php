<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeviceLocationWarning;
use App\Services\DeviceLocationWarningService;
use App\Services\DeviceLocationService;
use App\Models\Department;
use App\Models\Device;
use App\Models\DeviceLocation;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;

class DeviceLocationWarningController extends Controller
{
    protected $deviceLocationService;
    protected $deviceLocationWarningService;

    public function __construct()
    {
        $this->deviceLocationService = new DeviceLocationService(Auth::user());
        $this->deviceLocationWarningService = new DeviceLocationWarningService(Auth::user());
    }

    public function index(Request $request)
    {
        $device_locations = $this->deviceLocationService->device_locations($request, ['device', 'location', 'department'])->cursorPaginate(10);

        $devices = Device::where('state', 'active')
            ->get();

        $departments = Department::where('state', 'active')
            ->get();

        $locations = Location::where('state', 'active')
            ->get();

        return view('device_location_warnings.index', ['devices' => $devices, 'locations' => $locations, 'device_locations' => $device_locations, 'departments' => $departments]);
    }

    public function show($device_location_id)
    {
        $device_location_id = decrypt($device_location_id);
        $device_location_warnings = $this->deviceLocationWarningService->device_location_warnings($device_location_id);

        return response()->json($device_location_warnings);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_location_id' => 'required',
            'type' => 'required|string',
            'low_upper_threshold_start' => 'required|numeric',
            'low_upper_threshold_end' => 'required|numeric',
            'middle_upper_threshold_start' => 'required|numeric',
            'middle_upper_threshold_end' => 'required|numeric',
            'high_upper_threshold_start' => 'required|numeric',
            'high_upper_threshold_end' => 'required|numeric',
            'low_bottom_threshold_start' => 'required|numeric',
            'low_bottom_threshold_end' => 'required|numeric',
            'middle_bottom_threshold_start' => 'required|numeric',
            'middle_bottom_threshold_end' => 'required|numeric',
            'high_bottom_threshold_start' => 'required|numeric',
            'high_bottom_threshold_end' => 'required|numeric',
        ]);

        $device_location_warning = $this->deviceLocationWarningService->create($request);

        return response()->json($device_location_warning);
    }

    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'device_location_id' => 'required',
            'type' => 'required|string',
            'low_upper_threshold_start' => 'required|numeric',
            'low_upper_threshold_end' => 'required|numeric',
            'middle_upper_threshold_start' => 'required|numeric',
            'middle_upper_threshold_end' => 'required|numeric',
            'high_upper_threshold_start' => 'required|numeric',
            'high_upper_threshold_end' => 'required|numeric',
            'low_bottom_threshold_start' => 'required|numeric',
            'low_bottom_threshold_end' => 'required|numeric',
            'middle_bottom_threshold_start' => 'required|numeric',
            'middle_bottom_threshold_end' => 'required|numeric',
            'high_bottom_threshold_start' => 'required|numeric',
            'high_bottom_threshold_end' => 'required|numeric',
        ]);

        $device_location_warning = DeviceLocationWarning::find(($id));

        $device_location_warning = $this->deviceLocationWarningService->update($device_location_warning, $request);

        return response()->json($device_location_warning);
    }

    public function destroy($id)
    {
        $device_location_warning = DeviceLocationWarning::find(($id));

        $device_location_warning = $this->deviceLocationWarningService->delete($device_location_warning);

        return response()->json($device_location_warning);
    }
}
