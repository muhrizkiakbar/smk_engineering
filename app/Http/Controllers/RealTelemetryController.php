<?php

namespace App\Http\Controllers;

use App\Exports\RealTelemetryExport;
use App\Services\DevicePhotoService;
use App\Services\DeviceLocationService;
use App\Http\Requests\TelemetryRequest;
use App\Models\RealTelemetry;
use App\Models\DeviceLocation;
use App\Services\RealTelemetryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RealTelemetryController extends Controller
{
    protected $realTelemetryService;
    protected $deviceLocationService;
    protected $devicePhotoService;


    public function __construct()
    {
        $this->realTelemetryService = new RealTelemetryService(Auth::user());
        $this->deviceLocationService = new DeviceLocationService(Auth::user());
        $this->devicePhotoService = new DevicePhotoService(Auth::user());
    }

    //
    public function index(Request $request)
    {
        $telemetries = $this->realTelemetryService->realtelemetries($request, ['device_location' => ['device', 'location']])->latest()->cursorPaginate(10);
        $device_locations = DeviceLocation::where('state', 'active')->with(['device', 'location'])->get();

        return view('realtelemetries.index', ['device_locations' => $device_locations, 'telemetries' => $telemetries]);
    }

    public function create()
    {
        // Ambil device_id dan location_id dari DeviceLocation yang aktif
        $device_locations = DeviceLocation::where('state', 'active')->get();

        return view('realtelemetries.new', ['device_locations' => $device_locations]);
    }

    public function store(TelemetryRequest $request)
    {
        $this->realTelemetryService->create($request->all());
        return redirect('realtelemetries')->with('status', 'Telemetry berhasil Dibuat');
    }

    public function edit(string $id)
    {
        $telemetry = RealTelemetry::find(decrypt($id));

        $device_locations = DeviceLocation::where('state', 'active')->get();

        return view('realtelemetries.edit', ['device_locations' => $device_locations, 'telemetry' => $telemetry]);
    }

    public function update(Request $request, string $id)
    {
        $telemetry = RealTelemetry::find(decrypt($id));

        $telemetry = $this->realTelemetryService->update($telemetry, $request->all());

        return redirect('realtelemetries')->with('status', 'Telemetry berhasil Diubah');
    }

    public function destroy(string $id)
    {
        $telemetry = RealTelemetry::find(decrypt($id));
        $telemetry = $this->realTelemetryService->delete($telemetry);
        return redirect('realtelemetries')->with('status', 'Telemetry berhasil Dihapus');
    }

    public function export(Request $request)
    {
        return Excel::download(
            new RealTelemetryExport(
                $request->input('from_date'),
                $request->input('to_date'),
                $request->input('device_location_id')
            ),
            'actual_telemetries.xlsx'
        );
    }
}
