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

        $extension = $thumbnail->extension();
        $name = date('ymd') . time() . '.' . $extension;

        $data['thumbnail'] = $name;

        $thumbnail->storeAs('public/images/quizzes', $name);
        $quiz = Quiz::create($data);

        return $quiz;
    }

    /**
     * @param  \App\Models\Quiz  $quiz
     * @param  array  $data
     * @return \App\Models\Quiz
     */
    public function update($quiz, $data)
    {
        Storage::delete('public/images/quizzes/' . $quiz->thumbnail);

        $thumbnail = $data['thumbnail'];

        $extension = $thumbnail->extension();
        $name = date('ymd') . time() . '.' . $extension;

        $data['thumbnail'] = $name;

        $thumbnail->storeAs('public/images/quizzes', $name);

        $quiz = $quiz->update($data);

        return $quiz;
    }
}
