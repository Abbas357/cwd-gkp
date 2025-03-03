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
            'power_rating' => 'nullable|string|max:50',
            'manufacturing_year' => 'nullable|string|max:4',
            'operating_hours' => 'nullable|numeric|min:0',
            'last_maintenance_date' => 'nullable|date',
            'next_maintenance_date' => 'nullable|date',
            'location' => 'nullable|string|max:100',
            'hourly_cost' => 'nullable|numeric|min:0',
            'asset_tag' => 'nullable|string|max:50',
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
            'power_rating' => 'Power Rating',
            'manufacturing_year' => 'Manufacturing Year',
            'operating_hours' => 'Operating Hours',
            'last_maintenance_date' => 'Last Maintenance Date',
            'next_maintenance_date' => 'Next Maintenance Date',
            'location' => 'Location',
            'hourly_cost' => 'Hourly Cost',
            'asset_tag' => 'Asset Tag',
            'certification_status' => 'Certification Status',
            'specifications' => 'Specifications',
            'user_id' => 'User',
        ];
    }
}
