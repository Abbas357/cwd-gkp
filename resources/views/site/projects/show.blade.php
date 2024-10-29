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
                <ul class="nav nav-pills flex-column" id="projectTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link p-3 active" id="introduction-tab" data-bs-toggle="tab" href="#introduction" role="tab" aria-controls="introduction" aria-selected="true">Introduction</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link p-3" id="files-tab" data-bs-toggle="tab" href="#files" role="tab" aria-controls="files" aria-selected="false">Files</a>
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
                        <ul class="list-group">
                            @forelse ($project->files as $file)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ $loop->iteration }}</span>
                                    <span>{{ $file->file_name }}</span>
                                    <span class="badge bg-primary rounded-pill">{{ $file->file_type ?? 'N/A' }}</span>
                                    @if ($file->download_link)
                                        <a href="{{ $file->download_link }}" class="btn-animate" target="_blank">
                                            <i class="bi-cloud-arrow-down"></i> Download
                                        </a>
                                    @else
                                        <span class="text-muted">No file available</span>
                                    @endif
                                </li>
                            @empty
                                <li class="list-group-item">No files available for this project.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
