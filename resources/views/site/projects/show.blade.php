<x-main-layout title="{{ $project->name }}">
    <x-slot name="breadcrumbTitle">
        {{ $project->name }}
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">{{ $project->name }}</li>
    </x-slot>
    <div class="container my-3">
        <div class="row">
            <div class="col-md-3">
                <ul class="nav nav-pills nav-sm flex-column" id="projectTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link mb-1 p-3 active" id="introduction-tab" data-bs-toggle="tab" href="#introduction" role="tab" aria-controls="introduction" aria-selected="true">Introduction</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-1 p-3" id="files-tab" data-bs-toggle="tab" href="#files" role="tab" aria-controls="files" aria-selected="false">Files</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-9">
                <div class="tab-content" id="projectTabContent">
                    <div class="tab-pane fade show active" id="introduction" role="tabpanel" aria-labelledby="introduction-tab">
                        <h4>Introduction</h4>
                        <p>{!! $project->introduction !!}</p>
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Funding Source:</strong> {{ $project->funding_source ?? 'N/A' }}</li>
                            <li class="list-group-item"><strong>Location:</strong> {{ $project->location ?? 'N/A' }}</li>
                            <li class="list-group-item"><strong>Status:</strong> {{ ucfirst($project->status) }}</li>
                            <li class="list-group-item"><strong>Start Date:</strong> {{ $project->start_date ?? 'N/A' }}</li>
                            <li class="list-group-item"><strong>End Date:</strong> {{ $project->end_date ?? 'N/A' }}</li>
                            <li class="list-group-item"><strong>Budget:</strong> ${{ number_format($project->budget, 2) ?? 'N/A' }}</li>
                        </ul>
                    </div>

                    <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab">
                        <h4>Project Files</h4>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>File Name</th>
                                        <th>File Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($project->files as $file)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $file->file_name }}</td>
                                        <td>{{ $file->file_type ?? 'N/A' }}</td>
                                        <td>
                                            @if ($file->download_link)
                                            <a href="{{ $file->download_link }}" class="btn-animate text-no-wrap" target="_blank" style="white-space: nowrap">
                                                <i class="bi-cloud-arrow-down"></i> Download
                                            </a>
                                            @else
                                            <span class="text-muted">No file available</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No files available for this project.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-main-layout>