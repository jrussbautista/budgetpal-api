<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Laravel\Socialite\Facades\Socialite;


class LoginWithGoogleController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $accessToken = $request->input('accessToken');

        $results = Socialite::driver('google')->userFromToken($accessToken);

        if(!$results) {
            return 
                response()
                ->json(['message' => 'Unable to login with google right now. Please try again lter' ]);
        }

        $avatar = $results->getAvatar();
        $googleId = $results->getId();
        $name = $results->getName();
        $email = $results->getEmail();

        $user = User::where('email', $email)->first();

        if(!$user) {
            // save user to db
            $user = User::create([
                'email' => $email,
                'name' => $name,
                'image_url' => $avatar,
                'provider_id' => $googleId,
                'provider' => 'google'
            ]);

            $user->markEmailAsVerified();
        }

        $token = $user->createToken('token');

        return  response([
            'data' => [
                'token' => $token->plainTextToken,
                'user' => new UserResource($user)
            ]
        ]);
        
    }
}
