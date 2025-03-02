<?php

namespace App\Repositories;

use App\Models\Department;
use App\Repositories\Repository;

class Departments extends Repository
{
    public function __construct()
    {
        $this->model = Department::query();
    }

    protected function filterByQ($query, $value)
    {
        $query->where('name', 'like', '%'.$value.'%');
    }

    protected function filterByState($query, $value)
    {
        $query->where('state', $value);
    }

}
