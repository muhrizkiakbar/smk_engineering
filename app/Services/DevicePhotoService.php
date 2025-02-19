<?php

namespace App\Services;

use App\Models\DevicePhoto;
use Illuminate\Support\Facades\Storage;
use App\Services\AppService;
use Exception;
use Illuminate\Support\Facades\Request;

class DevicePhotoService extends AppService
{
    public function __construct()
    {
    }

    public function device_photo($device_location_id)
    {
        $device_photo = DevicePhoto::where('device_location_id', $device_location_id)
            ->where('state', 'pending')->first();
        return $device_photo;
    }

    public function create($device_location_id, $request = null)
    {
        if ($request != null) {
            $request_input = $request->except(['photo']);
            $device_photo =  DevicePhoto::create($request_input);

            $file = $request->file('photo');
            $filePath = $file->store('device_photos', 'public');

            $device_photo->photo = $filePath;
            $device_photo->state = 'active';
            $device_photo->save();

            return $device_photo;

        } else {

            DevicePhoto::create([
                'device_location_id' => $device_location_id,
            ]);

        }

        return;
    }

    public function update(DevicePhoto $device_photo, $request)
    {
        // Example logic for updating a photo record
        try {
            $file = $request->file('photo');
            $filePath = $file->store('device_photos', 'public');

            $device_photo->photo = $filePath;
            $device_photo->state = 'active';
            $device_photo->save();

            return $device_photo;
        } catch (Exception $e) {
            throw new Exception('Something went wrong.');
        }
    }

    public function delete(DevicePhoto $device_photo)
    {
        Storage::delete($device_photo->photo);
        // Example logic for deleting a photo record
        $device_photo->delete();

        return $device_photo;
    }
}
