<?php

namespace App\Services;

use App\Models\Telemetry;
use Illuminate\Http\Request;
use App\Repositories\Telemetries;
use App\Services\AppService;
use DateTime;
use Exception;

class TelemetryService extends AppService
{
    protected $telemetryRepository;

    public function __construct()
    {
        $this->telemetryRepository = new Telemetries();
    }

    public function telemetries(Request $request)
    {
        $telemetries = $this->telemetryRepository->filter($request->all());
        return $telemetries;
    }

    public function create($request)
    {
        $telemetry = Telemetry::create($request);

        return $telemetry;
    }

    public function update(Telemetry $telemetry, $request)
    {
        try {
            $telemetry->update($request);

            return $telemetry;
        } catch (Exception $e) {
            throw new Exception('Something went wrong.');
        }
    }

    public function delete(Telemetry $telemetry)
    {
        $telemetry->delete();
        return $telemetry;
    }

    public function generate($request)
    {
        $tanggal = $request->tanggal;
        $device_location_id = $request->device_location_id;

        for ($i = 0; $i <= 23; $i++) {
            $h = $i;
            if ($h < 10) {
                $h = '0'.$i;
            }
            Telemetry::create([
                'created_at' => DateTime::createFromFormat('Y-m-d H:i:s', $tanggal.' '.$h.':00:00'),
                'device_location_id' => $device_location_id,
                'ph' => 0,
                'tds' => 0,
                'tss' => 0,
                'velocity' => 0,
                'water_height' => 0,
                'rainfall' => 0,
                'temperature' => 0,
                'humidity' => 0,
                'wind_direction' => 0,
                'wind_speed' => 0,
                'solar_radiation' => 0,
                'evaporation' => 0,
                'dissolve_oxygen' => 0,
            ]);
        }
    }
}
