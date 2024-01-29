<?php

namespace App\Http\Repositories;
use App\Models\User;

class StudentRepository
{
    /**
     * @param User $student
     * @return mixed
     */
    public function show(User $student): mixed
    {
        return User::with('profile', 'results.quiz.questionCategories')->find($student->id);
    }
}