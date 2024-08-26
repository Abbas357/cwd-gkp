<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Collection;

use Yajra\DataTables\DataTables;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $data = User::query();
        if ($request->ajax()) {
            $dataTable = Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('users.partials.buttons', compact('row'))->render();
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->diffForHumans();
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
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
          
        return view('users.index');
    }

    public function create()
    {
        $cat = [
            'designations' => Collection::where('type', 'designation')->get(),
            'offices' => Collection::where('type', 'office')->get(),
        ];
        return view('users.create', compact('cat'));
    }

    public function store(Request $request)
    {
        //
    }

    public function show(User $user)
    {
        if ($user) {
            return response()->json([
                'success' => true,
                'data' => $user,
            ]);
        }
        return response()->json([
            'success' => false,
            'error' => 'User not found.',
        ]);
    }

    public function update(Request $request, User $user)
    {
        //
    }

    public function destroy(User $user)
    {
        if ($user->delete()) {
            return response()->json(['success' => 'User has been deleted successfully.']);
        }

        return response()->json(['error' => 'User can\'t be deleted.']);
    }
}
