<?php

namespace App\Services;

use App\Models\DeviceLocation;
use Illuminate\Http\Request;
use App\Repositories\DeviceLocations;
use App\Services\AppService;
use Exception;

class DeviceLocationService extends AppService
{
    protected $deviceLocationRepository;

    public function __construct()
    {
        $this->deviceLocationRepository = new DeviceLocations();
    }

    public function device_locations(Request $request)
    {
        $device_locations = $this->deviceLocationRepository->filter($request->all());
        return $device_locations;
    }

    public function create($request)
    {
        $device_location = DeviceLocation::create($request);

        return $device_location;
    }

    public function update(DeviceLocation $device_location, $request)
    {
        // Example logic for updating a photo record
        try {
            $device_location->update($request);

            return $device_location;
        } catch (Exception $e) {
            throw new Exception('Something went wrong.');
        }
    }

    public function delete(DeviceLocation $device_location)
    {
        // Example logic for deleting a photo record
        if ($device_location->state == "active") {
            $device_location->state = "archived";
        } else {
            $device_location->state = "active";
        }

        $device_location->save();

        return $device_location;
    }
}
