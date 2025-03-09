<?php

namespace App\Repositories;

use App\Models\DevicePhoto;
use App\Repositories\Repository;

class DevicePhotos extends Repository
{
    public function __construct()
    {
        $this->model = DevicePhoto::query();
    }

    protected function filterByDevice_Location_Id($query, $value)
    {
        $query->where('device_location_id', $value);
    }

    protected function filterByCreated_At($query, $value)
    {
        $query->whereDate('created_at', $value);
    }

    protected function filterByState($query, $value)
    {
        $query->whereDate('state', $value);
    }

}
