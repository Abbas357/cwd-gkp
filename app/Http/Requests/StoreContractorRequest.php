<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContractorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:100',
            'firm_name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'cnic' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'district' => 'required',
            'mobile_number' => 'required|max:15',
            'password' => 'required|max:100',
        ];
    }
}
