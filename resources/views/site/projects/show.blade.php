<x-main-layout title="{{ $project->name }}">
    @push('style')
    <style>
        .bg-gradient {
            background: #3b5998;
        }
        
        .nav-tabs {
            border-bottom: 2px solid #e0e0e0;
        }
        
        .nav-tabs .nav-link {
            color: #495057;
            border-radius: 0;
            transition: all 0.3s ease;
            position: relative;
            border: none;
            padding: 0.75rem 1rem;
            margin-bottom: -2px;
        }
        
        .nav-tabs .nav-link.active {
            color: #3b5998;
            font-weight: 600;
            background-color: #F0F0F0;
            border: none;
        }
        
        .nav-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background-color: #3b5998;
            border-radius: 4px 4px 0 0;
            box-shadow: 0 -2px 8px rgba(78, 115, 223, 0.5);
            transition: all 0.3s ease;
        }
        
        .nav-tabs .nav-link:hover:not(.active) {
            background-color: rgba(78, 115, 223, 0.1);
            border-color: transparent;
        }
        
        .nav-tabs .nav-link:hover:not(.active)::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: rgba(78, 115, 223, 0.3);
        }
        
        .project-description {
            line-height: 1.6;
        }
        
        .new-file-icon {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.4; }
            100% { opacity: 1; }
        }
        
        .card {
            transition: transform 0.3s ease;
        }
        
        @keyframes rotatePulse {
            0% {
                transform: rotate(-15deg) scale(1);
            }
            20% {
                transform: rotate(-25deg) scale(1.1);
            }
            40% {
                transform: rotate(-15deg) scale(1);
            }
            60% {
                transform: rotate(-5deg) scale(1.1);
            }
            80% {
                transform: rotate(-15deg) scale(1);
            }
            100% {
                transform: rotate(-15deg) scale(1);
            }
        }

        .new-icon {
            width: 2rem;
            margin-left: 0.5rem;
            animation: rotatePulse 2.5s infinite ease-in-out;
        }
        
        .table td, .table th {
            vertical-align: middle;
        }
    </style>
    @endpush
    <x-slot name="breadcrumbTitle">
        {{ $project->name }}
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">{{ $project->name }}</li>
    </x-slot>
    
    <div class="container my-4">
        <div class="card shadow-sm border-0 rounded-lg">
            <div class="card-header bg-gradient text-white p-4">
                <h3 class="mb-0">{{ $project->name }}</h3>
                <p class="text-white-50 mb-0">Project Details</p>
            </div>
            
            <div class="card-body">
                <ul class="nav nav-tabs nav-justified mb-4" id="projectTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="introduction-tab" data-bs-toggle="tab" href="#introduction" role="tab" 
                           aria-controls="introduction" aria-selected="true">
                           <i class="bi bi-info-circle me-2"></i>Introduction
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="files-tab" data-bs-toggle="tab" href="#files" role="tab" 
                           aria-controls="files" aria-selected="false">
                           <i class="bi bi-file-earmark me-2"></i>Documents
                        </a>
                    </li>
                </ul>
                
                <div class="tab-content p-3" id="projectTabContent">
                    <div class="tab-pane fade show active" id="introduction" role="tabpanel" aria-labelledby="introduction-tab">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="border-bottom pb-2 mb-3">Project Overview</h4>
                                <div class="project-description mb-4">
                                    {!! $project->introduction !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-header bg-secondary text-white">
                                        <h5 class="mb-0">Project Details</h5>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <strong><i class="bi bi-cash-coin me-2"></i>Funding Source:</strong>
                                            <span>{{ $project->funding_source ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <strong><i class="bi bi-geo-alt me-2"></i>Location:</strong>
                                            <span>{{ $project->location ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <strong><i class="bi bi-check-circle me-2"></i>Status:</strong>
                                            <span class="badge bg-{{ $project->status == 'completed' ? 'success' : ($project->status == 'active' ? 'primary' : 'warning') }}">
                                                {{ ucfirst($project->status) }}
                                            </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <strong><i class="bi bi-calendar-event me-2"></i>Start Date:</strong>
                                            <span>{{ $project->start_date ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <strong><i class="bi bi-calendar-check me-2"></i>End Date:</strong>
                                            <span>{{ $project->end_date ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <strong><i class="bi bi-wallet2 me-2"></i>Budget:</strong>
                                            <span>${{ number_format($project->budget, 2) ?? 'N/A' }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab">
                        <h4 class="border-bottom pb-2 mb-3"><i class="bi bi-folder me-2"></i>Project Files</h4>
                        
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>File Name</th>
                                        <th>File Type</th>
                                        <th>Upload Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($project->files as $file)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $file->file_name }}
                                            @php
                                            $isRecent = $file->published_at >= now()->subDays(7);
                                            @endphp
                                            @if ($isRecent)
                                                <img class="new-icon" src="{{ asset('site/images/new.png') }}" alt="New">
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border">
                                                <i class="bi bi-filetype-{{strtolower($file->file_type) == 'pdf' ? 'pdf' : 
                                                    (strtolower($file->file_type) == 'doc' || strtolower($file->file_type) == 'docx' ? 'doc' : 
                                                    (strtolower($file->file_type) == 'xls' || strtolower($file->file_type) == 'xlsx' ? 'xls' : 
                                                    (strtolower($file->file_type) == 'ppt' || strtolower($file->file_type) == 'pptx' ? 'ppt' : 'file')))}}"></i>
                                                {{ $file->file_type ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>{{ isset($file->created_at) ? date('M d, Y', strtotime($file->created_at)) : 'N/A' }}</td>
                                        <td>
                                            @if ($file->download_link)
                                            <a href="{{ $file->download_link }}" class="cw-btn" target="_blank">
                                                <i class="bi bi-cloud-arrow-down me-1"></i> Download
                                            </a>
                                            @else
                                            <span class="text-muted">No file available</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <i class="bi bi-folder-x text-muted" style="font-size: 2rem;"></i>
                                            <p class="mt-2">No files available for this project.</p>
                                        </td>
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

    @push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function activateTabFromHash() {
                const scrollPosition = window.scrollY;
                
                const hash = window.location.hash || '#introduction';
                const tabId = hash.replace('#', '');
                const tabToActivate = document.querySelector(`#projectTabs a[href="#${tabId}"]`);
                
                if (tabToActivate) {
                    const tab = new bootstrap.Tab(tabToActivate);
                    tab.show();
                }
                
                setTimeout(() => {
                    window.scrollTo(0, scrollPosition);
                }, 0);
            }
            
            activateTabFromHash();
            
            document.querySelectorAll('#projectTabs a').forEach(tab => {
                tab.addEventListener('click', function(e) {
                    const scrollPosition = window.scrollY;
                    
                    const href = this.getAttribute('href');
                    if (history.pushState) {
                        history.pushState(null, null, href);
                    } else {
                        window.location.hash = href;
                    }
                    
                    setTimeout(() => {
                        window.scrollTo(0, scrollPosition);
                    }, 0);
                });
                
            });
            
            window.addEventListener('hashchange', function(e) {
                e.preventDefault();
                activateTabFromHash();
            });
        });
    </script>
    @endpush
</x-main-layout>