<?php

namespace App\Repositories;

use App\Models\DeviceLocation;
use App\Repositories\Repository;

class DeviceLocations extends Repository
{
    public function __construct()
    {
        $this->model = DeviceLocation::query();
    }

    protected function filterByDevice_Id($query, $value)
    {
        $query->where('device_id', $value);
    }

    protected function filterByLocation_Id($query, $value)
    {
        $query->where('location_id', $value);
    }

    protected function filterByState($query, $value)
    {
        $query->where('state', $value);
    }

}
