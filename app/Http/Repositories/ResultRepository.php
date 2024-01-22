<?php

namespace App\Http\Repositories;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\Result;

class ResultRepository
{
    /**
     * @param  int  $userId
     * @param  Quiz  $quiz
     * @param  array  $submittedAnswers
     * @param  int  $totalTime
     * @return Result
     */
    public function store($userId, $quiz, $submittedAnswers, $totalTime):Result
    {
        $totalAnswered = count($submittedAnswers);
        $totalRightAnswer = 0;

        foreach ($submittedAnswers as $questionId => $submittedAnswer) {

            if ($this->isCorrectAnswer($questionId, $submittedAnswer)) {
                $totalRightAnswer++;
            }
        }

        return Result::create([
            'user_id' => $userId,
            'quiz_id' => $quiz->id,
            'passed' => $totalRightAnswer >= (count($submittedAnswers) / 2),
            'total_question' => count($submittedAnswers),
            'total_answered' => $totalAnswered,
            'total_right_answer' => $totalRightAnswer,
            'total_time' => $totalTime,
        ]);
    }
    private function isCorrectAnswer($questionId, $submittedAnswer)
    {
        $question = Question::find($questionId);

        if ($question) {
            $correctAnswer = $question->answer;

            return $submittedAnswer === $correctAnswer;
        }

        return false;
    }
}
