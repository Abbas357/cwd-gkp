<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\District;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::paginate(10);
        return view('admin.districts.index', compact('districts'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        District::create(['name' => $request->name]);
        return to_route('admin.districts.index')->with('success', 'District Created successfully.');
    }

    public function destroy(District $district)
    {
        $district->delete();
        return back()->with('success', 'District deleted.');
    }

    public function assignUser(Request $request, $districtId)
    {
        $request->validate([
            'user_id' => 'required',
        ]);

        $district = District::findOrFail($districtId);
        $district->users()->attach($request->user_id);

        return redirect()->back()->with('success', 'User assigned successfully.');
    }

    public function deleteAssignment($districtId, $userId)
    {
        $district = District::findOrFail($districtId);
        
        $district->users()->detach($userId);

        return redirect()->back()->with('success', 'User assignment deleted successfully.');
    }

}
