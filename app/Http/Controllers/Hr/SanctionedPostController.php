<?php

namespace App\Http\Controllers\Hr;

use App\Models\Office;
use App\Models\Posting;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Models\SanctionedPost;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SanctionedPostController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'Active');

        $sanctionedPosts = SanctionedPost::with(['office', 'designation'])
            ->where('status', $status);

        if ($request->ajax()) {
            $dataTable = Datatables::of($sanctionedPosts)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('modules.hr.sanctioned-posts.partials.buttons', compact('row'))->render();
                })
                ->addColumn('office_name', function ($row) {
                    return $row->office->name;
                })
                ->addColumn('designation_name', function ($row) {
                    return $row->designation->name;
                })
                ->addColumn('filled_positions', function ($row) {
                    return $row->filledPositions;
                })
                ->addColumn('vacant_positions', function ($row) {
                    return $row->vacancies;
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action']);

            return $dataTable->toJson();
        }

        return view('modules.hr.sanctioned-posts.index');
    }

    public function create()
    {
        $data = [
            'offices' => Office::where('status', 'Active')->get(),
            'designations' => Designation::where('status', 'Active')->get(),
        ];

        $html = view('modules.hr.sanctioned-posts.partials.create', compact('data'))->render();
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
            'office_id' => 'required|exists:offices,id',
            'designation_id' => 'required|exists:designations,id',
            'total_positions' => 'required|integer|min:1',
        ]);
        try {
            DB::beginTransaction();

            // Check if this combination already exists
            $exists = SanctionedPost::where('office_id', $request->office_id)
                ->where('designation_id', $request->designation_id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'error' => 'A sanctioned post already exists for this office and designation combination.'
                ], 422);
            }

            $sanctionedPost = new SanctionedPost();
            $sanctionedPost->office_id = $request->office_id;
            $sanctionedPost->designation_id = $request->designation_id;
            $sanctionedPost->total_positions = $request->total_positions;
            
            $sanctionedPost->save();
            
            DB::commit();
            
            return response()->json(['success' => 'Sanctioned post created successfully']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error creating sanctioned post: ' . $e->getMessage()]);
        }
    }

    public function edit(SanctionedPost $sanctionedPost)
    {
        $data = [
            'sanctionedPost' => $sanctionedPost->load(['office', 'designation']),
            'offices' => Office::where('status', 'Active')->get(),
            'designations' => Designation::where('status', 'Active')->get(),
            'filledPositions' => $sanctionedPost->filledPositions,
            'vacancies' => $sanctionedPost->vacancies
        ];

        $html = view('modules.hr.sanctioned-posts.partials.edit', compact('data'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function show(SanctionedPost $sanctionedPost)
    {
        $sanctionedPost->load(['office', 'designation', 'currentPostings.user']);
        
        $data = [
            'sanctionedPost' => $sanctionedPost,
            'filledPositions' => $sanctionedPost->filledPositions,
            'vacancies' => $sanctionedPost->vacancies,
            'currentPostings' => $sanctionedPost->currentPostings
        ];
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
        
        return view('modules.hr.sanctioned-posts.show', compact('data'));
    }

    public function update(Request $request, SanctionedPost $sanctionedPost)
    {
        $request->validate([
            'office_id' => 'required|exists:offices,id',
            'designation_id' => 'required|exists:designations,id',
            'total_positions' => 'required|integer|min:1',
            'status' => 'required|in:Active,Inactive',
        ]);
        
        try {
            DB::beginTransaction();

            // Check if changing office/designation and if the new combination already exists
            if (($sanctionedPost->office_id != $request->office_id || 
                 $sanctionedPost->designation_id != $request->designation_id) && 
                SanctionedPost::where('office_id', $request->office_id)
                    ->where('designation_id', $request->designation_id)
                    ->where('id', '!=', $sanctionedPost->id)
                    ->exists()) {
                return response()->json([
                    'error' => 'A sanctioned post already exists for this office and designation combination.'
                ], 422);
            }

            // Check if reducing positions below current filled positions
            $filledPositions = $sanctionedPost->filledPositions;
            if ($request->total_positions < $filledPositions) {
                return response()->json([
                    'error' => "Cannot reduce total positions below the current filled positions ({$filledPositions})."
                ], 422);
            }

            $sanctionedPost->office_id = $request->office_id;
            $sanctionedPost->designation_id = $request->designation_id;
            $sanctionedPost->total_positions = $request->total_positions;
            $sanctionedPost->status = $request->status;
            
            $sanctionedPost->save();
            
            DB::commit();
            
            return response()->json(['success' => 'Sanctioned post updated successfully']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error updating sanctioned post: ' . $e->getMessage()]);
        }
    }

    public function quickCreate(Request $request)
    {
        $request->validate([
            'office_id' => 'required|exists:offices,id',
            'designation_id' => 'required|exists:designations,id',
            'total_positions' => 'required|integer|min:1',
        ]);
        
        try {
            // Check if this combination already exists
            $exists = SanctionedPost::where('office_id', $request->office_id)
                ->where('designation_id', $request->designation_id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'error' => 'A sanctioned post already exists for this office and designation combination.'
                ], 422);
            }

            $sanctionedPost = SanctionedPost::create([
                'office_id' => $request->office_id,
                'designation_id' => $request->designation_id,
                'total_positions' => $request->total_positions,
                'status' => 'Active'
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Sanctioned post created successfully',
                'sanctioned_post' => $sanctionedPost
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to create sanctioned post: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkExists(Request $request)
    {
        $officeId = $request->input('office_id');
        $designationId = $request->input('designation_id');
        
        $sanctionedPost = SanctionedPost::where('office_id', $officeId)
            ->where('designation_id', $designationId)
            ->where('status', 'Active')
            ->first();
        
        if (!$sanctionedPost) {
            return response()->json([
                'exists' => false
            ]);
        }
        
        $filledPositions = Posting::where('office_id', $officeId)
            ->where('designation_id', $designationId)
            ->where('is_current', true)
            ->count();
        
        return response()->json([
            'exists' => true,
            'total' => $sanctionedPost->total_positions,
            'filled' => $filledPositions,
            'vacant' => $sanctionedPost->total_positions - $filledPositions,
            'is_full' => ($sanctionedPost->total_positions - $filledPositions) <= 0
        ]);
    }

    public function destroy(SanctionedPost $sanctionedPost)
    {
        if (request()->user()->isAdmin()) {
            // Check if there are current postings using this sanctioned post
            $hasFilled = $sanctionedPost->filledPositions > 0;
            
            if ($hasFilled) {
                return response()->json([
                    'error' => 'Cannot delete this sanctioned post as it has active postings. Set it to Inactive instead.'
                ]);
            }
            
            if ($sanctionedPost->delete()) {
                return response()->json(['success' => 'Sanctioned post has been deleted successfully.']);
            }
        }

        return response()->json(['error' => 'Sanctioned post can\'t be deleted.']);
    }
    
    public function getAvailablePositions(Request $request)
    {
        $officeId = $request->input('office_id');
        $userId = $request->input('user_id');
        
        $sanctionedPosts = SanctionedPost::where('office_id', $officeId)
            ->where('status', 'Active')
            ->with('designation')
            ->get()
            ->map(function($post) use ($userId, $officeId) {
                // Check if the user already has this posting
                $currentUserHasPosting = Posting::where('user_id', $userId)
                    ->where('designation_id', $post->designation_id)
                    ->where('office_id', $officeId)
                    ->where('is_current', true)
                    ->exists();
                    
                // Get filled positions count
                $filledPositions = Posting::where('designation_id', $post->designation_id)
                    ->where('office_id', $officeId)
                    ->where('is_current', true)
                    ->count();
                    
                return [
                    'id' => $post->designation_id, // Important: This should match the designation_id 
                    'designation_id' => $post->designation_id, // Add as fallback
                    'name' => $post->designation->name,
                    'total' => $post->total_positions,
                    'filled' => $filledPositions,
                    'vacant' => $post->total_positions - $filledPositions,
                    'is_full' => ($post->total_positions - $filledPositions) <= 0,
                    'current_user' => $currentUserHasPosting
                ];
            })
            ->filter(function($post) use ($userId) {
                // Return both: those with vacancies OR where the current user is already posted
                return $post['vacant'] > 0 || $post['current_user'];
            })
            ->values(); // Reindex the array after filtering
            
        return response()->json($sanctionedPosts);
    }
}