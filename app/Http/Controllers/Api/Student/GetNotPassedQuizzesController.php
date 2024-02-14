<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuizResource;
use App\Http\Repositories\QuizRepository;
use App\Http\Requests\GetQuizzesFilterRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetNotPassedQuizzesController extends Controller
{
    /**
     * @var QuizRepository
     */
    protected QuizRepository $quizRepository;

    public function __construct(QuizRepository $quizRepository)
    {
        $this->quizRepository = $quizRepository;
    }

    /**
     * @param GetQuizzesFilterRequest $request
     * @return AnonymousResourceCollection
     */
    public function __invoke(GetQuizzesFilterRequest $request): AnonymousResourceCollection
    {
        $passedQuizzes = $this->quizRepository->getNotPassedQuizzes();

        return QuizResource::collection($passedQuizzes);
    }
}
