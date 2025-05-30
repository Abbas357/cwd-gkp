<?php

namespace App\Http\Controllers\Asset;

use App\Models\User;
use App\Models\Asset;
use App\Helpers\Database;
use Illuminate\Http\Request;
use App\Helpers\SearchBuilder;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssetRequest;

class AssetController extends Controller
{
    public function all(Request $request)
    {
        $assets = Asset::query();
        
        $relationMappings = [
            'added_by' => 'user.currentPosting.designation.name',
            'assigned_to' => 'allotment.user.currentPosting.office.name',
            'officer_name' => 'allotment.user.name',
            'office_name' => 'allotment.office.name',
        ];
        
        if ($request->ajax()) {
            $dataTable = Datatables::of($assets)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('modules.assets.partials.buttons', compact('row'))->render();
                })
                ->addColumn('added_by', function ($row) {
                    return $row->user->currentPosting?->designation->name 
                    ? '<a href="'.route('admin.apps.hr.users.show', $row->user->id).'" target="_blank">'.$row->user->currentPosting?->designation->name .'</a>' 
                    : ($row->user->currentPosting?->designation->name  ?? 'N/A');
                })
                ->addColumn('assigned_to', function ($row) {
                    return view('modules.assets.partials.assignment', compact('row'))->render();
                })
                ->addColumn('officer_name', function ($row) {
                    return $row->allotment?->user?->name ?? 'Name not available';
                })
                ->addColumn('office_name', function ($row) {
                    return $row->allotment?->office?->name ?? 'Office not available';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'added_by', 'user', 'assigned_to', 'officer_name']);

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

        return view('modules.assets.index');
    }

    public function create()
    {
        $cat = [
            'users' => User::all(),
            'asset_type' => category('asset_type', 'asset'),
            'asset_functional_status' => category('asset_functional_status', 'asset'),
            'asset_brand' => category('asset_brand', 'asset'),
        ];

        $html = view('modules.assets.partials.create', compact('cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function store(StoreAssetRequest $request)
    {
        $asset = new Asset();
        $asset->type = $request->type;
        $asset->functional_status = $request->functional_status;
        $asset->color = $request->color;
        $asset->registration_number = $request->registration_number;
        $asset->fuel_type = $request->fuel_type;
        $asset->brand = $request->brand;
        $asset->model = $request->model;
        $asset->model_year = $request->model_year;
        $asset->registration_status = $request->registration_status;
        $asset->chassis_number = $request->chassis_number;
        $asset->engine_number = $request->engine_number;
        $asset->user_id = $request->user()->id;
        $asset->remarks = $request->remarks;

        session(['office' => $request->office]);

        if ($request->hasFile('front_view')) {
            $asset->addMedia($request->file('front_view'))
                ->toMediaCollection('vehicle_front_pictures');
        }

        if ($request->hasFile('side_view')) {
            $asset->addMedia($request->file('side_view'))
                ->toMediaCollection('vehicle_side_pictures');
        }

        if ($request->hasFile('rear_view')) {
            $asset->addMedia($request->file('rear_view'))
                ->toMediaCollection('vehicle_rear_pictures');
        }

        if ($request->hasFile('interior_view')) {
            $asset->addMedia($request->file('interior_view'))
                ->toMediaCollection('vehicle_interior_pictures');
        }

        if ($asset->save()) {
            session()->forget('office');
            return response()->json(['success' => 'Asset added successfully.']);
        }

        return response()->json(['error' => 'There was an error adding the vehicle.']);
    }

    public function showDetail(Asset $asset)
    {
        $cat = [
            'users' => User::all(),
            'vehicle_type' => category('vehicle_type', 'vehicle'),
            'vehicle_functional_status' => category('vehicle_functional_status', 'vehicle'),
            'vehicle_color' => category('vehicle_color', 'vehicle'),
            'fuel_type' => category('fuel_type', 'vehicle'),
            'vehicle_registration_status' => category('vehicle_registration_status', 'vehicle'),
            'vehicle_brand' => category('vehicle_brand', 'vehicle'),
        ];

        if (!$asset) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Asset Detail',
                ],
            ]);
        }

        $html = view('modules.assets.partials.detail', compact('vehicle', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function vehicleHistory(Asset $asset)
    {
        $allotments = $asset->allotments;

        if (!$asset) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Asset History',
                ],
            ]);
        }

        $html = view('modules.assets.partials.history', compact('vehicle', 'allotments'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function showAssetDetails(Asset $asset)
    {
        $allotments = $asset->allotments()
            ->with(['user', 'user.currentPosting', 'user.currentPosting.designation', 'user.currentPosting.office'])
            ->orderBy('start_date', 'desc')
            ->get();
            
        $currentAllotment = $allotments->where('is_current', true)->first();

        if (!$asset) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Asset Details',
                ],
            ]);
        }

        $html = view('modules.assets.partials.allotment-detail', compact('vehicle', 'allotments', 'currentAllotment'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, Asset $asset)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        $asset->{$request->field} = $request->value;

        if ($asset->isDirty($request->field)) {
            $asset->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }

    public function uploadFile(Request $request, Asset $asset)
    {
        $file = $request->file;
        $collection = $request->collection;
        $asset->addMedia($file)->toMediaCollection($collection);
        if ($asset->save()) {
            return response()->json(['success' => 'File Updated']);
        }
        return response()->json(['error' => 'Error Uploading File']);
    }

    public function destroy($id)
    {
        $asset = Asset::find($id);
        if (request()->user()->isAdmin() && $asset->delete()) {
            $asset->allotments()->delete();
            return response()->json(['success' => 'Asset has been deleted successfully.']);
        }

        return response()->json(['error' => 'You are not authorized to delete the vehicle.']);
    }
}
