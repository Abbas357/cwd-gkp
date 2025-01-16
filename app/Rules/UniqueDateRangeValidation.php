<?php

namespace App\Rules;

use Closure;
use App\Models\ContractorHumanResource;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueDateRangeValidation implements ValidationRule
{
    private string $field;
    private string $startDate;
    private string $endDate;

    public function __construct(string $field, string $startDate, string $endDate)
    {
        $this->field = $field;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $existingRecord = ContractorHumanResource::where($this->field, $value)
            ->where(function ($query) {
                $query->whereBetween('start_date', [$this->startDate, $this->endDate])
                    ->orWhereBetween('end_date', [$this->startDate, $this->endDate])
                    ->orWhere(function ($q) {
                        $q->where('start_date', '<=', $this->startDate)
                            ->where('end_date', '>=', $this->endDate);
                    });
            })
            ->first();

        if ($existingRecord) {
            $formattedStartDate = date('d M Y', strtotime($existingRecord->start_date));
            $formattedEndDate = date('d M Y', strtotime($existingRecord->end_date));
            
            $fail(ucfirst($this->field) . " '{$value}' is already registered with a contractor from {$formattedStartDate} to {$formattedEndDate}");
        }
    }
}