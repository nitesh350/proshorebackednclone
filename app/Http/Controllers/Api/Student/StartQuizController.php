<?php

namespace App\Http\Controllers\Api\Student;

use App\Models\Quiz;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuizResource;
use App\Http\Repositories\QuestionRepository;

class StartQuizController extends Controller
{
    protected QuestionRepository $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

     /**
     * @param Quiz $quiz
     * @return QuizResource
      */
    public function __invoke(Quiz $quiz): QuizResource
    {
        $quiz->load('category');
        $question_categories = $quiz->questionCategories()->select("question_category_id")->pluck("question_category_id");
        $questionResource = $this->questionRepository->getQuizQuestions($question_categories);
        return (new QuizResource($quiz))->additional([
            'data' => [
                "questions" => $questionResource,
            ]
        ]);
    }
}
