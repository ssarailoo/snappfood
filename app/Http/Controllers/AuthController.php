<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::query()->create($request->validated());
        $token = $user->createToken('registered')->plainTextToken;
        return response([
            'token' => $token,
            'message' => "Registered Successfully"
        ]);


    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $token = Auth::user()->createToken('logged')->plainTextToken;
            return response([
                'token' => $token,
                'message' => "Logged in Successfully"
            ], 201);
        } else return response([
            'message' => 'there is no user with this email and password'
        ], 401);
    }
}
