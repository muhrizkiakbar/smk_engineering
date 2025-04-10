<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\DeviceLocation;

class DeviceLocationWarning extends Model
{
    //
    protected $table = 'device_locations_warnings';
    protected $guarded = [];

    public function device_location(): BelongsTo
    {
        return $this->belongsTo(DeviceLocation::class, 'device_location_id');
    }
}
