<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DeviceLocation;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DevicePhoto extends Model
{
    //
    protected $table = 'device_photos';

    protected $attributes = [
        'state' => "pending",
    ];

    protected $guarded = [];

    public function device_location(): BelongsTo
    {
        return $this->belongsTo(DeviceLocation::class, 'device_location_id');
    }
}
