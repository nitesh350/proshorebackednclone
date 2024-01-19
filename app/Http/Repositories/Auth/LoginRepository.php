<?php

namespace App\Http\Repositories\Auth;

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

        $abilities = ($user->user_type == "admin")
            ? ['manage-quiz-categories', 'manage-quiz', 'manage-questions', 'manage-question-categories', 'view-results']
            : ['view-quizzes', 'can-attempt-quiz', 'view-quiz-results', 'manage-profile'];

        $token = $user->createToken('user_token', $abilities)->plainTextToken;

        return $token;
    }
}
