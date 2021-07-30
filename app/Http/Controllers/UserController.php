<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UserController extends Controller
{
    /**
     * @OA\Info(title="Dokumentasi API",version="11")
     *
     *@OA\Post(path="/lumen/public/userCreate",
     *   tags={"User"},
     *   summary="User Create",
     *   description="",
     *   operationId="placeOrder",
     *   @OA\RequestBody(
     *       required=true,
     *        @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="Input user name",
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     description="Input username",
     *                     property="username",
     *                     type="string",
     *                 ),
     *                  @OA\Property(
     *                     description="Input password",
     *                     property="password",
     *                     type="string",
     *                 ),
     *             )
     *         )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="successful operation"
     *   ),
     *   @OA\Response(response=400, description="Invalid Order")
     * )
     */
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

    /**
     *@OA\Post(path="/lumen/public/userUpdate",
     *   tags={"User"},
     *   summary="User Update",
     *   description="",
     *   operationId="placeOrder",
     *   @OA\RequestBody(
     *       required=true,
     *        @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="Input user id",
     *                     property="id",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     description="Input user name",
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     description="Input username",
     *                     property="username",
     *                     type="string",
     *                 ),
     *                  @OA\Property(
     *                     description="Input password",
     *                     property="password",
     *                     type="string",
     *                 ),
     *             )
     *         )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="successful operation",
     *     @OA\Schema(ref="")
     *   ),
     *   @OA\Response(response=400, description="Invalid Order")
     * )
     */

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

    /**
     *@OA\Post(path="/lumen/public/userDelete",
     *   tags={"User"},
     *   summary="User Delete",
     *   description="",
     *   operationId="placeOrder",
     *   @OA\RequestBody(
     *       required=true,
     *        @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="Input user id",
     *                     property="id",
     *                     type="string"
     *                 ),
     *             )
     *         )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="successful operation",
     *     @OA\Schema(ref="")
     *   ),
     *   @OA\Response(response=400, description="Invalid Order")
     * )
     */

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
