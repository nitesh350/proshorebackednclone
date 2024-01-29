<?php

namespace App\Http\Repositories;
use App\Models\User;

class StudentRepository
{
    /**
     * @param User $student
     * @return User
     */
    public function show(User $student): User
    {
        return $student->load(["profile","results.quiz.questionCategories"]);
    }
}
