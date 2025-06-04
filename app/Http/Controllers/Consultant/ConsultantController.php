<?php

namespace App\Http\Controllers\Consultant;

use App\Http\Controllers\Controller;
use App\Models\District;

use App\Models\Consultant;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ConsultantController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $consultants = Consultant::query();

        $consultants->when($status !== null, function ($query) use ($status) {
            $query->where('status', $status);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($consultants)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('modules.consultants.partials.buttons', compact('row'))->render();
                })
                ->addColumn('district', function ($row) {
                    return $row->district ? $row->district->name : 'N/A';
                })
                ->addColumn('status', function ($row) {
                    return view('modules.consultants.partials.status', compact('row'))->render();
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

        return view('modules.consultants.index');
    }

    public function detail(Consultant $consultant)
    {
        $cat = [
            'districts' => District::all(),
            'status' => ['draft', 'rejected', 'approved'],
            'sectors' => ['Road', 'Building', 'Bridge'],
        ];

        if (!$consultant) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Consultant detail',
                ],
            ]);
        }
        $html = view('modules.consultants.partials.detail', compact('consultant', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function projects(Consultant $consultant)
    {
        $cat = [
            'districts' => District::all(),
            'status' => ['draft', 'rejected', 'approved'],
        ];

        if (!$consultant) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Consultant detail',
                ],
            ]);
        }
        $html = view('modules.consultants.partials.detail', compact('Consultant', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, Consultant $consultant)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required',
        ]);

        $consultant->{$request->field} = $request->value;

        if ($consultant->isDirty($request->field)) {
            $consultant->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }

    public function uploadFile(Request $request, Consultant $consultant)
    {
        $file = $request->file;
        $collection = $request->collection;
        $consultant->addMedia($file)->toMediaCollection($collection);
        if ($consultant->save()) {
            return response()->json(['success' => 'File Updated']);
        }
        return response()->json(['error' => 'Error Uploading File']);
    }
}
