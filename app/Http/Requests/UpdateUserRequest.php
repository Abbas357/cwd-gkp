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
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($userId),
            ],
            'password' => 'nullable|min:5',
            'status' => 'nullable|in:Active,Inactive,Archived',

            // Profile information
            'profile.cnic' => 'nullable|min:13',
            'profile.mobile_number' => 'nullable|min:11',
            'profile.landline_number' => 'nullable|min:9',
            'profile.whatsapp' => 'nullable',
            'profile.facebook' => 'nullable',
            'profile.twitter' => 'nullable',
            'profile.message' => 'nullable',
            'profile.featured_on' => 'nullable|array',
            'profile.featured_on.*' => 'string|in:Home,Team,Contact',

            // Posting information
            'posting.designation_id' => 'nullable|exists:designations,id',
            'posting.office_id' => 'nullable|exists:offices,id',
            'posting.type' => 'nullable|in:Appointment,Deputation,Transfer,Mutual,Additional-Charge,Promotion,Suspension,OSD,Retirement,Termination',
            'posting.start_date' => 'nullable|date',
            'posting.end_date' => 'nullable|date|after:posting.start_date',
            'posting.order_number' => 'nullable',
            'posting.remarks' => 'nullable',

            // Media uploads
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            
            // Roles and Permissions
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'name.min' => 'Name must be at least 5 characters',
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'This email is already taken',
            'username.min' => 'Username must be at least 5 characters',
            'username.unique' => 'This username is already taken',
            'profile.mobile_number.min' => 'Mobile number must be at least 11 digits',
            'profile.landline_number.min' => 'Landline number must be at least 9 digits',
            'profile.cnic.min' => 'CNIC must be at least 13 characters',
            'posting.designation_id.exists' => 'Selected designation is invalid',
            'posting.office_id.exists' => 'Selected office is invalid',
            'posting.start_date.date' => 'Please enter a valid start date',
            'posting.end_date.after' => 'End date must be after start date',
        ];
    }
}
