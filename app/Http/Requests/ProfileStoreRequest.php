<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileStoreRequest extends FormRequest
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
    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => auth()->id(),
        ]);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "user_id" => "required|integer|exists:users,id|unique:profiles,user_id",
            "skills" => "required|array",
            'education' => 'required|string|max:5000',
            'experience' => 'required|string|max:5000',
            'career' => 'required|string|max:5000',
            'avatar' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'user_id.unique' => 'User already has a profile',
        ];
    }
}
