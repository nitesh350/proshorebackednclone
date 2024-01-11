<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuizUpdateRequest extends FormRequest
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
            'slug' => "required|string|max:255|unique:quizzes,slug,{$this->quiz->id}",
            'category_id' => 'nullable|exists:quiz_categories,id,deleted_at,NULL',
            'thumbnail' => 'image|mimes:jpg,png,jpeg|max:2048',
            'description' => 'required|string|max:1000',
            'time' => 'required|integer',
            'retry_after' => 'required|integer',
            'status' => 'boolean'
        ];
    }
}
