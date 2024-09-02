<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

use App\Models\Categories\Office;
use App\Models\Categories\Designation;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $active = $request->query('active', null);

        $users = User::query();

        $users->when($active !== null, function ($query) use ($active) {
            $query->where('is_active', $active);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('users.partials.buttons', compact('row'))->render();
                })
                ->editColumn('is_active', function ($row) {
                    return $row->is_active == 1 ? 'Yes' : 'No' ;
                })
                ->editColumn('password_updated_at', function ($row) {
                    return $row->password_updated_at->diffForHumans();
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
            'designations' => Designation::all(),
            'offices' => Office::all(),
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

    public function assignBoss(Request $request)
    {
        $user = User::find($request->input('user_id'));
        $boss = User::find($request->input('boss_id'));

        $user->boss()->sync([$boss->id]);

        return redirect()->back()->with('success', 'Boss assigned successfully.');

        // $boss = $user->boss->first();
        // $subordinates = $user->subordinates;
    }
}
