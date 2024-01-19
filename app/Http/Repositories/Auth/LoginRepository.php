<?php

namespace App\Http\Repositories\Auth;

use Illuminate\Support\Facades\Config;

class LoginRepository
{
    /**
     * Generate an authentication token for the user based on their role abilities.
     *
     * @return string The generated authentication token.
     */
    public function generateAuthToken(): string
    {
        $user = auth()->user();
        $userType = $user->user_type;

        $abilities = Config::get("abilities.$userType");

        $token = $user->createToken('user_token', $abilities)->plainTextToken;

        return $token;
    }
}
