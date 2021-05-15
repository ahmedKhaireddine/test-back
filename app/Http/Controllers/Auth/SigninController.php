<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SigninRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SigninController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \App\Http\Requests\Auth\SigninRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(SigninRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $user = Auth::user()->createToken(env('APP_NAME',  'Laravel'));

            return response()->json([
                'data' => [
                    'access_token' => $user->accessToken
                ]
            ], 200);
        } else {
            return response()->json([
                'data' => [
                    'message' => 'Invalid credentials.'
                ]
            ], 401);
        }
    }
}
