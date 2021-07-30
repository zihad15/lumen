<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

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
                'message' => 'You must fill all the fields.',
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
            'message' => 'Data saved successfully.',
            'data'=> $user
        ]);
    }

    public function update(Request $r)
    {
        $id = $r->id;
        $name = $r->name;
        $username = $r->username;
        $password = $r->password;
        $arr = [];

        if (empty($id)) {
            return response()->json([
                'status' => "failed",
                'errcode' => 400,
                'message' => 'Parameter id cannot be empty.'
            ]);
        }

        if (!empty($r->name)) {
            $arr['name'] = $name;
        }

        if (!empty($r->username)) {
            $arr['username'] = $username;
        }

        if (!empty($r->password)) {
            $arr['password'] = app('hash')->make($password);
        }

        $user = User::where('_id', $id)->update($arr);

        return response()->json([
            'status' => "success",
            'errcode' => 200,
            'message' => 'Data updated successfully.'
        ]);
    }

    public function delete(Request $r)
    {
        $id = $r->id;

        $user = User::where('_id', $id)->first();

        if (!$user) {
            return response()->json([
                'status' => "failed",
                'errcode' => 400,
                'message' => 'Data not found.'
            ]);
        } else {
            $user = $user->delete();
        }

        return response()->json([
            'status' => "success",
            'errcode' => 200,
            'message' => 'Data deleted successfully.'
        ]);
    }

    public function data()
    {
        $user = User::find(Auth::user()->id);

        return response()->json([
            'status' => "success",
            'errcode' => 200,
            'message' => 'Data retrieved successfully.',
            'data'=> $user
        ]);
    }
}
