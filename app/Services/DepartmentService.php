<?php

namespace App\Services;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Repositories\Departments;
use App\Services\AppService;
use Exception;

class DepartmentService extends AppService
{
    protected $departmentRepository;

    public function __construct()
    {
        $this->departmentRepository = new Departments();
    }

    public function departments(Request $request)
    {
        $departments = $this->departmentRepository->filter($request->all());
        return $departments;
    }

    public function create($request)
    {
        $department = Department::create($request);

        return $department;
    }

    public function update(Department $department, $request)
    {
        // Example logic for updating a photo record
        try {
            $department->update($request);

            return $department;
        } catch (Exception $e) {
            throw new Exception('Something went wrong.');
        }
    }

    public function delete(Department $department)
    {
        // Example logic for deleting a photo record
        if ($department->state == "active") {
            $department->state = "archived";
        } else {
            $department->state = "active";
        }

        $department->save();

        return $department;
    }
}
