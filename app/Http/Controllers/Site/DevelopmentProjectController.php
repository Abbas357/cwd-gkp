<?php

namespace App\Http\Controllers\Site;

use App\Models\DevelopmentProject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DevelopmentProjectController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'status' => 'nullable|in:In-Progress,On-Hold,Completed',
            'search' => 'nullable|string|max:255',
            'date_start' => 'nullable|date',
            'date_end' => 'nullable|date|after_or_equal:date_start',
            'district_id' => 'nullable|exists:districts,id',
        ]);

        $status = $request->query('status');

        $projects = DevelopmentProject::when($status, function ($query, $status) {
            $query->where('status', $status);
        })
            ->when($request->query('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->orWhere('total_cost', 'like', "%$search%")
                        ->orWhere('work_location', 'like', "%$search%");
                });
            })
            ->when($request->query('date_start'), function ($query, $dateStart) {
                $query->whereDate('commencement_date', '>=', $dateStart);
            })
            ->when($request->query('date_end'), function ($query, $dateEnd) {
                $query->whereDate('commencement_date', '<=', $dateEnd);
            })
            ->when($request->query('district_id'), function ($query, $districtId) {
                $query->where('district_id', $districtId);
            })
            ->paginate(10);

        return view('site.dev_projects.index', compact('projects'));
    }


    public function showDevelopmentProject($slug)
    {
        $project = DevelopmentProject::where('slug', $slug)
            ->with('media')
            ->firstOrFail();

        $mediaUrls = $project->getMedia('development_projects_attachments')->map(function ($media) {
            return $media->getUrl();
        });

        $projectData = [
            'id' => $project->id,
            'name' => $project->name,
            'slug' => $project->slug,
            'introduction' => $project->introduction,
            'total_cost' => $project->total_cost,
            'commencement_date' => $project->commencement_date?->format('M d, Y'),
            'district' => $project->district->name ?? '',
            'work_location' => $project->work_location,
            'chief_engineer' => $project->chiefEngineer->name ?? '',
            'superintendent_engineer' => $project->superintendentEngineer->name ?? '',
            'progress_percentage' => $project->progress_percentage,
            'year_of_completion' => $project->year_of_completion?->format('M d, Y'),
            'status' => $project->status,
            'views_count' => $project->views_count,
            'images' => $mediaUrls,
            'comments' => $project->comments()->whereNull('parent_id')->with('replies')->get(),
        ];

        $this->incrementViews($project);

        return view('site.dev_projects.show', compact('projectData'));
    }
}
