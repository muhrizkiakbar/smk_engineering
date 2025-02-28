<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function index(Request $request)
    {

    }

    public function create(): View
    {
        return view('auth.create');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->where(function ($query) {
                    return $query->where('username', $this->username);
                }),
            ],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'state' => ['required', 'string', 'max:255'],
        ]);

        User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'state' => $request->state,
        ]);

        return redirect(route('users', absolute: false));
    }

    public function edit(String $id)
    {
        $user = User::find(decrypt($id));
        return view('auth.create', ['user' => $user]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
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

        $userData = [
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'state' => $request->state,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect(route('users', absolute: false))->with('status', 'user-updated');
    }

    public function destroy(string $id)
    {
        $device = User::find(decrypt($id));
        if ($device->state == "active") {
            $device->state = "archived";
        } else {
            $device->state = "active";
        }

        $device->save();

        if ($device->state == "active") {
            $message = "User berhasil diaktifkan.";
        } else {
            $message = "User berhasil dinonaktifkan.";
        }

        return redirect(route('users', absolute: false))->with('status', $message);
    }
}
