<?php

namespace App\Exports;

use App\Models\Telemetry;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TelemetryExport implements FromCollection, WithHeadings
{
    protected $from_date;
    protected $to_date;
    protected $device_location_id;

    public function __construct($from_date = null, $to_date = null, $device_location_id = null)
    {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->device_location_id = $device_location_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Telemetry::with(['device_location.device', 'device_location.location']);

        if ($this->from_date && $this->to_date) {
            $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
        }

        if ($this->device_location_id) {
            $query->where('device_location_id', $this->device_location_id);
        }

        return $query->orderBy('created_at', 'desc')->get()->map(function ($data) {
            return [
                'device_name'      => optional($data->device_location)->device ? $data->device_location->device->name : 'N/A',
                'location_name'    => optional($data->device_location)->location ? $data->device_location->location->name : 'N/A',
                'city'             => optional($data->device_location)->location ? $data->device_location->location->city : 'N/A',
                'district'         => optional($data->device_location)->location ? $data->device_location->location->district : 'N/A',
                'date'             => $data->created_at->format('Y-m-d'),
                'time'             => $data->created_at->format('H:i:s'),
                'ph'               => $data->ph,
                'tds'              => $data->tds,
                'tss'              => $data->tss,
                'water_level'      => $data->water_height,
                'debit'            => $data->debit,
                'rainfall'         => $data->rainfall,
                'temperature'      => $data->temperature,
                'humidity'         => $data->humidity,
                'wind_direction'   => $data->wind_direction,
                'wind_speed'       => $data->wind_speed,
                'solar_radiation'  => $data->solar_radiation,
                'evaporation'      => $data->evaporation,
                'dissolve_oxygen'  => $data->dissolve_oxygen,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Device Name',
            'Location Name',
            'City',
            'District',
            'Tanggal',
            'Jam',
            'pH',
            'TDS',
            'TSS',
            'Water Level',
            'Debit',
            'Rainfall',
            'Temperature',
            'Humidity',
            'Wind Direction',
            'Wind Speed',
            'Solar Radiation',
            'Evaporation',
            'Dissolve Oxygen',
        ];
    }
}
