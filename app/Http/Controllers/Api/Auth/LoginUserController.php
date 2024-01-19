<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Repositories\Auth\LoginRepository;

class LoginUserController extends Controller
{
    private LoginRepository $loginRepository;

    /**
     * @param LoginRepository $loginRepository
     */
    public function __construct(LoginRepository $loginRepository)
    {
        $this->loginRepository = $loginRepository;
    }

    /**
     * @param LoginUserRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function __invoke(LoginUserRequest $request): JsonResponse
    {
        $request->authenticate();

        $token = $this->loginRepository->generateAuthToken();

        return response()->json([
            'message' => "Successfully logged in",
            'token' => $token
        ]);
    }
}
