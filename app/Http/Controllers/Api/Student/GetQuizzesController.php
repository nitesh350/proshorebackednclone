<?php

namespace App\Http\Controllers\Api\Student;

use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GetQuizzesResource;


class GetQuizzesController extends Controller
{
     /**
     * @param Request $request
     * @return GetQuizzesResource
     */
    public function __invoke(Request $request)
    {
        $data = Quiz::with(['results' => function ($query) {
            $query->where('user_id', auth()->id());
        }])->get();
        return GetQuizzesResource::collection($data);
    }
}
