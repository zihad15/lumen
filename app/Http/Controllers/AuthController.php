<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    public function login(Request $r)
    {
        $username = $r->username;
        $password = $r->password;

        if (empty($username) or empty($password)) {
            return response()->json([
                'status' => "failed",
                'errcode' => 400,
                'message' => 'You must fill all the fields.'
            ]);
        }

        $credentials = request(['username', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'status' => "success",
            'errcode' => 200,
            'message' => 'Successfully logged out.'
        ]);
    }
}
