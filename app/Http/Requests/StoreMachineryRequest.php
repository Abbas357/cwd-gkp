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
            'registration_number' => 'nullable|string|max:50',
            'model_year' => 'nullable|string|max:4',
            'fuel_type' => 'nullable|string|max:50',
            'engine_number' => 'nullable|string|max:50',
            'chassis_number' => 'nullable|string|max:50',
            'remarks' => 'nullable|string',
            'front_view' => 'nullable|image',
            'side_view'  => 'nullable|image'
        ];
    }

    public function attributes(): array
    {
        return [
            'type' => 'Machinery Type',
            'functional_status' => 'Functional Status',
            'brand' => 'Brand',
            'model' => 'Model',
            'registration_number' => 'Power Source',
            'model_year' => 'Manufacturing Year',
            'fuel_type' => 'Fuel Type',
            'engine_number' => 'Engine Number',
            'chassis_number' => 'Chassis Number',
            'remarks' => 'Remarks',
        ];
    }
}
