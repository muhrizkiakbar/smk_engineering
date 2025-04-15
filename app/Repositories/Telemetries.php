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
        if (is_array($value)) {
            $query->whereIn('device_location_id', $value);
        } else {
            $query->where('device_location_id', $value);
        }
    }

    protected function filterByTanggal($query, $value)
    {
        $query->whereDate('created_at', $value);
    }

    protected function filterByLTE_Tanggal($query, $value)
    {
        $query->whereDate('created_at', '<=', $value);
    }

    // Filter records from a specific 'from_date'
    protected function filterByFromDate($query, $value)
    {
        if ($value) {
            $query->whereDate('created_at', '>=', $value);
        }
    }

    // Filter records up to a specific 'to_date'
    protected function filterByToDate($query, $value)
    {
        if ($value) {
            $query->whereDate('created_at', '<=', $value);
        }
    }
}
