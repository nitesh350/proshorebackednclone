<?php

namespace App\Http\Requests\Auth;

use Illuminate\Validation\Rule;
use App\Models\QuestionCategory;
use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionCategoryRequest extends FormRequest
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
    $questionCategoryId = $this->route('question_category');

    return [
        'title' => 'required|string|max:255',
        'slug' => [
            'required',
            'string',
            'max:255',
            Rule::unique('question_categories', 'slug')->ignore($questionCategoryId),
        ],
    ];
}

}
