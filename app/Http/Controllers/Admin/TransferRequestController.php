<?php

namespace App\Http\Controllers\Admin;

use App\Models\Office;
use App\Helpers\Database;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Helpers\SearchBuilder;
use App\Models\TransferRequest;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransferRequestRequest;

class TransferRequestController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $transfer_requests = TransferRequest::query();

        $transfer_requests->when($status !== null, function ($query) use ($status) {
            $query->where('status', $status);
        });

        $relationMappings = [
            'user' => 'user.currentPosting.designation.name'
        ];

        if ($request->ajax()) {
            $dataTable = Datatables::of($transfer_requests)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.transfer_requests.partials.buttons', compact('row'))->render();
                })
                ->addColumn('user', function ($row) {
                    return $row->user->name;
                })
                ->addColumn('current_office', function ($row) {
                    return $row->user?->currentOffice?->name ?? null;
                })
                ->addColumn('current_designation', function ($row) {
                    return $row->user?->currentDesignation?->name ?? null;
                })
                ->addColumn('requested_office', function ($row) {
                    return $row->toOffice->name;
                })
                ->addColumn('requested_designation', function ($row) {
                    return $row->toDesignation->name;
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'user']);

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

        return view('admin.transfer_requests.index');
    }

    public function create()
    {
        $designations = Designation::whereNotIn('name', ['Minister', 'Secretary'])->get();
        $offices = Office::whereNotIn('name', ['Minister C&W', 'Secretary C&W'])->get();
        $html = view('admin.transfer_requests.partials.create', compact('designations','offices'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function store(StoreTransferRequestRequest $request)
    {
        dd($request);
        $transfer_request = new TransferRequest();
        $currentUser = request()->user();
        $transfer_request->user_id = $currentUser->id;
        $transfer_request->type = $request->type ?? 'Already Transferred';
        $transfer_request->from_office_id = $currentUser?->currentOffice?->id ?? null;
        $transfer_request->from_designation_id = $currentUser?->currentDesignation?->id ?? null;
        $transfer_request->to_office_id = $request->to_office_id;
        $transfer_request->to_designation_id = $request->to_designation_id;
        $transfer_request->posting_date = $request->posting_date;
        $transfer_request->remarks = $request->remarks;

        if($currentUser->transferRequests()->latest()->first()?->status === 'Pending') {
            return response()->json(['error' => 'You have already posted request. Please wait...']);
        }

        if($currentUser->transferRequests()->latest()->first()?->status === 'Rejected') {
            return response()->json(['error' => 'Your previous request is rejected. Kindly contact IT Cell...']);
        }

        if ($transfer_request->save()) {
            return response()->json(['success' => 'Transfer Request added successfully.']);
        }

        return response()->json(['error' => 'Failed to add Transfer Request.'], 500);
    }

    public function review(Request $request, TransferRequest $transfer_request)
    {
        $transfer_request->status = 'Under Review';
        if ($transfer_request->save()) {
            return response()->json(['success' => 'Transfer request has been placed Under review.'], 200);
        }
        return response()->json(['error' => 'Failed to placed the transfer request under review']);
    }

    public function approve(Request $request, TransferRequest $transfer_request)
    {
        $transfer_request->status = 'Approved';
        if ($transfer_request->save()) {
            $transfer_request->approved();
            return response()->json(['success' => 'Transfer request has been approved.'], 200);
        }
        return response()->json(['error' => 'Failed to approve the transfer request']);
    }

    public function reject(Request $request, TransferRequest $transfer_request)
    {
        $transfer_request->status = 'Rejected';
        if ($transfer_request->save()) {
            return response()->json(['success' => 'Transfer request has been rejected.'], 200);
        }
        return response()->json(['error' => 'Failed to reject the transfer request']);
    }

    public function show(TransferRequest $transfer_requests)
    {
        return response()->json($transfer_requests);
    }

    public function destroy(TransferRequest $transfer_request)
    {
        if (request()->user()->isAdmin() && $transfer_request->delete()) {
            return response()->json(['success' => 'TransferRequest has been deleted successfully.']);
        }

        return response()->json(['error' => 'Transfer request cannot be deleted.']);
    }
}
