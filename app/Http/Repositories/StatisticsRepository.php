<?php

namespace App\Http\Repositories;
use App\Models\User;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Result;

class StatisticsRepository
{
    /**
     * @return array
     */
    public function index()
    {
        $totalStudents = User::where('user_type', 'student')->count();
        $totalVerifiedStudents = User::where('email_verified_at', '!=', null)->count();
        $totalQuizzes = Quiz::count();
        $activeQuizzes = Quiz::where('status', true)->count();
        $totalQuestions = Question::count();
        $activeQuestions = Question::where('status', true)->count();
        $totalPassedStudents = Result::where('passed', true)->count();

        return [
            'total_students' => $totalStudents,
            'total_verified_students' => $totalVerifiedStudents,
            'total_quizzes' => $totalQuizzes,
            'active_quizzes' => $activeQuizzes,
            'total_questions' => $totalQuestions,
            'active_questions' => $activeQuestions,
            'total_passed_students' => $totalPassedStudents,
        ];
    }
}
