<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Http\Requests\DeviceRequest;
use App\Models\Device;
use App\Services\DeviceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    protected $deviceService;

    public function __construct()
    {
        $this->deviceService = new DeviceService(Auth::user());
    }

    //
    public function index(Request $request)
    {
        $devices = $this->deviceService->devices($request)->cursorPaginate(10);

        return view('devices.index', ['devices' => $devices]);
    }

    public function create()
    {
        return view('devices.new');
    }

    public function store(DeviceRequest $request)
    {
        $device = $this->deviceService->create($request->all());
        return redirect("devices")->with('status', 'Device telah dibuat');
    }

    public function edit(string $id)
    {
        $device = Device::find(decrypt($id));
        return view('devices.edit', ['device' => $device]);
    }

    public function update(Request $request, string $id)
    {
        $device = Device::find(decrypt($id));

        $request->validate([
            'name' => [ 'required','string', 'max:255' ],
            'type' => [ 'required','string', 'max:255' ],
            'bought_at' => [ 'nullable','date', 'max:255' ],
            'used_at' => [ 'nullable','date', 'max:255' ],
            'damaged_at' => [ 'nullable','date' ],
            'phone_number' => ['required', 'string', 'max:14', Rule::unique('devices', 'phone_number')->ignore($device->id)],
            'has_ph' => [ 'required','string' ],
            'has_tds' => [ 'required','string' ],
            'has_tss' => [ 'required','string' ],
            'has_velocity' => [ 'required','string' ],
            'has_rainfall' => [ 'required','string' ],
            'has_water_height' => [ 'required','string' ],
            'has_temperature' => [ 'required','string' ],
            'has_humidity' => [ 'required','string' ],
            'has_wind_direction' => [ 'required','string' ],
            'has_wind_speed' => [ 'required','string' ],
            'has_solar_radiation' => [ 'required','string' ],
            'has_evaporation' => [ 'required','string' ],
            'state' => [ 'nullable', 'string', 'max:255' ],
        ]);


        $this->deviceService->update($device, $request->all());

        return redirect('devices')->with('status', 'Device berhasil Diubah');
    }

    public function destroy(string $id)
    {
        $device = Device::find(decrypt($id));
        $device = $this->deviceService->delete($device);

        if ($device->state == "active") {
            $message = "Device berhasil diaktifkan.";
        } else {
            $message = "Device berhasil dinonaktifkan.";
        }

        return redirect('devices')->with('status', $message);
    }
}
