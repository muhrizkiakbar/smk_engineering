<?php

namespace App\Imports;

use App\Models\Telemetry;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class TelemetryImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Telemetry([
            'device_location_id' => intval($row['device_location_id']),
            'created_at' => Carbon::parse($row['tanggal'] . ' ' . $row['jam']),
            'ph' => (float) $row['ph'],
            'tds' => (float) $row['tds'],
            'tss' => (float) $row['tss'],
            'velocity' => (float) $row['velocity'],
            'water_height' => (float) $row['water_level'],
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
