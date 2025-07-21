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
}