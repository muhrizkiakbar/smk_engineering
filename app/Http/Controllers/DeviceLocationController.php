<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Http\Requests\DeviceLocationRequest;
use App\Models\Department;
use App\Models\Device;
use App\Models\DeviceLocation;
use App\Models\Location;
use App\Services\DeviceLocationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceLocationController extends Controller
{
    protected $deviceLocationService;

    public function __construct()
    {
        $this->deviceLocationService = new DeviceLocationService(Auth::user());
    }

    //
    public function index(Request $request)
    {
        $device_locations = $this->deviceLocationService->device_locations($request, ['device', 'location', 'department'])->cursorPaginate(10);

        $devices = Device::where('state', 'active')
            ->get();

        $departments = Department::where('state', 'active')
            ->get();

        $locations = Location::where('state', 'active')
            ->get();

        return view('device_locations.index', ['devices' => $devices, 'locations' => $locations, 'device_locations' => $device_locations, 'departments' => $departments]);
    }

    public function create()
    {
        // Ambil device_id dan location_id dari DeviceLocation yang aktif
        $device_location_ids = DeviceLocation::where('state', 'active')
            ->select('device_id', 'location_id')
            ->get();

        $existing_device_ids = $device_location_ids->pluck('device_id')->unique()->toArray();
        $existing_location_ids = $device_location_ids->pluck('location_id')->unique()->toArray();

        $departments = Department::where('state', 'active')
            ->get();

        $devices = Device::where('state', 'active')
            ->whereNotIn('id', $existing_device_ids)
            ->get();

        $locations = Location::where('state', 'active')
            ->whereNotIn('id', $existing_location_ids)
            ->get();

        return view('device_locations.new', ['devices' => $devices, 'locations' => $locations, 'departments' => $departments]);
    }

    public function store(DeviceLocationRequest $request)
    {
        $this->deviceLocationService->create($request->all());
        return redirect("device_locations")->with('status', 'Device Location telah dibuat');
    }

    public function edit(string $id)
    {
        $device_location = DeviceLocation::find(decrypt($id));

        $device_location_ids = DeviceLocation::where('state', 'active')
            ->whereNot('id', $device_location->id)
            ->select('device_id', 'location_id')
            ->get();

        $existing_device_ids = $device_location_ids->pluck('device_id')->unique()->toArray();
        $existing_location_ids = $device_location_ids->pluck('location_id')->unique()->toArray();

        $departments = Department::where('state', 'active')
            ->get();

        $devices = Device::where('state', 'active')
            ->whereNotIn('id', $existing_device_ids)
            ->get();

        $locations = Location::where('state', 'active')
            ->whereNotIn('id', $existing_location_ids)
            ->get();

        return view('device_locations.edit', ['device_location' => $device_location, 'devices' => $devices, 'locations' => $locations, 'departments' => $departments]);
    }

    public function update(Request $request, string $id)
    {
        $device_location = DeviceLocation::find(decrypt($id));

        $request->validate([
            'location_id' => ['required', 'string', 'max:14', Rule::unique('device_locations', 'location_id')->ignore($device_location->id)],
            'device_id' => ['required', 'string', 'max:14', Rule::unique('device_locations', 'device_id')->ignore($device_location->id)],
            'department_id' => [ 'required','string' ],
            'longitude' => [ 'required','string' ],
            'latitude' => [ 'required','string' ],
            'department_id' => [ 'required','string' ],
            'state' => [ 'nullable', 'string', 'max:255' ],
        ]);


        $this->deviceLocationService->update($device_location, $request->all());

        return redirect("device_locations")->with('status', 'Device Location berhasil Diubah');
    }

    public function destroy(string $id)
    {
        $device_location = DeviceLocation::find(decrypt($id));
        $device_location = $this->deviceLocationService->delete($device_location);

        if ($device_location->state == "active") {
            $message = "Device Location berhasil diaktifkan.";
        } else {
            $message = "Device Location berhasil dinonaktifkan.";
        }

        return redirect("device_locations")->with('status', $message);
    }
}
