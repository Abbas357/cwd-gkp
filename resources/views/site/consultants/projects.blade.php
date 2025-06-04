<x-main-layout>
    @include('site.consultants.partials.header')

    @push('style')
        <style>
        .hr-checkbox-wrapper {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 0.75rem;
            transition: all 0.2s ease;
        }
        
        .hr-checkbox-wrapper:hover {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
        
        .hr-info {
            margin-left: 0.5rem;
        }
        
        .badge.bg-warning.text-dark {
            font-size: 0.65em;
        }
        
        .modal-body ul li {
            margin-bottom: 0.5rem;
        }

        .hr-checkbox-wrapper:has(input:checked) {
            border-color: #0d6efd;
            border-width: 2px
        }
    </style>
    @endpush
    <div class="container">
        <!-- Warning Modal -->
        <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmationModalLabel">
                            <i class="fas fa-exclamation-triangle text-warning"></i> 
                            HR Assignment Warning
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="warningMessage">
                            <p class="mb-3">The following HR have conflicting project assignments:</p>
                            <ul id="warningList" class="list-unstyled">
                                <!-- Warnings will be populated here -->
                            </ul>
                            <p class="text-warning">
                                <strong>Are you sure you want to proceed?</strong> 
                                This may result in overlapping assignments or reassigning HR from other projects.
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-warning" id="confirmProceed">
                            <i class="fas fa-check"></i> Yes, Proceed
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <form class="needs-validation" action="{{ route('consultants.projects.store') }}" method="post" enctype="multipart/form-data" novalidate id="projectForm">
            @csrf
            <input type="hidden" name="confirm_reassignment" id="confirmReassignment" value="0">
            
            <div class="card cw-shadow mb-4 rounded-0">
                <div class="card-header bg-light fw-bold text-uppercase">
                    Projects <span class="ms-3 step-indicator">Step 3 of 3</span> <span class="ms-3 subtitle">Add all projects and allocate staff to each project</span>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="name">Name <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="name" value="{{ old('name') }}" placeholder="eg. Name of Project" name="name" required>
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="adp_number">ADP Number <abbr title="Required">*</abbr></label>
                            <input type="number" class="form-control" id="adp_number" value="{{ old('adp_number') }}" placeholder="ADP Number" name="adp_number" required>
                            @error('adp_number')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="scheme_code">Scheme Code <abbr title="Required">*</abbr></label>
                            <input type="number" class="form-control" id="scheme_code" value="{{ old('scheme_code') }}" placeholder="Scheme Code" name="scheme_code" required>
                            @error('scheme_code')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="estimated_cost">Estimated Cost (In Million) <abbr title="Required">*</abbr></label>
                            <input type="number" class="form-control" id="estimated_cost" value="{{ old('estimated_cost') }}" placeholder="Estimated Cost" name="estimated_cost" required>
                            @error('estimated_cost')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="district_id">District</label>
                            <select class="form-select" id="district_id" name="district_id">
                                <option value="">Choose...</option>
                                @foreach ($districts as $district)
                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                                @endforeach
                            </select>
                            @error('district_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="start_date">Start Date <abbr title="Required">*</abbr></label>
                            <input type="date" class="form-control" id="start_date" value="{{ old('start_date') }}" placeholder="Start Date" name="start_date" required>
                            @error('start_date')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="end_date">End Date <abbr title="Required">*</abbr></label>
                            <input type="date" class="form-control" id="end_date" value="{{ old('end_date') }}" placeholder="End Date" name="end_date" required>
                            @error('end_date')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label>Assign Human Resources</label>
                            @if($allHr->count() > 0)
                                <div class="row">
                                    @foreach($allHr as $hr)
                                        <div class="col-md-3 mb-3">
                                            <label class="form-check-label form-check hr-checkbox-wrapper" for="hr_{{ $hr->id }}">
                                                <input class="form-check-input" type="checkbox" name="hr[]" value="{{ $hr->id }}" id="hr_{{ $hr->id }}" data-hr-id="{{ $hr->id }}" {{ in_array($hr->id, old('hr', [])) ? 'checked' : '' }}>

                                                <div class="hr-info">
                                                    <strong>{{ $hr->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">
                                                        {{ $hr->designation }} | {{ $hr->email }}
                                                    </small>
                                                    @if(isset($hrAssignmentInfo[$hr->id]))
                                                    <br>
                                                    <small class="text-danger fw-bold">
                                                        <i class="fas fa-project-diagram"></i>
                                                        Currently in: {{ $hrAssignmentInfo[$hr->id]['project_name'] }}
                                                    </small>
                                                    @endif
                                                </div>
                                            </label>
                                        </div>

                                    @endforeach
                                </div>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle"></i>
                                    All approved HR are shown. HR with warning badges are currently assigned to other active projects.
                                </small>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    No approved human resources available for assignment.
                                </div>
                            @endif
                            @error('hr')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="my-2">
                <x-button type="submit" text="SAVE" />
            </div>
        </form>

        <!-- Display warnings if they exist -->
        @if(session('hr_warnings'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const warnings = @json(session('hr_warnings'));
                    showWarningModal(warnings);
                });
            </script>
        @endif

        <div class="card">
            <div class="card-body">
                <h3 class="card-title mb-3 p-2"> List of Projects </h3>
                <table class="table p-5 table-stripped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>ADP Number</th>
                            <th>Scheme Code</th>
                            <th>District</th>
                            <th>Estimated Cost</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Assigned HR</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                        <tr>
                            <td> {{ $project->name }} </td>
                            <td> {{ $project?->adp_number ?? '-' }} </td>
                            <td> {{ $project?->scheme_code ?? '-' }} </td>
                            <td> {{ $project->district?->name }} </td>
                            <td> {{ $project->estimated_cost }} </td>
                            <td>{{ \Carbon\Carbon::parse($project->start_date)->format('j F Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($project->end_date)->format('j F Y') }}</td>
                            <td>
                                @if($project->assignedHumanResources && $project->assignedHumanResources->count() > 0)
                                    <div class="hr-list">
                                        @foreach($project->assignedHumanResources as $hr)
                                            <span class="badge bg-primary mb-1 me-1" title="{{ $hr->designation }} - {{ $hr->email }}">
                                                <i class="fas fa-user"></i> {{ $hr->name }} ({{ $hr->designation }})
                                            </span>
                                        @endforeach
                                        <small class="text-muted d-block mt-1">
                                            Total: {{ $project->assignedHumanResources->count() }} HR assigned
                                        </small>
                                    </div>
                                @else
                                    <span class="text-muted">
                                        <i class="fas fa-user-slash"></i> No HR assigned
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="badge 
                                    @switch($project->status)
                                        @case('draft') bg-secondary @break
                                        @case('rejected') bg-danger @break
                                        @case('approved') bg-success @break
                                        @default bg-light text-dark
                                    @endswitch">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" class="text-center">No records found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $projects->links() }}
        </div>
    </div>

    @push('script')
    <script>
        // HR assignment data from PHP
        const hrAssignmentInfo = @json($hrAssignmentInfo ?? []);
        
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('projectForm');
            
            form.addEventListener('submit', function(e) {
                const selectedHr = Array.from(document.querySelectorAll('input[name="hr[]"]:checked'))
                    .map(input => parseInt(input.value));
                
                const assignedHr = selectedHr.filter(hrId => hrAssignmentInfo[hrId]);
                
                if (assignedHr.length > 0 && document.getElementById('confirmReassignment').value === '0') {
                    e.preventDefault();
                    
                    const warnings = assignedHr.map(hrId => {
                        const hrLabel = document.querySelector(`label[for="hr_${hrId}"]`);
                        const hrName = hrLabel.querySelector('strong').textContent;
                        const projectInfo = hrAssignmentInfo[hrId];
                        
                        return {
                            hr_id: hrId,
                            hr_name: hrName,
                            current_project: projectInfo.project_name,
                            start_date: projectInfo.start_date,
                            end_date: projectInfo.end_date,
                            message: `${hrName} is currently active in project: ${projectInfo.project_name} (${projectInfo.start_date} to ${projectInfo.end_date})`
                        };
                    });
                    
                    showWarningModal(warnings);
                }
            });
        });
        
        function showWarningModal(warnings) {
            const warningList = document.getElementById('warningList');
            warningList.innerHTML = '';
            
            warnings.forEach(warning => {
                const li = document.createElement('li');
                li.className = 'mb-2 p-2 bg-light border-start border-warning border-3';
                li.innerHTML = `
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user text-warning me-2"></i>
                        <div>
                            <strong>${warning.hr_name}</strong><br>
                            <small class="text-muted">Currently active in: <strong>${warning.current_project}</strong></small>
                            ${warning.start_date && warning.end_date ? `<br><small class="text-muted"><i class="fas fa-calendar-alt"></i> ${new Date(warning.start_date).toLocaleDateString()} - ${new Date(warning.end_date).toLocaleDateString()}</small>` : ''}
                        </div>
                    </div>
                `;
                warningList.appendChild(li);
            });
            
            const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            modal.show();
        }
        
        document.getElementById('confirmProceed').addEventListener('click', function() {
            document.getElementById('confirmReassignment').value = '1';
            const modal = bootstrap.Modal.getInstance(document.getElementById('confirmationModal'));
            modal.hide();
            document.getElementById('projectForm').submit();
        });
    </script>
@endpush
    
</x-main-layout>