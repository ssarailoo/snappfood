<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __invoke(UpdateUserRequest $request)
    {
        Auth::user()->update($request->validated());
        return response()->json([
            'message' => "your personal information has been updated"
        ],200);
    }
}
