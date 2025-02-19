<?php

namespace App\Services;

use App\Models\RealTelemetry;
use Illuminate\Http\Request;
use App\Repositories\RealTelemetries;
use App\Services\AppService;
use Exception;

class RealTelemetryService extends AppService
{
    protected $realTelemetryRepository;

    public function __construct()
    {
        $this->realTelemetryRepository = new RealTelemetries();
    }

    public function realtelemetries(Request $request)
    {
        $telemetries = $this->realTelemetryRepository->filter($request->all());
        return $telemetries;
    }

    public function create($request)
    {
        $telemetry = RealTelemetry::create($request);

        return $telemetry;
    }

    public function update(RealTelemetry $telemetry, $request)
    {
        try {
            $telemetry->update($request);

            return $telemetry;
        } catch (Exception $e) {
            throw new Exception('Something went wrong.');
        }
    }

    public function delete(RealTelemetry $telemetry)
    {
        $telemetry->delete();
        return $telemetry;
    }
}
