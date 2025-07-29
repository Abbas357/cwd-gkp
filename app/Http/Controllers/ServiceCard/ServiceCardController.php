<?php
namespace App\Http\Controllers\ServiceCard;
use App\Models\Office;
use App\Helpers\Database;
use App\Models\Designation;
use App\Models\ServiceCard;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\SearchBuilder;
use Yajra\DataTables\DataTables;
use Endroid\QrCode\Builder\Builder;
use App\Http\Controllers\Controller;
use Endroid\QrCode\Writer\SvgWriter;
use Endroid\QrCode\Encoding\Encoding;

class ServiceCardController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);
        $needs_renewal = $request->query('needs_renewal', null);
        $printed = $request->query('printed', null);
        $user = auth_user();

        $service_cards = ServiceCard::with(['user.profile', 'user.currentDesignation', 'user.currentOffice']);

        $service_cards->when(
            !$user->isAdmin() && !$user->can('viewAny', ServiceCard::class),
            function ($query) use ($user) {
                return $query->where('posting_id', $user->currentPosting->id);
            }
        );

        $service_cards->when($status !== null, function ($query) use ($status) {
            $query->where('status', $status);
        });

        $service_cards->when($needs_renewal === 'true', function ($query) {
            $query->where(function($q) {
                $q->where('status', 'expired')
                  ->orWhere('expired_at', '<', now());
            });
        });

        $service_cards->when($printed === 'true', function ($query) {
            $query->whereNotNull('printed_at');
        });

        $relationMappings = [
            'designation_id' => 'user.currentDesignation.name',
            'office_id' => 'user.currentOffice.name',
            'name' => 'user.name',
            'email' => 'user.email',
            'cnic' => 'user.profile.cnic',
            'mobile_number' => 'user.profile.mobile_number',
        ];

        if ($response = $this->getTabCounts($request, fn() => [
            'draft' => (clone $service_cards)->where('status', 'draft')->count(),
            'pending' => (clone $service_cards)->where('status', 'pending')->count(),
            'active' => (clone $service_cards)->where('status', 'active')->count(),
            'rejected' => (clone $service_cards)->where('status', 'rejected')->count(),
            'printed' => (clone $service_cards)->whereNotNull('printed_at')->count(),
            'expired' => (clone $service_cards)->where('status', 'expired')->count(),
            'needs_renewal' => (clone $service_cards)->where(function($q) {
                $q->where('status', 'expired')
                ->orWhere('expired_at', '<', now());
            })->count(),
            'lost' => (clone $service_cards)->where('status', 'lost')->count(),
            'duplicate' => (clone $service_cards)->where('status', 'duplicate')->count(),
        ])) {
            return $response;
        }

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
                ->editColumn('status', function ($row) {
                    $badges = [
                        'draft' => 'bg-secondary',
                        'pending' => 'bg-info',
                        'rejected' => 'bg-danger',
                        'active' => 'bg-success',
                        'printed' => 'bg-primary',
                        'expired' => 'bg-warning',
                        'lost' => 'bg-danger',
                        'duplicate' => 'bg-dark'
                    ];
                    $badge = $badges[$row->status] ?? 'bg-secondary';
                    return '<span class="badge ' . $badge . '">' . ucfirst($row->status) . '</span>';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'name', 'status', 'status', 'card_validity']);

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
        $currentBPS = auth_user()->currentDesignation->bps;
        
        $designations = Designation::where('bps', '<=', $currentBPS)->get();
        $offices = Office::all();

        return view('modules.service_cards.create', compact('designations', 'offices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'remarks' => 'nullable|string|max:500'
        ]);
        $timestamp = now()->format('j, F Y') . ' at ' . now()->format('h:i A');
        $userInfo = auth_user() ? " by " . auth_user()->name : "";
        $serviceCard = ServiceCard::create([
            'uuid' => Str::uuid(),
            'user_id' => $request->user_id,
            'posting_id' => auth_user()->currentPosting->id,
            'remarks' => "1. General Remarks: <strong>Card is created. It will be placed under review very soon. Thanks</strong> - <span style='color: #aaa; font-size: 12px'>{$timestamp}{$userInfo}</span>",
        ]);

        return redirect()->route('admin.apps.service_cards.index', $serviceCard)
            ->with('success', 'Service card application created successfully.');
    }


    public function show(ServiceCard $ServiceCard)
    {
        $ServiceCard->load(['user.profile', 'user.currentDesignation', 'user.currentOffice']);
        return response()->json($ServiceCard);
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

    public function showRemarks(ServiceCard $ServiceCard)
    {
        if (!$ServiceCard) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to Card Remarks',
                ],
            ]);
        }

        $html = view('modules.service_cards.partials.info', ['remarks' => $ServiceCard->remarks])->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function viewCard(ServiceCard $ServiceCard)
    {
        if (!in_array($ServiceCard->status, ['active', 'duplicate'])) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Service Card is not active',
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

    public function destroy(ServiceCard $ServiceCard)
    {
        if ($ServiceCard->delete()) {
            return response()->json(['success' => 'Card has been deleted successfully.']);
        }

        return response()->json(['error' => 'Card cannot be deleted.']);
    }
}