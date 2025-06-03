<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Models\ConsultantProject;
use App\Http\Controllers\Controller;

class ConsultantProjectController extends Controller
{
    public function create()
    {
        $machinery = ConsultantProject::where('consultant_id', session('consultant_id'))->paginate(10);
        return view('site.consultants.machinery', compact('machinery'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:50',
            'model' => 'nullable|string|max:100',
            'registration' => 'nullable|string|max:50',
            'machinery_docs.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,gif|max:5000',
            'machinery_pictures.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,gif|max:5000',
        ]);

        $machinery = new ConsultantProject();
        $machinery->name = $request->name;
        $machinery->number = $request->number;
        $machinery->model = $request->model;
        $machinery->registration = $request->registration;
        $machinery->consultant_id = session('consultant_id');

        $machinery_docs = $request->file('machinery_docs');
        $machinery_pictures = $request->file('machinery_pictures');

        if ($machinery_docs) {
            foreach ($machinery_docs as $doc) {
                $machinery->addMedia($doc)->toMediaCollection('consultant_machinery_docs');
            }
        }

        if ($machinery_pictures) {
            foreach ($machinery_pictures as $pic) {
                $machinery->addMedia($pic)->toMediaCollection('consultant_machinery_pics');
            }
        }

        if ($machinery->save()) {
            return redirect()->back()->with('success', 'Record has been added and will be placed under review. It will be visible once the moderation process is complete');
        }

        return redirect()->back()->with(['error' => 'An error occurred while saving the machinery details.']);
    }
}
