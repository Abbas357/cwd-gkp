<?php

namespace App\Http\Controllers\Site;

use App\Models\Contractor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ContractorMachinery;

class ContractorMachineryController extends Controller
{
    public function create()
    {
        return view('site.contractors.machinery');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:50',
            'model' => 'nullable|string|max:100',
            'registration' => 'nullable|string|max:50',
            'machinery_docs.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,gif|max:2048',
            'machinery_pictures.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,gif|max:2048',
        ]);

        $machinery = new ContractorMachinery();
        $machinery->name = $request->name;
        $machinery->number = $request->number;
        $machinery->model = $request->model;
        $machinery->registration = $request->registration;
        $machinery->contractor_id = session('contractor_id');

        $machinery_docs = $request->file('machinery_docs');
        $machinery_pictures = $request->file('machinery_pictures');

        if ($machinery_docs) {
            foreach ($machinery_docs as $doc) {
                $machinery->addMedia($doc)->toMediaCollection('contractor_machinery_docs');
            }
        }

        if ($machinery_pictures) {
            foreach ($machinery_pictures as $picture) {
                $machinery->addMedia($picture)->toMediaCollection('contractor_machinery_pics');
            }
        }

        if ($machinery->save()) {
            return redirect()->back()->with('success', 'Machinery details saved successfully!');
        }

        return redirect()->back()->with(['error' => 'An error occurred while saving the machinery details.']);
    }
}