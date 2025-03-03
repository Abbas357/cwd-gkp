<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMachineryAllocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'purpose' => 'required|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'machinery_id' => 'required|exists:machineries,id',
            'user_id' => 'required|exists:users,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'purpose' => 'Allocation Purpose',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'machinery_id' => 'Machinery',
            'user_id' => 'User',
            'project_id' => 'Project',
        ];
    }

    public function messages(): array
    {
        return [
            'end_date.after_or_equal' => 'The end date must be equal to or after the start date.',
            'machinery_id.exists' => 'The selected machinery does not exist.',
            'user_id.exists' => 'The selected user does not exist.',
        ];
    }
}
