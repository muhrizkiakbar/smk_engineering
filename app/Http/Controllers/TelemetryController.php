<?php

namespace App\Http\Controllers;

use App\Services\DevicePhotoService;
use App\Services\DeviceLocationService;
use App\Http\Requests\TelemetryRequest;
use App\Http\Requests\Telemetries\GenerateRequest;
use App\Models\Telemetry;
use App\Models\DeviceLocation;
use App\Services\TelemetryService;
use Illuminate\Http\Request;
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

    //
    public function index(Request $request)
    {
        $telemetries = $this->telemetryService->telemetries($request, ['device_location' => ['device', 'location']])->cursorPaginate(24);
        $device_locations = DeviceLocation::where('state', 'active')->with(['device', 'location'])->get();

        return view('telemetries.index', ['device_locations' => $device_locations, 'telemetries' => $telemetries]);
    }

    public function create()
    {
        // Ambil device_id dan location_id dari DeviceLocation yang aktif
        $device_locations = DeviceLocation::where('state', 'active')->get();

        return view('telemetries.new', ['device_locations' => $device_locations]);
    }

    public function store(TelemetryRequest $request)
    {
        $this->telemetryService->create($request->all());
        return back()->with('status', 'Telemetry telah dibuat');
    }

    public function edit(string $id)
    {
        $telemetry = Telemetry::find(decrypt($id));

        $device_locations = DeviceLocation::where('state', 'active')->get();

        return view('telemetries.edit', ['device_locations' => $device_locations, 'telemetry' => $telemetry]);
    }

    public function update(Request $request, string $id)
    {
        $telemetry = Telemetry::find(decrypt($id));

        $telemetry = $this->telemetryService->update($telemetry, $request->all());

        return redirect('telemetries')->with('status', 'Telemetry berhasil Diubah');
    }

    public function generate(GenerateRequest $request)
    {
        $this->telemetryService->generate($request);
        return back()->with('status', 'Telemetry berhasil digenerate');
    }

    public function destroy(string $id)
    {
        $telemetry = Telemetry::find(decrypt($id));
        $telemetry = $this->telemetryService->delete($telemetry);
        return back()->with('status', 'Telemetry berhasil Dihapus.');
    }

    public function create_device_photo(string $device_location_id)
    {
        $device = $this->devicePhotoService->create($device_location_id);
        return back()->with('status', 'Request for photo of device was created');
    }
}
