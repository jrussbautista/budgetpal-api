<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = auth()->attempt($credentials);

        if(!$user) return response(['message' => 'Email or Password is incorrect'], 401);

        $token = auth()->user()->createToken('token');

        return  response([
            'data' => [
                'token' => $token->plainTextToken,
                'user' => new UserResource(auth()->user())
            ]
        ]);

    }

    public function register(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = User::create(
            [
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password'])
            ]
        );

        $token = $user->createToken('token');

        return response([
            'data' =>  [
                'token' => $token->plainTextToken,
                'user' => new UserResource($user)
            ]
        ], 201);
    }


}
