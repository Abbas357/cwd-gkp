<?php

namespace App\Http\Controllers\ProvincialOwnReceipt;

use Carbon\Carbon;
use App\Models\User;
use App\Models\District;
use App\Helpers\Database;
use Illuminate\Http\Request;
use App\Helpers\SearchBuilder;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ProvincialOwnReceipt;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProvincialOwnReceiptRequest;

class ProvincialOwnReceiptController extends Controller
{
    public function all(Request $request)
    {
        $type = $request->query('type', null);

        $receipts = ProvincialOwnReceipt::query();

        $receipts->when($type !== null, function ($query) use ($type) {
            $query->where('type', $type);
        });

        $relationMappings = [
            'district' => 'district.name',
        ];

        if ($request->ajax()) {
            $dataTable = Datatables::of($receipts)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('modules.porms.partials.buttons', compact('row'))->render();
                })
                ->addColumn('district', function ($row) {
                    return $row->district->name;
                })
                ->editColumn('month', function ($row) {
                    return $row->month->format('F Y');
                })
                ->editColumn('amount', function ($row) {
                    return number_format($row->amount, 2);
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action']);

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

        return view('modules.porms.index');
    }

    public function create()
    {
        $cat = [
            'receipt_type' => ['tender'],
            'districts' => District::all(),
        ];

        $html = view('modules.porms.partials.create', compact('cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function index()
    {
        $totalAmount = ProvincialOwnReceipt::sum('amount');

        $totalDistricts = ProvincialOwnReceipt::distinct('district_id')->count('district_id');
        $totalTypes = ProvincialOwnReceipt::distinct('type')->count('type');

        // Get receipts by type
        $receiptsByType = ProvincialOwnReceipt::select('type', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('type')
            ->orderBy('total_amount', 'desc')
            ->get();

        // Get receipts by district with district names
        $receiptsByDistrict = ProvincialOwnReceipt::select(
            'provincial_own_receipts.district_id',
            'districts.name as district_name',
            DB::raw('SUM(provincial_own_receipts.amount) as total_amount')
        )
            ->join('districts', 'provincial_own_receipts.district_id', '=', 'districts.id')
            ->groupBy('provincial_own_receipts.district_id', 'districts.name')
            ->orderBy('total_amount', 'desc')
            ->get();

        // Get monthly trend for the last 12 months
        $monthlyTrend = ProvincialOwnReceipt::select(
            DB::raw('DATE_FORMAT(month, "%Y-%m") as month_date'),
            DB::raw('DATE_FORMAT(month, "%b %Y") as month_label'),
            DB::raw('SUM(amount) as total_amount')
        )
            ->where('month', '>=', Carbon::now()->subMonths(12))
            ->groupBy('month_date', 'month_label')
            ->orderBy('month_date')
            ->get();

        // Get district and type breakdown
        $districtTypeBreakdown = ProvincialOwnReceipt::select(
            'provincial_own_receipts.district_id',
            'districts.name as district_name',
            'provincial_own_receipts.type',
            DB::raw('SUM(provincial_own_receipts.amount) as total_amount'),
            DB::raw('COUNT(*) as entry_count')
        )
            ->join('districts', 'provincial_own_receipts.district_id', '=', 'districts.id')
            ->groupBy('provincial_own_receipts.district_id', 'districts.name', 'provincial_own_receipts.type')
            ->orderBy('total_amount', 'desc')
            ->get();

        return view('modules.porms.dashboard', compact(
            'totalAmount',
            'totalDistricts',
            'totalTypes',
            'receiptsByType',
            'receiptsByDistrict',
            'monthlyTrend',
            'districtTypeBreakdown'
        ));
    }

    public function store(StoreProvincialOwnReceiptRequest $request)
    {
        $receipt = new ProvincialOwnReceipt();
        $receipt->month = $request->month;
        $receipt->ddo_code = $request->ddo_code;
        $receipt->district_id = $request->district_id;
        $receipt->type = $request->type;
        $receipt->amount = $request->amount;
        $receipt->remarks = $request->remarks;
        $receipt->user_id = Auth::id();

        if ($receipt->save()) {
            return response()->json(['success' => 'Receipt added successfully'], 200);
        }

        return response()->json(['error' => 'There was an error adding the receipt'], 500);
    }

    public function show(ProvincialOwnReceipt $ProvincialOwnReceipt)
    {
        return response()->json($ProvincialOwnReceipt);
    }

    public function report(Request $request)
    {
        $districts = District::all();
        $users = User::all();
        $ddoCodes = ProvincialOwnReceipt::distinct('ddo_code')->pluck('ddo_code');
        $receiptTypes = ProvincialOwnReceipt::distinct('type')->pluck('type');

        $filters = [
            'user_id' => null,
            'district_id' => null,
            'ddo_code' => null,
            'type' => null,
            'start_month' => null,
            'end_month' => null
        ];

        $filters = array_merge($filters, $request->only(array_keys($filters)));

        $query = ProvincialOwnReceipt::query()
            ->with(['district', 'user']);

        if ($filters['user_id']) {
            $query->where('user_id', $filters['user_id']);
        }

        if ($filters['district_id']) {
            $query->where('district_id', $filters['district_id']);
        }

        if ($filters['ddo_code']) {
            $query->where('ddo_code', $filters['ddo_code']);
        }

        if ($filters['type']) {
            $query->where('type', $filters['type']);
        }

        if ($filters['start_month']) {
            $query->where('month', '>=', $filters['start_month'] . '-01');
        }

        if ($filters['end_month']) {
            $lastDay = Carbon::parse($filters['end_month'] . '-01')->endOfMonth()->format('Y-m-d');
            $query->where('month', '<=', $lastDay);
        }

        $receipts = $query->latest()->get();

        $receiptSummaryByType = [];
        $receiptSummaryByDistrict = [];

        if ($receipts->count() > 0) {
            $receiptSummaryByType = $receipts->groupBy('type')
                ->map(function ($group) {
                    return $group->sum('amount');
                });

            $receiptSummaryByDistrict = $receipts->groupBy(function ($receipt) {
                return $receipt->district->name ?? 'Unknown';
            })->map(function ($group) {
                return $group->sum('amount');
            });
        }

        return view('modules.porms.reports', compact(
            'districts',
            'ddoCodes',
            'receiptTypes',
            'receipts',
            'filters',
            'receiptSummaryByType',
            'receiptSummaryByDistrict'
        ));
    }

    public function showDetail(ProvincialOwnReceipt $ProvincialOwnReceipt)
    {
        if (!$ProvincialOwnReceipt) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Receipt Detail',
                ],
            ]);
        }

        $cat = [
            'receipt_type' => ['tender'],
            'districts' => District::all(),
        ];

        $html = view('modules.porms.partials.detail', compact('ProvincialOwnReceipt', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, ProvincialOwnReceipt $ProvincialOwnReceipt)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        $ProvincialOwnReceipt->{$request->field} = $request->value;

        if ($ProvincialOwnReceipt->isDirty($request->field)) {
            $ProvincialOwnReceipt->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }

    public function edit(ProvincialOwnReceipt $ProvincialOwnReceipt)
    {
        $cat = [
            'receipt_type' => ['tender'],
            'districts' => District::all(),
        ];

        $html = view('modules.porms.partials.edit', compact('provincialOwnReceipt', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function destroy(ProvincialOwnReceipt $ProvincialOwnReceipt)
    {

        if (auth_user()->isAdmin() && $ProvincialOwnReceipt->delete()) {
            return response()->json(['success' => 'Receipt has been deleted successfully.']);
        }

        return response()->json(['error' => 'You do not have permission to delete this receipt.']);
    }
}
