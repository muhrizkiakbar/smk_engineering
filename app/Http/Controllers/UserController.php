<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct()
    {
        $this->userService = new UserService(Auth::user());
    }

    /**
     * Display the registration view.
     */
    public function index(Request $request)
    {
        $users = $this->userService->users($request, ['department'])->cursorPaginate(10);
        $departments = Department::where('state', 'active')->get();
        return view('users.index', ['users' => $users, 'departments' => $departments]);
    }

    public function create(): View
    {
        $departments = Department::where('state', 'active')->get();
        return view('users.new', ['departments' => $departments]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'department_id' => ['required', 'string', 'max:255'],
            'type_user' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->where(function ($query) use ($request) {
                    return $query->where('username', $request['username']);
                }),
            ],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'state' => ['required', 'string', 'max:255'],
        ]);

        $user = $this->userService->create($request->all());

        return redirect(route('users.index', absolute: false))->with('status', "User has been created.");
    }

    public function edit(String $id)
    {
        $user = User::find(decrypt($id));
        $departments = Department::where('state', 'active')->get();
        return view('users.edit', ['user' => $user, 'departments' => $departments]);
    }

    public function update(Request $request, String $id): RedirectResponse
    {
        $user = User::find(decrypt($id));

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'department_id' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($user->id)->where(function ($query) use ($request) {
                    return $query->where('username', $request->username);
                }),
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'state' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = $this->userService->update($request->all(), $user);

        return redirect(route('users.index'))->with('status', 'user-updated');
    }

    public function destroy(string $id)
    {
        $user = User::find(decrypt($id));
        $user = $this->userService->delete($user);

        if ($user->state == "active") {
            $message = "User berhasil diaktifkan.";
        } else {
            $message = "User berhasil dinonaktifkan.";
        }

        return redirect(route('users.index'))->with('status', $message);
    }
}
