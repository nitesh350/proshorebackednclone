<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ResponseHelper;
use App\Models\Question;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Repositories\QuestionRepository;
use App\Http\Requests\QuestionFilterRequest;
use App\Http\Resources\QuestionResource;
use App\Http\Requests\QuestionStoreRequest;
use App\Http\Requests\QuestionUpdateRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class QuestionController extends Controller
{
    private QuestionRepository $questionRepository;

    /**
     * @param  QuestionRepository $questionRepository
     */
    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }


    /**
     * @return AnonymousResourceCollection
     */
    public function index(QuestionFilterRequest $request): AnonymousResourceCollection
    {
        $params = $request->validated();
        $questions = $this->questionRepository->getFilteredQuestions($params);
        return QuestionResource::collection($questions);
    }


    /**
     * @param QuestionStoreRequest $request
     * @return QuestionResource
     */
    public function store(QuestionStoreRequest $request): QuestionResource
    {
        $data = $request->validated();
        $question = Question::create($data)->fresh();
        return (new QuestionResource($question))->additional(ResponseHelper::stored());
    }


    /**
     * @param Question $question
     * @return QuestionResource
     */
    public function show(Question $question): QuestionResource
    {
        return new QuestionResource($question);
    }


    /**
     * @param QuestionUpdateRequest $request
     * @param Question $question
     * @return QuestionResource
     */
    public function update(QuestionUpdateRequest $request, Question $question): QuestionResource
    {
        $data = $request->validated();
        $question->update($data);
        return (new QuestionResource($question))->additional(ResponseHelper::updated($question));
    }


    /**
     * @param Question $question
     * @return Response
     */
    public function destroy(Question $question): Response
    {
        $question->delete();
        return response()->noContent();
    }
}
