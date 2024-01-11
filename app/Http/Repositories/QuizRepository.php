<?php

namespace App\Http\Repositories;

use App\Http\Requests\QuizStoreRequest;
use App\Http\Requests\QuizUpdateRequest;
use App\Models\Quiz;
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
        $data['thumbnail'] =  $data['thumbnail']->storeAs('images/quizzes', $name);
        return Quiz::create(array_merge($data));
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
            $data['thumbnail'] =  $data['thumbnail']->storeAs('images/quizzes', $name);
        }

        $quiz->update($data);

        return $quiz;
    }
}
