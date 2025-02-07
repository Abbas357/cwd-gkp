<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => 'nullable|string|max:255',
            'functional_status' => 'nullable|string|max:255',
            'brand' => 'required|string|max:255',
            'color' => 'nullable|string|max:255',
            'fuel_type' => 'required',
            'registration_number' => 'required|string|unique:vehicles',
            'model' => 'required|string|max:255',
            'model_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'registration_status' => 'nullable|string|max:255',
            'chassis_number' => 'nullable|string|max:255',
            'engine_number' => 'nullable|string|max:255',
            'vehicle_user_id' => 'required|exists:vehicle_users,id',
            'remarks' => 'nullable|string',
        ];
    }
}
