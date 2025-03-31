<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInfrastructureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'length' => 'required|numeric|min:0',
            'east_start_coordinate' => 'nullable|numeric|between:-180,180',
            'north_start_coordinate' => 'nullable|numeric|between:-90,90',
            'east_end_coordinate' => 'nullable|numeric|between:-180,180',
            'north_end_coordinate' => 'nullable|numeric|between:-90,90',
        ];
    }
}
