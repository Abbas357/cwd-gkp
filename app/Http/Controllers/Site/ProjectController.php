<?php

namespace App\Http\Controllers\Site;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function showProject($name)
    {
        $project = Project::with('files')->where('name', $name)->firstOrFail();

        $project->files->each(function ($file) {
            $file->download_link = $file->file_link ?: $file->getFirstMediaUrl('project_files') ?: null;
        });

        return view('site.projects.show', compact('project'));
    }
}
