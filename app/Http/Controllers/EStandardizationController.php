<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EStandardization;
use Yajra\DataTables\DataTables;

use App\Http\Requests\StoreEStandardizationRequest;
use App\Http\Requests\UpdateEStandardizationRequest;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;

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

        if ($request->hasFile('secp_certificate')) {
            $standardization->addMedia($request->file('secp_certificate'))
                ->toMediaCollection('secp_certificates');
        }

        if ($request->hasFile('iso_certificate')) {
            $standardization->addMedia($request->file('iso_certificate'))
                ->toMediaCollection('iso_certificates');
        }

        if ($request->hasFile('commerce_membership')) {
            $standardization->addMedia($request->file('commerce_membership'))
                ->toMediaCollection('commerse_memberships');
        }

        if ($request->hasFile('pec_certificate')) {
            $standardization->addMedia($request->file('pec_certificate'))
                ->toMediaCollection('pec_certificates');
        }

        if ($request->hasFile('annual_tax_returns')) {
            $standardization->addMedia($request->file('annual_tax_returns'))
                ->toMediaCollection('annual_tax_returns');
        }

        if ($request->hasFile('audited_financial')) {
            $standardization->addMedia($request->file('audited_financial'))
                ->toMediaCollection('audited_financials');
        }

        if ($request->hasFile('dept_org_cert')) {
            $standardization->addMedia($request->file('dept_org_cert'))
                ->toMediaCollection('organization_registrations');
        }

        if ($request->hasFile('performance_certificate')) {
            $standardization->addMedia($request->file('performance_certificate'))
                ->toMediaCollection('performance_certificate');
        }

        if ($standardization->save()) {
            return redirect()->route('standardizations.create')->with('success', 'Your form has been submitted successfully');
        }
        return redirect()->route('standardizations.create')->with('danger', 'There is an error submitting your data');
    }

    public function show(EStandardization $EStandardization)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $EStandardization,
            ],
        ]);
    }

    public function showDetail(EStandardization $EStandardization)
    {
        if (!$EStandardization) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Product detail',
                ],
            ]);
        }
        $html = view('standardizations.partials.detail', compact('EStandardization'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function showCard(EStandardization $EStandardization)
    {
        if ($EStandardization->approval_status !== 1) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'The Product is not standardized',
                ],
            ]);
        }
        $data = route('standardizations.approved', ['id' => $EStandardization->id]);
        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data($data)
            ->encoding(new Encoding('UTF-8'))
            ->size(300)
            ->margin(1)
            ->build();

        $qrCodeUri = $qrCode->getDataUri();

        $html = view('standardizations.partials.card', compact('EStandardization', 'qrCodeUri'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function approve(Request $request, EStandardization $EStandardization)
    {
        if ($EStandardization->approval_status !== 1) {
            $EStandardization->approval_status = 1;
            $EStandardization->save();
            return response()->json(['success' => 'Product has been approved successfully.']);
        }
        return response()->json(['error' => 'Product can\'t be approved.']);
    }

    public function approvedProducts(Request $request, $id)
    {
        $product = EStandardization::find($id);
        return view('standardizations.approved', compact('product'));
    }

    public function reject(Request $request, EStandardization $EStandardization)
    {
        if (!in_array($EStandardization->approval_status, [1, 2])) {
            $EStandardization->approval_status = 2;
            $EStandardization->rejection_reason = $request->reason;
            $EStandardization->save();
            return response()->json(['success' => 'Product has been rejected.']);
        }
        return response()->json(['error' => 'Product can\'t be rejected.']);
    }

    public function updateField(Request $request)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        $EStandardization = EStandardization::find($request->id);
        $EStandardization->{$request->field} = $request->value;
        $EStandardization->save();

        return response()->json(['success' => 'Field saved']);
    }

    public function upsertImage(Request $request)
    {
        $standardization = EStandardization::find($request->id);
        $image = $request->image;
        $collection = $request->collection;
        $standardization->addMedia($image)->toMediaCollection($collection);
        if($standardization->save()) {
            return response()->json(['success' => 'Image Updated']);
        }
        return response()->json(['error' => 'Error Uploading Image']);

    }

    public function update(UpdateEStandardizationRequest $request, EStandardization $eStandardization)
    {
        $validated = $request->validated();

        $eStandardization->fill(array_filter($validated, function ($value) {
            return $value !== null;
        }));

        if ($request->hasFile('image')) {
        }

        if ($eStandardization->save()) {
            return response()->json(['success' => 'User updated']);
        }
        return response()->json(['error' => 'User updation failed']);
    }
}
