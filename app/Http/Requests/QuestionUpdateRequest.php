<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;


class QuestionUpdateRequest extends FormRequest
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
        $questionId = $this->route("question");
        return [
            'title' => "string|required|max:255",
            'category_id' => "required|exists:questions,id",
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('questions', 'slug')->ignore($questionId),
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'
            ],
            'description' => "string|nullable|max:5000",
            'options' => "array|required",
            'answer' => "string|required|in_array:options.*",
            "weightage" => "required|integer|in:5,10,15",
            "status" => "boolean|nullable"
        ];
    }
}
