<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DataTables;

class UserController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = User::query();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        return view('users.actions', ['id' => $row->id])->render();
                    })
                    ->editColumn('created_at', function($row) {
                        return $row->created_at->diffForHumans();
                    })
                    ->editColumn('updated_at', function($row) {
                        return $row->updated_at->diffForHumans();
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
          
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
