<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class StoreServiceCardRequest extends FormRequest
{
    public function __construct()
    {
        Validator::extend('email_exists', function ($attribute, $value, $parameters, $validator) {
            $domain = substr(strrchr($value, "@"), 1);
            return checkdnsrr($domain, "MX");
        });
        
        Validator::replacer('email_exists', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'The :attribute domain does not appear to be valid or does not accept emails.');
        });
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ddo_code' => 'required|max:50',
            'name' => 'required|string|max:100',
            'father_name' => 'required|string|max:100',
            'date_of_birth' => 'required|date',
            'mark_of_identification' => 'nullable|string|max:255',
            'cnic' => [
                'required',
                'string',
                'max:15',
                'regex:/^[0-9]{5}-[0-9]{7}-[0-9]{1}$/',
                'unique:service_cards,cnic'
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'email_exists',
                'unique:service_cards,email'
            ],
            'landline_number' => 'nullable|string|max:15',
            'mobile_number' => [
                'required',
                'string',
                'max:15',
                'regex:/^((\+92|92|0)([0-9]{3}|[0-9]{3}-)[0-9]{7}|(\+92|92|0)[0-9]{10})$/',
                'unique:service_cards,mobile_number'
            ],
            'personnel_number' => 'required|string|max:15|unique:service_cards,personnel_number',
            'blood_group' => 'nullable|string|max:5',
            'emergency_contact' => [
                'nullable',
                'string',
                'max:15',
                'regex:/^((\+92|92|0)([0-9]{3}|[0-9]{3}-)[0-9]{7}|(\+92|92|0)[0-9]{10})$/'
            ],
            'permanent_address' => 'required|string|max:255',
            'present_address' => 'required|string|max:255',
            'designation_id' => 'required|exists:designations,id',
            'bps' => 'required|string|max:100',
            'office_id' => 'required|exists:offices,id',
        ];
    }

    public function messages(): array
    {
        return [
            'cnic.regex' => 'The CNIC must be in the format 00000-0000000-0.',
            'mobile_number.regex' => 'The mobile number must be a valid Pakistani number format (e.g., +923001234567, 03001234567, or 0300-1234567).',
            'emergency_contact.regex' => 'The emergency contact must be a valid Pakistani number format (e.g., +923001234567, 03001234567, or 0300-1234567).',
        ];
    }
}