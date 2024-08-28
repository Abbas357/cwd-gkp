<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Categories\Designation;

class DesignationController extends Controller
{
    public function index()
    {
        $designations = Designation::paginate(10);
        return view('categories.designations.index', compact('designations'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Designation::create(['name' => $request->name]);
        return to_route('designations.index')->with('success', 'Designation Created successfully.');
    }

    public function destroy(Designation $designation)
    {
        $designation->delete();
        return back()->with('success', 'Designation deleted.');
    }
}
