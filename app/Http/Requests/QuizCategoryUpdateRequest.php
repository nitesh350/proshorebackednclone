<?php

namespace App\Http\Requests;

use App\Rules\ValidSlug;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class QuizCategoryUpdateRequest extends FormRequest
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
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('quiz_categories', 'slug')->ignore($this->quiz_category->id),
                new ValidSlug,
            ],
        ];
    }
}
