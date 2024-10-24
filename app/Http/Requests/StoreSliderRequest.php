<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSliderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required',
            'summary' => 'required',
            'image' => 'required|file|mimes:jpeg,jpg,png,gif|max:10240',
        ];
    }
}
