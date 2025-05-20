<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;

class StoreAssetRequest extends FormRequest
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
            'registration_number' => [
                'nullable',
                'string', 
                'max:255',
                function ($attribute, $value, $fail) {
                    if ($value === null) {
                        return;
                    }
                    
                    $normalized = $this->normalizeIdentifier($value);
                    $exists = DB::table('vehicles')
                        ->where('id', '!=', $this->id ?? 0)
                        ->whereRaw('REPLACE(REPLACE(REPLACE(LOWER(registration_number), "-", ""), " ", ""), "_", "") = ?', [$normalized])
                        ->exists();
                    
                    if ($exists) {
                        $fail('The registration number has already been taken.');
                    }
                }
            ],
            'model' => 'required|string|max:255',
            'model_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'registration_status' => 'nullable|string|max:255',
            'chassis_number' => [
                'nullable',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if ($value === null) {
                        return;
                    }
                    
                    $normalized = $this->normalizeIdentifier($value);
                    $exists = DB::table('vehicles')
                        ->where('id', '!=', $this->id ?? 0)
                        ->whereRaw('REPLACE(REPLACE(REPLACE(LOWER(chassis_number), "-", ""), " ", ""), "_", "") = ?', [$normalized])
                        ->exists();
                    
                    if ($exists) {
                        $fail('The chassis number has already been taken.');
                    }
                }
            ],
            'engine_number' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ];
    }

    private function normalizeIdentifier($value)
    {
        return strtolower(str_replace(['-', ' ', '_'], '', $value));
    }
}
