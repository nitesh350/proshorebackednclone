<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionCategory;
use App\Http\Resources\QuestionCategoryResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetQuestionCategoriesController extends Controller
{
    /**
     * @return QuestionCategoryResource
     */
    public function __invoke(): AnonymousResourceCollection
    {
        $questionCategories = QuestionCategory::select(['id', 'title'])->get();
        return QuestionCategoryResource::collection($questionCategories);
    }
}
