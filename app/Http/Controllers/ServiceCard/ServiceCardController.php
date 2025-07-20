<?php
namespace App\Http\Controllers\ServiceCard;
use App\Models\User;
use App\Models\Office;
use App\Helpers\Database;
use App\Models\Designation;
use App\Models\ServiceCard;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\SearchBuilder;
use App\Models\SanctionedPost;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Endroid\QrCode\Builder\Builder;
use App\Http\Controllers\Controller;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\SvgWriter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ServiceCard\RenewedMail;
use Endroid\QrCode\Encoding\Encoding;
use App\Mail\ServiceCard\RejectedMail;
use App\Mail\ServiceCard\VerifiedMail;

class ServiceCardController extends Controller
{
    public function index(Request $request)
    {
        $approval_status = $request->query('approval_status', null);
        $card_status = $request->query('card_status', null);

        $service_cards = ServiceCard::with(['user.profile', 'user.currentDesignation', 'user.currentOffice']);

        // Filter by approval status
        $service_cards->when($approval_status !== null, function ($query) use ($approval_status) {
            $query->where('approval_status', $approval_status);
        });

        // Filter by card status
        $service_cards->when($card_status !== null, function ($query) use ($card_status) {
            $query->where('card_status', $card_status);
        });

        $relationMappings = [
            'designation_id' => 'user.currentDesignation.name',
            'office_id' => 'user.currentOffice.name',
            'name' => 'user.name',
            'email' => 'user.email',
            'cnic' => 'user.profile.cnic',
            'mobile_number' => 'user.profile.mobile_number',
        ];

        if ($request->ajax()) {
            $dataTable = Datatables::of($service_cards)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('modules.service_cards.partials.buttons', compact('row'))->render();
                })
                ->addColumn('name', function ($row) {
                    return '<div style="display: flex; align-items: center;">
                        <img style="width: 30px; height: 30px; border-radius: 50%;" 
                             src="' . getProfilePic($row->user) . '" /> 
                        <span> &nbsp; ' . $row->user->name . '</span>
                    </div>';
                })
                ->addColumn('email', function ($row) {
                    return $row->user->email;
                })
                ->addColumn('designation', function ($row) {
                    return $row->user->currentDesignation ? $row->user->currentDesignation->name : 'N/A';
                })
                ->addColumn('office', function ($row) {
                    return $row->user->currentOffice ? $row->user->currentOffice->name : 'N/A';
                })
                ->addColumn('cnic', function ($row) {
                    return $row->user->profile ? $row->user->profile->cnic : 'N/A';
                })
                ->addColumn('mobile_number', function ($row) {
                    return $row->user->profile ? $row->user->profile->mobile_number : 'N/A';
                })
                ->addColumn('card_validity', function ($row) {
                    if ($row->expired_at) {
                        return $row->isExpired() 
                            ? '<span class="badge bg-danger">Expired</span>' 
                            : '<span class="badge bg-success">Valid until ' . $row->expired_at->format('M d, Y') . '</span>';
                    }
                    return '<span class="badge bg-warning">No expiry set</span>';
                })
                ->editColumn('approval_status', function ($row) {
                    $badges = [
                        'draft' => 'bg-secondary',
                        'verified' => 'bg-success',
                        'rejected' => 'bg-danger'
                    ];
                    $badge = $badges[$row->approval_status] ?? 'bg-secondary';
                    return '<span class="badge ' . $badge . '">' . ucfirst($row->approval_status) . '</span>';
                })
                ->editColumn('card_status', function ($row) {
                    $badges = [
                        'active' => 'bg-success',
                        'expired' => 'bg-warning',
                        'revoked' => 'bg-danger',
                        'lost' => 'bg-dark',
                        'reprinted' => 'bg-info'
                    ];
                    $badge = $badges[$row->card_status] ?? 'bg-secondary';
                    return '<span class="badge ' . $badge . '">' . ucfirst($row->card_status) . '</span>';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'name', 'approval_status', 'card_status', 'card_validity']);

