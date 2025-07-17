<?php

namespace App\Http\Controllers\Hr;;

use App\Models\Posting;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Models\SanctionedPost;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class DesignationController extends Controller
{
    public function index(Request $request)
    {
        $designations = Designation::query()
            ->when($request->filled('status'), function ($query) use ($request) {
                return $query->where('status', $request->status);
            });
            
        if ($request->ajax()) {
            $dataTable = Datatables::of($designations)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('modules.hr.designations.partials.buttons', compact('row'))->render();
                })
                ->addColumn('officers_count', function ($row) {
                    return Posting::where('designation_id', $row->id)
                        ->where('is_current', true)
                        ->count();
                })
                ->addColumn('sanctioned_posts', function ($row) {
                    return SanctionedPost::where('designation_id', $row->id)
                        ->sum('total_positions');
                })
                ->rawColumns(['action']);
                
            return $dataTable->toJson();
        }
        
        $statuses = ['Active', 'Inactive', 'Archived'];
        
        return view('modules.hr.designations.index', compact('statuses'));
    }

    public function create()
    {
        $bps = $this->getBpsRange(1, 20);
        
        $statuses = ['Active', 'Inactive', 'Archived'];
        
        $html = view('modules.hr.designations.partials.create', compact('bps', 'statuses'))->render();

        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:designations,name',
            'bps' => 'nullable|string|max:10',
        ]);

        $designation = new Designation();
        $designation->name = $request->name;
        $designation->bps = $request->bps;
        
        if($designation->save()) {
            return response()->json(['success' => 'Designation created successfully']);
        }
        return response()->json(['error' => 'There is an error adding the designation']);
    }

    public function show(Designation $designation)
    {
        $currentOfficers = $designation->currentOfficers()
            ->with('currentPosting.office')
            ->get();
            
        $sanctionedPosts = SanctionedPost::where('designation_id', $designation->id)
            ->with('office')
            ->withCount(['currentPostings as filled_positions'])
            ->get()
            ->map(function ($post) {
                $post->vacancies = $post->total_positions - $post->filled_positions;
                return $post;
            });
            
        return view('modules.hr.designations.show', compact('designation', 'currentOfficers', 'sanctionedPosts'));
    }

    public function showDetail(Designation $designation)
    {
        $allBPS = $this->getBpsRange();   
        
        $html = view('modules.hr.designations.partials.detail', compact('designation', 'allBPS'))->render();

        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, Designation $designation)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        $designation->{$request->field} = $request->value;

        if ($designation->isDirty($request->field)) {
            $designation->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }

    public function activateDesignation(Request $request, Designation $designation)
    {
        if ($designation->status === 'Active') {
            $designation->status = 'Inactive';
            $message = 'Designation deactivated successfully.';
        } else {
            $designation->status = 'Active';
            $message = 'Designation activated successfully.';
        }
        $designation->save();
        return response()->json(['success' => $message], 200);
    }

    public function destroy(Designation $designation)
    {
        if (Posting::where('designation_id', $designation->id)->where('is_current', true)->exists()) {
            return response()->json([
                'success' => false, 
                'message' => 'Cannot delete designation with active designationrs.'
            ]);
        }
        
        if (SanctionedPost::where('designation_id', $designation->id)->exists()) {
            return response()->json([
                'success' => false, 
                'message' => 'Cannot delete designation with sanctioned posts.'
            ]);
        }
        
        $designation->delete();
        
        return response()->json(['success' => true]);
    }

    public function officers()
    {
        $designations = Designation::where('status', 'Active')->get();
        
        return view('modules.hr.designations.officers', compact('designations'));
    }

    public function getDesignationOfficers(Designation $designation)
    {
        $officers = $designation->currentOfficers()
            ->with('currentPosting.office')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'office' => $user->currentPosting->office->name,
                    'start_date' => $user->currentPosting->start_date->format('j, F Y'),
                ];
            });
            
        return response()->json(['officers' => $officers]);
    }
}