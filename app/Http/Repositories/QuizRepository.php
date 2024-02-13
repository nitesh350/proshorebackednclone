<?php

namespace App\Http\Repositories;

use App\Models\Quiz;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class QuizRepository
{

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getFilteredQuizzesForStudents(array $data): LengthAwarePaginator
    {
        $query = Quiz::with('category:id,title')
            ->with('result');

        if (!empty($data['title'])) {
            $query = $query->where('title', 'like', '%' . $data['title'] . '%');
        }

        if (!empty($data['category_id'])) {
            $query->where('category_id', $data['category_id']);
        }
        return $query->paginate(10);
    }

    /**
     * Undocumented function
     *
     * @param array $data
     * @return LengthAwarePaginator $query
     */
    public function getFilteredQuizzes(array $data): LengthAwarePaginator
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
     * @param Quiz $quiz
     * @return Quiz
     */
    public function show(Quiz $quiz): Quiz
    {
        return $quiz->load(['category:id,title','questionCategories:id,title']);
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
     * @return JsonResponse|Response
     */
    public function destroy(Quiz $quiz): Response|JsonResponse
    {
        if ($quiz->results()->exists()) {
            return response()->json(['error' => 'Could not delete the Quiz.']);
        }

        $quiz->questionCategories()->detach();
        $quiz->delete();
        return response()->noContent();
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getPassedQuizzes(): LengthAwarePaginator
    {
        return Quiz::whereHas('result', function ($query) {
            $query->where('passed', true);
        })
        ->with('category:id,title')
        ->paginate(10);
    }
}
