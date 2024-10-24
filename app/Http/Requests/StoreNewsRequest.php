<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required',
            'summary' => 'required',
            'attachment' => 'required|file|mimes:pdf,docx,pptx,txt,jpeg,jpg,png,gif|max:10240', 
        ];
    }
}
