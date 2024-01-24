<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Repositories\QuizRepository;
use App\Http\Requests\GetQuizzesFilterRequest;
use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuizResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class GetQuizzesController extends Controller
{
    protected $quizRepository;

    public function __construct(QuizRepository $quizRepository)
    {
        $this->quizRepository = $quizRepository;
    }
    
    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function __invoke(GetQuizzesFilterRequest $request): AnonymousResourceCollection
    {
        $data = $request->validated();

        $quizzes=$this->quizRepository->getFilteredQuizzes($data);

        return QuizResource::collection($quizzes);
    }
}
