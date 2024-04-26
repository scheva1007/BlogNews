<?php

namespace App\Http\Controllers\Api;

use App\Commands\RegisterAuthCommand;
use App\Http\Controllers\Controller;
use App\Http\Request\RegistrationAuthRequest;
use App\Http\Request\LoginAuthRequest;
use App\Http\Resources\AuthLoginResource;
use App\Http\Resources\AuthRegisterResource;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register (RegistrationAuthRequest $request, RegisterAuthCommand $register)
    {
        $user = $register->userCreate($request);
        $token = $user->createToken('AuthToken')->plainTextToken;

        return new AuthRegisterResource($user, $token);
    }

    public function login (LoginAuthRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password')))
        {
            $user = Auth::user();
            $token = $user->createToken('AuthToken')->plainTextToken;

            return new AuthLoginResource($user, $token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout ()
    {
        Auth::user()->tokens()->delete();

        return response()->json([]);
    }
}
