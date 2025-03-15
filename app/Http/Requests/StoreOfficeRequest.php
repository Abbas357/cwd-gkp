<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOfficeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:offices,name'],
            'type' => [
                'nullable', 
                'string', 
                'in:Secretariat,Provincial,Regional,Divisional,District,Tehsil'
            ],
            'parent_id' => [
                'nullable', 
                'exists:offices,id',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $office = \App\Models\Office::find($value);
                        if ($office && $office->status !== 'Active') {
                            $fail('The parent office must be active.');
                        }
                    }
                }
            ],
            'district_id' => [
                'nullable',
                'exists:districts,id',
                Rule::unique('offices', 'district_id'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The office name is required.',
            'name.unique' => 'This office name already exists.',
            'type.in' => 'The selected type must either be Provincial, Regional, Divisional, District, Tehsil',
            'parent_id.exists' => 'The selected parent office does not exist.',
            'district_id.unique' => 'This district is already assigned to another office.',
        ];
    }
}
