<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\District;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::paginate(10);
        return view('categories.districts.index', compact('districts'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        District::create(['name' => $request->name]);
        return to_route('districts.index')->with('success', 'District Created successfully.');
    }

    public function destroy(District $district)
    {
        $district->delete();
        return back()->with('success', 'District deleted.');
    }

}
