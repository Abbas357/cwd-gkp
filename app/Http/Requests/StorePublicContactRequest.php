<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePublicContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'email' => 'required|email|max:255',
            'contact_number' => [
                'required',
                'string',
                'max:15',
                'regex:/^(\+92|0)[0-9]{10}$/',
            ],
            'cnic' => [
                'required',
                'string',
                'max:15',
                'regex:/^[0-9]{5}-[0-9]{7}-[0-9]{1}$/',
            ],
            'message' => [
                'required',
                'string',
                'max:1000',
                'regex:/^[A-Za-z0-9\s\.,!?\'"()-]+$/',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'The name field should contain only letters and spaces.',
            'contact_number.regex' => 'The contact number must be a valid Pakistani phone number (e.g., +923001234567 or 03001234567).',
            'cnic.regex' => 'The CNIC must be in a valid Pakistani format (e.g., 12345-1234567-1).',
            'message.regex' => 'The message field should contain only text, numbers, spaces, and basic punctuation.',
        ];
    }
}
