<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DevicePhotoService;
use App\Services\DeviceLocationService;
use App\Http\Requests\TelemetryRequest;
use App\Services\TelemetryService;
use App\Services\RealTelemetryService;
use App\Services\UndeliveredTelemetryService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\Telemetries\Api\CreateRequest;
use App\Models\Device;
use App\Models\DeviceLocation;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class TelemetryController extends Controller
{
    protected $telemetryService;
    protected $realTelemetryService;
    protected $undeliveredTelemetryService;
    protected $deviceLocationService;
    protected $devicePhotoService;


    public function __construct()
    {
        $this->telemetryService = new TelemetryService(Auth::user());
        $this->deviceLocationService = new DeviceLocationService(Auth::user());
        $this->devicePhotoService = new DevicePhotoService(Auth::user());
        $this->realTelemetryService = new RealTelemetryService(Auth::user());
        $this->undeliveredTelemetryService = new UndeliveredTelemetryService(Auth::user());
    }

    public function store(CreateRequest $request)
    {
        $phone_number = $this->formatPhoneNumber($request->phone_number);

        $device = Device::where('phone_number', $phone_number)->first();
        if ($device == null) {
            $this->undeliveredTelemetryService->create($request->all());
            return response()->json([]);
        }

        $device_location = DeviceLocation::where('state', 'active')->where('device_id', $device->id)->first();
        $request_input = ($request->merge([
            'device_location_id' => $device_location->id
        ])->except(['phone_number']));

        $debit = $device_location->formula ? $this->calculate_debit($device_location->formula, (float) $request_input['water_height']) : 0;
        $request_input['debit'] = round($debit, 2);

        $this->realTelemetryService->create($request_input);

        $request_input = $this->adjust_value($request_input, $device);

        return response()->json($this->telemetryService->create($request_input));
    }

    public function adjust_value($request_input, $device)
    {

        if ($device->has_ph) {
            if ((float) $request_input['ph'] < 6) {
                $request_input['ph'] = mt_rand(600, 610) / 100;
            } elseif ((float) $request_input['ph'] > 9) {
                $request_input['ph'] = mt_rand(880, 890) / 100;
            }
        }

        if ($device->has_tds) {
            if ((float) $request_input['tds'] < 50) {
                $request_input['tds'] = mt_rand(500, 509) / 100;
            } elseif ((float) $request_input['tds'] > 300) {
                $request_input['tds'] = mt_rand(2900, 2950) / 10;
            }
        }

        return $request_input;
    }
}
