<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAchievementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'content' => 'nullable',
            'location' => 'nullable',
        ];
    }
}
