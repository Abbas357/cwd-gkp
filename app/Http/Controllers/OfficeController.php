<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories\Office;

class OfficeController extends Controller
{
    public function index()
    {
        $offices = Office::paginate(10);
        return view('categories.offices.index', compact('offices'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Office::create(['name' => $request->name]);
        return to_route('offices.index')->with('success', 'Office Created successfully.');
    }

    public function destroy(Office $office)
    {
        $office->delete();
        return back()->with('success', 'Office deleted.');
    }
}
