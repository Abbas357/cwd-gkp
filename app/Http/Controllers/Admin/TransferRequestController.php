<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Database;
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
        $type = $request->query('type', null);

        $transfer_requests = TransferRequest::query();

        $transfer_requests->when($type !== null, function ($query) use ($type) {
            $query->where('type', $type);
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
                    return $row->user->currentOffice->name;
                })
                ->addColumn('current_designation', function ($row) {
                    return $row->user->currentDesignation->name;
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
        $html = view('admin.transfer_requests.partials.create')->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function store(StoreTransferRequestRequest $request)
    {
            $transfer_requests = new TransferRequest();
            $transfer_requests->title = $request->title;
            $transfer_requests->description = $request->description;
            $transfer_requests->date_of_advertisement = $request->date_of_advertisement;
            $transfer_requests->closing_date = $request->closing_date;
            $transfer_requests->user_id = $request->user ?? 0;

            if (!$transfer_requests->save()) {
                return response()->json(['error' => 'Failed to add Transfer Request.'], 500);
            }

            return response()->json(['success' => 'Transfer Request added successfully.']);
    }

    public function show(TransferRequest $transfer_requests)
    {
        return response()->json($transfer_requests);
    }

    public function destroy(TransferRequest $transfer_requests)
    {
        if (request()->user()->isAdmin() || $transfer_requests->delete()) {
            return response()->json(['success' => 'TransferRequest has been deleted successfully.']);
        }

        return response()->json(['error' => 'Transfer request cannot be deleted.']);
    }
}
