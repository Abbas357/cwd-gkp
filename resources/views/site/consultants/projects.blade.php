<x-main-layout>
    @include('site.consultants.partials.header')

    <div class="container">
        <form class="needs-validation" action="{{ route('consultants.projects.store') }}" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="card cw-shadow mb-4 rounded-0">
                <div class="card-header bg-light fw-bold text-uppercase">
                    Projects <span class="ms-3 step-indicator">Step 3 of 3</span> <span class="ms-3 subtitle">Add all projects and allocate staff to each project</span>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="name">Name <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="name" value="{{ old('name') }}" placeholder="eg. Name of Project" name="name" required>
                            @error('name')
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
                            <label for="estimated_cost">Estimated Cost <abbr title="Required">*</abbr></label>
                            <input type="number" class="form-control" id="estimated_cost" value="{{ old('estimated_cost') }}" placeholder="Estimated Cost" name="estimated_cost" required>
                            @error('estimated_cost')
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
                            @if($availableHr->count() > 0)
                                <div class="row">
                                    @foreach($availableHr as $hr)
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="hr[]" value="{{ $hr->id }}" 
                                                       id="hr_{{ $hr->id }}"
                                                       {{ in_array($hr->id, old('hr', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="hr_{{ $hr->id }}">
                                                    <strong>{{ $hr->name }}</strong><br>
                                                    <small class="text-muted">
                                                        {{ $hr->designation }} | {{ $hr->email }}
                                                    </small>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <small class="form-text text-muted">
                                    Select human resources to assign to this project. Only approved HR that are not currently assigned to other active projects are shown.
                                </small>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    No available human resources for assignment. All approved HR are currently assigned to other active projects.
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

        <div class="card">
            <div class="card-body">
                <h3 class="card-title mb-3 p-2"> List of Projects </h3>
                <table class="table p-5 table-stripped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
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
</x-main-layout>
