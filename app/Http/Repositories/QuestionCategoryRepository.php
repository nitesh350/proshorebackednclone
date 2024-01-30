<?php

namespace App\Http\Repositories;
use App\Models\QuestionCategory;
use Illuminate\Database\Eloquent\Collection;

/**
 * @param $data
 * @return Collection
 */
class QuestionCategoryRepository
{
    public function getFilteredQuestionCategories($data): Collection
    {
        $query = QuestionCategory::select(['id', 'title']);

        if (isset($data['title'])) {
            $query->where('title', 'like', '%' . $data['title'] . '%');
        }

        return $query->get();
    }
}