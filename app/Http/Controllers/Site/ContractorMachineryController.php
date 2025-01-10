<?php

namespace App\Http\Controllers\Site;

use App\Models\Contractor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ContractorMachineryController extends Controller
{
    public function create()
    {
        return view('site.contractors.machinery');
    }

    public function store(Request $request)
    {
        $contractor = Contractor::findOrFail(session('contractor_id'));

        $request->validate([
            'machinery_docs' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'machinery.*.name' => 'required|string|max:255',
            'machinery.*.number' => 'required|string|max:50',
            'machinery.*.model' => 'nullable|string|max:100',
            'machinery.*.registration' => 'nullable|string|max:50'
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->machinery as $machine) {
                $machinery = $contractor->machinery()->create([
                    'name' => $machine['name'],
                    'number' => $machine['number'],
                    'model' => $machine['model'] ?? null,
                    'registration' => $machine['registration'] ?? null
                ]);

                if ($request->hasFile('machinery_docs')) {
                    $machinery->addMedia($request->file('machinery_docs'))
                        ->toMediaCollection('machinery_documents');
                }
            }

            DB::commit();
            return redirect()->route('contractors.work_experience.create')
                ->with('status', 'Machinery details saved successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'An error occurred while saving the machinery details.'])
                ->withInput();
        }
    }
}
