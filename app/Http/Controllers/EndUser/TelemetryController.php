<?php

namespace App\Http\Controllers\EndUser;

use App\Http\Controllers\Controller;
use App\Models\DevicePhoto;
use App\Services\TelemetryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\DevicePhotoService;

class TelemetryController extends Controller
{
    protected $telemetryService;
    protected $devicePhotoService;

    public function __construct()
    {
        $this->telemetryService = new TelemetryService(Auth::user());
        $this->devicePhotoService = new DevicePhotoService(Auth::user());
    }

    //
    public function index(Request $request, string $id)
    {
        $request_input = $request->merge(
            [
                'device_location_id' => $id,
                'LTE_Tanggal' => now(),
            ]
        );
        $telemetries_query = $this->telemetryService->telemetries($request_input, ['device_location' => ['device', 'location']]);
        $telemetry = $telemetries_query->orderby('created_at', 'desc')->first();
        $telemetries = $telemetries_query->get();
        $device_photo = DevicePhoto::where('state', 'active')->orderby('created_at', 'desc')->first();

        return view('end_user.telemetries.index', ['telemetry' => $telemetry, 'telemetries' => $telemetries, 'device_photo' => $device_photo]);
    }

    public function create_device_photo(string $device_location_id)
    {
        $device = $this->devicePhotoService->create($device_location_id);
        return back()->with('status', 'Request for photo of device was created');
    }
}
