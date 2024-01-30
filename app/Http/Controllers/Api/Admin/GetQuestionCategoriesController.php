<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionCategoryFilterRequest;
use App\Http\Resources\QuestionCategoryResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Repositories\QuestionCategoryRepository;

class GetQuestionCategoriesController extends Controller
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
     * @param QuestionCategoryFilterRequest $request
     * @return AnonymousResourceCollection
     */
    public function __invoke(QuestionCategoryFilterRequest $request): AnonymousResourceCollection
    {
        $data = $request->validated();
        $questionCategories = $this->questionCategoryRepository->getFilteredQuestionCategories($data);
        
        return QuestionCategoryResource::collection($questionCategories);
    }
}
