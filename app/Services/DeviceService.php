<?php

namespace App\Services;

use App\Models\Device;
use Illuminate\Http\Request;
use App\Repositories\Devices;
use App\Services\AppService;
use Exception;

class DeviceService extends AppService
{
    protected $deviceRepository;

    public function __construct()
    {
        $this->deviceRepository = new Devices();
    }

    public function devices(Request $request)
    {
        $devices = $this->deviceRepository->filter($request->all());
        return $devices;
    }

    public function create($request)
    {

        $device = Device::create($request);

        return $device;
    }

    public function update(Device $device, $request)
    {
        // Example logic for updating a photo record
        try {
            $device->update($request);

            return $device;
        } catch (Exception $e) {
            throw new Exception('Something went wrong.');
        }
    }

    public function delete(Device $device)
    {
        // Example logic for deleting a photo record
        if ($device->state == "active") {
            $device->state = "archived";
        } else {
            $device->state = "active";
        }

        $device->save();

        return $device;
    }
}
