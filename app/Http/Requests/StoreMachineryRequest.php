<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMachineryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => 'required|string|max:50',
            'functional_status' => 'required|string|max:50',
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'engine_number' => 'nullable|string|max:100',
            'registration_number' => 'nullable|string|max:50',
            'model_year' => 'nullable|string|max:4',
            'operating_hours' => 'nullable|numeric|min:0',
            'fuel_type' => 'nullable|date',
            'location' => 'nullable|string|max:100',
            'chassis_number' => 'nullable|string|max:50',
            'specifications' => 'nullable|string',
            'remarks' => 'nullable|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'type' => 'Machinery Type',
            'functional_status' => 'Operational Status',
            'brand' => 'Manufacturer',
            'model' => 'Model',
            'engine_number' => 'Serial Number',
            'registration_number' => 'Power Source',
            'model_year' => 'Manufacturing Year',
            'fuel_type' => 'Last Maintenance Date',
            'location' => 'Location',
            'chassis_number' => 'Certification Status',
            'specifications' => 'Specifications',
            'user_id' => 'User',
        ];
    }
}
