<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function __invoke(Request $request)
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
                    return $row->causer?->position 
                    ? '<a href="'.route('admin.users.show', $row->causer->id).'" target="_blank">'.$row->causer->position.'</a>' 
                    : ($row->causer?->designation ?? 'System');
                })
                ->addColumn('subject', function ($row) {
                    return view('admin.activity_logs.partials.subject', [
                        'subjectId' => $row->subject_id,
                        'subjectType' => $row->subject_type,
                    ])->render();
                })
                ->addColumn('properties', function ($row) {
                    return view('admin.activity_logs.partials.properties', ['row' => $row])->render();
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y').' ('.$row->created_at->diffForHumans().')';
                })
                ->rawColumns(['properties', 'subject', 'causer']);
            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\SearchBuilder($request, $query);
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('admin.activity_logs.index');
    }
}
