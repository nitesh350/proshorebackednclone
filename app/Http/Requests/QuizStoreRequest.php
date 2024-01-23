<?php

namespace App\Http\Requests;

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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:quizzes|max:255',
            'category_id' => 'required|exists:quiz_categories,id,deleted_at,NULL',
            'thumbnail' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'description' => 'required|string|max:5000',
            'time' => 'required|integer',
            'pass_percentage'=>'required|integer|max:100',
            'retry_after' => 'required|integer',
            'status' => 'boolean',
            'question_categories' => 'required|array',
            'question_categories.*'=> 'required|exists:question_categories,id'
        ];
    }
}
