<?php

namespace App\Repositories;

use App\Models\Telemetry;
use App\Repositories\Repository;

class Telemetries extends Repository
{
    public function __construct()
    {
        $this->model = Telemetry::query();
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
        $query->where('created_at', '<=', $value);
    }
}
