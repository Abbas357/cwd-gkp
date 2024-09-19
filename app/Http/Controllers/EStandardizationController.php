<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EStandardization;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\StoreEStandardizationRequest;
use App\Http\Requests\UpdateEStandardizationRequest;

class EStandardizationController extends Controller
{
    public function index(Request $request)
    {
        $approved = $request->query('approved', null);

        $standardizations = EStandardization::query();

        $standardizations->when($approved !== null, function ($query) use ($approved) {
            $query->where('approval_status', $approved);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($standardizations)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('standardizations.partials.buttons', compact('row'))->render();
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->diffForHumans();
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->editColumn('approval_status', function ($row) {
                    return $row->approval_status === 1 ? 'Approved' : 'Not Approved';
                })
                ->rawColumns(['action']);

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\SearchBuilder($request, $query);
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('standardizations.index');
    }

    public function create()
    {
        return view('standardizations.create');
    }

    public function store(StoreEStandardizationRequest $request)
    {
        $standardization = new EStandardization();
        $standardization->product_name = $request->input('product_name');
        $standardization->specification_details = $request->input('specification_details');
        $standardization->firm_name = $request->input('firm_name');
        $standardization->address = $request->input('address');
        $standardization->mobile_number = $request->input('mobile_number');
        $standardization->phone_number = $request->input('phone_number');
        $standardization->email = $request->input('email');
        $standardization->locality = $request->input('locality');
        $standardization->ntn_number = $request->input('ntn_number');
        $standardization->location_type = $request->input('location_type');

        if ($request->hasFile('cnic_front_attachment')) {
            $standardization->cnic_front_attachment = $request->file('cnic_front_attachment')->store('standardizations/cnic', 'public');
        }

        if ($standardization->save()) {
            return redirect()->route('registrations.create')->with('success', 'Your form has been submitted successfully');
        }
        return redirect()->route('registrations.create')->with('danger', 'There is an error submitting your data');
    }

    public function show(EStandardization $eStandardization)
    {
        return view('standardizations.show', compact('EStandardization'));
    }

    public function approve(Request $request, EStandardization $eStandardization)
    {
        if ($eStandardization->approval_status !== 1) {
            $eStandardization->approval_status = 1;
            $eStandardization->save();
            return response()->json(['success' => 'Registration has been approved successfully.']);
        }
        return response()->json(['error' => 'Registration can\'t be approved.']);
    }

    public function update(UpdateEStandardizationRequest $request, EStandardization $eStandardization)
    {
        $validated = $request->validated();

        $eStandardization->fill(array_filter($validated, function ($value) {
            return $value !== null;
        }));

        if (!empty($validated['password'])) {
            $eStandardization->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('image')) {
        }

        if ($request->has('roles')) {
            $eStandardization->syncRoles($validated['roles']);
        }

        if ($request->has('permissions')) {
            $eStandardization->syncPermissions($validated['permissions']);
        }

        if($eStandardization->save()) {
            return response()->json(['success' => 'User updated']);
        }
        return response()->json(['error' => 'User updation failed']);
    }

}
