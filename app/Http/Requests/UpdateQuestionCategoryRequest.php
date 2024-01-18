<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;
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
     * @return array<string, ValidationRule|array|string>
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
