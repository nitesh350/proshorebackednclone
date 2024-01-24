<?php

namespace App\Http\Controllers\Api\Student;

use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuizResource;


class GetQuizzesController extends Controller
{
     /**
     * @param Request $request
     * @return QuizResource
     */
    public function __invoke(Request $request)
    {
        $quizzes = Quiz::with(['results' => function ($query) {
            $query->where('user_id', auth()->id());
        }])->get();
        return QuizResource::collection($quizzes);
    }
}
