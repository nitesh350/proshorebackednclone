<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuizCategoryFilterRequest;
use App\Http\Resources\QuizCategoryResource;
use App\Http\Repositories\QuizCategoryRepository;
use App\Models\QuizCategory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetQuizCategories extends Controller
{
    private QuizCategoryRepository $quizCategoryRepository;

    /**
     * @param  QuizCategoryRepository  $quizCategoryRepository
     */
    public function __construct(QuizCategoryRepository $quizCategoryRepository)
    {
        $this->quizCategoryRepository = $quizCategoryRepository;
    }

    /**
     * @param QuizCategoryFilterRequest $request
     * @return AnonymousResourceCollection
     */
    public function __invoke(): AnonymousResourceCollection
    {
        $quizCategories = QuizCategory::select(['id', 'title'])->get();
        return QuizCategoryResource::collection($quizCategories);

    }
}
