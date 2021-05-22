<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserSettingController extends Controller
{
    public function update(Request $request) {

        $user = auth()->user();

        if($request->has('currency')) {
            $user->currency = $request->input('currency');
        }

        $user->save();

        return response([
            'message' => 'User settings updated successfully', 
             'data' => [
                 'user' => new UserResource(auth()->user())
             ]
            ]);
    }
}
