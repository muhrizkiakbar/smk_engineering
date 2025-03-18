<?php

namespace App\Http\Controllers;

use App\Services\DevicePhotoService;
use App\Services\DeviceLocationService;
use App\Http\Requests\TelemetryRequest;
use App\Http\Requests\Telemetries\GenerateRequest;
use App\Imports\TelemetryImport;
use App\Models\Telemetry;
use App\Models\DeviceLocation;
use App\Services\TelemetryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

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
        return redirect('telemetries')->with('status', 'Telemetry berhasil digenerate');
    }

    public function destroy(string $id)
    {
        $telemetry = Telemetry::find(decrypt($id));
        $telemetry = $this->telemetryService->delete($telemetry);
        return redirect('telemetries')->with('status', 'Telemetry berhasil dihapus');
    }

    public function create_device_photo(string $device_location_id)
    {
        $device = $this->devicePhotoService->create($device_location_id);
        return redirect('telemetries')->with('status', 'Request for photo of device was created');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx,csv|max:2048',
        ]);

        try {
            $file = $request->file('file');

            if (!$file->isValid()) {
                return redirect('telemetries')
                    ->with('error', 'File tidak valid atau rusak.');
            }

            $device_locations = DeviceLocation::where('state', 'active')->mapWithKeys(function ($item) {
                return [$item->id => ['formula' => $item->formula]];
            })->toArray();

            Excel::import(new TelemetryImport(), $file, $device_locations);

            return redirect('telemetries')
            ->with('status', 'Telemetry berhasil diimport');
        } catch (ValidationException $e) {
            return redirect()->route('telemetries.index')
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Throwable $e) {
            Log::error('Import telemetry error: ' . $e->getMessage());

            return redirect('telemetries')
                ->with('error', 'Terjadi kesalahan saat mengimpor data.');
        }
    }
}
