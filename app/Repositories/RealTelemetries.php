<?php

namespace App\Repositories;

use App\Models\RealTelemetry;
use App\Repositories\Repository;

class RealTelemetries extends Repository
{
    public function __construct()
    {
        $this->model = RealTelemetry::query();
    }

    protected function filterByDevice_Location_Id($query, $value)
    {
        $query->where('device_location_id', $value);
    }

    protected function filterByTanggal($query, $value)
    {
        $query->whereDate('created_at', $value);
    }

    protected function filterByLTE_Tanggal($query, $value)
    {
        $query->whereDate('created_at', '<=', $value);
    }
}
