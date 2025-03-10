<x-hr-layout>
    @push('style')
    @endpush

    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">HR Dashboard</li>
    </x-slot>

    <div class="row">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Sanctioned Posts & Vacancies</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card radius-10 bg-info bg-gradient">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-white">Total Positions</p>
                                        <h4 class="mb-0 text-white">{{ $totalPositions }}</h4>
                                    </div>
                                    <div class="ms-auto text-white fs-3"><i class="bi bi-diagram-3"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card radius-10 bg-success bg-gradient">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-white">Filled Positions</p>
                                        <h4 class="mb-0 text-white">{{ $filledPositions }}</h4>
                                    </div>
                                    <div class="ms-auto text-white fs-3"><i class="bi bi-person-check"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card radius-10 bg-warning bg-gradient">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-dark">Vacant Positions</p>
                                        <h4 class="mb-0 text-dark">{{ $vacantPositions }}</h4>
                                    </div>
                                    <div class="ms-auto text-dark fs-3"><i class="bi bi-person-dash"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="table-responsive mt-3">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Office</th>
                                <th>Designation</th>
                                <th>Total</th>
                                <th>Filled</th>
                                <th>Vacant</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topVacancies as $vacancy)
                            <tr>
                                <td>{{ $vacancy->office->name }}</td>
                                <td>{{ $vacancy->designation->name }}</td>
                                <td>{{ $vacancy->total_positions }}</td>
                                <td>{{ $vacancy->filled_positions }}</td>
                                <td>
                                    <span class="badge {{ $vacancy->vacant_positions > 0 ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $vacancy->vacant_positions }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-end">
                    <a href="{{ route('admin.apps.hr.sanctioned-posts.index') }}" class="btn btn-sm btn-primary">View All Sanctioned Posts</a>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">My Team</h5>
                <a href="{{ route('admin.apps.hr.org-chart') }}" class="btn btn-sm btn-primary">View Full Organization</a>
            </div>
            <div class="card-body">
                @if($currentUser->currentPosting)
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Your Position</h6>
                                    <p class="mb-1"><strong>Designation:</strong> {{ optional($currentUser->currentDesignation)->name ?? 'Not Assigned' }}</p>
                                    <p class="mb-1"><strong>Office:</strong> {{ optional($currentUser->currentOffice)->name ?? 'Not Assigned' }}</p>
                                    <p class="mb-0"><strong>Since:</strong> {{ $currentUser->currentPosting->start_date->format('d M, Y') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Team Statistics</h6>
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <h3 class="mb-0">{{ count($directSubordinates) }}</h3>
                                            <p class="small mb-0">Direct Reports</p>
                                        </div>
                                        <div class="col-6">
                                            <h3 class="mb-0">{{ count($entireTeam) }}</h3>
                                            <p class="small mb-0">Total Team Size</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($directSupervisor)
                        <div class="mb-4">
                            <h6 class="mb-3">Your Supervisor</h6>
                            <div class="d-flex align-items-center">
                                <img src="{{ getProfilePic($directSupervisor) }}" alt="Supervisor" class="rounded-circle me-3" style="width: 50px; height: 50px;">
                                <div>
                                    <h6 class="mb-1">{{ $directSupervisor->name }}</h6>
                                    <p class="mb-1 small">{{ optional($directSupervisor->currentDesignation)->name ?? 'No Designation' }}</p>
                                    <p class="mb-0 small text-muted">{{ optional($directSupervisor->currentOffice)->name ?? 'No Office' }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if(count($directSubordinates) > 0)
                        <div class="mb-4">
                            <h6 class="mb-3">Direct Reports</h6>
                            <div class="row">
                                @foreach($directSubordinates as $subordinate)
                                    <div class="col-md-6 mb-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ getProfilePic($subordinate) }}" alt="Subordinate" class="rounded-circle me-3" style="width: 50px; height: 50px;">
                                                    <div>
                                                        <h6 class="mb-1">{{ $subordinate->name }}</h6>
                                                        <p class="mb-1 small">{{ optional($subordinate->currentDesignation)->name ?? 'No Designation' }}</p>
                                                        <p class="mb-0 small text-muted">{{ optional($subordinate->currentOffice)->name ?? 'No Office' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    @if(count($entireTeam) > count($directSubordinates))
                        <div>
                            <h6 class="mb-3">Extended Team</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Designation</th>
                                            <th>Office</th>
                                            <th>Reports To</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($extendedTeam as $member)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ getProfilePic($member) }}" alt="Team Member" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                                        {{ $member->name }}
                                                    </div>
                                                </td>
                                                <td>{{ optional($member->currentDesignation)->name ?? 'No Designation' }}</td>
                                                <td>{{ optional($member->currentOffice)->name ?? 'No Office' }}</td>
                                                <td>
                                                    @php
                                                        $memberSupervisor = $member->getDirectSupervisor();
                                                    @endphp
                                                    {{ $memberSupervisor ? $memberSupervisor->name : 'N/A' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        You don't have an active posting. When you are assigned to an office and designation, you'll be able to see your team here.
                    </div>
                @endif
            </div>
        </div>

    </div>
</x-hr-layout>