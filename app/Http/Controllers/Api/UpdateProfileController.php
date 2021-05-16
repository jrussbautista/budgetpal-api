<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UpdateProfileController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'min:6',
            'email' => 'email'
        ]);

        $user = auth()->user();

        $user->update($validatedData);

        return response([
            'message' => 'Profile updated successfully', 
            'data' => [
                'user' => new UserResource($user)
            ]
        ]);
    }
}
