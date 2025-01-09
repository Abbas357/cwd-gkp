<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStandardizationRequest extends FormRequest
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
        ];
    }
}
