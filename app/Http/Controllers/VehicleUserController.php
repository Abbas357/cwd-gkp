<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\VehicleUser;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class VehicleUserController extends Controller
{
    public function index(Request $request)
    {
        $users = VehicleUser::query();

        if ($request->ajax()) {
            $dataTable = Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.vehicles.users.partials.buttons', compact('row'))->render();
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
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

        return view('admin.vehicles.users.index');
    }
    
    public function create()
    {
        $designations = Category::where('type', 'designation')->get();
        $offices = Category::where('type', 'office')->get();
        return view('admin.vehicles.users.create', compact('designations', 'offices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'office' => 'required|string|max:255',
            'office_type' => 'required|in:division,circle',
        ]);

        $vehicleUser = new VehicleUser();
        $vehicleUser->name = $request->name;
        $vehicleUser->designation = $request->designation;
        $vehicleUser->office = $request->office;
        $vehicleUser->office_type = $request->office_type;

        if ($vehicleUser->save()) {
            return redirect()->route('admin.vehicle-users.index')
                ->with('success', 'User added successfully');
        }

        return redirect()->route('admin.vehicle-users.create')
            ->with('danger', 'There was an error adding the user');
    }

    public function showDetail($id)
    {
        $user = VehicleUser::find($id);

        $cat = [
            'designations' => Category::where('type', 'designation')->get(),
            'offices' => Category::where('type', 'office')->get(),
        ];

        if (!$user) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load User Detail',
                ],
            ]);
        }

        $html = view('admin.vehicles.users.partials.detail', compact('user', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, $id)
    {
        $user = VehicleUser::find($id);
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        $user->{$request->field} = $request->value;

        if ($user->isDirty($request->field)) {
            $user->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }

    public function destroy($id)
    {
        $user = VehicleUser::find($id);
        if (request()->user()->isAdmin() && $user->delete()) {
            return response()->json(['success' => 'User has been deleted successfully.']);
        }

        return response()->json(['error' => 'You are not authorized to delete the user.']);
    }
}
