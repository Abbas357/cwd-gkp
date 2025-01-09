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
            'email' => 'required|email|max:255',
            'password' => 'required|max:255',
            'owner_name' => 'required|string|max:255',
            'pec_number' => 'required|numeric',
            'cnic' => 'required|string|max:15',
            'mobile_number' => 'required|string|max:15',
        ];
    }
}
