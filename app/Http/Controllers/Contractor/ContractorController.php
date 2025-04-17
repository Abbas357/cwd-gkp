<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Models\District;

use App\Models\Contractor;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

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
                    return view('modules.contractors.partials.buttons', compact('row'))->render();
                })
                ->addColumn('status', function ($row) {
                    return view('modules.contractors.partials.status', compact('row'))->render();
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at?->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'status']);

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\Helpers\SearchBuilder($request, $query);
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('modules.contractors.index');
    }

    public function detail(Contractor $contractor)
    {
        $cat = [
            'districts' => District::all(),
            'status' => ['active', 'blacklisted', 'suspended', 'dormant'],
        ];

        if (!$contractor) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Contractor detail',
                ],
            ]);
        }
        $html = view('modules.contractors.partials.detail', compact('Contractor', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function machinery(Contractor $contractor)
    {
        $cat = [
            'districts' => District::all(),
            'status' => ['active', 'blacklisted', 'suspended', 'dormant'],
        ];

        if (!$contractor) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Contractor detail',
                ],
            ]);
        }
        $html = view('modules.contractors.partials.detail', compact('Contractor', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function experience(Contractor $contractor)
    {
        $cat = [
            'districts' => District::all(),
            'status' => ['active', 'blacklisted', 'suspended', 'dormant'],
        ];

        if (!$contractor) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Contractor detail',
                ],
            ]);
        }
        $html = view('modules.contractors.partials.detail', compact('Contractor', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, Contractor $contractor)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required',
        ]);

        $contractor->{$request->field} = $request->value;

        if ($contractor->isDirty($request->field)) {
            $contractor->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }

    public function uploadFile(Request $request, Contractor $contractor)
    {
        $file = $request->file;
        $collection = $request->collection;
        $contractor->addMedia($file)->toMediaCollection($collection);
        if ($contractor->save()) {
            return response()->json(['success' => 'File Updated']);
        }
        return response()->json(['error' => 'Error Uploading File']);
    }
}
