<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use App\Models\Device;
use App\Models\DeviceLocation;

class Location extends Model
{
    //
    protected $attributes = [
        'state' => 'active',
    ];
    protected $guarded = [];

    public function devices(): HasManyThrough
    {
        return $this->hasManyThrough(Device::class, DeviceLocation::class, 'location_id', 'device_id');
    }
}
