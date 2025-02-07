<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'email' => 'nullable|email|max:255',
            'body' => [
                'required',
                'string',
                'max:1000',
                'regex:/^[A-Za-z0-9\s\p{P}]+$/u',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'The name field should contain only letters and spaces.',
            'body.regex' => 'The body field should contain only text, numbers, and basic punctuation.',
        ];
    }
}
