<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file_name' => ['required', 'string', 'max:255'],
            'file_type' => ['nullable', 'string', 'max:50'],
            'file_link' => ['nullable', 'url'],
            'project_id' => ['required', 'exists:projects,id'],
            'status' => ['nullable', 'in:draft,published,archived'],
        ];
    }
}
