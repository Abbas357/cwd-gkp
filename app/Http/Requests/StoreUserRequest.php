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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:191|unique:users',
            'username' => 'nullable|string|max:191|unique:users',
            'password' => 'nullable|string|min:6',
            
            'profile.landline_number' => 'nullable|string|max:255',
            
            'posting.office_id' => 'required|exists:offices,id',
            'posting.designation_id' => 'required|exists:designations,id',
            'posting.start_date' => 'nullable|date',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'name',
            'email' => 'email address',
            'password' => 'password',
            'profile.landline_number' => 'landline number',
            'posting.office_id' => 'office',
            'posting.designation_id' => 'designation',
            'posting.start_date' => 'start date',
        ];
    }
    
    public function messages(): array
    {
        return [
            'posting.office_id.required' => 'Please select an office for the posting.',
            'posting.designation_id.required' => 'Please select a designation for the posting.',
            'posting.type.required' => 'Please select a posting type.',
        ];
    }

}
