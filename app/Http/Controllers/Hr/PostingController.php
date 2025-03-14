<?php

namespace App\Http\Controllers\Hr;

use App\Models\User;
use App\Models\Office;
use App\Models\Posting;
use App\Models\District;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Models\SanctionedPost;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostingRequest;

class PostingController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'current');
        
        $postings = Posting::query()
            ->with(['user', 'office', 'designation'])
            ->when($status === 'current', function ($query) {
                return $query->where('is_current', true);
            })
            ->when($status === 'historical', function ($query) {
                return $query->where('is_current', false);
            });

        if ($request->ajax()) {
            $dataTable = Datatables::of($postings)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('modules.hr.postings.partials.buttons', compact('row'))->render();
                })
                ->addColumn('user', function ($row) {
                    return $row->user->name;
                })
                ->addColumn('office', function ($row) {
                    return $row->office->name;
                })
                ->addColumn('designation', function ($row) {
                    return $row->designation->name;
                })
                ->editColumn('start_date', function ($row) {
                    return $row->start_date?->format('j, F Y');
                })
                ->editColumn('end_date', function ($row) {
                    return $row->end_date?->format('j, F Y') ?? 'Current';
                })
                ->rawColumns(['action']);
                
            return $dataTable->toJson();
        }

        return view('modules.hr.postings.index');
    }

    public function create()
    {
        $users = User::all();
        $offices = Office::where('status', 'Active')->get();
        $designations = Designation::where('status', 'Active')->get();
        $postingTypes = ['Appointment', 'Transfer', 'Promotion', 'Retirement', 'Termination'];

        $html = view('modules.hr.postings.partials.create', compact('users', 'offices', 'designations', 'postingTypes'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function store(StorePostingRequest $request)
    {
        DB::beginTransaction();
        
        try {
            if ($request->end_current && $currentPosting = Posting::where('user_id', $request->user_id)->where('is_current', true)->first()) {
                $currentPosting->endPosting($request->start_date);
            }
            
            $posting = Posting::create([
                'user_id' => $request->user_id,
                'office_id' => $request->office_id,
                'designation_id' => $request->designation_id,
                'type' => $request->type,
                'start_date' => $request->start_date,
                'is_current' => true,
                'order_number' => $request->order_number,
                'remarks' => $request->remarks,
            ]);
            
            if ($request->hasFile('posting_order')) {
                $posting->addMedia($request->file('posting_order'))
                    ->toMediaCollection('posting_orders');
            }
                        
            DB::commit();
            
            return redirect()->route('admin.apps.hr.postings.index')
                ->with('success', 'Posting created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating posting: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Posting $posting)
    {
        $posting->load(['user', 'office', 'designation']);        
        return view('modules.hr.postings.show', compact('posting'));
    }

    public function edit(Posting $posting)
    {
        $users = User::all();
        $offices = Office::where('status', 'Active')->get();
        $designations = Designation::where('status', 'Active')->get();
        $postingTypes = ['Appointment', 'Transfer', 'Promotion', 'Retirement', 'Termination'];
                
        return view('modules.hr.postings.edit', compact('posting', 'users', 'offices', 'designations', 'postingTypes'));
    }

    public function update(Request $request, Posting $posting)
    {
        $validated = $request->validate([
            'office_id' => 'required|exists:offices,id',
            'designation_id' => 'required|exists:designations,id',
            'type' => 'required|in:Appointment,Transfer,Promotion,Retirement,Termination',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'boolean',
            'order_number' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);
        
        DB::beginTransaction();
        
        try {
            $posting->update($validated);
            
            // Update posting order if provided
            if ($request->hasFile('posting_order')) {
                $posting->addMedia($request->file('posting_order'))
                    ->toMediaCollection('posting_orders');
            }
            
            DB::commit();
            
            return redirect()->route('admin.apps.hr.postings.index')
                ->with('success', 'Posting updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating posting: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Posting $posting)
    {
        DB::beginTransaction();
        
        try {            
            $posting->delete();
            
            DB::commit();
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function endPosting(Request $request, Posting $posting)
    {
        $request->validate([
            'end_date' => 'required|date|after_or_equal:' . $posting->start_date,
        ]);
        
        try {
            $posting->endPosting($request->end_date);
            return response()->json(['success' => 'Posting has been ended']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Posting cannot be ended']);
        }
    }
 
    public function userPostingHistory(User $user)
    {
        $postings = Posting::where('user_id', $user->id)
            ->with(['office', 'designation'])
            ->orderBy('start_date', 'desc')
            ->get();
            
        return view('modules.hr.postings.history', compact('user', 'postings'));
    }

    public function officePostings(Office $office)
    {
        $currentPostings = Posting::where('office_id', $office->id)
            ->where('is_current', true)
            ->with(['user', 'designation'])
            ->get();
            
        return view('modules.hr.postings.office', compact('office', 'currentPostings'));
    }

    public function checkSanctionedPost(Request $request)
    {
        $request->validate([
            'office_id' => 'required|exists:offices,id',
            'designation_id' => 'required|exists:designations,id',
        ]);
        
        $sanctionedPost = SanctionedPost::where('office_id', $request->office_id)
            ->where('designation_id', $request->designation_id)
            ->first();
            
        if (!$sanctionedPost) {
            return response()->json([
                'valid' => false,
                'message' => 'No sanctioned post exists for this office and designation.'
            ]);
        }
        
        $currentPostingsCount = Posting::where('office_id', $request->office_id)
            ->where('designation_id', $request->designation_id)
            ->where('is_current', true)
            ->count();
            
        $valid = $currentPostingsCount < $sanctionedPost->total_positions;
        
        return response()->json([
            'valid' => $valid,
            'sanctioned' => $sanctionedPost->total_positions,
            'filled' => $currentPostingsCount,
            'available' => $sanctionedPost->total_positions - $currentPostingsCount,
            'message' => $valid ? 'Sanctioned post is available.' : 'All sanctioned posts are filled.'
        ]);
    }

    public function checkOccupancy(Request $request)
    {
        $officeId = $request->input('office_id');
        $designationId = $request->input('designation_id');
        
        $posting = Posting::where('office_id', $officeId)
            ->where('designation_id', $designationId)
            ->where('is_current', true)
            ->with('user')
            ->first();
        
        return response()->json([
            'is_occupied' => !!$posting,
            'user' => $posting ? $posting->user : null
        ]);
    }

    public function getCurrentOfficers(Request $request)
    {
        $officeId = $request->input('office_id');
        $designationId = $request->input('designation_id');
        
        $officers = User::whereHas('currentPosting', function($query) use ($officeId, $designationId) {
            $query->where('office_id', $officeId)
                ->where('designation_id', $designationId);
        })->get();
        
        return response()->json([
            'officers' => $officers
        ]);
    }
}