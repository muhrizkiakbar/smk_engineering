<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DevicePhotoRequest;
use App\Models\DevicePhoto;
use App\Services\DevicePhotoService;
use Illuminate\Support\Facades\Auth;

class DevicePhotoController extends Controller
{
    protected $devicePhotoService;

    public function __construct()
    {
        $this->devicePhotoService = new DevicePhotoService(Auth::user());
    }

    public function index($device_location_id)
    {
        $device_photo = $this->devicePhotoService->device_photo($device_location_id);

        return response()->json($device_photo);
    }

    public function update(DevicePhotoRequest $request, string $device_photo_id)
    {
        $device_photo = DevicePhoto::find($device_photo_id);

        $this->devicePhotoService->update($device_photo, $request);

        return response()->json($device_photo);
    }
}
