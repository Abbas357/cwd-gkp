<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Categories\Office;

class OfficeController extends Controller
{
    public function index()
    {
        $offices = Office::paginate(10);
        return view('admin.categories.offices.index', compact('offices'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Office::create(['name' => $request->name]);
        return to_route('admin.offices.index')->with('success', 'Office Created successfully.');
    }

    public function destroy(Office $office)
    {
        $office->delete();
        return back()->with('success', 'Office deleted.');
    }
}
