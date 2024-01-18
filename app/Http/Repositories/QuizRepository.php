<?php

namespace App\Http\Repositories;

use App\Http\Resources\QuestionResource;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

class QuizRepository
{

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
        return $quiz;
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

    /**
     * @param $quiz
     * @return AnonymousResourceCollection
     */
    public function getRandomQuestionsForQuiz($quiz): AnonymousResourceCollection
    {
        $categoryId = $quiz->category_id;

        $questionsWeightage5 = $this->getRandomQuestionsByWeightage($categoryId, '5', 10);
        $questionsWeightage10 = $this->getRandomQuestionsByWeightage($categoryId, '10', 2);
        $questionsWeightage15 = $this->getRandomQuestionsByWeightage($categoryId, '15', 2);

        $randomQuestions = $questionsWeightage5
            ->concat($questionsWeightage10)
            ->concat($questionsWeightage15);

        $questions = Question::whereIn('id', $randomQuestions)
            ->select('id', 'title', 'slug', 'description', 'options', 'weightage', 'status')
            ->orderBy('weightage')
            ->get();

        return QuestionResource::collection($questions);
    }

    /**
     * @param $categoryId
     * @param $weightage
     * @param $limit
     * @return Question
     */
    private function getRandomQuestionsByWeightage($categoryId, $weightage, $limit)
    {
        return Question::select('id', 'category_id', 'title', 'slug', 'description', 'options', 'weightage', 'status')
            ->where('category_id', $categoryId)
            ->where('weightage', $weightage)
            ->where('status', 1)
            ->inRandomOrder()
            ->limit($limit)
            ->pluck('id');
    }

}
