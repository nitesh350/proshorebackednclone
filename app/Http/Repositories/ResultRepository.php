<?php

namespace App\Http\Repositories;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\Result;

class ResultRepository
{
    public function calculateAndCreateResult(Quiz $quiz, array $data): Result
    {

        $total_answered = count($data['answers']);
        $total_right_answered = 0;
        $total_weightage = 0;

        foreach ($data['answers'] as $qaData) {
            $question = Question::find($qaData['question_id']);
            if ($question->answer === $qaData['answer']) {
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
