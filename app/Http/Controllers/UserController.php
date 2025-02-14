<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Divisions\User as DivisionsUser;
use App\Http\Requests\DivisionUserRequest;

class UserController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function search_json(Request $request)
    {
        $term = trim($request->q);
        if (empty($term)) {
            return response()->json([]);
        }
        $tags = User::where('name','LIKE','%'.$term.'%')->limit(20)->get();
        $formatted_tags = [];
        foreach ($tags as $tag) {
            $formatted_tags[] = ['id' => $tag->id, 'name' => $tag->nip." - ". $tag->name];
        }
        return response()->json($formatted_tags);
    }

    public function division_users($division_id)
    {
        $division_users = DivisionsUser::leftJoin('users', 'division_users.user_id', '=', 'users.id')
            ->leftJoin('divisions', 'division_users.division_id', '=', 'divisions.id')
            ->where('division_id', intval($division_id))
            ->get();

        return response()->json(
            [
                'data' => $division_users->map(function ($division_user) {
                    return [
                        'id' => $division_user->id,
                        'user' => [
                            'nip' => $division_user->user->nip,
                            'name' => $division_user->user->name,
                        ],
                        'division' => [
                            'name' => $division_user->division->name,
                        ]
                    ];
                })
            ]
        );
    }

    public function create_division_user(DivisionUserRequest $request)
    {
        $division_user = new DivisionsUser();
        $division_user->division_id = $request["user_id"];
        $division_user->user_id = $request["user_id"];
        $division_user->save();

        return response()->json(
            [
                'data' => [
                    'id' => $division_user->id,
                    'user' => [
                        'nip' => $division_user->user->nip,
                        'name' => $division_user->user->name,
                    ],
                    'division' => [
                        'name' => $division_user->division->name,
                    ]
                ]
            ]
        );
    }

    public function delete_division_user(string $id)
    {
        $division_user = DivisionsUser::find(intval($id));
        $division_user->delete();

        return response()->json(
            [
                'success' => 'Berhasil menghapus user pada divisi.'
            ]
        );
    }
}
