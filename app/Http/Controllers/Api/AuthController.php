<?php

namespace App\Http\Controllers\Api;

use App\Commands\RegisterAuthCommand;
use App\Http\Controllers\Controller;
use App\Http\Request\RegistrationAuthRequest;
use App\Http\Request\LoginAuthRequest;
use App\Http\Resources\AuthLoginResource;
use App\Http\Resources\AuthRegisterResource;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * @OA\Post(
 *     path="/api/register",
 *     summary="Register a new user",
 *     tags={"Authentication"},
 *     operationId="registerUser",
 *     @OA\RequestBody(
 *         required=true,
 *         description="User registration details",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="name", type="string"),
 *                 @OA\Property(property="email", type="string", format="email"),
 *                 @OA\Property(property="password", type="string"),
 *                 @OA\Property(property="password_confirmation", type="string")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="token", type="string"),
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="email", type="string"),
 *             @OA\Property(property="role", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthenticated"
 *
 *  )
 * )
 *
 * @OA\Post(
 *     path="/api/logout",
 *     summary="Logout the authenticated user",
 *     tags={"Authentication"},
 *     operationId="logoutUser",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=204,
 *         description="Successfully logged out"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthenticated"
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/login",
 *     summary="Login user",
 *     tags={"Authentication"},
 *     operationId="loginUser",
 *     @OA\RequestBody(
 *         required=true,
 *         description="User login details",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="email", type="string", format="email"),
 *                 @OA\Property(property="password", type="string", format="password")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful login",
 *         @OA\JsonContent(
 *             @OA\Property(property="token", type="string"),
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="email", type="string"),
 *             @OA\Property(property="role", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     )
 * )
 */

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
