<?php

namespace App\Http\Repositories;

use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class QuestionRepository
{
    /**
     * @param $categories
     * @return array
     */
    public function getQuizQuestions($categories): array
    {
        $basicQuestions =   $this->getQuestionByWeightage($categories, "5", 10);
        $intermediateQuestions =  $this->getQuestionByWeightage($categories, "10", 2);
        $advanceQuestions =  $this->getQuestionByWeightage($categories, "15", 2);
        $questionIds = $basicQuestions->merge($intermediateQuestions)->merge($advanceQuestions);
        $questions = Question::select("id", "title", "options", "weightage", "description", "status")
            ->whereIn("id", $questionIds)
            ->orderBy("weightage")
            ->get();
        return [
            'data' => [
                'questions' => QuestionResource::collection($questions)
            ]
        ];
    }

    /**
     * @param $categories
     * @param $weightage
     * @param $limit
     * @return mixed
     */
    public function getQuestionByWeightage($categories, $weightage, $limit): mixed
    {
        return Question::select('id', 'category_id', 'title', 'description', 'options', 'weightage', 'status')
            ->whereIn('category_id', $categories)
            ->active()
            ->inRandomOrder()
            ->where("weightage", $weightage)->limit($limit)->pluck("id");
    }


    /**
     * @param $params
     * @return LengthAwarePaginator
     */
    public function getFilteredQuestions($params): LengthAwarePaginator
    {
        $query = Question::select(['id', 'title', 'slug', 'description', 'options', 'weightage', 'category_id', 'status'])->with('category:id,title');

        if (isset($params['title'])) {
            $query->where('title', 'like', '%' . $params['title'] . '%');
        }

        if (isset($params['category_id'])) {
            $query->where('category_id', $params['category_id']);
        }

        if (isset($params['status'])) {
            $query->where('status', $params['status']);
        }

        return $query->paginate(10);
    }
}
