<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    protected $departmentService;

    public function __construct()
    {
        $this->departmentService = new DepartmentService(Auth::user());
    }

    //
    public function index(Request $request)
    {
        $departments = $this->departmentService->departments($request)->cursorPaginate(10);

        return view('departments.index', ['departments' => $departments]);
    }

    public function create()
    {
        return view('departments.new');
    }

    public function store(DepartmentRequest $request)
    {
        $department = $this->departmentService->create($request->all());
        return redirect('departments')->with('status', 'Department telah dibuat');
    }

    public function edit(string $id)
    {
        $department = Department::find(decrypt($id));
        return view('departments.edit', ['department' => $department]);
    }

    public function update(Request $request, string $id)
    {
        $department = Department::find(decrypt($id));

        $request->validate([
            'name' => [ 'required','string', 'max:255' ],
            'visibility_telemetry' => [ 'required','string', 'max:255' ],
            'state' => [ 'nullable', 'string', 'max:255' ],
        ]);


        $this->departmentService->update($department, $request->all());

        return redirect("departments")->with('status', 'Department berhasil Diubah');
    }

    public function destroy(string $id)
    {
        $department = Department::find(decrypt($id));
        $department = $this->departmentService->delete($department);

        if ($department->state == "active") {
            $message = "Device berhasil diaktifkan.";
        } else {
            $message = "Device berhasil dinonaktifkan.";
        }

        return redirect("departments")->with('status', $message);
    }
}
