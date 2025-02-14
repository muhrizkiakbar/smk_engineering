<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Device;
use App\Models\Location;
use App\Models\Telemetry;

class DeviceLocation extends Model
{
    protected $table = 'device_locations';
    protected $attributes = [
        'state' => 'pending',
    ];

    protected $guarded = [];

    public function telemetries(): HasMany
    {
        return $this->hasMany(Telemetry::class);
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class, 'device_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
