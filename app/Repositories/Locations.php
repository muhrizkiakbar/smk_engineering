<?php

namespace App\Repositories;

use App\Models\Location;
use App\Repositories\Repository;

class Locations extends Repository
{
    public function __construct()
    {
        $this->model = Location::query();
    }

    protected function filterByQ($query, $value)
    {
        $query->where('name', 'like', '%'.$value.'%')
            ->orWhere('city', 'like', '%'.$value.'%')
            ->orWhere('district', 'like', '%'.$value.'%');
    }

    protected function filterByState($query, $value)
    {
        $query->where('state', $value);
    }

}
