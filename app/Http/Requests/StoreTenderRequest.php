<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTenderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required',
            'procurement_entity' => 'required',
            'date_of_advertisement' => 'required',
            'closing_date' => 'required',
            'tender_domain' => 'required',
        ];
    }
}
