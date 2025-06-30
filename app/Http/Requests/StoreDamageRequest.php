<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDamageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'report_date' => 'required|date',
            'type' => 'required|string|max:50',
            'infrastructure_id' => 'required|exists:infrastructures,id',
            'damaged_length' => 'required|numeric|min:0',
            'damage_east_start' => 'nullable|numeric|between:-180,180',
            'damage_north_start' => 'nullable|numeric|between:-90,90',
            'damage_east_end' => 'nullable|numeric|between:-180,180',
            'damage_north_end' => 'nullable|numeric|between:-90,90', 
            'damage_status' => 'required|string|max:255',
            'approximate_restoration_cost' => 'nullable|numeric|min:0',
            'approximate_rehabilitation_cost' => 'nullable|numeric|min:0',
            'road_status' => 'required|string|max:255',
            'remarks' => 'nullable|string|max:1000'
        ];
    }
}
