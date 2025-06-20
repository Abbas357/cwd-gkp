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
            'type' => 'required|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'machinery_id' => 'required|exists:machineries,id',
            'office_id' => 'required|exists:offices,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'type' => 'Allocation Purpose',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'machinery_id' => 'Machinery',
            'office_id' => 'Office',
            'project_id' => 'Project',
        ];
    }

    public function messages(): array
    {
        return [
            'end_date.after_or_equal' => 'The end date must be equal to or after the start date.',
            'machinery_id.exists' => 'The selected machinery does not exist.',
            'office_id.exists' => 'The selected office does not exist.',
        ];
    }
}
