<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticationController extends Controller
{
    public function signup(SignupRequest $request)
    {
        $data = $request->validated();

        if (User::where('email', $data['email'])->exists()) {
            return $this->badRequestResponse('Email already exists');
        }

        $user = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $token = JWTAuth::fromUser($user);

        $data = [
            'user' => $user,
            'token' => $token,
        ];

        return $this->createdResponse('User has been created successfully', $data);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = auth('api')->user();

        $data = [
            'user' => $user,
            'token' => $token,
        ];

        return $this->okResponse('Login successful', $data);

    }
}
