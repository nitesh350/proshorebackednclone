<?php

namespace App\Http\Repositories;

use App\Models\User;

class StudentRepository
{
    /**
     * @param User $student
     * @return User
     */
    public function show(int $id): User
    {
        $student =  User::where('user_type', 'student')->findOrFail($id);
        return $student->load(["profile", "results.quiz.questionCategories"]);
    }
}
