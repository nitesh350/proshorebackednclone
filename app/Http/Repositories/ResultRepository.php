<?php

namespace App\Http\Repositories;

use App\Exports\ResultExport;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Result;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;

class ResultRepository
{

    /**
     * @param $data
     * @param $export
     * @return LengthAwarePaginator|Collection
     */
    public function getFilteredResult($data, $export): Collection|LengthAwarePaginator
    {
        $query = Result::with(['user','quiz']);
        if (isset($data['quiz'])) {
            $query->whereHas('quiz', function ($quizQuery) use ($data) {
                $quizQuery->where('title', 'like', '%' . $data['quiz'] . '%');
            });
        }
        if (isset($data['user'])) {
            $query->whereHas('user', function ($userQuery) use ($data) {
                $userQuery->where('name', 'like', '%' . $data['user'] . '%');
            });
        }

        if (isset($data['passed'])) {
            $query->where('passed', $data['passed']);
        }
        if ($export){
            return $query->with('user')->get();
        }
        return $query->paginate(5);
    }
    public function exportResult($result): JsonResponse
    {
        $exportFilePath = 'exports/results.xlsx';

        $status = Excel::store(new ResultExport($result),$exportFilePath);
        if($status){
            $storagePath = asset($exportFilePath);
            return response()->json(['export_url' => $storagePath]);
        }

        return response()->json(['message' => "Could not generate. Please try again later"],503);

    }

    public function calculateAndCreateResult(Quiz $quiz, array $data): Result
    {

        $total_answered = count($data['answers']);
        $total_right_answered = 0;
        $total_weightage = 0;

        foreach ($data['answers'] as $qaData) {
            $question = Question::find($qaData['question_id']);
            if ($question && $question->answer === $qaData['answer']) {
                $total_weightage += $question->weightage;
                $total_right_answered++;
            }
        }
        $total_weightage_percentage = ($total_weightage / 100) * 100;

        $resultData = [
            "quiz_id" => $quiz->id,
            "user_id" => auth()->id(),
            "passed" => $total_weightage_percentage >= $quiz->pass_percentage,
            "total_answered" => $total_answered,
            "total_right_answer" => $total_right_answered,
            "total_time" => $data['total_time'],
            "total_question" => $data['total_question']
        ];

        return Result::create($resultData);
    }
}
