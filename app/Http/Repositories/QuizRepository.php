<?php

namespace App\Http\Repositories;

use App\Models\Quiz;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Exports\QuizzesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Collection;
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
     *
     * @param array $data, $export
     * @return LengthAwarePaginator|Collection
     */
    public function getFilteredQuizzes(array $data, $export): LengthAwarePaginator|Collection
    {
        $query = Quiz::with('category:id,title');

        if (isset($data['title'])) {
            $query->where('title', 'like', '%' . $data['title'] . '%')->get();
        }

        if (isset($data['status'])) {
            $query->where('status', $data['status'])->get();
        }

        if (isset($data['description'])) {
            $query->where('description', 'like', '%' . $data['description'] . '%')->get();
        }

        if (isset($data['category_id'])) {
            $query->where('category_id', $data['category_id'])->get();
        }

        if($export){
            return $query->get();
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
     * @param Collection $quizzes
     * @return JsonResponse
    */
    public function exportQuizzes($quizzes): JsonResponse
    {
        $exportFilePath = 'exports/quizzes.xlsx';

        $status = Excel::store(new QuizzesExport($quizzes), $exportFilePath);

        if ($status) {
            $storagePath = asset($exportFilePath);
            return response()->json(['export_url' => $storagePath]);
        }

        return response()->json(['message' => "Could not generate export file. Please try again later"], 503);
    }
}
