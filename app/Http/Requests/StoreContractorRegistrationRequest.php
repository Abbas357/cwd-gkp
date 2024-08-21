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
            'owner_name' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'pec_number' => 'required|string|max:15',
            'category_applied' => 'required|string|max:255',
            'contractor_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'pec_category' => 'required|string|max:255',
            'cnic' => 'required|string|max:15',
            'fbr_ntn' => 'required|string|max:20',
            'kpra_reg_no' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'mobile_number' => 'required|string|max:15',
            'pre_enlistment' => 'nullable|array',
            'pre_enlistment.*' => 'string|max:255',
            'is_limited' => 'required|in:yes,no',
            'cnic_front_attachment' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'cnic_back_attachment' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'fbr_attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kpra_attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'pec_attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'form_h_attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'pre_enlistment_attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'is_agreed' => 'required|accepted',
        ];
    }
}
