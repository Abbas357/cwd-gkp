<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Standardization;

class StandardizationDocumentsUploadedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('standardization_id')) {
            return redirect()->route('standardizations.dashboard')
                ->with('error', 'Standardization session not found. Please try again.');
        }

        $standardization = Standardization::findOrFail(session('standardization_id'));
        
        // Use the same document list as in the component for consistency
        $requiredDocuments = [
            'secp_certificates' => 'SECP Certificate',
            'iso_certificates' => 'ISO Certificate',
            'commerse_memberships' => 'Commerce Membership',
            'pec_certificates' => 'PEC Certificate',
            'annual_tax_returns' => 'Annual Tax Returns',
            'audited_financials' => 'Audited Financial',
            'organization_registrations' => 'Department / Organization Registrations',
            'performance_certificate' => 'Performance Certificate'
        ];
        
        // Check if all required documents are uploaded
        $documentsUploaded = true;
        $missingDocuments = [];
        
        foreach ($requiredDocuments as $key => $name) {
            if (!$standardization->hasMedia($key)) {
                $documentsUploaded = false;
                $missingDocuments[] = $name;
            }
        }
        
        if (!$documentsUploaded) {
            return redirect()->route('standardizations.upload')
                ->with('error', 'Please upload all required documents before continuing. Missing: ' . implode(', ', $missingDocuments));
        }
        
        return $next($request);
    }
}