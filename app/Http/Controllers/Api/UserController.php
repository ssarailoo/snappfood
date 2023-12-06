<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function __invoke(UpdateUserRequest $request)
    {
        try {
            Auth::user()->update($request->validated());
        } catch (QueryException $e) {
            Log::error('Error Updating Personal Information' . $e->getMessage());
            return response()->json([
                'data' => [
                    'message' => "An unexpected error occurred"
                ]
            ], 500);
        }

        return response()->json([
            'message' => "your personal information has been updated"
        ], 200);
    }
}
