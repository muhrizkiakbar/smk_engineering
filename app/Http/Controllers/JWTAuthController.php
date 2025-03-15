<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTAuthController extends Controller
{
    // User login
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        try {
            // First, check if the user is already logged in and has a valid token
            try {
                $currentToken = JWTAuth::getToken();
                if ($currentToken) {
                    // Invalidate the current token
                    JWTAuth::invalidate($currentToken);
                }
            } catch (\Exception $e) {
                // No valid token exists, continue with login
            }

            // Attempt authentication
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            // Get the authenticated user
            $user = auth()->user();

            // Make sure we have a valid user before accessing properties
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            // Attach the role to the token
            $token = JWTAuth::claims(['role' => $user->type_user])->fromUser($user);

            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60, // in seconds
            ]);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token: ' . $e->getMessage()], 500);
        }
    }

    // User logout
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }
}
