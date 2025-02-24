<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleAllotmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
        ];
    }
}
