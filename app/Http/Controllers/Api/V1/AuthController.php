<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function register(RegisterRequest $request)
        {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make( $request->password),
            ]);


            $token = $user->createToken('api-token')->plainTextToken;


            return response()->json([
                'success' => true,

                'data' => [
                    'user' => new UserResource($user),
                    'token' => $token,
                ],
            ], 201);
        }


        public function login(LoginRequest $request)
        {
            if (!Auth::attempt($request->only(
                'email',
                'password'
            ))) {

                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }


            $user = Auth::user();


            $token = $user
                ->createToken('api-token')
                ->plainTextToken;


            return response()->json([
                'success' => true,
                'data' => [
                    'user' => new UserResource($user),
                    'token' => $token,
                ]
            ]);}


    public function me()
        {
            return response()->json([
                'success' => true,

                'data' => new UserResource(
                    auth()->user()
                )
            ]);
        }

        public function logout()
{
    auth()
        ->user()
        ->currentAccessToken()
        ->delete();


    return response()->json([
        'success' => true,
        'message' => 'Logged out successfully',
    ]);
}

}

