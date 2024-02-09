<?php

namespace App\Http\Requests;

use App\Rules\ValidSlug;
use Illuminate\Foundation\Http\FormRequest;

class QuizCategoryStoreRequest extends FormRequest
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
                "unique:quiz_categories,slug,NULL,id,deleted_at,NULL",
                new ValidSlug,
            ],
        ];
    }
}
