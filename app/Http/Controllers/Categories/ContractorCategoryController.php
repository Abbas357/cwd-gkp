<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Categories\ContractorCategory;

class ContractorCategoryController extends Controller
{
    public function index()
    {
        $contractor_categories = ContractorCategory::paginate(10);
        return view('categories.contractor_categories.index', compact('contractor_categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        ContractorCategory::create(['name' => $request->name]);
        return to_route('contractor_categories.index')->with('success', 'Contractor Category Created successfully.');
    }

    public function destroy(ContractorCategory $contractor_category)
    {
        $contractor_category->delete();
        return back()->with('success', 'Contractor Category deleted.');
    }
}
