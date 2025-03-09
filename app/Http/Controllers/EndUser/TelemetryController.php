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


    //API
}
