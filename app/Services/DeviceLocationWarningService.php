<?php

namespace App\Services;

use App\Models\DeviceLocationWarning;
use Illuminate\Http\Request;
use App\Services\AppService;
use App\Repositories\DeviceLocations;
use Exception;

class DeviceLocationWarningService extends AppService
{
    public function device_location_warnings($device_location_id)
    {
        $device_location_warnings = DeviceLocationWarning::where('device_location_id', $device_location_id)->get();

        return $device_location_warnings;
    }

    public function create($request)
    {
        $request['device_location_id'] = decrypt($request['device_location_id']);
        $device_location_warning = DeviceLocationWarning::create($request->all());

        return $device_location_warning;
    }

    public function update(DeviceLocationWarning $device_location_warning, $request)
    {
        try {
            $request['device_location_id'] = decrypt($request['device_location_id']);
            $device_location_warning->update($request->all());

            return $device_location_warning;
        } catch (Exception $e) {
            throw new Exception('Something went wrong.');
        }
    }

    public function delete(DeviceLocationWarning $device_location_warning)
    {
        $device_location_warning->delete();

        return $device_location_warning;
    }
}
