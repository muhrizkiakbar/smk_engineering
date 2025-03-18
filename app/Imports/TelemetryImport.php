<?php

namespace App\Imports;

use App\Models\Telemetry;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class TelemetryImport implements ToModel, WithHeadingRow
{
    protected $device_locations;

    public function __construct(array $device_locations, Controller $controller)
    {
        $this->device_locations = $device_locations;
        $this->controller = $controller;
    }

    public function model(array $row)
    {
        $device_location_id = intval($row['device_location_id']);
        $formula = $this->device_locations[$device_location_id]['formula'] ?? null;
        $water_level = (float) $row['water_height'];

        $velocity = $formula ? $this->controller->calculate_velocity($formula, $water_level) : 0;

        return new Telemetry([
            'device_location_id' => $device_location_id,
            'created_at' => Carbon::parse($row['tanggal'] . ' ' . $row['jam']),
            'ph' => (float) $row['ph'],
            'tds' => (float) $row['tds'],
            'tss' => (float) $row['tss'],
            'velocity' => $velocity,
            'water_height' => $water_level,
            'rainfall' => (float) $row['rainfall'],
            'temperature' => (float) $row['temperature'],
            'humidity' => (float) $row['humidity'],
            'wind_direction' => (float) $row['wind_direction'],
            'wind_speed' => (float) $row['wind_speed'],
            'solar_radiation' => (float) $row['solar_radiation'],
            'evaporation' => (float) $row['evaporation'],
        ]);
    }
}
