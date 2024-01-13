<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Http\Requests\QuizStoreRequest;
use App\Http\Requests\QuizUpdateRequest;
use App\Http\Resources\QuizResource;
use App\Http\Repositories\QuizRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

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
    public function index(): AnonymousResourceCollection
    {
        return QuizResource::collection(Quiz::paginate(8));
    }

    /**
     * @param  QuizStoreRequest  $request
     * @return QuizResource
     */
    public function store(QuizStoreRequest $request): QuizResource
    {
        $data = $request->validated();
        $quiz = $this->quizRepository->store($data);
        return new QuizResource($quiz);
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
        $quiz = $this->quizRepository->update($quiz,$data);
        return new QuizResource($quiz);
    }

    /**
     * @param  Quiz  $quiz
     * @return Response
     */
    public function destroy(Quiz $quiz): Response
    {
        $quiz->delete();
        return response()->noContent();
    }
}
