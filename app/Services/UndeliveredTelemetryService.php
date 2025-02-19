<?php

namespace App\Services;

use App\Models\UndeliveredTelemetry;
use Illuminate\Http\Request;
use App\Repositories\UndeliveredTelemetries;
use App\Services\AppService;
use Exception;

class UndeliveredTelemetryService extends AppService
{
    protected $undeliveredTelemetryRepository;

    public function __construct()
    {
        $this->undeliveredTelemetryRepository = new UndeliveredTelemetries();
    }

    public function telemetries(Request $request)
    {
        $telemetries = $this->undeliveredTelemetryRepository->filter($request->all());
        return $telemetries;
    }

    public function create($request)
    {
        $telemetry = UndeliveredTelemetry::create($request);

        return $telemetry;
    }

    public function update(UndeliveredTelemetry $telemetry, $request)
    {
        try {
            $telemetry->update($request);

            return $telemetry;
        } catch (Exception $e) {
            throw new Exception('Something went wrong.');
        }
    }

    public function delete(UndeliveredTelemetry $telemetry)
    {
        $telemetry->delete();
        return $telemetry;
    }
}
