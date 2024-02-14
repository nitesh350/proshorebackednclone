<?php

namespace App\Imports;

use App\Models\Question;
use Illuminate\Support\Str;
use App\Models\QuestionCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class QuestionImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, SkipsOnFailure
{
    /**
     * @var array
     */
    protected array $failures = [];

    /**
     * @param  array  $row
     * @return Question|null
     */
     public function model(array $row): ?Question
    {
        $questionCategory = QuestionCategory::where('title', $row['category'])->first();
        if ($questionCategory) {
            $slug = Str::slug($row['title']);
            $existingQuestion = Question::where("slug", $slug)->first();
            if ($existingQuestion) return  $existingQuestion;
            return new Question([
                'category_id' => $questionCategory->id,
                'title' => $row['title'],
                'slug' => Str::slug($row['title']),
                'description' => $row['description'],
                'options' => [
                    $row['option1'],
                    $row['option2'],
                    $row['option3'],
                    $row['option4'],
                ],
                'answer' => $row['answer'],
                'weightage' => (string) $row['weightage']
            ]);
        }
        return null;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'category' => 'required|exists:question_categories,title',
            'title' => "string|required|max:255",
            'description' => "string|nullable|max:5000",
            'option1' => 'required|string',
            'option2' => 'required|string',
            'option3' => 'required|string',
            'option4' => 'required|string',
            'answer' => 'required|string',
            'weightage' => 'required|in:5,10,15',
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages(): array
    {
        return [
            'category_slug.exists' => 'The category slug does not exist in the question_categories table.',
        ];
    }

    /**
     * @param Failure ...$failures
     * @return void
     */
    public function onFailure(Failure ...$failures): void
    {
        foreach ($failures as $failure) {
            $this->failures[] = [
                'row' => $failure->row(),
                'errors' => $failure->errors(),
            ];
        }
    }

    /**
     * @return array
     */
    public function getFailures(): array
    {
        return $this->failures;
    }
}
