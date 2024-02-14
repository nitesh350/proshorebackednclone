<?php

namespace App\Imports;


use App\Models\Question;
use App\Rules\ValidSlug;
use App\Models\QuestionCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class QuestionImport implements ToModel, WithHeadingRow , WithValidation
{
    /**
     * @param  array  $row 
     * @return \App\Models\Question|null 
     */
    public function model(array $row)
    {
        $questionCategory = QuestionCategory::where('slug', $row['category_slug'])->first();

        return new Question([
            'category_id' => $questionCategory->id,
            'title' => $row['title'],
            'slug' => $row['slug'],
            'description' => $row['description'],
            'options' => json_encode([$row['options'], $row['options2'], $row['options3']]),
            'answer' => $row['answer'],
            'weightage' => (string)$row['weightage'],
            'status' => $row['status']
        ]);
    }
    public function rules(): array
    {
        return [
            'category_slug' => 'required|exists:question_categories,slug',
            'title' => "string|required|max:255",
            'slug' => [
                'required',
                'string',
                'max:255',
                "unique:questions,slug,NULL,id,deleted_at,NULL",
                new ValidSlug,
            ],
            'description' => "string|nullable|max:5000",
            'options' => 'required|string',
            'options2' => 'required|string',
            'options3' => 'required|string',
            'answer' => 'required|string',
            'weightage' => 'required|in:5,10,15',
            'status' => 'required|boolean',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'category_slug.exists' => 'The category slug does not exist in the question_categories table.',
        ];
    }



    public function headingRow(): int
    {
        return 1;
    }
}
