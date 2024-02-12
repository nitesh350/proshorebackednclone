<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
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

    /**
     * @param $params
     * @param $export
     * @return LengthAwarePaginator|Collection
     */
    public function getFilteredStudent($params, $export): Collection|LengthAwarePaginator
    {
        $query = User::query()->select(['id', 'name', 'email','user_type'])->where('user_type','student');

        if (isset($params['name'])){
            $query = $query->where('name', 'like', '%' . $params['name'] . '%')->get();
        }

        if($export){
            return $query->with('profile')->get();
        }

        return $query->paginate(10);
    }

    public function exportStudents($students) : JsonResponse
    {
        $exportFileName = 'students.xlsx';
        $exportFilePath = 'exports/' . $exportFileName;

        Excel::store(new RegisteredStudentExport($students), $exportFilePath);

        $storagePath = asset($exportFilePath);
        return response()->json(['export_url' => $storagePath]);
    }
}
