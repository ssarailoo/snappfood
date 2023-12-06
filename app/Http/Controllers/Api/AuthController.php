<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * @group User Authentication
 *
 *
 */
class AuthController extends Controller
{

    /**
     *Register a new user and obtain an authentication token.
     * @unauthenticated
     * @bodyParam password_confirmation string required must match the password Example:ss123456
     * @response 201 scenario="User registered successfully" {
     *      "token": "your-auth-token",
     *      "message": "Registered Successfully"
     *  }
     * @response 422 scenario="Validation errors" {
     *      "message": "The given data was invalid.",
     *      "errors": {
     *          "name": [
     *              "The name field is required."
     *          ],
     *          "email": [
     *              "The email field is required."
     *          ],
     *          "password": [
     *              "The password field is required."
     *          ]
     *      }
     *  }
     */

    public function register(RegisterRequest $request)
    {

        $user = User::query()->create($request->validated());
        $token = $user->createToken('registered')->plainTextToken;
        return response()->json([
            'data' => [
                'token' => $token,
            ]
            , 'message' => "Registered Successfully"
        ], 201);


    }

    /**
     * Authenticate a user and obtain an authentication token.
     * @unauthenticated
     * @response 200 scenario="User logged in successfully" {
     *      "token": "your-auth-token",
     *      "message": "Logged in Successfully"
     *  }
     *
     * @response 401 scenario="Invalid credentials" {
     *      "message": "There is no user with this email and password"
     *  }
     */
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            Auth::user()->tokens()->delete();
            $token = Auth::user()->createToken('logged')->plainTextToken;
            return response()->json([
                'data' => [
                    'token' => $token,
                ],
                'message' => "Logged in Successfully"
            ], 200);
        } else return response()->json([
            'message' => 'These credentials do not match our records.'
        ], 401);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'msg' => 'logged out!'
        ], 200);
    }
}
