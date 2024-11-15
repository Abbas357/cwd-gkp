<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user');
        return [
            'name' => 'required|min:5',
            'username' => [
                'nullable',
                'min:5',
                Rule::unique('users')->ignore($userId),
            ],
            'email' => 'required|email|unique:users',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($userId),
            ],
            'title'=> 'nullable',
            'bps'=> 'nullable',
            'password'=> 'nullable|min:5',
            'mobile_number'=> 'nullable|min:11',
            'landline_number'=> 'nullable|min:9',
            'cnic'=> 'nullable|min:13',
            'designation'=> 'nullable',
            'position'=> 'nullable',
            'office'=> 'nullable',
            'posting_type'=> 'nullable',
            'posting_date'=> 'nullable',
            'exit_type'=> 'nullable',
            'exit_date'=> 'nullable',
            'message'=> 'nullable',
            'whatsapp'=> 'nullable',
            'facebook'=> 'nullable',
            'twitter'=> 'nullable',
        ];
    }
}
