<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\Category;
use App\Models\District;
use Illuminate\Http\Request;

use Yajra\DataTables\DataTables;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Mail;

use Endroid\QrCode\Encoding\Encoding;
use App\Models\Contractor;
use App\Mail\Contractor\RenewedMail;
use App\Mail\Contractor\ApprovedMail;
use App\Mail\Contractor\DeferredFirstMail;
use App\Mail\Contractor\DeferredThirdMail;
use App\Mail\Contractor\DeferredSecondMail;

class ContractorController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $contractors = Contractor::query();

        $contractors->when($status !== null, function ($query) use ($status) {
            $query->where('status', $status);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($contractors)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.contractors.partials.buttons', compact('row'))->render();
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at?->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action']);

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\Helpers\SearchBuilder($request, $query);
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('admin.contractors.index');
    }

    public function changeStatus(Request $request) {
        //
    }

    public function updateField(Request $request, Contractor $Contractor)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required',
        ]);

        if (($request->has('reg_no') || $request->has('expiry_date') || $request->has('issue_date')) && in_array($Contractor->status, ['approved_three', 'approved'])) {
            return response()->json(['error' => 'Approved or Rejected Contractors cannot be updated']);
        }
        if ($request->field === 'pec_number') {
            if (Contractor::where('pec_number', $request->value)->where('status', '!=', 'approved')->exists()) {
                return response()->json(['error' => 'PEC number already exists']);
            }
        }

        $Contractor->{$request->field} = $request->field === 'pre_enlistment'
            ? json_encode($request->value)
            : $request->value;
        $Contractor->save();

        return response()->json(['success' => 'Field saved']);
    }

    public function uploadFile(Request $request, Contractor $Contractor)
    {
        if ($request->hasFile('contractor_pictures') && in_array($Contractor->status, ['approved_three', 'approved'])) {
            return response()->json(['error' => 'Approved or Rejected Contractors cannot be updated']);
        }
        $file = $request->file;
        $collection = $request->collection;
        $Contractor->addMedia($file)->toMediaCollection($collection);
        if ($Contractor->save()) {
            return response()->json(['success' => 'File Updated']);
        }
        return response()->json(['error' => 'Error Uploading File']);
    }
}
