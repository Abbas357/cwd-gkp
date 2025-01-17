<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|min:5',
            'username' => 'nullable|unique:users|min:5',
            'email' => 'required|email|unique:users',
            'password'=> 'required|min:5',
            'mobile_number'=> 'nullable|min:11',
            'landline_number'=> 'nullable|min:9',
            'cnic'=> 'nullable|min:13',
            'designation'=> 'required',
            'office'=> 'required',
        ];
    }
}
