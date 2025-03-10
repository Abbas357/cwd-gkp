{{-- resources/views/admin/users/partials/edit-form.blade.php --}}
@method('patch')
<ul class="nav nav-tabs nav-primary" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" data-bs-toggle="tab" href="#basic-info-tab" role="tab" aria-selected="true">
            <div class="d-flex align-items-center">
                <div class="tab-icon"><i class="bi bi-person me-1 fs-6"></i></div>
                <div class="tab-title">Basic Info</div>
            </div>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" data-bs-toggle="tab" href="#profile-tab" role="tab" aria-selected="false">
            <div class="d-flex align-items-center">
                <div class="tab-icon"><i class="bi bi-card-text me-1 fs-6"></i></div>
                <div class="tab-title">Profile</div>
            </div>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" data-bs-toggle="tab" href="#posting-tab" role="tab" aria-selected="false">
            <div class="d-flex align-items-center">
                <div class="tab-icon"><i class="bi bi-briefcase me-1 fs-6"></i></div>
                <div class="tab-title">Posting</div>
            </div>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" data-bs-toggle="tab" href="#roles-tab" role="tab" aria-selected="false">
            <div class="d-flex align-items-center">
                <div class="tab-icon"><i class="bi bi-shield me-1 fs-6"></i></div>
                <div class="tab-title">Roles</div>
            </div>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" data-bs-toggle="tab" href="#permissions-tab" role="tab" aria-selected="false">
            <div class="d-flex align-items-center">
                <div class="tab-icon"><i class="bi bi-key me-1 fs-6"></i></div>
                <div class="tab-title">Permissions</div>
            </div>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" data-bs-toggle="tab" href="#reporting-tab" role="tab" aria-selected="false">
            <div class="d-flex align-items-center">
                <div class="tab-icon"><i class="bi bi-diagram-3 me-1 fs-6"></i></div>
                <div class="tab-title">Reporting</div>
            </div>
        </a>
    </li>
</ul>

