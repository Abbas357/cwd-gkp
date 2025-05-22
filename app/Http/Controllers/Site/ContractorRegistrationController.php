<?php

namespace App\Http\Controllers\Site;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContractorRegistration;
use App\Http\Requests\StoreContractorRegistrationRequest;

class ContractorRegistrationController extends Controller
{
    private const CATEGORY_RANKS = [
        'PK-C-6' => 1,
        'PK-C-5' => 2,
        'PK-C-4' => 3,
        'PK-C-3' => 4,
        'PK-C-2' => 5,
        'PK-C-1' => 6,
        'PK-C-B' => 7,
        'PK-C-A' => 8
    ];

    public function index()
    {
        $query = ContractorRegistration::where('contractor_id', session('contractor_id'))
            ->when(request('status'), function ($q) {
                $q->where('status', request('status'));
            })
            ->when(request('category'), function ($q) {
                $q->where('pec_category', request('category'));
            })
            ->when(request('search'), function ($q) {
                $q->where(function ($query) {
                    $search = request('search');
                    $query->where('pec_number', 'LIKE', "%{$search}%")
                        ->orWhere('name', 'LIKE', "%{$search}%")
                        ->orWhere('fbr_ntn', 'LIKE', "%{$search}%")
                        ->orWhere('kpra_reg_no', 'LIKE', "%{$search}%");
                });
            });

        $registrations = $query->latest()->paginate(10);

        foreach ($registrations as $registration) {
            $registration->can_edit = $registration->created_at->isToday();
        }

        $categories = ['PK-C-A', 'PK-C-B', 'PK-C-1', 'PK-C-2', 'PK-C-3', 'PK-C-4', 'PK-C-5', 'PK-C-6'];

        return view('site.contractors.registration.index', compact('registrations', 'categories'));
    }

    public function create()
    {
        $cat = [
            'contractor_category' => ['PK-C-A', 'PK-C-B', 'PK-C-1', 'PK-C-2', 'PK-C-3', 'PK-C-4', 'PK-C-5', 'PK-C-6'],
            'provincial_entities' => ['C&W', 'PHE', 'Local Government', 'Local Council Board', 'Irrigation', 'PHA', 'PKHA', 'FATA', 'PDA', 'Electric Inspector', 'Others'],
        ];
        return view('site.contractors.registration.create', compact('cat'));
    }

    public function store(StoreContractorRegistrationRequest $request)
    {
        $pecNumber = $request->input('pec_number');
        $pecCategory = $request->input('pec_category');

        $canApply = $this->canContractorApply($pecNumber, $pecCategory);

        if (!$canApply['status']) {
            return redirect()->route('contractors.registration.create')
                ->with('danger', $canApply['message']);
        }

        $registration = new ContractorRegistration();
        $registration->uuid = Str::uuid();
        $registration->pec_number = $pecNumber;
        $registration->pec_category = $pecCategory;
        $registration->fbr_ntn = $request->input('fbr_ntn');
        $registration->kpra_reg_no = $request->input('kpra_reg_no');
        $registration->is_limited = $request->input('is_limited');
        $registration->status = 'draft';
        $registration->reg_number = $this->generateRegistrationNumber();
        $registration->contractor_id = session('contractor_id');

        if ($request->has('pre_enlistment')) {
            $registration->pre_enlistment = json_encode($request->input('pre_enlistment'));
        }

        $this->handleFileUploads($request, $registration);

        if ($registration->save()) {
            return redirect()->route('contractors.registration.create')
                ->with('success', 'Your form has been submitted successfully');
        }

        return redirect()->route('contractors.registration.create')
            ->with('danger', 'There is an error submitting your data');
    }

    private function generateRegistrationNumber(): string
    {
        $latest = ContractorRegistration::latest()->first();
        if ($latest && preg_match('/CWD(\d+)/', $latest->reg_number, $matches)) {
            $nextNumber = (int)$matches[1] + 1;
        } else {
            $nextNumber = 1000;
        }
        return 'CWD' . $nextNumber;
    }

    public function show($uuid)
    {
        $registration = ContractorRegistration::with(['media', 'contractor'])->where('uuid', '=', $uuid)->firstOrFail();

        $documents = [
            'FBR Registration' => [
                'url' => $registration->getFirstMediaUrl('fbr_attachments'),
                'mime_type' => $registration->getFirstMedia('fbr_attachments')?->mime_type
            ],
            'KPRA Certificate' => [
                'url' => $registration->getFirstMediaUrl('kpra_attachments'),
                'mime_type' => $registration->getFirstMedia('kpra_attachments')?->mime_type
            ],
            'PEC Certificate' => [
                'url' => $registration->getFirstMediaUrl('pec_attachments'),
                'mime_type' => $registration->getFirstMedia('pec_attachments')?->mime_type
            ],
            'Form H' => [
                'url' => $registration->getFirstMediaUrl('form_h_attachments'),
                'mime_type' => $registration->getFirstMedia('form_h_attachments')?->mime_type
            ],
            'Previous Enlistment' => [
                'url' => $registration->getFirstMediaUrl('pre_enlistment_attachments'),
                'mime_type' => $registration->getFirstMedia('pre_enlistment_attachments')?->mime_type
            ]
        ];

        return view('site.contractors.registration.show', compact('registration', 'documents'));
    }