            if ($request->input('search.value')) {
                Database::applyRelationalSearch($dataTable, $relationMappings);
            }

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request, $relationMappings) {
                    $sb = new SearchBuilder(
                        $request, 
                        $query,
                        [],
                        $relationMappings,
                    );
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('modules.service_cards.index');
    }

    public function create()
    {        
        $designations = Designation::whereNotIn('name', ['Minister', 'Secretary'])->get();
        $offices = Office::whereNotIn('name', ['Minister C&W', 'Secretary C&W'])->get();

        return view('modules.service_cards.create', compact('designations', 'offices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'remarks' => 'nullable|string|max:500'
        ]);
        
        // // Check for existing card again
        // $existingCard = ServiceCard::where('user_id', auth_user()->id)
        //     ->whereIn('approval_status', ['draft', 'verified'])
        //     ->first();
            
        // if ($existingCard) {
        //     return redirect()->route('admin.apps.service_cards.show', $existingCard)
        //         ->with('error', 'You already have a service card.');
        // }

        $serviceCard = ServiceCard::create([
            'uuid' => Str::uuid(),
            'user_id' => auth_user()->id,
            'approval_status' => 'draft',
            'card_status' => 'active',
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('admin.apps.service_cards.show', $serviceCard)
            ->with('success', 'Service card application created successfully.');
    }


    public function show(ServiceCard $ServiceCard)
    {
        $ServiceCard->load(['user.profile', 'user.currentDesignation', 'user.currentOffice']);
        return response()->json($ServiceCard);
    }

    public function verify(Request $request, ServiceCard $ServiceCard)
    {
        if ($ServiceCard->approval_status !== 'verified') {
            $ServiceCard->approval_status = 'verified';
            $ServiceCard->status_updated_at = now();
            $ServiceCard->status_updated_by = auth_user()->id;
            
            // Set issued and expiry dates if not already set
            if (!$ServiceCard->issued_at) {
                $ServiceCard->issued_at = now();
            }
            if (!$ServiceCard->expired_at) {
                $ServiceCard->expired_at = now()->addYear();
            }
            
            if ($ServiceCard->save()) {
                // Mail::to($ServiceCard->user->email)->queue(new VerifiedMail($ServiceCard));
                return response()->json(['success' => 'Service Card has been verified successfully.']);
            }
        }
        return response()->json(['error' => 'Service Card can\'t be verified.']);
    }

    public function restore(Request $request, ServiceCard $ServiceCard)
    {
        if ($ServiceCard->approval_status === 'rejected') {
            $ServiceCard->approval_status = 'draft';
            $ServiceCard->status_updated_at = now();
            $ServiceCard->status_updated_by = auth_user()->id;
            
            if ($ServiceCard->save()) {
                return response()->json(['success' => 'Service Card has been restored successfully.']);
            }
        }
        return response()->json(['error' => 'Service Card can\'t be restored.']);
    }

    public function reject(Request $request, ServiceCard $ServiceCard)
    {
        if (!in_array($ServiceCard->approval_status, ['verified', 'rejected'])) {
            $ServiceCard->approval_status = 'rejected';
            $ServiceCard->status_updated_at = now();
            $ServiceCard->status_updated_by = auth_user()->id;
            
            if ($ServiceCard->save()) {
                return response()->json(['success' => 'Service Card has been rejected.']);
            }
        }
        return response()->json(['error' => 'Service Card can\'t be rejected.']);
    }

    public function renew(Request $request, ServiceCard $ServiceCard)
    {
        if (!$ServiceCard->canBeRenewed()) {
            return response()->json(['error' => 'Service Card cannot be renewed at this time.']);
        }

        // Mark current card as expired
        $ServiceCard->card_status = 'expired';
        $ServiceCard->status_updated_at = now();
        $ServiceCard->status_updated_by = auth_user()->id;
        $ServiceCard->save();

        // Create new card
        $newCard = ServiceCard::create([
            'uuid' => Str::uuid(),
            'user_id' => $ServiceCard->user_id,
            'approval_status' => 'verified',
            'card_status' => 'active',
            'issued_at' => now(),
            'expired_at' => now()->addYear(),
            'status_updated_at' => now(),
            'status_updated_by' => auth_user()->id,
            'remarks' => 'Renewed from card #' . $ServiceCard->id,
        ]);
        
        // Mail::to($ServiceCard->user->email)->queue(new RenewedMail($newCard));

        return response()->json(['success' => 'Service Card has been renewed successfully.', 'new_card_id' => $newCard->id]);
    }

    public function showDetail(ServiceCard $ServiceCard)
    {
        if (!$ServiceCard) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Card Detail',
                ],
            ]);
        }

        $ServiceCard->load(['user.profile', 'user.currentDesignation', 'user.currentOffice']);

        $cat = [
            'designations' => Designation::where('status', 'Active')->get(),
            'offices' => Office::where('status', 'Active')->get(),
            'bps' => $this->getBpsRange(1, 20),
            'blood_groups' => ["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"]
        ];

        $html = view('modules.service_cards.partials.details', compact('ServiceCard', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function showCard(ServiceCard $ServiceCard)
    {
        if ($ServiceCard->approval_status !== 'verified') {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Service Card is not verified',
                ],
            ]);
        }

        $ServiceCard->load(['user.profile', 'user.currentDesignation', 'user.currentOffice']);

        $data = route('service_cards.verified', ['uuid' => $ServiceCard->uuid]);
        $qrCode = Builder::create()
            ->writer(new SvgWriter())
            ->data($data)
            ->encoding(new Encoding('UTF-8'))
            ->size(300)
            ->margin(1)
            ->build();

        $qrCodeUri = $qrCode->getDataUri();

        $html = view('modules.service_cards.partials.card', compact('ServiceCard', 'qrCodeUri'))->render();

        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, ServiceCard $ServiceCard)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        if (!$ServiceCard->canBeEdited()) {
            return response()->json(['error' => 'Verified or rejected cards cannot be updated'], 403);
        }

        // Check if field belongs to service card or user profile
        $serviceCardFields = ['remarks', 'issued_at', 'expired_at'];
        $userFields = ['name', 'email'];
        $profileFields = ['father_name', 'cnic', 'personnel_number', 'date_of_birth', 
                         'mobile_number', 'permanent_address', 'present_address', 
                         'blood_group', 'emergency_contact', 'mark_of_identification'];

        if (in_array($request->field, $serviceCardFields)) {
            $ServiceCard->{$request->field} = $request->value;
            if ($ServiceCard->isDirty($request->field)) {
                $ServiceCard->save();
                return response()->json(['success' => 'Field updated successfully'], 200);
            }
        } elseif (in_array($request->field, $userFields)) {
            $user = $ServiceCard->user;
            $user->{$request->field} = $request->value;
            if ($user->isDirty($request->field)) {
                $user->save();
                return response()->json(['success' => 'Field updated successfully'], 200);
            }
        } elseif (in_array($request->field, $profileFields)) {
            $profile = $ServiceCard->user->profile;
            if (!$profile) {
                $profile = $ServiceCard->user->profile()->create([]);
            }
            $profile->{$request->field} = $request->value;
            if ($profile->isDirty($request->field)) {
                $profile->save();
                return response()->json(['success' => 'Field updated successfully'], 200);
            }
        } else {
            return response()->json(['error' => 'Invalid field'], 400);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }

    public function uploadFile(Request $request, ServiceCard $ServiceCard)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:5000',
        ]);

        if (!$ServiceCard->canBeEdited()) {
            return response()->json(['error' => 'Verified or rejected cards cannot be updated'], 403);
        }

        try {
            $ServiceCard->addMedia($request->file('image'))
                ->toMediaCollection('service_card_pictures');

            return response()->json(['success' => 'Image uploaded successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error uploading file: ' . $e->getMessage()], 500);
        }
    }

    public function updateStatus(Request $request, ServiceCard $ServiceCard)
    {
        $request->validate([
            'card_status' => 'required|in:active,expired,revoked,lost,reprinted',
            'remarks' => 'nullable|string'
        ]);

        $ServiceCard->card_status = $request->card_status;
        $ServiceCard->status_updated_at = now();
        $ServiceCard->status_updated_by = auth_user()->id;
        
        if ($request->has('remarks')) {
            $existingRemarks = $ServiceCard->remarks ? $ServiceCard->remarks . "\n" : '';
            $ServiceCard->remarks = $existingRemarks . "[" . now()->format('Y-m-d H:i') . "] Status changed to {$request->card_status}: {$request->remarks}";
        }
        
        if ($ServiceCard->save()) {
            return response()->json(['success' => 'Card status updated successfully']);
        }
        
        return response()->json(['error' => 'Failed to update card status'], 500);
    }

    public function revoke(Request $request, ServiceCard $ServiceCard)
    {
        if ($ServiceCard->approval_status !== 'verified' || $ServiceCard->card_status !== 'active') {
            return response()->json(['error' => 'Only active verified cards can be revoked'], 400);
        }

        $request->validate([
            'reason' => 'required|string'
        ]);

        $ServiceCard->card_status = 'revoked';
        $ServiceCard->status_updated_at = now();
        $ServiceCard->status_updated_by = auth_user()->id;
        
        $existingRemarks = $ServiceCard->remarks ? $ServiceCard->remarks . "\n" : '';
        $ServiceCard->remarks = $existingRemarks . "[" . now()->format('Y-m-d H:i') . "] Revoked: {$request->reason}";
        
        if ($ServiceCard->save()) {
            // Optionally send notification email
            return response()->json(['success' => 'Service Card has been revoked']);
        }
        
        return response()->json(['error' => 'Failed to revoke card'], 500);
    }

    public function markLost(Request $request, ServiceCard $ServiceCard)
    {
        if ($ServiceCard->approval_status !== 'verified' || $ServiceCard->card_status !== 'active') {
            return response()->json(['error' => 'Only active verified cards can be marked as lost'], 400);
        }

        $ServiceCard->card_status = 'lost';
        $ServiceCard->status_updated_at = now();
        $ServiceCard->status_updated_by = auth_user()->id;
        
        $existingRemarks = $ServiceCard->remarks ? $ServiceCard->remarks . "\n" : '';
        $ServiceCard->remarks = $existingRemarks . "[" . now()->format('Y-m-d H:i') . "] Marked as lost";
        
        if ($ServiceCard->save()) {
            return response()->json(['success' => 'Service Card has been marked as lost']);
        }
        
        return response()->json(['error' => 'Failed to mark card as lost'], 500);
    }

    public function reprint(Request $request, ServiceCard $ServiceCard)
    {
        if ($ServiceCard->approval_status !== 'verified' || $ServiceCard->card_status !== 'lost') {
            return response()->json(['error' => 'Only lost cards can be reprinted'], 400);
        }

        $newCard = ServiceCard::create([
            'uuid' => Str::uuid(),
            'user_id' => $ServiceCard->user_id,
            'approval_status' => 'verified',
            'card_status' => 'active',
            'issued_at' => now(),
            'expired_at' => $ServiceCard->expired_at, // Keep same expiry
            'status_updated_at' => now(),
            'status_updated_by' => auth_user()->id,
            'is_duplicate' => true,
            'remarks' => 'Reprinted replacement for lost card #' . $ServiceCard->id,
        ]);

        $ServiceCard->card_status = 'reprinted';
        $ServiceCard->status_updated_at = now();
        $ServiceCard->status_updated_by = auth_user()->id;
        $ServiceCard->remarks = sprintf(
            "%s[%s] Reprinted as card #%d",
            $ServiceCard->remarks ? "$ServiceCard->remarks\n" : '',
            now()->format('Y-m-d H:i'),
            $newCard->id
        );
        $ServiceCard->save();

        return response()->json([
            'success' => 'Service Card has been reprinted',
            'new_card_id' => $newCard->id
        ]);
    }

    private function generateUsername($email)
    {
        $username = strstr($email, '@', true);

        $originalUsername = $username;
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $originalUsername . '-' . $counter;
            $counter++;
        }

        return $username;
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'father_name' => 'required|string|max:255',
            'cnic' => [
                'required',
                'string',
                'regex:/^[0-9]{5}-[0-9]{7}-[0-9]$/',
                'unique:user_profiles,cnic'
            ],
            'date_of_birth' => 'required|date|before:today',
            'mobile_number' => 'required|string',
            'personnel_number' => 'required|string|unique:user_profiles,personnel_number',
            'permanent_address' => 'required|string',
            'present_address' => 'required|string',
            'designation_id' => 'required|exists:designations,id',
            'office_id' => 'required|exists:offices,id',
            'blood_group' => 'nullable|string',
            'emergency_contact' => 'nullable|string',
            'mark_of_identification' => 'nullable|string',
            'profile_picture' => 'nullable|image|max:5120',
            'sanctioned_positions' => 'nullable|integer|min:1',
            'exceed_sanctioned' => 'nullable|boolean',
            'override_sanctioned_post' => 'nullable|boolean',
            'excess_justification' => 'nullable|string'
        ]);

        $currentUser = auth_user();
        
        // Verify the office is in user's domain
        $userOffices = collect([$currentUser->currentOffice]);
        if ($currentUser->currentOffice) {
            $childOffices = $currentUser->currentOffice->getAllDescendants();
            $userOffices = $userOffices->merge($childOffices);
        }
        
        if (!$userOffices->pluck('id')->contains($request->office_id)) {
            return response()->json([
                'type' => 'error',
                'message' => 'You can only create users in your office domain.']);
        }

        DB::beginTransaction();
        try {
            // Create user with basic info only
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'uuid' => Str::uuid(),
                'username' => $this->generateUsername($request->email),
                'password' => Hash::make(Str::random(16)),
                'password_updated_at' => now(),
                'status' => 'Active'
            ];
            
            $user = User::create($userData);

            // Create user profile
            $user->profile()->create([
                'father_name' => $request->father_name,
                'cnic' => $request->cnic,
                'date_of_birth' => $request->date_of_birth,
                'mobile_number' => $request->mobile_number,
                'personnel_number' => $request->personnel_number,
                'permanent_address' => $request->permanent_address,
                'present_address' => $request->present_address,
                'blood_group' => $request->blood_group,
                'emergency_contact' => $request->emergency_contact,
                'mark_of_identification' => $request->mark_of_identification,
            ]);

            // Handle profile picture
            if ($request->hasFile('profile_picture')) {
                $user->addMedia($request->file('profile_picture'))
                    ->toMediaCollection('profile_pictures');
            }

            // Check sanctioned post availability (unless overridden)
            if (!$request->has('override_sanctioned_post')) {
                $sanctionedPost = SanctionedPost::where('office_id', $request->office_id)
                    ->where('designation_id', $request->designation_id)
                    ->where('status', 'Active')
                    ->first();

                if (!$sanctionedPost) {
                    // Create new sanctioned post with specified positions
                    $positions = $request->sanctioned_positions ?? 1;
                    $sanctionedPost = SanctionedPost::create([
                        'office_id' => $request->office_id,
                        'designation_id' => $request->designation_id,
                        'total_positions' => $positions,
                        'status' => 'Active',
                        'created_by' => $currentUser->id
                    ]);
                } else {
                    // Use the existing isAvailableForPosting method
                    if (!$sanctionedPost->isAvailableForPosting('Appointment') && !$request->exceed_sanctioned) {
                        throw new \Exception('No vacancy available for this position. Please check the exceed sanctioned checkbox to proceed.');
                    }
                    
                    // If user explicitly wants to exceed sanctioned strength
                    if ($request->exceed_sanctioned && !$sanctionedPost->isAvailableForPosting('Appointment')) {
                        if (!$request->filled('excess_justification')) {
                            throw new \Exception('Justification is required when exceeding sanctioned strength.');
                        }
                        $sanctionedPost->increment('total_positions');
                    }
                }
            }

            // Create posting for the user
            $postingData = [
                'office_id' => $request->office_id,
                'designation_id' => $request->designation_id,
                'type' => 'Appointment',
                'start_date' => now(),
                'remarks' => 'Initial appointment via Service Card application by ' . $currentUser->name . 
                    ($request->filled('excess_justification') ? '. Justification: ' . $request->excess_justification : ''),
                'is_current' => true
            ];

            $user->postings()->create($postingData);

            // Create service card application
            $serviceCard = ServiceCard::create([
                'uuid' => Str::uuid(),
                'user_id' => $user->id,
                'approval_status' => 'draft',
                'card_status' => 'active',
                'remarks' => 'Applied by ' . $currentUser->name . ' (Focal Person)',
                'status_updated_by' => $currentUser->id,
                'status_updated_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'type' => 'success',
                'message' => 'User created and service card application submitted successfully.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'type' => 'error',
                'message' => 'Failed to create user: ' . $e->getMessage()
            ]);
        }
    }

    public function updateProfile(Request $request, User $user)
    {
        $request->validate([
            'father_name' => 'required|string|max:255',
            'cnic' => [
                'required',
                'string',
                'regex:/^[0-9]{5}-[0-9]{7}-[0-9]$/',
                'unique:user_profiles,cnic,' . $user->profile?->id
            ],
            'date_of_birth' => 'required|date|before:today',
            'mobile_number' => 'required|string',
            'personnel_number' => [
                'required',
                'string',
                'unique:user_profiles,personnel_number,' . $user->profile?->id
            ],
            'permanent_address' => 'required|string',
            'present_address' => 'required|string',
            'blood_group' => 'nullable|string',
            'emergency_contact' => 'nullable|string',
            'mark_of_identification' => 'nullable|string',
        ]);

        $currentUser = auth_user();
        
        // Verify the user is in current user's domain
        $userOffices = collect([$currentUser->currentOffice]);
        if ($currentUser->currentOffice) {
            $childOffices = $currentUser->currentOffice->getAllDescendants();
            $userOffices = $userOffices->merge($childOffices);
        }
        
        if (!$userOffices->pluck('id')->contains($user->currentOffice?->id)) {
            return response()->json([
                'success' => false,
                'message' => 'You can only update profiles of users in your office domain.'
            ], 403);
        }

        try {
            DB::beginTransaction();
            
            // Create or update profile
            if (!$user->profile) {
                $user->profile()->create($request->only([
                    'father_name', 'cnic', 'date_of_birth', 'mobile_number',
                    'personnel_number', 'permanent_address', 'present_address',
                    'blood_group', 'emergency_contact', 'mark_of_identification'
                ]));
            } else {
                $user->profile->update($request->only([
                    'father_name', 'cnic', 'date_of_birth', 'mobile_number',
                    'personnel_number', 'permanent_address', 'present_address',
                    'blood_group', 'emergency_contact', 'mark_of_identification'
                ]));
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'data' => $user->profile->fresh()
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile: ' . $e->getMessage()
            ], 500);
        }
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $forServiceCard = $request->get('for_service_card', false);
        
        if (strlen($query) < 3) {
            return response()->json([]);
        }
        
        $currentUser = auth_user();
        
        // Get user's office hierarchy for domain filtering
        $userOffices = collect([$currentUser->currentOffice]);
        if ($currentUser->currentOffice) {
            $childOffices = $currentUser->currentOffice->getAllDescendants();
            $userOffices = $userOffices->merge($childOffices);
        }
        $officeIds = $userOffices->pluck('id')->toArray();
        
        $users = User::with([
            'profile', 
            'currentDesignation', 
            'currentOffice',
            'serviceCards' => function($q) {
                $q->whereIn('approval_status', ['draft', 'verified'])
                ->orderBy('created_at', 'desc');
            }
        ])
        ->where(function ($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhereHas('profile', function ($profile) use ($query) {
                $profile->where('cnic', 'like', "%{$query}%")
                        ->orWhere('personnel_number', 'like', "%{$query}%");
            })
            ->orWhereHas('currentDesignation', function ($designation) use ($query) {
                $designation->where('name', 'like', "%{$query}%");
            })
            ->orWhereHas('currentOffice', function ($office) use ($query) {
                $office->where('name', 'like', "%{$query}%");
            });
        })
        ->limit(10)
        ->get();
        
        $result = $users->map(function ($user) use ($officeIds, $forServiceCard) {
            $isSubordinate = in_array($user->currentOffice?->id, $officeIds);
            $hasServiceCard = $user->serviceCards->isNotEmpty();
            
            $data = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'designation' => $user->currentDesignation?->name,
                'office' => $user->currentOffice?->name,
                'cnic' => $user->profile?->cnic,
                'personnel_number' => $user->profile?->personnel_number,
                'profile_picture' => getProfilePic($user),
                'is_subordinate' => $isSubordinate,
                'has_service_card' => $hasServiceCard,
                'can_renew' => $hasServiceCard && $user->serviceCards->first()?->canBeRenewed(),
            ];
            
            // Add profile data for service card applications
            if ($forServiceCard) {
                $data['profile'] = $user->profile ? [
                    'father_name' => $user->profile->father_name,
                    'cnic' => $user->profile->cnic,
                    'date_of_birth' => $user->profile->date_of_birth,
                    'mobile_number' => $user->profile->mobile_number,
                    'personnel_number' => $user->profile->personnel_number,
                    'permanent_address' => $user->profile->permanent_address,
                    'present_address' => $user->profile->present_address,
                    'blood_group' => $user->profile->blood_group,
                    'emergency_contact' => $user->profile->emergency_contact,
                    'mark_of_identification' => $user->profile->mark_of_identification,
                ] : null;
            }
            
            return $data;
        });
        
        return response()->json($result);
    }
}