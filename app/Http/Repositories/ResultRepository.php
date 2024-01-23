<?php

namespace App\Http\Repositories;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\Result;

class ResultRepository
{
    public function calculateAndCreateResult(Quiz $quiz, $userId, array $answers, array $data): Result
    {
        $total_answered = count($answers);
        $total_right_answered = 0;
        $total_weightage = 0;

        foreach ($answers as $answer) {
            $question = Question::find($answer['question_id']);
            if ($question->answer === $answer['answer']) {
                $total_weightage += $question->weightage;
                $total_right_answered++;
            }
        }
        $total_weightage_percentage = ($total_weightage/100)*100;

        $resultData = [
            "quiz_id" => $quiz->id,
            "user_id" => $userId,
            "passed" => $total_weightage_percentage >= $quiz->pass_percentage,
            "total_answered" => $total_answered,
            "total_right_answer" => $total_right_answered,
            "total_time" => $data['total_time'],
            "total_question" => $data['total_question']
        ];

        return Result::create($resultData);
    }
}
