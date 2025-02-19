<?php

namespace App\Http\Controllers;

use App\Services\DevicePhotoService;
use App\Services\DeviceLocationService;
use App\Http\Requests\UndeliveredTelemetryRequest;
use App\Models\UndeliveredTelemetry;
use App\Models\DeviceLocation;
use App\Services\UndeliveredTelemetryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UndeliveredTelemetryController extends Controller
{
    protected $undeliveredTelemetryService;
    protected $deviceLocationService;
    protected $devicePhotoService;


    public function __construct()
    {
        $this->undeliveredTelemetryService = new UndeliveredTelemetryService(Auth::user());
        $this->deviceLocationService = new DeviceLocationService(Auth::user());
        $this->devicePhotoService = new DevicePhotoService(Auth::user());
    }

    //
    public function index(Request $request)
    {
        $telemetries = $this->undeliveredTelemetryService->telemetries($request, ['device_location' => ['device', 'location']])->cursorPaginate(24);
        $device_locations = DeviceLocation::where('state', 'active')->with(['device', 'location'])->get();

        return view('undeliveredtelemetries.index', ['device_locations' => $device_locations, 'telemetries' => $telemetries]);
    }

    public function create()
    {
        // Ambil device_id dan location_id dari DeviceLocation yang aktif
        $device_locations = DeviceLocation::where('state', 'active')->get();

        return view('undeliveredtelemetries.new', ['device_locations' => $device_locations]);
    }

    public function store(UndeliveredTelemetryRequest $request)
    {
        $this->undeliveredTelemetryService->create($request->all());
        return redirect('undeliveredtelemetries')->with('status', 'Telemetry berhasil Dibuat');
    }

    public function edit(string $id)
    {
        $telemetry = UndeliveredTelemetry::find(decrypt($id));

        $device_locations = DeviceLocation::where('state', 'active')->get();

        return view('undeliveredtelemetries.edit', ['device_locations' => $device_locations, 'telemetry' => $telemetry]);
    }

    public function update(Request $request, string $id)
    {
        $telemetry = UndeliveredTelemetry::find(decrypt($id));

        $telemetry = $this->undeliveredTelemetryService->update($telemetry, $request->all());

        return redirect('undeliveredtelemetries')->with('status', 'Telemetry berhasil Diubah');
    }

    public function destroy(string $id)
    {
        $telemetry = UndeliveredTelemetry::find(decrypt($id));
        $telemetry = $this->undeliveredTelemetryService->delete($telemetry);
        return redirect('undeliveredtelemetries')->with('status', 'Telemetry berhasil Dihapus');
    }
}
