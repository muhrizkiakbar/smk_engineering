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

            // Get the authenticated user directly from the model instead of auth()
            $user = User::where('username', $credentials['username'])->first();

            // Debugging
            if (!$user) {
                // Log the credentials for debugging (remove in production)
                \Log::info('User lookup failed for username: ' . $credentials['username']);
                return response()->json(['error' => 'User lookup failed after successful authentication'], 500);
            }

            // Attach the role to the token
            $token = JWTAuth::claims(['role' => $user->type_user])->fromUser($user);

            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60, // in seconds
                'user_info' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'type' => $user->type_user
                ] // Return user info for debugging
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
