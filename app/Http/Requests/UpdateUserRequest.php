<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|min:5',
            'email' => 'required|email',
            'password'=> 'nullable|min:5',
            'mobile_number'=> 'nullable|min:11',
            'landline_number'=> 'nullable|min:9',
            'cnic'=> 'nullable|min:13',
            'designation'=> 'required',
            'office'=> 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'roles' => 'nullable|array',
            'permissions' => 'nullable|array',
        ];
    }
}
