<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'site_name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'email' => 'required|email|max:255',
            'maintenance_mode' => 'required|boolean',
            'contact_phone' => 'required|string|max:20',
            'contact_address' => 'required|string|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'secret_key' => 'nullable|string|max:500',
        ];
    }
}
