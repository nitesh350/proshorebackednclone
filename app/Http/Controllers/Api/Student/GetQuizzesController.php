<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Requests\GetQuizzesFilterRequest;
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
    public function __invoke(GetQuizzesFilterRequest $request): AnonymousResourceCollection
    {
        $data = $request->validated();

        $query = Quiz::with('category:id,title')
            ->with('result');

        if (!empty($data['title'])) {
            $query = $query->where('title', 'like', '%' . $data['title'] . '%');
        }

        if (!empty($data['category_id'])) {
            $query->where('category_id', $data['category_id']);
        }

        return QuizResource::collection($query->paginate(10));
    }
}