<div class="tab-content p-2 pt-3">
    {{-- Basic Info Tab --}}
    <div class="tab-pane fade show active" id="basic-info-tab" role="tabpanel">
        <div class="row">
            <div class="col-lg-4 d-flex justify-content-center align-items-center mb-3">
                <label class="label" data-toggle="tooltip" title="Change Profile Picture">
                    <img id="image-label-preview" src="{{ getProfilePic($data['user']) }}" alt="avatar" class="change-image img-fluid rounded-circle">
                    <input type="file" id="image" name="image" class="sr-only" accept="image/*">
                </label>
            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $data['user']->name) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $data['user']->username) }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $data['user']->email) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current password">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="status">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="Active" {{ $data['user']->status === 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ $data['user']->status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="Archived" {{ $data['user']->status === 'Archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Profile Tab --}}
    <div class="tab-pane fade" id="profile-tab" role="tabpanel">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="cnic">CNIC</label>
                <input type="text" class="form-control" id="cnic" name="profile[cnic]" value="{{ old('profile.cnic', $data['user']->profile->cnic ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="mobile_number">Mobile Number</label>
                <input type="text" class="form-control" id="mobile_number" name="profile[mobile_number]" value="{{ old('profile.mobile_number', $data['user']->profile->mobile_number ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="landline_number">Landline Number</label>
                <input type="text" class="form-control" id="landline_number" name="profile[landline_number]" value="{{ old('profile.landline_number', $data['user']->profile->landline_number ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="whatsapp">WhatsApp</label>
                <input type="text" class="form-control" id="whatsapp" name="profile[whatsapp]" value="{{ old('profile.whatsapp', $data['user']->profile->whatsapp ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="facebook">Facebook</label>
                <input type="text" class="form-control" id="facebook" name="profile[facebook]" value="{{ old('profile.facebook', $data['user']->profile->facebook ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="twitter">Twitter</label>
                <input type="text" class="form-control" id="twitter" name="profile[twitter]" value="{{ old('profile.twitter', $data['user']->profile->twitter ?? '') }}">
            </div>
            <div class="col-12 mb-3">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" name="profile[message]" rows="3">{{ old('profile.message', $data['user']->profile->message ?? '') }}</textarea>
            </div>
            <div class="col-12 mb-3">
                <label for="featured_on">Featured On</label>
                <select class="form-select" id="featured_on" name="profile[featured_on][]" multiple>
                    @php
                    $featuredOn = $data['user']->profile?->featured_on
                    ? json_decode($data['user']->profile->featured_on, true)
                    : [];
                    @endphp
                    <option value="Home" {{ in_array('Home', $featuredOn) ? 'selected' : '' }}>Home</option>
                    <option value="Team" {{ in_array('Team', $featuredOn) ? 'selected' : '' }}>Team</option>
                    <option value="Contact" {{ in_array('Contact', $featuredOn) ? 'selected' : '' }}>Contact</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Posting Tab --}}
    {{-- Modified Posting Tab for User Edit Form --}}
    <div class="tab-pane fade" id="posting-tab" role="tabpanel">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="office_id">Office</label>
                <select class="form-select" id="office_id" name="posting[office_id]">
                    <option value="">Select Office</option>
                    @foreach($data['allOffices'] as $office)
                    <option value="{{ $office->id }}" {{ optional($data['user']->currentPosting)->office_id == $office->id ? 'selected' : '' }}>
                        {{ $office->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="designation_id">Designation</label>
                <select class="form-select" id="designation_id" name="posting[designation_id]">
                    <option value="">Select Designation</option>
                    @foreach($data['allDesignations'] as $designation)
                    <option value="{{ $designation->id }}" {{ optional($data['user']->currentPosting)->designation_id == $designation->id ? 'selected' : '' }} data-bps="{{ $designation->bps }}">
                        {{ $designation->name }}
                    </option>
                    @endforeach
                </select>
                <div id="vacancy-info" class="mt-2 small"></div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="posting_type">Posting Type</label>
                <select class="form-select" id="posting_type" name="posting[type]">
                    <option value="">Select Posting Type</option>
                    <option value="Appointment" {{ optional($data['user']->currentPosting)->type === 'Appointment' ? 'selected' : '' }}>Appointment</option>
                    <option value="Transfer" {{ optional($data['user']->currentPosting)->type === 'Transfer' ? 'selected' : '' }}>Transfer</option>
                    <option value="Promotion" {{ optional($data['user']->currentPosting)->type === 'Promotion' ? 'selected' : '' }}>Promotion</option>
                    <option value="Retirement" {{ optional($data['user']->currentPosting)->type === 'Retirement' ? 'selected' : '' }}>Retirement</option>
                    <option value="Termination" {{ optional($data['user']->currentPosting)->type === 'Termination' ? 'selected' : '' }}>Termination</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="start_date">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="posting[start_date]" value="{{ old('posting.start_date', optional(optional($data['user']->currentPosting)->start_date)->format('Y-m-d')) }}">
            </div>
            <div class="col-md-12 mb-3">
                <label for="order_number">Order Number</label>
                <input type="text" class="form-control" id="order_number" name="posting[order_number]" value="{{ old('posting.order_number', optional($data['user']->currentPosting)->order_number) }}">
            </div>         
            <div class="col-12 mb-3">
                <label for="remarks">Remarks</label>
                <textarea class="form-control" id="remarks" name="posting[remarks]" rows="3">{{ old('posting.remarks', $data['user']->currentPosting->remarks ?? '') }}</textarea>
            </div>

            <div class="col-12">
                <div class="card bg-light mt-4">
                    <div class="card-body">
                        <h6 class="card-title">Posting History</h6>
                        @if($data['user']->postings->count() > 0)
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Designation</th>
                                    <th>Office</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['user']->postings->sortByDesc('start_date') as $posting)
                                <tr>
                                    <td>{{ $posting->type }}</td>
                                    <td>{{ optional($posting->designation)->name }}</td>
                                    <td>{{ optional($posting->office)->name }}</td>
                                    <td>{{ $posting->start_date->format('d M, Y') }}</td>
                                    <td>{{ $posting->end_date ? $posting->end_date->format('d M, Y') : 'Current' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p class="text-muted">No posting history available</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-3">
            <div class="card bg-light">
                <div class="card-header">
                    <h6 class="mb-0">District Information</h6>
                </div>
                <div class="card-body">
                    <div id="district-info-container">
                        @if($data['user']->currentOffice)
                            @php
                                $directDistrict = $data['user']->currentOffice->district;
                                $managedDistricts = $data['user']->currentOffice->getAllManagedDistricts();
                            @endphp
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="mb-2">Direct District Assignment</h6>
                                    @if($directDistrict)
                                        <span class="badge bg-primary">{{ $directDistrict->name }}</span>
                                    @else
                                        <span class="text-muted">No direct district assignment</span>
                                    @endif
                                </div>
                                
                                <div class="col-md-6">
                                    <h6 class="mb-2">Managed Districts</h6>
                                    @if($managedDistricts->count() > 0)
                                        @foreach($managedDistricts as $district)
                                            <span class="badge bg-secondary mb-1">{{ $district->name }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">No managed districts</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-text mt-3">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    District assignments are based on the office hierarchy. Higher-level office users manage districts of their subordinate offices.
                                </small>
                            </div>
                        @else
                            <div class="text-center text-muted">
                                <i class="bi bi-building-x mb-2" style="font-size: 2rem;"></i>
                                <p>No office assignment. District information will be available once an office is assigned.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Roles Tab (Same as before) --}}
    <div class="tab-pane fade" id="roles-tab" role="tabpanel">
        <h5 class="mb-3">Roles assigned</h5>
        <div class="mb-3">
            <input type="text" id="roleSearch" class="form-control" placeholder="Search for a role..." />
        </div>
        <div id="roles" class="inline-block-items">
            @foreach($data['allRoles'] as $role)
            <div class="form-check form-switch role-item">
                <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" role="switch" id="role{{ $role->id }}" @if($data['roles']->pluck('name')->contains($role->name)) checked @endif>
                <label class="form-check-label" for="role{{ $role->id }}">{{ $role->name }}</label>
            </div>
            @endforeach
        </div>
    </div>


    {{-- Permissions Tab (Same as before) --}}
    <div class="tab-pane fade" id="permissions-tab" role="tabpanel">
        <h5 class="mb-3">Direct Permissions (Use direct permission as a last resort)</h5>
        <div class="mb-3">
            <input type="text" id="permissionSearch" class="form-control" placeholder="Search for a permission..." />
        </div>
        <div id="permissions" class="inline-block-items">
            @foreach($data['allPermissions'] as $permission)
            <div class="form-check form-switch permission-item">
                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" role="switch" id="permission{{ $permission->id }}" @if($data['permissions']->pluck('name')->contains($permission->name)) checked @endif>
                <label class="form-check-label" for="permission{{ $permission->id }}">{{ $permission->name }}</label>
            </div>
            @endforeach
        </div>
    </div>

    <div class="tab-pane fade" id="reporting-tab" role="tabpanel">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="card-title">Current Position</h6>
                        <div class="d-flex align-items-center">
                            @if($data['user']->currentPosting)
                            <div>
                                <p class="mb-1"><strong>Designation:</strong>
                                    {{ optional($data['user']->currentDesignation)->name ?? 'Not Assigned' }}
                                </p>
                                <p class="mb-1"><strong>Office:</strong>
                                    {{ optional($data['user']->currentOffice)->name ?? 'Not Assigned' }}
                                </p>
                                <p class="mb-0"><strong>Since:</strong>
                                    {{ $data['user']->currentPosting->start_date->format('d M, Y') }}
                                </p>
                            </div>
                            @else
                            <p class="mb-0 text-muted">No active posting assigned.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Reports To</h6>
                    </div>
                    <div class="card-body" id="supervisor-container">
                        <div class="text-center py-3">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2 mb-0">Loading supervisor information...</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Subordinates</h6>
                    </div>
                    <div class="card-body" id="subordinates-container">
                        <div class="text-center py-3">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2 mb-0">Loading subordinate information...</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Reporting relationships are automatically determined based on the office hierarchy and user designations.
                    To change these relationships, you may need to modify the office structure or update user postings.
                </div>
            </div>
        </div>
    </div>


</div>

<script>
    $(document).ready(function() {
        $('a[data-bs-toggle="tab"][href="#reporting-tab"]').on('shown.bs.tab', function(e) {
            loadReportingRelationships();
        });

        function loadReportingRelationships() {
            $.ajax({
                url: "{{ route('admin.apps.hr.user-relationships') }}"
                , type: "GET"
                , data: {
                    user_id: "{{ $data['user']->id }}"
                }
                , success: function(response) {
                    // Update supervisor information
                    let supervisorHtml = '';
                    if (response.directSupervisor) {
                        supervisorHtml = `
                        <div class="d-flex align-items-center">
                            <img src="${getUserAvatar(response.directSupervisor)}" class="rounded-circle me-3" style="width: 50px; height: 50px;">
                            <div>
                                <h6 class="mb-1">${response.directSupervisor.name}</h6>
                                <p class="mb-1 small">${response.directSupervisor.current_designation ? response.directSupervisor.current_designation.name : 'No Designation'}</p>
                                <p class="mb-0 small text-muted">${response.directSupervisor.current_office ? response.directSupervisor.current_office.name : 'No Office'}</p>
                            </div>
                        </div>
                    `;
                    } else if (response.supervisors && response.supervisors.length > 0) {
                        supervisorHtml = '<div class="list-group">';
                        $.each(response.supervisors, function(index, supervisor) {
                            supervisorHtml += `
                            <div class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <img src="${getUserAvatar(supervisor)}" class="rounded-circle me-3" style="width: 40px; height: 40px;">
                                    <div>
                                        <h6 class="mb-1">${supervisor.name}</h6>
                                        <p class="mb-1 small">${supervisor.current_designation ? supervisor.current_designation.name : 'No Designation'}</p>
                                        <p class="mb-0 small text-muted">${supervisor.current_office ? supervisor.current_office.name : 'No Office'}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                        });
                        supervisorHtml += '</div>';
                    } else {
                        supervisorHtml = '<div class="alert alert-info">No direct supervisor found. This may be a top-level position.</div>';
                    }
                    $('#supervisor-container').html(supervisorHtml);

                    // Update subordinates information
                    let subordinatesHtml = '';
                    if (response.subordinates && response.subordinates.length > 0) {
                        subordinatesHtml = '<div class="list-group">';
                        $.each(response.subordinates, function(index, subordinate) {
                            subordinatesHtml += `
                            <div class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <img src="${getUserAvatar(subordinate)}" class="rounded-circle me-3" style="width: 40px; height: 40px;">
                                    <div>
                                        <h6 class="mb-1">${subordinate.name}</h6>
                                        <p class="mb-1 small">${subordinate.current_designation ? subordinate.current_designation.name : 'No Designation'}</p>
                                        <p class="mb-0 small text-muted">${subordinate.current_office ? subordinate.current_office.name : 'No Office'}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                        });
                        subordinatesHtml += '</div>';
                    } else {
                        subordinatesHtml = '<div class="alert alert-info">No subordinates found for this user.</div>';
                    }
                    $('#subordinates-container').html(subordinatesHtml);
                }
                , error: function() {
                    $('#supervisor-container').html('<div class="alert alert-danger">Error loading supervisor information.</div>');
                    $('#subordinates-container').html('<div class="alert alert-danger">Error loading subordinate information.</div>');
                }
            });
        }

        // Helper function to get user avatar
        function getUserAvatar(user) {
            // Replace with your actual method to get user profile picture
            return "{{ asset('admin/images/no-profile.png') }}";
        }
    });

    // Initialize image cropper
    imageCropper({
        fileInput: '#image'
        , inputLabelPreview: '#image-label-preview'
        , aspectRatio: 9 / 10
    , });

    // Initialize Select2 for dropdowns
    $('#featured_on').select2({
        theme: "bootstrap-5"
        , width: '100%'
        , placeholder: 'Select Featured On'
        , closeOnSelect: true
    , });
    // Initialize Select2 for other dropdowns
    $('#designation_id, #office_id').select2({
        theme: "bootstrap-5"
        , width: '100%'
        , placeholder: 'Select option'
        , closeOnSelect: true
    , });

    // Input masks
    $('#mobile_number, #whatsapp').mask('0000-0000000', {
        placeholder: "____-_______"
    });

    $('#cnic').mask('00000-0000000-0', {
        placeholder: "_____-_______-_"
    });

    // Search functionality for roles
    document.getElementById('roleSearch').addEventListener('keyup', function() {
        let searchQuery = this.value.toLowerCase();
        let roleItems = document.querySelectorAll('.role-item');

        roleItems.forEach(function(item) {
            let label = item.querySelector('label').innerText.toLowerCase();
            item.style.display = label.includes(searchQuery) ? '' : 'none';
        });
    });

    // Search functionality for permissions
    document.getElementById('permissionSearch').addEventListener('keyup', function() {
        let searchQuery = this.value.toLowerCase();
        let permissionItems = document.querySelectorAll('.permission-item');

        permissionItems.forEach(function(item) {
            let label = item.querySelector('label').innerText.toLowerCase();
            item.style.display = label.includes(searchQuery) ? '' : 'none';
        });
    });

    $(document).ready(function() {
        // Function to check sanctioned post vacancies
        function checkVacancies() {
            const officeId = $('#office_id').val();
            const designationId = $('#designation_id').val();
            const userId = '{{ $data['user']->id }}';
            if (officeId && designationId) {
                $('#vacancy-info').html('<span class="text-info">Checking vacancy...</span>');

                $.ajax({
                    url: "{{ route('admin.apps.hr.sanctioned-posts.available-positions') }}"
                    , type: "GET"
                    , data: {
                        office_id: officeId
                        , user_id: userId
                    }
                    , success: function(data) {
                        const position = data.find(p => p.id == designationId);

                        if (position) {
                            if (position.is_full && !position.current_user) {
                                $('#vacancy-info').html(`<span class="text-danger">No vacancy available. (${position.filled}/${position.total} positions filled)</span>`);
                            } else {
                                $('#vacancy-info').html(`<span class="text-success">Vacancy available. (${position.filled}/${position.total} positions filled)</span>`);
                            }
                        } else {
                            $('#vacancy-info').html('<span class="text-danger">This position is not sanctioned for the selected office.</span>');
                        }
                    }
                    , error: function() {
                        $('#vacancy-info').html('<span class="text-danger">Error checking vacancy.</span>');
                    }
                });
            } else {
                $('#vacancy-info').html('');
            }
        }

        function fetchDistrictInformation() {
            const officeId = $('#office_id').val();
            const designationId = $('#designation_id').val();
            const userId = '{{ $data['user']->id }}';
            $.ajax({
                url: "{{ route('admin.apps.hr.offices.district') }}",
                type: "GET",
                data: { office_id: officeId },
                success: function(response) {
                    if (response.success) {
                        let html = '<div class="row">';
                        
                        // Direct district
                        html += '<div class="col-md-6">';
                        html += '<h6 class="mb-2">Direct District Assignment</h6>';
                        if (response.district) {
                            html += '<span class="badge bg-primary">' + response.district.name + '</span>';
                        } else {
                            html += '<span class="text-muted">No direct district assignment</span>';
                        }
                        html += '</div>';
                        
                        // Managed districts
                        html += '<div class="col-md-6">';
                        html += '<h6 class="mb-2">Managed Districts</h6>';
                        if (response.managed_districts && response.managed_districts.length > 0) {
                            response.managed_districts.forEach(function(district) {
                                html += '<span class="badge bg-secondary mb-1 me-1">' + district.name + '</span>';
                            });
                        } else {
                            html += '<span class="text-muted">No managed districts</span>';
                        }
                        html += '</div>';
                        
                        html += '</div>';
                        
                        // Add info text
                        html += '<div class="form-text mt-3">' +
                                '<small class="text-muted">' +
                                '<i class="bi bi-info-circle me-1"></i>' +
                                'District assignments are based on the office hierarchy. Higher-level office users manage districts of their subordinate offices.' +
                                '</small>' +
                                '</div>';
                        
                        $('#district-info-container').html(html);
                    }
                },
                error: function() {
                    $('#district-info-container').html(
                        '<div class="alert alert-danger">Error loading district information</div>'
                    );
                }
            });
        }

        // Check vacancies when office or designation changes
        $('#office_id, #designation_id').change(function() {
            checkVacancies();
            fetchDistrictInformation();
        });

        // Initial check if values are already set
        if ($('#office_id').val() && $('#designation_id').val()) {
            checkVacancies();
            fetchDistrictInformation();
        }
    });

</script>
