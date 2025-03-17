<div class="office-staff-list">
    <div class="mb-4">
        <h5 class="text-primary mb-1">{{ $office->name }}</h5>
        <p class="text-muted mb-0">
            <span class="badge bg-secondary me-2">{{ $office->level ?? 'N/A' }}</span>
            {{ $office->district->name ?? 'N/A' }}
        </p>
        <p class="mt-2 mb-0">
            <span class="badge bg-primary">{{ $staff->count() }} Staff Members</span>
        </p>
    </div>
    
    @if($staff->count() > 0)
        <div class="table-responsive">
            <table class="table table-sm table-hover">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th style="width: 60px;">Photo</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Contact</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($staff as $index => $employee)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <img src="{{ $employee->getFirstMediaUrl('profile_pictures') ?: asset('admin/images/default-avatar.jpg') }}" 
                                     alt="{{ $employee->name }}" class="rounded-circle" 
                                     style="width: 40px; height: 40px; object-fit: cover;">
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $employee->name }}</div>
                                <div class="small text-muted">
                                    {{ $employee->profile->cnic ?? 'N/A' }}
                                </div>
                            </td>
                            <td>
                                @if($employee->currentPosting && $employee->currentPosting->designation)
                                    <div>{{ $employee->currentPosting->designation->name }}</div>
                                    <div class="small text-muted">
                                        {{ $employee->currentPosting->designation->bps ?? 'N/A' }}
                                    </div>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                <div>{{ $employee->email }}</div>
                                <div class="small text-muted">
                                    {{ $employee->profile->mobile_number ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.apps.hr.users.employee', $employee->uuid) }}" 
                                   class="btn btn-sm btn-outline-primary" target="_blank">
                                    <i class="bi bi-eye-fill"></i> Profile
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">
            <i class="bi bi-info-circle-fill me-2"></i>
            No staff members found for this office.
        </div>
    @endif
</div>