<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request_data = $request->all();

        $validation  = Validator::make($request_data, [
            'email' => [
                'required',
                'unique:users,email'
            ],
            'name' => 'required',
            'password' => 'required',
            'gender' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status'   => false,
                'message'   => $validation->errors()->first(),
                'error'      => $validation->errors()
            ], 422);
        }
        $request_data['password'] = Hash::make($request_data['password']);
        $user = User::create($request_data);
        $user->access_token = $user->createToken('KrishThesis')->plainTextToken;

        return response()->json([
            'status'   => true,
            'message'   => 'Successfully registered user',
            'data'      => $user
        ], 200);

    }

    public function login(Request $request)
    {
        $request_data = $request->all();

        $validation  = Validator::make($request_data, [
            'email' => [
                'required'
            ],
            'password' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status'   => false,
                'message'   => $validation->errors()->first(),
                'error'      => $validation->errors()
            ], 422);
        }

        $user = Auth::attempt($request_data);

        if (!$user) {
            return response()->json([
                'success'   => false,
                'message'   => 'Unauthenticate User',
            ], 200);
        }
        $user = Auth::user();
        $user->access_token = $user->createToken('KrishThesis')->plainTextToken;

        return response()->json([
            'status'   => true,
            'message'   => 'Successfully login',
            'data'      => $user
        ], 200);
    }



    public function updateCategory(Request $request)
    {
        $request_data = $request->all();

        $validation  = Validator::make($request_data, [
            'category_id' => [
                'required',
                'exists:categories,id'
            ],
            'user_id'=> [
                'required'
            ]
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status'   => false,
                'message'   => $validation->errors()->first(),
                'error'      => $validation->errors()
            ], 422);
        }

        // $user = $request->user();
        // dd($user);
        $user = User::find($request->user_id);
        $user->category_id = $request_data['category_id'];
        $user->save();

        return response()->json([
            'status'   => true,
            'message'   => 'Successfully update category',
        ], 200);
    }
}
