<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceCardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'mark_of_identification' => 'nullable|string|max:255',
            'cnic' => 'required|string|max:15|unique:service_cards,cnic',
            'email' => 'required|email|max:255|unique:service_cards,email',
            'landline_number' => 'nullable|string|max:15',
            'mobile_number' => 'required|string|max:15|unique:service_cards,mobile_number',
            'personnel_number' => 'required|string|max:15|unique:service_cards,personnel_number',
            'blood_group' => 'nullable|string|max:5',
            'emergency_contact' => 'nullable|string|max:15',
            'parmanent_address' => 'required|string|max:255',
            'present_address' => 'required|string|max:255',
            'designation' => 'required|string|max:100',
            'bps' => 'required|string|max:100',
            'office' => 'required|string|max:100',
        ];
    }
}