    public function edit($uuid)
    {
        $registration = ContractorRegistration::where('uuid', '=', $uuid)->firstOrFail();
        if ($registration->contractor_id !== session('contractor_id')) {
            return redirect()->back()
                ->with('error', 'Unauthorized access.');
        }

        if (!$registration->created_at->isToday()) {
            return redirect()->back()
                ->with('error', 'Registration can only be edited on the same day it was created.');
        }

        $cat = [
            'contractor_category' => ['PK-C-A', 'PK-C-B', 'PK-C-1', 'PK-C-2', 'PK-C-3', 'PK-C-4', 'PK-C-5', 'PK-C-6'],
            'provincial_entities' => ['C&W', 'PHE', 'Local Government', 'Local Council Board', 'Irrigation', 'PHA', 'PKHA', 'FATA', 'PDA', 'Electric Inspector', 'Others'],
        ];

        return view('site.contractors.registration.edit', compact('registration', 'cat'));
    }

    public function update(StoreContractorRegistrationRequest $request, $uuid)
    {
        $registration = ContractorRegistration::where('uuid', '=', $uuid)->firstOrFail();

        if ($registration->contractor_id !== session('contractor_id')) {
            return redirect()->back()
                ->with('error', 'Unauthorized access.');
        }

        if (!$registration->created_at->isToday()) {
            return redirect()->back()
                ->with('error', 'Registration can only be edited on the same day it was created.');
        }

        $pecNumber = $request->input('pec_number');
        $pecCategory = $request->input('pec_category');

        if (
            $pecNumber !== $registration->pec_number ||
            $pecCategory !== $registration->pec_category
        ) {
            $canApply = $this->canContractorApply($pecNumber, $pecCategory, $registration->id);

            if (!$canApply['status']) {
                return redirect()->back()
                    ->with('danger', $canApply['message']);
            }
        }

        $registration->pec_number = $pecNumber;
        $registration->pec_category = $pecCategory;
        $registration->fbr_ntn = $request->input('fbr_ntn');
        $registration->kpra_reg_no = $request->input('kpra_reg_no');
        $registration->is_limited = $request->input('is_limited');

        if ($request->has('pre_enlistment')) {
            $registration->pre_enlistment = json_encode($request->input('pre_enlistment'));
        }

        $this->handleFileUploads($request, $registration);

        if ($registration->save()) {
            return redirect()->route('contractors.registration.edit', $registration->uuid)
                ->with('success', 'Registration updated successfully');
        }

        return redirect()->back()
            ->with('danger', 'There was an error updating your registration');
    }

    private function handleFileUploads(Request $request, ContractorRegistration $registration)
    {
        $attachments = [
            'fbr_attachment' => 'fbr_attachments',
            'kpra_attachment' => 'kpra_attachments',
            'pec_attachment' => 'pec_attachments',
            'form_h_attachment' => 'form_h_attachments',
            'pre_enlistment_attachment' => 'pre_enlistment_attachments'
        ];

        foreach ($attachments as $requestKey => $collectionName) {
            if ($request->hasFile($requestKey)) {
                $registration->addMedia($request->file($requestKey))
                    ->toMediaCollection($collectionName);
            }
        }
    }

    public function approvedContractors(Request $request, $uuid)
    {
        $contractor_registration = ContractorRegistration::where('uuid', $uuid)->first();
        return view('site.contractors.approved', compact('ContractorRegistration'));
    }

    public function checkPEC(Request $request)
    {
        $pecNumber = $request->input('pec_number');
        $pecCategory = $request->input('pec_category') ?? null;

        $result = $this->canContractorApply($pecNumber, $pecCategory);

        return response()->json([
            'unique' => $result['status'],
            'message' => $result['message']
        ]);
    }

