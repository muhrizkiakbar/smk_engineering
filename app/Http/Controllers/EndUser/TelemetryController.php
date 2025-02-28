<?php

namespace App\Http\Controllers\EndUser;

use App\Http\Controllers\Controller;
use App\Models\DeviceLocation;
use App\Models\DevicePhoto;
use App\Services\TelemetryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\DevicePhotoService;
use Carbon\Carbon;

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
                'LTE_Tanggal' => Carbon::now()->format('Y-m-d H:i:s'),
            ]
        );
        $telemetries_query = $this->telemetryService->telemetries($request_input, ['device_location' => ['device', 'location']]);
        $telemetry = $telemetries_query->orderby('created_at', 'desc')->first();
        $telemetries = $telemetries_query->limit(12)->get();
        $device_photo = DevicePhoto::where('state', 'active')->orderby('created_at', 'desc')->first();
        $device_locations = DeviceLocation::with(['device', 'location'])->where('state', 'active')->orderby('id', 'asc')->get();
        $current_device_location = DeviceLocation::find($id)->load(['device', 'location']);

        return view(
            'end_user.telemetries.index',
            [
                'telemetry' => $telemetry,
                'telemetries' => $telemetries,
                'device_photo' => $device_photo,
                'device_locations' => $device_locations,
                'current_device_location' => $current_device_location
            ]
        );
    }

    public function telemetry(string $device_location_id)
    {
        $device_location_id = decrypt($device_location_id);
        $request = new Request();
        $request_input = $request->merge(
            [
                'device_location_id' => $device_location_id,
                'LTE_Tanggal' => Carbon::now()->format('Y-m-d H:i:s'),
            ]
        );
        $telemetries_query = $this->telemetryService->telemetries($request_input, ['device_location' => ['device', 'location']]);
        $telemetry = $telemetries_query->orderby('created_at', 'desc')->first();
        $telemetries = $telemetries_query->limit(12)->get();
        $device_photo = DevicePhoto::where('state', 'active')->orderby('created_at', 'desc')->first();

        return response()->json([
            'ph' => $telemetry->ph,
            'tds' => $telemetry->tds,
            'tss' => $telemetry->tss,
            'velocity' => $telemetry->velocity,
            'rainfall' => $telemetry->rainfall,
            'water_height' => $telemetry->water_height,
            'device_photo' => asset('storage/'.$device_photo->photo),
            'telemetries' => $telemetries,
        ]);
    }

    public function create_device_photo(string $device_location_id)
    {
        $device = $this->devicePhotoService->create($device_location_id);
        return back()->with('status', 'Request for photo of device was created');
    }
}
