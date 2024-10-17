<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ActivityLogController extends Controller
{
    public function __invoke(Request $request)
    {
        $logs = ActivityLog::query();

        if (!$request->user()->isAdmin()) {
            $logs = $request->user()->logs()->getQuery();
        }

        if ($request->ajax()) {
            $dataTable = Datatables::of($logs)
                ->addIndexColumn()
                ->editColumn('loggable_type', function ($log) {
                    return class_basename($log->loggable_type);
                })
                ->addColumn('user', function ($log) {
                    return $log->user ? $log->user->name . ' (' . $log->user->designation . ' - ' . $log->user->office  . ')' : 'N/A';
                })
                ->editColumn('action_at', function ($row) {
                    return $row->action_at->diffForHumans();
                });
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
