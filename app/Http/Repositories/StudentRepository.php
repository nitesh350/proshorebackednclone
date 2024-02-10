<?php

namespace App\Http\Repositories;

use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RegisteredStudentExport;

class StudentRepository
{
    /**
     * @param int $id
     * @return User
     */
    public function show(int $id): User
    {
        $student =  User::where('user_type', 'student')->findOrFail($id);
        return $student->load(["profile", "results.quiz.questionCategories"]);
    }

    public function getFilteredStudent($params)
    {
        $query = User::query()->select(['id', 'name', 'email','user_type'])->where('user_type','student');

        if (isset($params['name']))
        {
            $query->with('profile')
                ->where('name', 'like', '%' . $params['name'] . '%')->get();
        }

        return $query->paginate(10);
    }
}
