<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Model;

class UniqueDateRangeValidation implements ValidationRule
{
    private string $field;
    private string $startDate;
    private string $endDate;
    private string $modelClass;
    private ?int $excludeId;
    private array $additionalConditions; // Generic additional conditions

    public function __construct(
        string $field, 
        string $startDate, 
        string $endDate, 
        string $modelClass,
        ?int $excludeId = null,
        array $additionalConditions = [] // Accept any additional where conditions
    ) {
        $this->field = $field;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->modelClass = $modelClass;
        $this->excludeId = $excludeId;
        $this->additionalConditions = $additionalConditions;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = $this->modelClass::where($this->field, $value);
        
        // Apply any additional conditions (like consultant_id, contractor_id, etc.)
        foreach ($this->additionalConditions as $column => $conditionValue) {
            $query->where($column, $conditionValue);
        }
        
        $query->where(function ($query) {
            $query->whereBetween('start_date', [$this->startDate, $this->endDate])
                ->orWhereBetween('end_date', [$this->startDate, $this->endDate])
                ->orWhere(function ($q) {
                    $q->where('start_date', '<=', $this->startDate)
                        ->where('end_date', '>=', $this->endDate);
                });
        });

        // Exclude current record when updating
        if ($this->excludeId) {
            $query->where('id', '!=', $this->excludeId);
        }

        $existingRecord = $query->first();

        if ($existingRecord) {
            $formattedStartDate = date('d M Y', strtotime($existingRecord->start_date));
            $formattedEndDate = date('d M Y', strtotime($existingRecord->end_date));
            
            $fail(ucfirst($this->field) . " '{$value}' is already registered with another firm from {$formattedStartDate} to {$formattedEndDate}");
        }
    }
}