<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDesignationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:designations,name'],
            'bps' => ['nullable'],
            'status' => ['nullable', 'string', 'in:Active,Inactive,Archived'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The designation name is required.',
            'name.unique' => 'This designation name already exists.',
            'status.in' => 'The selected status is invalid.',
        ];
    }
}
