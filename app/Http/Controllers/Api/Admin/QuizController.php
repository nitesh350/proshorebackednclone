<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuizResource;
use App\Http\Requests\QuizStoreRequest;
use App\Http\Requests\QuizUpdateRequest;
use App\Http\Repositories\QuizRepository;
use App\Http\Requests\CheckQueryParamRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class QuizController extends Controller
{
    private QuizRepository $quizRepository;

    /**
     * @param  QuizRepository  $quizRepository
     */
    public function __construct(QuizRepository $quizRepository)
    {
        $this->quizRepository = $quizRepository;
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index(CheckQueryParamRequest $request): AnonymousResourceCollection
    {
        $data = $request->validated();
        $quizzes = $this->quizRepository->getALLQuizzes($data);
        return QuizResource::collection($quizzes);
    }


    /**
     * @param  QuizStoreRequest  $request
     * @return QuizResource
     */
    public function store(QuizStoreRequest $request): QuizResource
    {
        $data = $request->validated();
        $quiz = $this->quizRepository->store($data);
        return (new QuizResource($quiz))->additional(ResponseHelper::stored());
    }


    /**
     * @param  Quiz  $quiz
     * @return QuizResource
     */
    public function show(Quiz $quiz): QuizResource
    {
        return new QuizResource($quiz);
    }


    /**
     * @param  Quiz  $quiz
     * @param  QuizUpdateRequest  $request
     * @return QuizResource
     */
    public function update(Quiz $quiz, QuizUpdateRequest $request): QuizResource
    {
        $data = $request->validated();
        $quiz = $this->quizRepository->update($quiz, $data);
        return (new QuizResource($quiz))->additional(ResponseHelper::updated($quiz));
    }

    /**
     * @param  Quiz  $quiz
     * @return Response
     */
    public function destroy(Quiz $quiz): Response
    {
        $this->quizRepository->destroy($quiz);
        return response()->noContent();
    }
}
