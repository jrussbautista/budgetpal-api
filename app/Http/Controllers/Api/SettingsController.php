<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function update(Request $request)  {
        $user = Auth::user();

        $fields = $request->validate([
            'theme' =>  'in:light,dark',
            'currency' => 'in:USD,PHP',
            'language' => 'in:en,zh'
        ]);
        
        if(count($fields)) {
            $user->update($request->only('theme', 'currency', 'language'));
            return new UserResource($user);
        }

   }
}