    private function canContractorApply($pecNumber, $pecCategory = null, $excludeId = null)
{
    // Early return if essential parameters are missing
    if (empty($pecNumber) || empty($pecCategory)) {
        return [
            'status' => false,
            'message' => 'PEC number and category are required for validation.'
        ];
    }

    // Validate if the category exists in our ranking system
    if (!isset(self::CATEGORY_RANKS[$pecCategory])) {
        return [
            'status' => false,
            'message' => 'Invalid PEC category provided.'
        ];
    }

    $contractorId = session('contractor_id');
    if (empty($contractorId)) {
        return [
            'status' => false,
            'message' => 'Contractor session not found. Please login again.'
        ];
    }

    // 1. Check if PEC number is already used by OTHER contractors
    $pecUsedByOthers = ContractorRegistration::where('pec_number', $pecNumber)
        ->where('contractor_id', '!=', $contractorId)
        ->exists();

    if ($pecUsedByOthers) {
        return [
            'status' => false,
            'message' => 'This PEC number is already registered with another contractor. Each PEC number can only be used by one contractor.'
        ];
    }

    // 2. Check for pending registrations (ABSOLUTE BLOCK - highest priority)
    $pendingRegistration = ContractorRegistration::where('contractor_id', $contractorId)
        ->whereIn('status', ['draft', 'deferred_once', 'deferred_twice'])
        ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
        ->orderBy('created_at', 'desc')
        ->first();

    if ($pendingRegistration) {
        $statusMessages = [
            'draft' => 'You have a pending registration that has not yet been reviewed by the enlistment committee. You cannot submit a new registration until this is resolved.',
            'deferred_once' => 'Your previous registration was deferred with remarks: "' . ($pendingRegistration->remarks ?? 'No specific remarks provided') . '". You cannot apply again until this application is finalized in next enlistment committee meeting. Please address the concerns or contact the department for assistance.',
            'deferred_twice' => 'Your registration has been deferred twice with remarks: "' . ($pendingRegistration->remarks ?? 'No specific remarks provided') . '". You must wait for the final decision in next enlistment committee meeting before submitting any new application. One more deferral will require you to restart the process. Please contact the department immediately.',
        ];
        
        return [
            'status' => false,
            'message' => $statusMessages[$pendingRegistration->status] ?? 'You have a pending registration that must be resolved first.'
        ];
    }

    // Get all contractor's historical registrations for validation
    $contractorRegistrations = ContractorRegistration::where('contractor_id', $contractorId)
        ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
        ->orderBy('created_at', 'desc')
        ->get();

    if ($contractorRegistrations->isEmpty()) {
        // First-time applicant - no restrictions
        return [
            'status' => true, 
            'message' => 'Application is valid for first-time applicant.'
        ];
    }

    // 3. Separate approved and deferred_thrice registrations
    $approvedRegistrations = $contractorRegistrations->where('status', 'approved');
    $deferredThriceRegistrations = $contractorRegistrations->where('status', 'deferred_thrice');

    $newPecRank = self::CATEGORY_RANKS[$pecCategory];

    // 4. Handle contractors with approved registrations
    if ($approvedRegistrations->isNotEmpty()) {
        $maxApprovedRank = $approvedRegistrations->max(fn($reg) => self::CATEGORY_RANKS[$reg->pec_category] ?? 0);
        
        // Approved contractors can NEVER apply for lower category
        if ($newPecRank <= $maxApprovedRank) {
            $highestApprovedCategory = $approvedRegistrations
                ->sortByDesc(fn($reg) => self::CATEGORY_RANKS[$reg->pec_category] ?? 0)
                ->first()
                ->pec_category;
                
            return [
                'status' => false,
                'message' => "You have approved registration(s). You can only apply for categories higher than your highest approved category: {$highestApprovedCategory}."
            ];
        }
    }

    // 5. Handle deferred_thrice contractors (special rules)
    if ($deferredThriceRegistrations->isNotEmpty()) {
        // Check if using same PEC number as any deferred_thrice registration
        $deferredThriceWithSamePec = $deferredThriceRegistrations
            ->where('pec_number', $pecNumber)
            ->first();

        if ($deferredThriceWithSamePec) {
            // Rule 1a: Same PEC number - can only apply same or lower category
            $previousPecRank = self::CATEGORY_RANKS[$deferredThriceWithSamePec->pec_category] ?? 0;
            
            if ($newPecRank > $previousPecRank) {
                return [
                    'status' => false,
                    'message' => "With PEC number {$pecNumber} that was deferred thrice, you can only apply for category {$deferredThriceWithSamePec->pec_category} or lower."
                ];
            }
        } else {
            // Rule 1b: Different PEC number - can apply in any category (like fresh applicant)
            // But still need to respect approved registration rules if they exist
            if ($approvedRegistrations->isNotEmpty()) {
                $maxApprovedRank = $approvedRegistrations->max(fn($reg) => self::CATEGORY_RANKS[$reg->pec_category] ?? 0);
                if ($newPecRank <= $maxApprovedRank) {
                    return [
                        'status' => false,
                        'message' => 'Even with a different PEC number, you cannot apply for a category lower than your approved registrations.'
                    ];
                }
            }
        }
    }

    // 6. Final validation - ensure progressive growth with same PEC number
    $previousWithSamePec = ContractorRegistration::where('pec_number', $pecNumber)
        ->where('contractor_id', $contractorId)
        ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
        ->whereNotIn('status', ['deferred_thrice']) // Already handled above
        ->orderBy('created_at', 'desc')
        ->first();

    if ($previousWithSamePec) {
        $previousPecRank = self::CATEGORY_RANKS[$previousWithSamePec->pec_category] ?? 0;

        if ($newPecRank <= $previousPecRank) {
            return [
                'status' => false,
                'message' => "You have previously applied for category {$previousWithSamePec->pec_category} with this PEC number. You must apply for a higher category to show professional growth."
            ];
        }
    }

    return [
        'status' => true, 
        'message' => 'Application is valid and meets all requirements.'
    ];
}
}