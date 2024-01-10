<?php

namespace App\Http\Repositories;

use App\Models\Quiz;
use Illuminate\Support\Facades\Storage;

class QuizRepository
{

    /**
     * @param  array  $data
     * @return \App\Models\Quiz
     */
    public function store($data)
    {
        $thumbnail = $data['thumbnail'];

        $name = date('ymd') . time() . '.' . $thumbnail->extension();

        $thumbnail->storeAs('public/images/quizzes', $name);

        return Quiz::create(array_merge($data, ['thumbnail' => $name]));
    }

    /**
     * @param  \App\Models\Quiz  $quiz
     * @param  array  $data
     * @return \App\Models\Quiz
     */
    public function update(Quiz $quiz, array $data): Quiz
    {
        if (isset($data['thumbnail'])) {
            Storage::delete('public/images/quizzes/' . $quiz->thumbnail);

            $thumbnail = $data['thumbnail'];

            $name = date('ymd') . time() . '.' . $thumbnail->extension();

            $thumbnail->storeAs('public/images/quizzes', $name);

            $data['thumbnail'] = $name;
        }

        $quiz->update($data);

        return $quiz;
    }
}
