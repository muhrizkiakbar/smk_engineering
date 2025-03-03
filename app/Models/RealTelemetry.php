<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RealTelemetry extends Model
{
    //
    protected $table = 'real_telemetries';

    protected $attributes = [
        'ph' => 0,
        'tds' => 0,
        'tss' => 0,
        'velocity' => 0,
        'rainfall' => 0,
        'water_height' => 0,
    ];
    protected $guarded = [];

    public function device_location(): BelongsTo
    {
        return $this->belongsTo(DeviceLocation::class, 'device_location_id');
    }
}
