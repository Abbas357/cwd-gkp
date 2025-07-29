<?php

namespace App\Http\Controllers\ServiceCard;

use App\Models\User;
use App\Models\ServiceCard;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SanctionedPost;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ServiceCardUserController extends Controller
{
    public function updateField(Request $request, ServiceCard $ServiceCard)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        if (!$ServiceCard->canBeEdited()) {
            return response()->json(['error' => 'Verified or rejected cards cannot be updated']);
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
                return response()->json(['success' => 'Field updated successfully']);
            }
        } elseif (in_array($request->field, $userFields)) {
            $user = $ServiceCard->user;
            $user->{$request->field} = $request->value;
            if ($user->isDirty($request->field)) {
                $user->save();
                return response()->json(['success' => 'Field updated successfully']);
            }
        } elseif (in_array($request->field, $profileFields)) {
            $profile = $ServiceCard->user->profile;
            if (!$profile) {
                $profile = $ServiceCard->user->profile()->create([]);
            }
            $profile->{$request->field} = $request->value;
            if ($profile->isDirty($request->field)) {
                $profile->save();
                return response()->json(['success' => 'Field updated successfully']);
            }
        } else {
            return response()->json(['error' => 'Invalid field'], 400);
        }

        return response()->json(['error' => 'No changes were made to the field']);
    }

    public function uploadFile(Request $request, ServiceCard $ServiceCard)
    {
        $request->validate([
            'attachment' => 'required',
            'collection_name' => 'required|string|in:profile_pictures,users_cnic_front,users_cnic_back,covering_letters,payslips',
        ]);
        if (!$ServiceCard->canBeEdited()) {
            return response()->json(['error' => 'Verified or rejected cards cannot be updated']);
        }

        $file = $request->file('attachment');
        $collection = $request->input('collection_name');

        $modalToUpdate = in_array($collection, ['profile_pictures', 'users_cnic_front', 'users_cnic_back']) 
            ? $ServiceCard->user 
            : $ServiceCard;

        try {
            $modalToUpdate->addMedia($file)
                ->toMediaCollection($collection);

            return response()->json(['success' => 'Image uploaded successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error uploading file: ' . $e->getMessage()]);
        }
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

            ServiceCard::create([
                'uuid' => Str::uuid(),
                'user_id' => $user->id,
                'posting_id' => auth_user()->currentPosting->id,
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
        
        $userOffices = collect([$currentUser->currentOffice]);
        if ($currentUser->currentOffice) {
            $childOffices = $currentUser->currentOffice->getAllDescendants();
            $userOffices = $userOffices->merge($childOffices);
        }
        
        if (!$userOffices->pluck('id')->contains($user->currentOffice?->id)) {
            return response()->json([
                'success' => false,
                'message' => 'You can only update profiles of users in your office domain.'
            ]);
        }

        try {
            DB::beginTransaction();
            
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
            ]);
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
                $q->orderBy('created_at', 'desc');
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
