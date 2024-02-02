<?php

namespace App\Http\Repositories;

use App\Models\QuizCategory;
use Illuminate\Database\Eloquent\Collection;

class QuizCategoryRepository
{
    /**
     * @param $data
     * @return Collection
     */
    public function getFilteredQuizCategories($data): Collection
    {
        $query =QuizCategory::select(['id', 'title']);

        if (isset($data['title'])) {
            $query->where('title', 'like', '%' . $data['title'] . '%');
        }

        return $query->get();
    }

    /**
     * @param $quizCategory
     * @return mixed
     */
    public function destroy($quizCategory): mixed
    {
        if ($quizCategory->quizzes()->exists()) {

            return response()->json(['error' => 'Could not delete the category.']);
        }

        $quizCategory->delete();
        return response()->noContent();
    }
}
