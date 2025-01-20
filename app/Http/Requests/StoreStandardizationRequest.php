<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStandardizationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'firm_name' => 'required|string',
            'owner_name' => 'required|string',
            'address' => 'required|string',
            'district' => 'required|string',
            'cnic' => 'required|string',
            'mobile_number' => 'required',
            'email' => 'required|email',
            'firm_picture' => 'nullable|file|mimes:jpg,jpeg,png|max:5000', 
        ];
    }
}
