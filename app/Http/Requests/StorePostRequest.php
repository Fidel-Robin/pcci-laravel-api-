<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'title' => 'required|string|min:4',
            'body' => ['required', 'string', 'min:2'],
            // 'tags' => 'array',
            // 'tags.*' => 'string|min:2'
        ];
    }

    public function messages()
    {
        return[
            'title.required' => 'title is required',
            'title.string' => 'title must be valid string',
            'title.min' => 'title must be at least :min characters long'
        ];
    }
}
