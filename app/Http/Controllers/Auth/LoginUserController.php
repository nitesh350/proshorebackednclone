<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;

class LoginUserController extends Controller
{
    /**
     * @param LoginRequest $request 
     * @throws ValidationException
     * @return JsonResponse
     */
    public function __invoke(LoginUserRequest $request): JsonResponse
    {
        $request->authenticate();

        $token = auth()->user()->createToken('user_token')->plainTextToken;

        return response()->json([
            'message' => "Successfully logged in",
            'token' => $token
        ]);
    }
}
