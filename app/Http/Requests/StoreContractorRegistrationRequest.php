<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContractorRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pec_number' => 'required|numeric',
            'category_applied' => 'required|string|max:255',
            'pec_category' => 'required|string|max:255',
            'fbr_ntn' => 'required|string|max:20',
            'kpra_reg_no' => 'required|string|max:20',
            'pre_enlistment' => 'nullable|array',
            'pre_enlistment.*' => 'string|max:255',
            'is_limited' => 'required|in:Yes,No',
            
            'fbr_attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5000',
            'kpra_attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5000',
            'pec_attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5000',
            'form_h_attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5000',
            'pre_enlistment_attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5000',
        ];
    }
}
