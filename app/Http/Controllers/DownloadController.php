<?php

namespace App\Http\Controllers;

use App\Models\Download;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDownloadRequest;
use Yajra\DataTables\DataTables;

class DownloadController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $downloads = Download::query();

        $downloads->when($status !== null, function ($query) use ($status) {
            $query->where('status', $status);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($downloads)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.downloads.partials.buttons', compact('row'))->render();
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->diffForHumans();
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->editColumn('status', function ($row) {
                    return $row->status === 1 ? 'Approved' : 'Not Approved';
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

        return view('admin.downloads.index');
    }

    public function create()
    {
        $stats = [
            'totalCount' => Download::count(),
            'publishedCount' => Download::whereNotNull('published_at')->count(),
            'unPublishedCount' => Download::whereNull('published_at')->count(),
        ];
        return view('admin.downloads.create', compact('stats'));
    }

    public function store(StoreDownloadRequest $request)
    {
        $standardization = new Download();
        $standardization->product_name = $request->input('product_name');

        if ($request->hasFile('secp_certificate')) {
            $standardization->addMedia($request->file('secp_certificate'))
                ->toMediaCollection('secp_certificates');
        }

        if ($standardization->save()) {
            return redirect()->route('admin.downloads.create')->with('success', 'Your form has been submitted successfully');
        }
        return redirect()->route('admin.downloads.create')->with('danger', 'There is an error submitting your data');
    }

    public function show(Download $Download)
    {
        return response()->json($Download);
    }

    public function showDetail(Download $Download)
    {
        if (!$Download) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Product detail',
                ],
            ]);
        }
        $html = view('admin.downloads.partials.detail', compact('Download'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        $Download = Download::find($request->id);
        if($Download->status !== 0) {
            return response()->json(['error' => 'Approved or Rejected Products cannot be updated']);
        }
        $Download->{$request->field} = $request->value;
        $Download->save();

        return response()->json(['success' => 'Field saved']);
    }

    public function uploadFile(Request $request)
    {
        $standardization = Download::find($request->id);
        if($standardization->status !== 0) {
            return response()->json(['error' => 'Approved or Rejected Products cannot be updated']);
        }
        $file = $request->file;
        $collection = $request->collection;
        $standardization->addMedia($file)->toMediaCollection($collection);
        if($standardization->save()) {
            return response()->json(['success' => 'File Updated']);
        }
        return response()->json(['error' => 'Error Uploading File']);
    }
}
