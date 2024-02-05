<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Response;
use App\Helpers\ResponseHelper;
use App\Models\QuestionCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionCategoryResource;
use App\Http\Requests\StoreQuestionCategoryRequest;
use App\Http\Requests\UpdateQuestionCategoryRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\QuizCategoryResource;
use App\Http\Repositories\QuestionCategoryRepository;
use App\Models\Question;

class QuestionCategoryController extends Controller
{
    private QuestionCategoryRepository $questionCategoryRepository;
    /**
     * @param  QuestionCategoryRepository  $questionCategoryRepository
     */
    public function __construct(QuestionCategoryRepository $questionCategoryRepository)
    {
        $this->questionCategoryRepository = $questionCategoryRepository;
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollectionQuestionCategory
    {
        $questionCategories = QuestionCategory::paginate(10);

        return QuestionCategoryResource::collection($questionCategories);
    }

    /**
     * @param StoreQuestionCategoryRequest $request
     * @return QuestionCategoryResource
     */
    public function store(StoreQuestionCategoryRequest $request): QuestionCategoryResource
    {
        $data = $request->validated();

        $questionCategory = QuestionCategory::create($data);

        return new QuestionCategoryResource($questionCategory);
    }

    /**
     * @param QuestionCategory $questionCategory
     * @return QuestionCategoryResource
     */
    public function show(QuestionCategory $questionCategory): QuestionCategoryResource
    {
        return new QuestionCategoryResource($questionCategory);
    }

    /**
     * @param UpdateQuestionCategoryRequest $request
     * @param QuestionCategory $questionCategory
     * @return QuestionCategoryResource
     */
    public function update(UpdateQuestionCategoryRequest $request,  $questionCategory): QuestionCategoryResource
    {
        $data = $request->validated();

        $questionCategory->update($data);

        return (new QuestionCategoryResource($questionCategory))->additional(ResponseHelper::updated($questionCategory));
    }

    /**
     * @param  QuestionCategory $questionCategory
     * @return JsonResponse
     */
    public function destroy(QuestionCategory $questionCategory)
    {
        return $this->questionCategoryRepository->destroy($questionCategory);
    }
}
