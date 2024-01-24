<?php

namespace App\Http\Repositories;

use App\Models\Quiz;
use App\Http\Resources\QuizResource;
use Illuminate\Support\Facades\Storage;

class QuizRepository
{
    /**
     * Undocumented function
     *
     * @param array $data
     * @return $query
     */
    public function getALLQuizzes($data)
    {
        $query = Quiz::with('category:id,title');

        if (isset($data['title'])) {
            $query->where('title', 'like', '%' . $data['title'] . '%');
        }

        if (isset($data['status'])) {
            $query->where('status', $data['status']);
        }

        if (isset($data['description'])) {
            $query->where('description', 'like', '%' . $data['description'] . '%');
        }

        if (isset($data['category_id'])) {
            $query->where('category_id', $data['category_id']);
        }

        return $query->paginate(8);
    }

    /**
     * @param array $data
     * @return Quiz
     */
    public function store(array $data): Quiz
    {
        $name = date('ymd') . time() . '.' . $data['thumbnail']->extension();
        $data['thumbnail'] = $data['thumbnail']->storeAs('images/quizzes', $name);
        $quiz = Quiz::create($data);
        $quiz->questionCategories()->sync($data['question_categories']);
        return $quiz->fresh();
    }


    /**
     * @param Quiz $quiz
     * @param array $data
     * @return Quiz
     */
    public function update(Quiz $quiz, array $data): Quiz
    {
        if (isset($data['thumbnail'])) {
            Storage::delete('public/images/quizzes/' . $quiz->thumbnail);
            $name = date('ymd') . time() . '.' . $data['thumbnail']->extension();
            $data['thumbnail'] = $data['thumbnail']->storeAs('images/quizzes', $name);
        }
        $quiz->questionCategories()->sync($data['question_categories']);
        $quiz->update($data);

        return $quiz;
    }


    /**
     * @param Quiz $quiz
     * @return void
     */
    public function destroy(Quiz $quiz): void
    {
        $quiz->questionCategories()->detach();
        $quiz->delete();
    }
}
