<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $credentials = $request->validate([
            'current_password' => 'required|min:6',
            'new_password'  => 'required|min:6|confirmed',
        ]);

        $currentUser = auth()->user();
        $currentUserPassword = $currentUser->password;
        $oldPassword = $credentials['current_password'];
        $newPassword = $credentials['new_password'];

        if(!Hash::check($oldPassword, $currentUserPassword)){
            return response(['message' => 'Current Password is incorrect'], 400);
        }

        if(Hash::check($newPassword, $currentUserPassword)) {
            return response(['message' => 'New Password cannot be the  same with your old  password'], 400);
        }

        $currentUser->update(['password' => Hash::make($newPassword)]);

        $currentUser->tokens()->delete();

        $token = $currentUser->createToken('token');

        return response([
            'message' => 'Password changed successfully.',
            'data' =>  [
                'token' => $token->plainTextToken,
            ]
        ]);

    }
}
