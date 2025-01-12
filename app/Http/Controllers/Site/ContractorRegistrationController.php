<?php

namespace App\Http\Controllers\Site;

use App\Models\Category;
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
                $q->where('category_applied', request('category'));
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

        $categories = Category::where('type', 'contractor_category')->get();

        return view('site.contractors.registration.index', compact('registrations', 'categories'));
    }

    public function create()
    {
        $cat = [
            'contractor_category' => Category::where('type', 'contractor_category')->get(),
            'provincial_entities' => Category::where('type', 'provincial_entity')->get(),
        ];
        return view('site.contractors.registration.create', compact('cat'));
    }

    public function store(StoreContractorRegistrationRequest $request)
    {
        $pecNumber = $request->input('pec_number');
        $categoryApplied = $request->input('category_applied');
        $pecCategory = $request->input('pec_category');


        $canApply = $this->canContractorApply($pecNumber, $categoryApplied, $pecCategory);

        if (!$canApply['status']) {
            return redirect()->route('contractors.registration.create')
                ->with('danger', $canApply['message']);
        }

        $registration = new ContractorRegistration();
        $registration->pec_number = $pecNumber;
        $registration->category_applied = $categoryApplied;
        $registration->pec_category = $pecCategory;
        $registration->fbr_ntn = $request->input('fbr_ntn');
        $registration->kpra_reg_no = $request->input('kpra_reg_no');
        $registration->is_limited = $request->input('is_limited');
        $registration->status = 'new';
        $registration->uuid = Str::uuid();
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
            'contractor_category' => Category::where('type', 'contractor_category')->get(),
            'provincial_entities' => Category::where('type', 'provincial_entity')->get(),
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
        $categoryApplied = $request->input('category_applied');
        $pecCategory = $request->input('pec_category');

        if (
            $pecNumber !== $registration->pec_number ||
            $categoryApplied !== $registration->category_applied ||
            $pecCategory !== $registration->pec_category
        ) {
            $canApply = $this->canContractorApply($pecNumber, $categoryApplied, $pecCategory, $registration->id);

            if (!$canApply['status']) {
                return redirect()->back()
                    ->with('danger', $canApply['message']);
            }
        }

        $registration->pec_number = $pecNumber;
        $registration->category_applied = $categoryApplied;
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

    public function checkPEC(Request $request)
    {
        $pecNumber = $request->input('pec_number');
        $categoryApplied = $request->input('category_applied') ?? null;
        $pecCategory = $request->input('pec_category') ?? null;

        $result = $this->canContractorApply($pecNumber, $categoryApplied, $pecCategory);

        return response()->json([
            'unique' => $result['status'],
            'message' => $result['message']
        ]);
    }

    private function canContractorApply($pecNumber, $categoryApplied = null, $pecCategory = null, $excludeId = null)
    {
        $pendingApplications = ContractorRegistration::where(function ($query) use ($pecNumber) {
            $query->whereIn('status', ['new', 'deffered_once', 'deffered_twice']);
        })
        ->when($excludeId, function ($query) use ($excludeId) {
            $query->where('id', '!=', $excludeId);
        })
        ->latest()
        ->first();

        if ($pendingApplications) {
            return [
                'status' => false,
                'message' => 'You have already applied with PEC number (' . $pendingApplications->pec_number . '). Please wait for decision or contact IT cell for assistance.'
            ];
        }

        $latestRegistration = ContractorRegistration::where('pec_number', $pecNumber)
        ->where('contractor_id', session('contractor_id'))
        ->when($excludeId, function ($query) use ($excludeId) {
            $query->where('id', '!=', $excludeId);
        })
        ->latest()
        ->first();

        if ($latestRegistration && $latestRegistration->status === 'approved') {
            if (
                !$this->isValidCategoryUpgrade($latestRegistration->category_applied, $categoryApplied) ||
                !$this->isValidCategoryUpgrade($latestRegistration->pec_category, $pecCategory)
            ) {
                return [
                    'status' => false,
                    'message' => 'With a different PEC number, you can only apply for categories higher than your previous approved application.'
                ];
            }

            return ['status' => true, 'message' => 'You can proceed with the application'];
        }

        return ['status' => true, 'message' => 'You can proceed with the application'];
    }

    private function isValidCategoryUpgrade($previousCategory, $newCategory)
    {
        if (!$previousCategory || !$newCategory || $previousCategory === $newCategory) {
            return false;
        }
        
        $previousRank = self::CATEGORY_RANKS[$previousCategory] ?? 0;
        $newRank = self::CATEGORY_RANKS[$newCategory] ?? 0;

        return $newRank > $previousRank;
    }
}
