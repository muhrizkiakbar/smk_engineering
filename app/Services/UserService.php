<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\Users;
use App\Services\AppService;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserService extends AppService
{
    protected $userRepository;

    public function __construct()
    {
        $this->userRepository = new Users();
    }

    public function users(Request $request)
    {
        $users = $this->userRepository->filter($request->all());
        return $users;
    }

    public function create($request)
    {
        $user = User::create([
            'username' => $request['username'],
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'department_id' => $request['department_id'],
            'state' => $request['state'],
        ]);


        return $user;
    }

    public function update($request, User $user)
    {
        // Example logic for updating a photo record
        try {

            $userData = [
                'username' => $request['username'],
                'name' => $request['name'],
                'email' => $request['email'],
                'state' => $request['state'],
                'department_id' => (int) $request['department_id'],
            ];

            // Only update password if provided
            if ($request['password']) {
                $userData['password'] = Hash::make($request['password']);
            }

            $user->update($userData);

            return $user;
        } catch (Exception $e) {
            throw new Exception('Something went wrong.');
        }
    }

    public function delete(User $user)
    {
        // Example logic for deleting a photo record
        if ($user->state == "active") {
            $user->state = "archived";
        } else {
            $user->state = "active";
        }

        $user->save();

        return $user;
    }
}
