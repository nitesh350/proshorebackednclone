<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuizCategoryResource;
use App\Models\QuizCategory;
use Illuminate\Http\Request;

class GetQuizCategories extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $quizCategories = QuizCategory::select(['id', 'title'])->get();
        return QuizCategoryResource::collection($quizCategories);
    }
}
