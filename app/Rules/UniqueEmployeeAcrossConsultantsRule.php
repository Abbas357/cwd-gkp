<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\ConsultantHumanResource;

class UniqueEmployeeAcrossConsultantsRule implements ValidationRule
{
    private string $field;
    private string $startDate;
    private string $endDate;
    private int $currentConsultantId;
    private ?int $excludeId;

    public function __construct(
        string $field, 
        string $startDate, 
        string $endDate, 
        int $currentConsultantId,
        ?int $excludeId = null
    ) {
        $this->field = $field;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->currentConsultantId = $currentConsultantId;
        $this->excludeId = $excludeId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = ConsultantHumanResource::where($this->field, $value)
            ->where('consultant_id', '!=', $this->currentConsultantId) // Check OTHER consultants only
            ->where(function ($query) {
                // Check for date range overlaps
                $query->where(function ($q) {
                    // New period starts during existing period
                    $q->where('start_date', '<=', $this->startDate)
                      ->where('end_date', '>=', $this->startDate);
                })->orWhere(function ($q) {
                    // New period ends during existing period
                    $q->where('start_date', '<=', $this->endDate)
                      ->where('end_date', '>=', $this->endDate);
                })->orWhere(function ($q) {
                    // New period completely contains existing period
                    $q->where('start_date', '>=', $this->startDate)
                      ->where('end_date', '<=', $this->endDate);
                })->orWhere(function ($q) {
                    // Existing period completely contains new period
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
            
            $fail("This employee ({$this->field}: '{$value}') is already working with another consultant from {$formattedStartDate} to {$formattedEndDate}. Please check the employment dates.");
        }
    }
}