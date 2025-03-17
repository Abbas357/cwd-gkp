<?php

namespace App\Http\Controllers\Settings;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = Activity::query()->latest('id');

        if (!$request->user()->isAdmin()) {
            $logs = $request->user()->logs()->getQuery();
        }

        if ($request->ajax()) {
            $dataTable = Datatables::of($logs)
                ->addColumn('description', function ($row) {
                    return $row->description;
                })
                ->addColumn('causer', function ($row) {
                    if ($row->causer && $row->causer->currentPosting && $row->causer->currentPosting->designation) {
                        return '<a href="'.route('admin.apps.hr.users.show', $row->causer->id).'" target="_blank">'
                            . $row->causer->currentPosting->designation->name .'</a>';
                    }
                    
                    if ($row->user && $row->user->currentPosting && $row->user->currentPosting->designation) {
                        return $row->user->currentPosting->designation->name;
                    }
                    
                    return 'N/A';
                })
                ->addColumn('subject', function ($row) {
                    return view('modules.settings.activity_logs.partials.subject', [
                        'subjectId' => $row->subject_id,
                        'subjectType' => $row->subject_type,
                    ])->render();
                })
                ->addColumn('properties', function ($row) {
                    return view('modules.settings.activity_logs.partials.properties', ['row' => $row])->render();
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y').' ('.$row->created_at->diffForHumans().')';
                })
                ->rawColumns(['properties', 'subject', 'causer']);

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\Helpers\SearchBuilder($request, $query);
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('modules.settings.activity_logs.index');
    }

    public function getNotifications(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 5);
        $user = $request->user();
        
        $query = Activity::query()->orderBy('created_at', 'desc');
        
        if (!$user->isAdmin()) {
            $query->where('causer_id', $user->id);
        }
        
        $activities = $query->paginate($perPage, ['*'], 'page', $page);
        
        $todayCount = Activity::where('created_at', '>=', Carbon::today())
            ->when(!$user->isAdmin(), function($q) use ($user) {
                return $q->where('causer_id', $user->id);
            })
            ->count();
        
        $hasMorePages = $activities->hasMorePages();
        
        $formattedActivities = $activities->map(function ($activity) {
            return [
                'id' => $activity->id,
                'description' => $activity->description,
                'causer_name' => $activity->causer ? $activity->causer->name : 'System',
                'causer_image' => $activity->causer ? getProfilePic($activity->causer) : asset('admin/images/no-profile.png'),
                'subject_type' => $activity->subject_type ? class_basename($activity->subject_type) : null,
                'time' => $activity->created_at->diffForHumans(),
                'created_at' => $activity->created_at->format('Y-m-d H:i:s'),
                'is_today' => $activity->created_at->isToday(),
            ];
        });
        
        return response()->json([
            'activities' => $formattedActivities,
            'hasMorePages' => $hasMorePages,
            'total' => $activities->total(),
            'todayCount' => $todayCount,
        ]);
    }
}
