<?php

namespace App\Services;

use App\Models\DevicePhoto;
use Illuminate\Support\Facades\Storage;
use App\Services\AppService;
use Exception;
use Illuminate\Http\Request;
use App\Repositories\DevicePhotos;

class DevicePhotoService extends AppService
{
    protected $devicePhotoRepository;

    public function __construct()
    {
        $this->devicePhotoRepository = new DevicePhotos();
    }

    public function device_photos(Request $request)
    {
        $device_photos = $this->devicePhotoRepository->filter($request->all());
        return $device_photos;
    }


    public function device_photo($device_location_id)
    {
        $device_photo = DevicePhoto::where('device_location_id', $device_location_id)
            ->where('state', 'pending')->first();
        return $device_photo;
    }

    public function create($device_location_id, $request = null)
    {
        $request_input = $request->except(['photo']);
        $device_photo =  DevicePhoto::create($request_input);

        $file = $request->file('photo');

        // Nama file original atau custom
        $filename = $request_input['device_location_id']. '_' . $file->getClientOriginalName();

        // Path di minio tempat file akan disimpan (optional)
        $path = 'foto/'. $request_input['device_location_id'] ."/". date('Y/m/d');

        // Simpan file ke Minio
        $filePath = Storage::disk('s3')->put(
            $path,
            $file,
        );


        // Dapatkan URL publik dari file (jika bucket public)
        $url = Storage::disk('s3')->url($filePath);

        $device_photo->photo = $url;
        $device_photo->state = 'active';
        $device_photo->save();

        return $device_photo;
    }

    public function request_create($device_location_id, $request = null)
    {
        DevicePhoto::create([
            'device_location_id' => $device_location_id,
        ]);


        return;
    }


    public function update(DevicePhoto $device_photo, $request)
    {
        // Example logic for updating a photo record

        $file = $request->file('photo');

        // Nama file original atau custom
        $filename = time() . '_' . $file->getClientOriginalName();

        // Path di minio tempat file akan disimpan (optional)
        $path = 'foto/'. $device_photo->device_location_id."/". date('Y/m/d');

        // Simpan file ke Minio
        $filePath = Storage::disk('s3')->put(
            $path,
            $file,
        );

        // Dapatkan URL publik dari file (jika bucket public)
        $url = Storage::disk('s3')->url($filePath);


        $device_photo->photo = $url;
        $device_photo->state = 'active';
        $device_photo->save();

        return $device_photo;
    }

    public function delete(DevicePhoto $device_photo)
    {
        Storage::delete($device_photo->photo);
        // Example logic for deleting a photo record
        $device_photo->delete();
        Storage::disk('s3')->delete($device_photo->photo);

        return $device_photo;
    }
}
