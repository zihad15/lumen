<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function create(Request $r)
    {
        $name = $r->name;
        $username = $r->username;
        $password = $r->password;

        if (empty($name) || empty($username) || empty($password)) {
            return response()->json([
                'status' => "failed",
                'errcode' => 400,
                'message' => 'Please complete requirement parameters!',
            ]);
        }

        $user = User::create([
            'name' => $name,
            'username' => $username,
            'password' => app('hash')->make($password),
        ]);

        return response()->json([
            'status' => "success",
            'errcode' => 200,
            'message' => 'Data saved successfully!',
            'data'=> $user
        ]);
    }
}
