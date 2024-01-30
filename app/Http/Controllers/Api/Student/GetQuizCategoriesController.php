<?php

namespace App\Http\Controllers\Api\Student;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuizCategoryResource;
use App\Models\QuizCategory;

class GetQuizCategoriesController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function __invoke(): AnonymousResourceCollection
    {
        $quizCategories = QuizCategory::paginate(10);
        return QuizCategoryResource::collection($quizCategories);

    }
}
