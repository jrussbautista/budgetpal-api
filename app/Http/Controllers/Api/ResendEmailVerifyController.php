<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResendEmailVerifyController extends Controller
{
    public function __invoke(Request $request)
    {   
        $request->user()->sendEmailVerificationNotification();

        return response()->json(['message', 'Verification link sent!']);
    }
}
