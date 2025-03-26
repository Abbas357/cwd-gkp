<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Standardization;

class StandardizationDocumentStatus extends Component
{
    public $standardization;
    public $requiredDocuments;
    public $uploadedCount;
    public $totalCount;
    public $percentComplete;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Standardization $standardization)
    {
        $this->standardization = $standardization;
        $this->requiredDocuments = [
            'secp_certificates' => 'SECP Certificate',
            'iso_certificates' => 'ISO Certificate',
            'commerse_memberships' => 'Commerce Membership',
            'pec_certificates' => 'PEC Certificate',
            'annual_tax_returns' => 'Annual Tax Returns',
            'audited_financials' => 'Audited Financial',
            'organization_registrations' => 'Department / Organization Registrations',
            'performance_certificate' => 'Performance Certificate'
        ];
        
        $this->calculateProgress();
    }

    /**
     * Calculate the document upload progress.
     *
     * @return void
     */
    private function calculateProgress()
    {
        $this->uploadedCount = 0;
        $this->totalCount = count($this->requiredDocuments);
        
        foreach ($this->requiredDocuments as $key => $name) {
            if ($this->standardization->hasMedia($key)) {
                $this->uploadedCount++;
            }
        }
        
        $this->percentComplete = ($this->uploadedCount / $this->totalCount) * 100;
    }
    
    /**
     * Check if all documents are uploaded.
     *
     * @return bool
     */
    public function isComplete()
    {
        return $this->percentComplete == 100;
    }
    
    /**
     * Get the status class based on completion.
     *
     * @return string
     */
    public function getStatusClass()
    {
        return $this->isComplete() ? 'success' : 'warning';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.standardization-document-status');
    }
}