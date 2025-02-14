<?php

namespace App\Repositories;

use App\Models\Device;
use App\Repositories\Repository;

class Devices extends Repository
{
    public function __construct()
    {
        $this->model = Device::query();
    }

    protected function filterByType($query, $value)
    {
        $query->where('type', $value);
    }

    protected function filterByPhone_Number($query, $value)
    {
        $query->where('phone_number', $value);
    }

    protected function filterByBought_At($query, $value)
    {
        $query->whereDate('bought_at', $value);
    }

    protected function filterByUsed_At($query, $value)
    {
        $query->whereDate('used_at', $value);
    }

    protected function filterByDamaged_At($query, $value)
    {
        $query->whereDate('damaged_at', $value);
    }

    protected function filterByQ($query, $value)
    {
        $query->where('name', 'like', '%'.$value.'%')
            ->orWhere('phone_number', 'like', '%'.$value.'%');
    }

    protected function filterByState($query, $value)
    {
        $query->where('state', $value);
    }

}
