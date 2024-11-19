<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required',
            'type' => 'required',
            'cover_photo' => 'image|max:2048',
            'images.*' => 'image|max:5000',
        ];
    }
}
