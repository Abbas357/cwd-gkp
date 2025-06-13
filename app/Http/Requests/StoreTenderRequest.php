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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_of_advertisement' => 'required|date',
            'closing_date' => 'required|date|after:date_of_advertisement',
            'user' => 'nullable|integer|exists:users,id',
            
            'tender_documents.*' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpeg,jpg,png',
                'max:10240' // 10MB in KB
            ],
            'tender_eoi_documents.*' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpeg,jpg,png',
                'max:10240'
            ],
            'bidding_documents.*' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpeg,jpg,png',
                'max:10240'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'tender_documents.*.mimes' => 'Each tender document must be a PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, JPEG, JPG, or PNG.',
            'tender_documents.*.max' => 'Each tender document must not exceed 10MB.',
            'tender_eoi_documents.*.mimes' => 'Each EOI document must be a PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, JPEG, JPG, or PNG.',
            'tender_eoi_documents.*.max' => 'Each EOI document must not exceed 10MB.',
            'bidding_documents.*.mimes' => 'Each bidding document must be a PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, JPEG, JPG, or PNG.',
            'bidding_documents.*.max' => 'Each bidding document must not exceed 10MB.',
        ];
    }
}