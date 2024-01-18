<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Repositories\QuizRepository;
use App\Models\Quiz;
use Illuminate\Http\JsonResponse;

class GetQuizController extends Controller
{
    protected $quizRepository;

    public function __construct(QuizRepository $quizRepository)
    {
        $this->quizRepository = $quizRepository;
    }

     /**
     * @param Quiz $quiz
     * @return JsonResponse
     */
    public function __invoke(Quiz $quiz): JsonResponse
    {
        $questions = $this->quizRepository->getRandomQuestionsForQuiz($quiz);

        $response = [
            'quiz_description' => $quiz->description,
            'questions' => $questions,
        ];

        return response()->json($response);
    }
}
