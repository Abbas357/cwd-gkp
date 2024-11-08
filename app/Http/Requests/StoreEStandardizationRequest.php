<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEStandardizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_name' => 'required|string',
            'specification_details' => 'required',
            'firm_name' => 'required|string',
            'address' => 'required|string',
            'mobile_number' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email',
            'locality' => 'required',
            'ntn_number' => 'required',
            'location_type' => 'required',

            'firm_picture' => 'nullable|file|mimes:jpg,jpeg,png|max:5000', 
            'secp_certificate' => 'nullable|file|mimes:jpg,jpeg,png|max:5000', 
            'iso_certificate' => 'nullable|file|mimes:jpg,jpeg,png|max:5000', 
            'commerce_membership' => 'nullable|file|mimes:jpg,jpeg,png|max:5000', 
            'pec_certificate' => 'nullable|file|mimes:jpg,jpeg,png|max:5000', 
            'annual_tax_returns' => 'nullable|file|mimes:jpg,jpeg,png|max:5000', 
            'audited_financial' => 'nullable|file|mimes:jpg,jpeg,png|max:5000', 
            'dept_org_cert' => 'nullable|file|mimes:jpg,jpeg,png|max:5000', 
            'performance_certificate' => 'nullable|file|mimes:jpg,jpeg,png|max:5000', 
        ];
    }
}
