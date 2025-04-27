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
            'operational_status' => 'required|string|max:50',
            'manufacturer' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'serial_number' => 'nullable|string|max:100',
            'power_source' => 'nullable|string|max:50',
            'manufacturing_year' => 'nullable|string|max:4',
            'operating_hours' => 'nullable|numeric|min:0',
            'last_maintenance_date' => 'nullable|date',
            'location' => 'nullable|string|max:100',
            'certification_status' => 'nullable|string|max:50',
            'specifications' => 'nullable|string',
            'remarks' => 'nullable|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'type' => 'Machinery Type',
            'operational_status' => 'Operational Status',
            'manufacturer' => 'Manufacturer',
            'model' => 'Model',
            'serial_number' => 'Serial Number',
            'power_source' => 'Power Source',
            'manufacturing_year' => 'Manufacturing Year',
            'last_maintenance_date' => 'Last Maintenance Date',
            'location' => 'Location',
            'certification_status' => 'Certification Status',
            'specifications' => 'Specifications',
            'user_id' => 'User',
        ];
    }
}
