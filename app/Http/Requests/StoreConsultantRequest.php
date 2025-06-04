<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConsultantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'firm_name' => 'required|max:100',
            'email' => 'required|email|max:100',
            'pec_number' => 'required|integer|unique:consultants,pec_number',
        ];
    }
}
