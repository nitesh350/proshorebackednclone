<?php

namespace App\Http\Controllers\Api\Student;

use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuizResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class GetQuizzesController extends Controller
{
     /**
     * @param Request $request
     * @return AnonymousResourceCollection
      */
    public function __invoke(Request $request): AnonymousResourceCollection
    {
        $quizzes = Quiz::with('result')->paginate(10);
        return QuizResource::collection($quizzes);
    }
}
