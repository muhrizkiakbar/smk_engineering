<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\DeviceLocation;

class Device extends Model
{
    protected $table = 'devices';
    protected $attributes = [
        'state' => 'active',
    ];
    protected $guarded = [];
    //
    public function location(): HasOne
    {
        return $this->hasOne(Location::class, DeviceLocation::class, 'device_id', 'location_id');
    }
}
