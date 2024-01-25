<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResultFilterRequest extends FormRequest
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
            'user_id'=>'numeric|exists:users,id',
            'quiz_id'=>'numeric|exists:quizzes,id',
            'passed_status'=>'boolean',
            'date'=>'string',
        ];
    }
}
