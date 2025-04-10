<?php

namespace App\Imports;

use App\Models\Telemetry;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class TelemetryImport implements ToModel, WithHeadingRow
{
    protected $device_locations;

    public function __construct(array $device_locations)
    {
        $this->device_locations = $device_locations;
    }

    public function model(array $row)
    {
        $device_location_id = intval($row['device_location_id']);
        $formula = $this->device_locations[$device_location_id]['formula'] ?? null;
        $water_level = (float) $row['water_level'];

        $debit = $formula ? round($this->calculate_debit($formula, $water_level), 2) : 0;

        return new Telemetry([
            'device_location_id' => $device_location_id,
            'created_at' => Carbon::parse($row['tanggal'] . ' ' . $row['jam']),
            'ph' => (float) $row['ph'],
            'tds' => (float) $row['tds'],
            'tss' => (float) $row['tss'],
            'debit' => $debit,
            'water_height' => $water_level,
            'rainfall' => (float) $row['rainfall'],
            'temperature' => (float) $row['temperature'],
            'humidity' => (float) $row['humidity'],
            'wind_direction' => (float) $row['wind_direction'],
            'wind_speed' => (float) $row['wind_speed'],
            'solar_radiation' => (float) $row['solar_radiation'],
            'evaporation' => (float) $row['evaporation'],
            'dissolve_oxygen' => (float) $row['dissolve_oxygen'],
        ]);
    }

    public function calculate_debit($formula, $water_level)
    {
        if (!str_contains($formula, '$water_level')) {
            return 0;
        }
        $processedFormula = str_replace('$water_level', $water_level, $formula);

        $expressLanguage =  new ExpressionLanguage();
        return $expressLanguage->evaluate($processedFormula, ['$water_level' => $water_level]);
    }
}
