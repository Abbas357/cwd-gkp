<?php

namespace App\Http\Controllers\Site;

use App\Models\DevelopmentProject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DevelopmentProjectController extends Controller
{
    public function index()
    {
        $projects = DevelopmentProject::paginate(10);
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
            'commencement_date' => $project->commencement_date->format('M d, Y'),
            'district' => $project->district->name ?? 'N/A',
            'work_location' => $project->work_location,
            'chief_engineer' => $project->chiefEngineer->name ?? 'N/A',
            'superintendent_engineer' => $project->superintendentEngineer->name ?? 'N/A',
            'progress_percentage' => $project->progress_percentage,
            'year_of_completion' => $project->year_of_completion,
            'status' => $project->status,
            'images' => $mediaUrls, 
        ];

        return view('site.dev_projects.show', compact('projectData'));
    }
}
