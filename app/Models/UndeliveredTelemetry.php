<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UndeliveredTelemetry extends Model
{
    protected $table = 'undelivered_telemetries';

    protected $attributes = [
        'ph' => 0,
        'tds' => 0,
        'tss' => 0,
        'velocity' => 0,
        'rainfall' => 0,
        'water_height' => 0,
    ];
    protected $guarded = [];
}
