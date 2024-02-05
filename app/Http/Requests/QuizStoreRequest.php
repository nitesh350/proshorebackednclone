<?php

namespace App\Http\Requests;

use App\Rules\ValidSlug;
use Illuminate\Foundation\Http\FormRequest;

class QuizStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return void
     */
    protected function prepareForValidation():void
    {
        $this->merge([
            'question_categories' => $this->transformQuestionCategories($this->input('question_categories')),
        ]);
    }

    /**
     * @param mixed $question_categories
     * @return array
     */
    private function transformQuestionCategories($question_categories): array
    {
        return is_array($question_categories) ? $question_categories : explode(',', $question_categories);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                'unique:quizzes,slug',
                new ValidSlug,
            ],
            'category_id' => 'required|exists:quiz_categories,id,deleted_at,NULL',
            'thumbnail' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'description' => 'required|string|max:5000',
            'time' => 'required|integer',
            'pass_percentage'=>'required|integer|min:1|max:100',
            'retry_after' => 'required|integer',
            'status' => 'boolean',
            'question_categories' => 'required|array',
            'question_categories.*' => 'required|exists:question_categories,id'
        ];
    }
}
