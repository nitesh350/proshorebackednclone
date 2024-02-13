<?php

namespace App\Http\Controllers\Api\Student;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Controllers\Controller;
use App\Http\Repositories\QuizRepository;
use App\Http\Resources\QuizResource;
use App\Models\Quiz;

class GetPassedQuizzesController extends Controller
{
    protected QuizRepository $quizRepository;

    public function __construct(QuizRepository $quizRepository)
    {
        $this->quizRepository = $quizRepository;
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function __invoke(): AnonymousResourceCollection
    {
        $passedQuizzes = $this->quizRepository->getPassedQuizzes();
        
        return QuizResource::collection($passedQuizzes);
    }
}
