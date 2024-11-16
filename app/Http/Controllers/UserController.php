<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

use App\Mail\User\RenewedMail;
use App\Mail\User\RejectedMail;
use App\Mail\User\VerifiedMail;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use Endroid\QrCode\Builder\Builder;

use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Endroid\QrCode\Encoding\Encoding;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $active = $request->query('active', null);

        $users = User::query()->withoutGlobalScope('active');

        $users->when($active !== null, function ($query) use ($active) {
            $query->where('is_active', $active);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.users.partials.buttons', compact('row'))->render();
                })
                ->editColumn('name', function ($row) {
                    return '<div style="display: flex; align-items: center;"><img style="width: 30px; height: 30px; border-radius: 50%;" src="' . getProfilePic($row) . '" /> <span> &nbsp; ' . $row->name . '</span></div>';
                })
                ->editColumn('is_active', function ($row) {
                    return $row->is_active == 1 ? 'Yes' : 'No';
                })
                ->editColumn('password_updated_at', function ($row) {
                    return $row->password_updated_at ? $row->password_updated_at->diffForHumans() : 'Not Updated Yet';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'name']);

            // if (!$request->input('search.value') && $request->has('searchBuilder')) {
            //     $dataTable->filter(function ($query) use ($request) {
            //         $sb = new \App\SearchBuilder($request, $query);
            //         $sb->build();
            //     });
            // }

            return $dataTable->toJson();
        }

        return view('admin.users.index');
    }

    public function cards(Request $request)
    {
        $status = $request->query('status', null);

        $users = User::query()->withoutGlobalScope('active')->whereNotNull('card_status');

        $users->when($status !== null, function ($query) use ($status) {
            $query->where('card_status', $status);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.users.partials.card-buttons', compact('row'))->render();
                })
                ->editColumn('name', function ($row) {
                    return '<div style="display: flex; align-items: center;"><img style="width: 30px; height: 30px; border-radius: 50%;" src="' . getProfilePic($row) . '" /> <span> &nbsp; ' . $row->name . '</span></div>';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'name']);

            // if (!$request->input('search.value') && $request->has('searchBuilder')) {
            //     $dataTable->filter(function ($query) use ($request) {
            //         $sb = new \App\SearchBuilder($request, $query);
            //         $sb->build();
            //     });
            // }

            return $dataTable->toJson();
        }

        return view('admin.users.cards');
    }

    public function users(Request $request)
    {
        $search = $request->get('q');
        $users = User::where('position', 'LIKE', "%{$search}%")
            ->select('id', 'position')
            ->paginate(10);

        return response()->json([
            'items' => $users->items(),
            'pagination' => [
                'more' => $users->hasMorePages()
            ]
        ]);
    }

    public function create()
    {
        $bps = [];
        for ($i = 1; $i <= 22; $i++) {
            $bps[] = sprintf("BPS-%02d", $i);
        }

        $cat = [
            'designations' => Category::where('type', 'designation')->get(),
            'positions' => Category::where('type', 'position')->get(),
            'offices' => Category::where('type', 'office')->get(),
            'bps' => $bps,
        ];
        return view('admin.users.create', compact('cat'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username ?? $this->generateUsername($request->email);
        $user->password = bcrypt($request->password);

        $user->designation = $request->designation;
        $user->position = $request->position;
        $user->office = $request->office;
        $user->title = $request->title ?? null;
        $user->bps = $request->bps ?? null;

        $user->mobile_number = $request->mobile_number ?? null;
        $user->landline_number = $request->landline_number ?? null;
        $user->cnic = $request->cnic ?? null;
        $user->posting_type = $request->posting_type ?? null;
        $user->posting_date = $request->posting_date ?? null;
        $user->exit_type = $request->exit_type ?? null;
        $user->exit_date = $request->exit_date ?? null;
        $user->message = $request->message ?? null;
        $user->facebook = $request->facebook ?? null;
        $user->whatsapp = $request->whatsapp ?? null;
        $user->twitter = $request->twitter ?? null;

        if ($request->hasFile('image')) {
            $user->addMedia($request->file('image'))
                ->toMediaCollection('profile_pictures');
        }

        if ($request->hasFile('posting_order')) {
            $user->addMedia($request->file('posting_order'))
                ->toMediaCollection('posting_orders');
        }

        if ($request->hasFile('exit_order')) {
            $user->addMedia($request->file('exit_order'))
                ->toMediaCollection('exit_orders');
        }

        if ($user->save()) {
            Cache::forget('message_partial');
            Cache::forget('team_partial');
            return redirect()->route('admin.users.create')->with('success', 'User added successfully');
        }

        return redirect()->route('admin.users.create')->with('danger', 'Error submitting the user');
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function activateUser(Request $request, $userId)
    {
        $user = User::withoutGlobalScope('active')->findOrFail($userId);
        if ($user->is_active ===  0) {
            $user->is_active = 1;    
            $message = 'User has been Activated successfully.';
        } else {
            $user->is_active = 0;
            $message = 'User has been Deactivate.';
        }
        Cache::forget('message_partial');
        Cache::forget('team_partial');
        $user->save();
        return response()->json(['success' => $message], 200);
    }

    public function edit($userId)
    {
        $user = User::withoutGlobalScope('active')->findOrFail($userId);
        if (!$user) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'The user does not exists in Database',
                ],
            ]);
        }

        $data = [
            'user' => $user,
            'roles' => $user->roles,
            'permissions' => $user->getDirectPermissions(),
            'allRoles' => Role::all(),
            'allPermissions' => Permission::all(),
            'allDesignations' => Category::where('type', 'designation')->get(),
            'allPositions' => Category::where('type', 'position')->get(),
            'allOffices' => Category::where('type', 'office')->get(),
            'bps' => Category::where('type', 'bps')->get(),
        ];

        $html = view('admin.users.partials.edit', compact('data'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function update(UpdateUserRequest $request, $userId)
    {
        $user = User::withoutGlobalScope('active')->findOrFail($userId);
        $validated = $request->validated();
        $user->fill(array_filter($validated, function ($value) {
            return $value !== null;
        }));

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('image')) {
            $user->addMedia($request->file('image'))
                ->toMediaCollection('profile_pictures');
        }

        if ($request->hasFile('posting_order')) {
            $user->addMedia($request->file('posting_order'))
                ->toMediaCollection('posting_orders');
        }

        if ($request->hasFile('exit_order')) {
            $user->addMedia($request->file('exit_order'))
                ->toMediaCollection('exit_orders');
        }

        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        if ($request->has('permissions')) {
            $user->syncPermissions($request->permissions);
        }

        if ($user->save()) {
            Cache::forget('message_partial');
            Cache::forget('team_partial');
            return response()->json(['success' => 'User updated']);
        }
        return response()->json(['error' => 'User updation failed']);
    }

    public function destroy(User $user)
    {
        if ($user->delete()) {
            Cache::forget('message_partial');
            Cache::forget('team_partial');
            return response()->json(['success' => 'User has been deleted successfully.']);
        }

        return response()->json(['error' => 'User can\'t be deleted.']);
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

    public function assignBoss(Request $request)
    {
        $user = User::find($request->input('user_id'));
        $boss = User::find($request->input('boss_id'));

        $user->boss()->sync([$boss->id]);

        return redirect()->back()->with('success', 'Boss assigned successfully.');

        // $boss = $user->boss->first();
        // $subordinates = $user->subordinates;
    }

    public function verify(Request $request, $userId)
    {
        $user = User::withoutGlobalScope('active')->findOrFail($userId);
        if ($user->card_status !== 'verified') {
            $user->card_status = 'verified';
            $user->card_issue_date = Carbon::now();
            $user->card_expiry_date = Carbon::now()->addYears(3);
            if($user->save()) {
                Mail::to($user->email)->queue(new VerifiedMail($user));
                return response()->json(['success' => 'User has been verified successfully.']);
            }
        }
        return response()->json(['error' => 'User can\'t be verified.']);
    }

    public function restore(Request $request, $userId)
    {
        $user = User::withoutGlobalScope('active')->findOrFail($userId);
        if ($user->card_status === 'rejected') {
            $user->card_status = 'new';
            if($user->save()) {
                return response()->json(['success' => 'User has been restored successfully.']);
            }
        }
        return response()->json(['error' => 'User can\'t be restored.']);
    }

    public function reject(Request $request, $userId)
    {
        $user = User::withoutGlobalScope('active')->findOrFail($userId);
        if (!in_array($user->card_status, ['verified', 'rejected'])) {
            $user->card_status = 'rejected';
            $user->rejection_reason = $request->reason;

            if($user->save()) {
                Mail::to($user->email)->queue(new RejectedMail($user, $request->reason));
                return response()->json(['success' => 'User has been rejected.']);
            }
        }
        return response()->json(['error' => 'User can\'t be rejected.']);
    }

    public function renew(Request $request, $userId)
    {
        $user = User::withoutGlobalScope('active')->findOrFail($userId);
        $currentDate = Carbon::now();

        if ($user->card_status === 'verified') {
            if ($currentDate->greaterThanOrEqualTo($user->card_expiry_date)) {
                $user->card_issue_date = $request->issue_date ?? $currentDate;
                $user->card_expiry_date = Carbon::parse($user->card_issue_date)->addYears(3);

                if ($user->save()) {
                    Mail::to($user->email)->queue(new RenewedMail($user));
                    return response()->json(['success' => 'User card has been renewed successfully.']);
                } else {
                    return response()->json(['error' => 'An error occurred while saving the user card data. Please try again.']);
                }
            } else {
                return response()->json(['error' => 'User card cannot be renewed because it has not yet expired.']);
            }
        } else {
            return response()->json(['error' => 'User card status does not allow renewal.']);
        }
    }

    public function showDetail($userId)
    {
        $user = User::withoutGlobalScope('active')->findOrFail($userId);
        if (!$user) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load User Detail',
                ],
            ]);
        }

        $cat = [
                'designations' => Category::where('type', 'designation')->get(),
                'positions' => Category::where('type', 'position')->get(),
                'offices' => Category::where('type', 'office')->get(),
                'bps' => Category::where('type', 'bps')->get(),
                'blood_groups' => ["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"
            ]
        ];

        $html = view('admin.users.partials.card-details', compact('user', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function showCard($userId)
    {
        $user = User::withoutGlobalScope('active')->findOrFail($userId);
        if ($user->card_status !== 'verified') {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'The User is not verified',
                ],
            ]);
        }
        $data = route('card.verified', ['id' => $user->id]);
        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data($data)
            ->encoding(new Encoding('UTF-8'))
            ->size(300)
            ->margin(1)
            ->build();

        $qrCodeUri = $qrCode->getDataUri();

        $html = view('admin.users.partials.card', compact('user', 'qrCodeUri'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
            'id'    => 'required|integer|exists:users,id',
        ]);

        $user = User::withoutGlobalScope('active')->findOrFail($request->id);

        if (in_array($user->cart_status, ['verified', 'rejected'])) {
            return response()->json(['error' => 'Verified or Rejected user cannot be updated'], 403);
        }

        $user->{$request->field} = $request->value;

        if ($user->isDirty($request->field)) {
            $user->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'id'   => 'required|integer|exists:users,id',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:5000', 
        ]);

        $user = User::withoutGlobalScope('active')->findOrFail($request->id);

        if (in_array($user->cart_status, ['verified', 'rejected'])) {
            return response()->json(['error' => 'Verified or Rejected user cannot be updated'], 403); 
        }

        try {
            $user->addMedia($request->file('image'))
                ->toMediaCollection('profile_pictures');

            return response()->json(['success' => 'File uploaded successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error uploading file: ' . $e->getMessage()], 500);
        }
    }
}
