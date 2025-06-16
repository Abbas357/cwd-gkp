<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSecureDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'document_type' => 'required',
            'title' => 'required',
            'description' => 'nullable|string|max:1000',
            'document_number' => 'nullable|string',
            'issue_date' => 'nullable|date',
        ];
    }
}
