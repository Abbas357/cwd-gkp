<x-service-card-layout title="Apply for Service Card">
    @push('style')
        <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
        <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
        <style>
            .user-search-results {
                padding: .2rem;
                max-height: 400px;
                overflow-y: auto;
            }

            .user-card {
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .user-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            }

            .user-card.selected {
                border-color: #0d6efd;
                background-color: #e7f1ff;
            }

            .action-section {
                display: none;
            }

            .action-section.active {
                display: block;
            }

            .form-control.is-invalid~.select2-container .select2-selection {
                border-color: #dc3545;
            }

            .invalid-feedback {
                display: block !important;
            }

            #form-error-alert {
                position: sticky;
                top: 20px;
                z-index: 1000;
                margin-bottom: 20px;
            }

            .profile-field {
                margin-bottom: 10px;
                padding: 8px 12px;
                border-radius: 4px;
            }

            .field-name {
                font-weight: 600;
                color: #495057;
            }

            .field-value {
                color: #6c757d;
                font-style: italic;
            }

            .required-field::after {
                content: " *";
                color: #dc3545;
            }
            
            .admin-notice {
                background-color: #f0f8ff;
                border-left: 4px solid #0066cc;
                padding: 15px;
                margin-bottom: 20px;
            }
        </style>
    @endpush

    <x-slot name="breadcrumbTitle">
        Apply for Service Card
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Service Card Application</li>
    </x-slot>

    <div class="mt-3">
        @if(isset($isAdminOrCanViewAny) && $isAdminOrCanViewAny)
        <div class="admin-notice">
            <i class="bi bi-shield-check"></i> <strong>Administrator Mode:</strong> You can create service cards for any user across all offices.
        </div>
        @endif
        
        <!-- Step 1: User Selection -->
        <div class="card shadow-md mb-4">
            <div class="card-header bg-primary-subtle text-white">
                <h4 class="mb-0"><i class="bi bi-person-search"></i> Step 1: Search & Select User</h4>
            </div>
            <div class="card-body">
                <div class="mx-auto">
                    <div class="input-group p-3">
                        <input type="text" class="form-control fs-5 shadow-sm py-3 px-4 rounded-pill" id="userSearch"
                            placeholder="Search by name, CNIC, email, personnel number, Office or Designation...">
                    </div>

                    <div id="searchResults" class="user-search-results"></div>

                    <div id="selectedUserDisplay" class="alert alert-info d-none">
                        <h6>Selected User:</h6>
                        <div id="selectedUserInfo"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2: Action Selection -->
        <div id="actionSection" class="card shadow-md mb-4 d-none">
            <div class="card-header bg-success-subtle text-white">
                <h4 class="mb-0"><i class="bi bi-card-checklist"></i> Step 2: Action Required</h4>
            </div>
            <div class="card-body">
                <div id="actionContent"></div>
            </div>
        </div>

        <!-- Profile Validation Section -->
        <div id="profileValidationSection" class="action-section">
            <div class="card shadow-md">
                <div class="card-header bg-warning-subtle text-dark">
                    <h4 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Profile Validation Required</h4>
                </div>
                <div class="card-body">
                    <div id="profileValidationContent"></div>
                </div>
            </div>
        </div>

        <!-- Apply for Service Card Section -->
        <div id="applySection" class="action-section">
            <div class="card shadow-md">
                <div class="card-header bg-info-subtle text-white">
                    <h4 class="mb-0"><i class="bi bi-credit-card"></i> Apply for Service Card</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-success bg-success-subtle">
                        <i class="bi bi-check-circle"></i> <strong>Profile Complete:</strong> All required information
                        is available for service card generation.
                    </div>

                    <form id="applyForm" method="POST" action="{{ route('admin.apps.service_cards.store') }}">
                        @csrf
                        <input type="hidden" name="user_id" id="apply_user_id">
                        <input type="hidden" name="posting_id" id="apply_posting_id">

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="remarks">Remarks (Optional)</label>
                                <textarea class="form-control" name="remarks" id="remarks" rows="3"
                                    placeholder="Add any special notes or remarks..."></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="cw-btn bg-success"
                                    confirm="Apply for service card for the selected User">
                                    <i class="bi bi-check-circle"></i> Apply for Service Card
                                </button>
                                <button type="button" class="cw-btn bg-secondary ms-2" onclick="resetSelection()">
                                    <i class="bi bi-x-circle"></i> Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Transfer Request Section -->
        <div id="transferSection" class="action-section">
            <div class="card shadow-md">
                <div class="card-header bg-warning-subtle text-dark">
                    <h4 class="mb-0"><i class="bi bi-arrow-left-right"></i> Transfer Request Required</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger">
                        This user is currently not part of your office. Please submit a transfer request to the IT Cell below and wait for approval. Once the user has been transferred to this office, you will be able to create a service card for them.
                    </div>

                    <form id="transferForm" class="row" method="POST"
                        action="{{ route('admin.transfer_requests.store') }}">
                        @csrf
                        <input type="hidden" name="user_id" id="transfer_user_id">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div>Current Designation: <span id="currentDesignation" class="fw-bold"></span></div>
                                <div>Current Office: <span id="currentOffice" class="fw-bold"></span></div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="to_designation_id">Designation here <span class="text-danger">(Leave blank if
                                    designation is same)</span></label>
                            <select class="form-select form-select-md" id="to_designation_id"
                                name="to_designation_id">
                                <option value="">Select Designation</option>
                                @foreach ($designations as $designation)
                                    <option value="{{ $designation->id }}"> {{ $designation->name }} </option>
                                @endforeach
                            </select>
                            <small class="form-text">Target Designation on which currently posted in this
                                office</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="posting_date">Date of Posting</label>
                            <input type="date" class="form-control" id="posting_date"
                                value="{{ old('posting_date') }}" placeholder="Start Date & Time" name="posting_date"
                                required>
                            @error('posting_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <small class="form-text">Date of transferred.</small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="remarks">Remarks</label>
                            <input type="text" class="form-control" id="remarks" value="{{ old('remarks') }}"
                                placeholder="Remarks" name="remarks">
                            @error('remarks')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <small class="form-text">Add any additional remarks regarding the transfer
                                (optional).</small>
                        </div>

                        <div>
                            <button type="submit" class="cw-btn bg-warning"
                                confirm="This will send a transfer request to the this office.">
                                <i class="bi bi-send"></i> Send Transfer Request
                            </button>

                            <button type="button" class="cw-btn bg-secondary ms-2" onclick="resetSelection()">
                                <i class="bi bi-x-circle"></i> Cancel
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- Create New User Section -->
        <div id="createUserSection" class="action-section">
            <div class="card shadow-md">
                <div class="card-header bg-primary-suble text-white">
                    <h4 class="mb-0"><i class="bi bi-person-plus"></i> Create New User</h4>
                </div>
                <div class="card-body">
                    <form id="createUserForm" method="POST"
                        action="{{ route('admin.apps.service_cards.users.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="apply_service_card" value="1">
                        <input type="hidden" name="posting_id" id="create_posting_id">

                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="mb-3">Personal Information</h5>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="name">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="father_name">Father Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="father_name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="cnic">CNIC Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="cnic" name="cnic"
                                            required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="date_of_birth">Date of Birth <span
                                                class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="date_of_birth" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="mobile_number">Mobile Number <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="mobile_number"
                                            name="mobile_number" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="personnel_number">Personnel Number <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="personnel_number" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="blood_group">Blood Group</label>
                                        <select class="form-select" name="blood_group">
                                            <option value="">Choose...</option>
                                            @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                                                <option value="{{ $bg }}">{{ $bg }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="permanent_address">Permanent Address <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="permanent_address" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="present_address">Present Address <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="present_address" required>
                                    </div>
                                </div>

                                <h5 class="mb-3 mt-4">Official Information</h5>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="designation_id">Designation <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="designation_id" name="designation_id"
                                            required>
                                            <option value="">Choose...</option>
                                            @foreach ($designations as $designation)
                                                <option value="{{ $designation->id }}">{{ $designation->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="office_id">Office <span class="text-danger">*</span></label>
                                        <select class="form-select" id="office_id" name="office_id" required>
                                            <option value="">Choose...</option>
                                            @foreach ($offices as $office)
                                                <option value="{{ $office->id }}">{{ $office->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Vacancy Check Section -->
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div id="vacancy-info" class="mt-2"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <h5 class="mb-3">Additional Information</h5>

                                <div class="mb-3">
                                    <label for="emergency_contact">Emergency Contact</label>
                                    <input type="text" class="form-control" id="emergency_contact"
                                        name="emergency_contact">
                                </div>

                                <div class="mb-3">
                                    <label for="mark_of_identification">Mark of Identification</label>
                                    <input type="text" class="form-control" name="mark_of_identification">
                                </div>

                                <div class="mb-3">
                                    <label for="profile_picture">Profile Picture</label>
                                    <input type="file" class="form-control" id="profile_picture"
                                        name="profile_picture" accept="image/*">
                                    <img id="profile_picture_preview" src="#" alt="Preview"
                                        style="display:none; margin-top: 10px; max-height: 200px;">
                                </div>

                                <div class="alert alert-info">
                                    <strong>Note:</strong> After creating the user, a service card application will be
                                    automatically created.
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-lg" id="createUserSubmit">
                                    <i class="bi bi-person-plus"></i> Create User & Apply for Card
                                </button>
                                <button type="button" class="btn btn-secondary btn-lg ms-2"
                                    onclick="resetSelection()">
                                    <i class="bi bi-x-circle"></i> Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Update Modal -->
    <div class="modal fade" id="profileUpdateModal" tabindex="-1" aria-labelledby="profileUpdateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileUpdateModalLabel">
                        <i class="bi bi-person-gear"></i> Update Profile Information
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="profileUpdateForm">
                        <input type="hidden" id="profile_user_id" name="user_id">

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="profile_father_name" class="required-field">Father Name</label>
                                <input type="text" class="form-control" id="profile_father_name"
                                    name="father_name" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="profile_cnic" class="required-field">CNIC Number</label>
                                <input type="text" class="form-control" id="profile_cnic" name="cnic"
                                    required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="profile_date_of_birth" class="required-field">Date of Birth</label>
                                <input type="date" class="form-control" id="profile_date_of_birth"
                                    name="date_of_birth" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="profile_mobile_number" class="required-field">Mobile Number</label>
                                <input type="text" class="form-control" id="profile_mobile_number"
                                    name="mobile_number" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="profile_personnel_number" class="required-field">Personnel Number</label>
                                <input type="text" class="form-control" id="profile_personnel_number"
                                    name="personnel_number" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="profile_blood_group">Blood Group</label>
                                <select class="form-select" id="profile_blood_group" name="blood_group">
                                    <option value="">Choose...</option>
                                    @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                                        <option value="{{ $bg }}">{{ $bg }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="profile_permanent_address" class="required-field">Permanent Address</label>
                            <textarea class="form-control" id="profile_permanent_address" name="permanent_address" rows="2" required></textarea>
                        </div>

                        <div class="mb-2">
                            <label for="profile_present_address" class="required-field">Present Address</label>
                            <textarea class="form-control" id="profile_present_address" name="present_address" rows="2" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="profile_emergency_contact">Emergency Contact</label>
                                <input type="text" class="form-control" id="profile_emergency_contact"
                                    name="emergency_contact">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="profile_mark_of_identification">Mark of Identification</label>
                                <input type="text" class="form-control" id="profile_mark_of_identification"
                                    name="mark_of_identification">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-primary" id="updateProfileBtn">
                        <i class="bi bi-check-circle"></i> Update Profile
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/jquery-mask/jquery.mask.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
        <script>
            let selectedUser = null;
            let searchTimeout = null;
            const isAdminOrCanViewAny = {{ isset($isAdminOrCanViewAny) && $isAdminOrCanViewAny ? 'true' : 'false' }};

            const requiredFields = {
                'father_name': 'Father Name',
                'cnic': 'CNIC Number',
                'date_of_birth': 'Date of Birth',
                'mobile_number': 'Mobile Number',
                'emergency_contact': 'Emergency Contact',
                'personnel_number': 'Personnel Number',
                'permanent_address': 'Permanent Address',
                'present_address': 'Present Address',
                'mark_of_identification': 'Mark of Identification'
            };

            $(document).ready(function() {
                $('.form-select').select2({
                    theme: 'bootstrap-5'
                });

                $('#mobile_number, #profile_mobile_number').mask('0000-0000000', {
                    placeholder: "____-_______"
                });
                $('#emergency_contact, #profile_emergency_contact').mask('0000-0000000', {
                    placeholder: "____-_______"
                });
                $('#cnic, #profile_cnic').mask('00000-0000000-0', {
                    placeholder: "_____-_______-_"
                });

                imageCropper({
                    fileInput: "#profile_picture",
                    inputLabelPreview: "#profile_picture_preview",
                    aspectRatio: 5 / 6,
                    onComplete() {
                        $("#profile_picture_preview").show();
                    }
                });

                $('#userSearch').on('input', debounce(function() {
                    const query = $(this).val();
                    if (query.length < 3) {
                        $('#searchResults').html('');
                        return;
                    }

                    searchUsers(query);
                }, 500));

                $('#userSearch').on('focus', function() {
                    resetSelection();
                });

                $('#designation_id, #office_id').change(function() {
                    checkVacancies();
                });

                $('#updateProfileBtn').on('click', function() {
                    updateUserProfile();
                });
            });

            async function searchUsers(query) {
                $('#searchResults').html('<div class="text-center"><div class="spinner-border" role="status"></div></div>');

                const url = new URL('{{ route('admin.apps.service_cards.users.search') }}');
                url.searchParams.append('q', query);
                url.searchParams.append('for_service_card', 'true');

                try {
                    const response = await fetch(url.toString(), {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }

                    const result = await response.json();

                    const users = result.data || result.result || result;
                    displaySearchResults(users);

                } catch (error) {
                    console.error('Search error:', error);
                    $('#searchResults').html('<div class="alert alert-danger">Error searching users</div>');
                }
            }

            function displaySearchResults(results) {
                if (results.length === 0) {
                    $('#searchResults').html(`
                        <div class="alert alert-warning">
                            No users found. Would you like to create a new user?
                            <button class="btn btn-sm btn-primary ms-2" onclick="showCreateUserForm()">
                                <i class="bi bi-person-plus"></i> Create New User
                            </button>
                        </div>
                    `);
                    return;
                }

                const subordinates = results.filter(user => user.is_subordinate && !user.is_admin_override);
                const nonSubordinates = results.filter(user => !user.is_subordinate && !user.is_admin_override);
                const adminOverride = results.filter(user => user.is_admin_override);

                let html = '';

                // Show Admin Override section if applicable
                if (isAdminOrCanViewAny && adminOverride.length > 0) {
                    html += `
                        <div class="mb-4 border border-info">
                            <h5 class="text-secondary bg-info-subtle p-1 mb-3">All Users (Administrator Access)</h5>
                    `;
                    html += '<div class="row">';
                    adminOverride.forEach(user => {
                        const hasServiceCard = user.has_service_card;
                        html += `
                            <div class="col-md-4 mb-3">
                                <div class="card user-card" onclick="selectUser(${JSON.stringify(user).replace(/"/g, '&quot;')})">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="${user.profile_picture}" 
                                                    class="rounded-circle" width="50" height="50">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0">${user.name}</h6>
                                                <small class="text-muted">${user.designation || 'N/A'} - ${user.office || 'N/A'}</small>
                                                <br>
                                                <small>CNIC: ${user.cnic || 'N/A'} | Personnel: ${user.personnel_number || 'N/A'}</small>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            ${hasServiceCard ? '<span class="badge bg-success">Has Service Card</span>' : ''}
                                            <span class="badge bg-info">Admin Access</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    html += '</div>';
                    html += '</div>';
                } else {
                    html += `
                        <div class="mb-4 border border-success"><h5 class="text-secondary bg-success-subtle p-1 mb-3">Users in Your Office</h5>
                    `;

                    if (subordinates.length > 0) {
                        html += '<div class="row">';
                        subordinates.forEach(user => {
                            const hasServiceCard = user.has_service_card;
                            html += `
                                <div class="col-md-4 mb-3">
                                    <div class="card user-card" onclick="selectUser(${JSON.stringify(user).replace(/"/g, '&quot;')})">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="${user.profile_picture}" 
                                                        class="rounded-circle" width="50" height="50">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0">${user.name}</h6>
                                                    <small class="text-muted">${user.designation || 'N/A'} - ${user.office || 'N/A'}</small>
                                                    <br>
                                                    <small>CNIC: ${user.cnic || 'N/A'} | Personnel: ${user.personnel_number || 'N/A'}</small>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                ${hasServiceCard ? '<span class="badge bg-success">Has Service Card</span>' : ''}
                                                <span class="badge bg-primary">In Your Office</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                        html += '</div>';
                    } else {
                        html += `
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> No users in this list by default
                            </div>
                        `;
                    }

                    html += '</div>';

                    html += `
                        <div class="mb-4 border border-warning">
                            <h5 class="text-secondary bg-warning-subtle p-1 mb-3">Users Not in Your Office</h5>
                    `;

                    if (nonSubordinates.length > 0) {
                        html += '<div class="row">';
                        nonSubordinates.forEach(user => {
                            const hasServiceCard = user.has_service_card;
                            html += `
                                <div class="col-md-4 mb-3">
                                    <div class="card user-card" onclick="selectUser(${JSON.stringify(user).replace(/"/g, '&quot;')})">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="${user.profile_picture}" 
                                                        class="rounded-circle" width="50" height="50">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0">${user.name}</h6>
                                                    <small class="text-muted">${user.designation || 'N/A'} - ${user.office || 'N/A'}</small>
                                                    <br>
                                                    <small>CNIC: ${user.cnic || 'N/A'} | Personnel: ${user.personnel_number || 'N/A'}</small>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                ${hasServiceCard ? '<span class="badge bg-success">Has Service Card</span>' : ''}
                                                <span class="badge bg-warning">Transfer Required</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                        html += '</div>';
                    } else {
                        html += `
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> No users in this list by default
                            </div>
                        `;
                    }

                    html += '</div>';
                }

                $('#searchResults').html(html);
            }

            function selectUser(user) {
                selectedUser = user;

                $('.user-card').removeClass('selected');
                event.currentTarget.classList.add('selected');

                $('#selectedUserDisplay').removeClass('d-none');
                $('#selectedUserInfo').html(`
                <strong>${user.name}</strong><br>
                ${user.designation || 'N/A'} - ${user.office || 'N/A'}<br>
                CNIC: ${user.cnic || 'N/A'}
            `);

                // Show appropriate action
                $('#actionSection').removeClass('d-none');
                $('.action-section').removeClass('active');

                if (user.has_service_card) {
                    $('#actionContent').html(`
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> This user already has a service card.
                        ${user.can_renew ? '<br>The card can be renewed.' : ''}
                    </div>
                `);
                } else if (user.is_subordinate || (isAdminOrCanViewAny && user.is_admin_override)) {
                    checkProfileCompletion(user);
                } else {
                    $('#transfer_user_id').val(user.id);
                    $('#currentOffice').text(user.office || 'N/A');
                    $('#currentDesignation').text(user.designation || 'N/A');
                    $('#transferSection').addClass('active');
                }
            }

            function checkProfileCompletion(user) {
                const profile = user.profile || {};
                const missingFields = [];
                const completedFields = [];

                Object.keys(requiredFields).forEach(field => {
                    const value = profile[field] || user[field];
                    if (!value || value.toString().trim() === '') {
                        missingFields.push({
                            field: field,
                            label: requiredFields[field]
                        });
                    } else {
                        completedFields.push({
                            field: field,
                            label: requiredFields[field],
                            value: value
                        });
                    }
                });

                if (missingFields.length > 0) {
                    showProfileValidation(user, missingFields, completedFields);
                } else {
                    $('#apply_user_id').val(user.id);
                    // For admin users, they might want to specify a different posting_id
                    if (isAdminOrCanViewAny) {
                        // You can add a field in the apply form for posting_id selection if needed
                        // For now, it will use the current user's posting_id
                    }
                    $('#applySection').addClass('active');
                }
            }

            function showProfileValidation(user, missingFields, completedFields) {
                let html = `
                <div class="p-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-exclamation-triangle text-warning fs-3 me-3"></i>
                        <div>
                            <h5 class="mb-1">Profile Incomplete</h5>
                            <p class="mb-0 text-muted">Some required fields are missing for service card generation.</p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-danger"><i class="bi bi-x-circle"></i> Missing Fields (${missingFields.length})</h6>
                            <div class="missing-fields">
            `;

                missingFields.forEach(item => {
                    html += `
                    
                    <div class="profile-field bg-danger-subtle">
                        <span class="field-name">${item.label}</span>
                        <span class="field-value">Not provided</span>
                    </div>
                `;
                });

                html += `
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-success"><i class="bi bi-check-circle"></i> Completed Fields (${completedFields.length})</h6>
                            <div class="completed-fields">
            `;

                completedFields.forEach(item => {
                    html += `
                    <div class="profile-field bg-success-subtle">
                        <span class="field-name">${item.label}</span>
                        <span class="field-value">${item.value}</span>
                    </div>
                `;
                });

                html += `
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-2">
                        <button type="button" class="cw-btn bg-success" onclick="openProfileUpdateModal('${user.id}')">
                            <i class="bi bi-pencil-square"></i> Update Profile
                        </button>
                        <button type="button" class="cw-btn bg-secondary ms-2" onclick="resetSelection()">
                            <i class="bi bi-x-circle"></i> Cancel
                        </button>
                    </div>
                </div>
            `;

                $('#profileValidationContent').html(html);
                $('#profileValidationSection').addClass('active');
            }

            function openProfileUpdateModal(userId) {
                $('#profile_user_id').val(userId);

                const profile = selectedUser.profile || {};

                $('#profile_father_name').val(profile.father_name || '');
                $('#profile_cnic').val(profile.cnic || '');
                $('#profile_date_of_birth').val(profile.date_of_birth || '');
                $('#profile_mobile_number').val(profile.mobile_number || '');
                $('#profile_personnel_number').val(profile.personnel_number || '');
                $('#profile_blood_group').val(profile.blood_group || '');
                $('#profile_permanent_address').val(profile.permanent_address || '');
                $('#profile_present_address').val(profile.present_address || '');
                $('#profile_emergency_contact').val(profile.emergency_contact || '');
                $('#profile_mark_of_identification').val(profile.mark_of_identification || '');

                $('#profileUpdateModal').modal('show');
            }

            async function updateUserProfile() {
                const userId = $('#profile_user_id').val();
                const formData = new FormData(document.getElementById('profileUpdateForm'));

                const updateBtn = $('#updateProfileBtn');
                const originalBtnHtml = updateBtn.html();
                updateBtn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm me-2"></span>Updating...');
                const url = "{{ route('admin.apps.service_cards.users.update', ':user') }}".replace(':user', userId);
                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const result = await response.json();

                    if (!response.ok) {
                        if (response.status === 422) {
                            handleValidationErrors(result.errors);
                            return;
                        } else {
                            throw new Error(result.message || result.error || 'An error occurred');
                        }
                    }

                    if (!selectedUser.profile) {
                        selectedUser.profile = {};
                    }

                    Object.keys(requiredFields).forEach(field => {
                        if (formData.has(field)) {
                            selectedUser.profile[field] = formData.get(field);
                        }
                    });

                    $('#profileUpdateModal').modal('hide');
                    showNotification('Profile updated successfully!', 'success');
                    checkProfileCompletion(selectedUser);

                } catch (error) {
                    showNotification(error.message || 'Failed to update profile', 'error');
                } finally {
                    updateBtn.prop('disabled', false).html(originalBtnHtml);
                }
            }

            function showCreateUserForm() {
                selectedUser = null;
                $('#selectedUserDisplay').addClass('d-none');
                $('#actionSection').removeClass('d-none');
                $('.action-section').removeClass('active');
                $('#createUserSection').addClass('active');
                
                // Set posting_id for admin users if needed
                if (isAdminOrCanViewAny) {
                    // For now, use current user's posting_id
                    // You can modify this to allow selection of posting_id
                }
            }

            function resetSelection() {
                selectedUser = null;
                $('#userSearch').val('');
                $('#searchResults').html('');
                $('#selectedUserDisplay').addClass('d-none');
                $('#actionSection').addClass('d-none');
                $('.action-section').removeClass('active');
                $('.user-card').removeClass('selected');
                $('#vacancy-info').html('');
            }

            async function checkVacancies() {
                const officeId = $('#office_id').val();
                const designationId = $('#designation_id').val();

                $('#vacancy-info').html('');

                if (!officeId || !designationId) {
                    return;
                }

                $('#vacancy-info').html('<span class="text-info">Checking vacancy...</span>');

                const url = new URL("{{ route('admin.apps.hr.sanctioned-posts.check-exists') }}");
                url.searchParams.append('office_id', officeId);
                url.searchParams.append('designation_id', designationId);

                try {
                    const response = await fetch(url.toString(), {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }

                    const result = await response.json();

                    const vacancyData = result.data || result.result || result;
                    displayVacancyInfo(vacancyData);

                } catch (error) {
                    console.error('Vacancy check error:', error);
                    $('#vacancy-info').html('<span class="text-danger">Error checking vacancy.</span>');
                }
            }

            function displayVacancyInfo(response) {
                if (!response.exists) {
                    $('#vacancy-info').html(`
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i> This position is not sanctioned for the selected office.
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" 
                            onclick="showCreateSanctionedPostForm()">
                            <i class="bi bi-plus-circle"></i> Create Sanctioned Post
                        </button>
                    </div>
                `);
                    $('#createUserSubmit').prop('disabled', true);
                } else if (!response.is_full) {
                    $('#vacancy-info').html(`
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle"></i> Vacancy available (${response.filled}/${response.total} positions filled)
                    </div>
                `);
                    $('#createUserSubmit').prop('disabled', false);

                    $('input[name="override_sanctioned_post"]').remove();
                    $('input[name="exceed_sanctioned"]').remove();
                    $('input[name="excess_justification"]').remove();
                } else {
                    $('#vacancy-info').html(`
                    <div class="alert alert-danger">
                        <i class="bi bi-x-circle"></i> No vacancy available (${response.filled}/${response.total} positions filled)
                        <button type="button" class="btn btn-sm btn-outline-warning mt-2" 
                            onclick="showOverrideOptions()">
                            <i class="bi bi-gear"></i> Override Options
                        </button>
                    </div>
                `);
                    $('#createUserSubmit').prop('disabled', true);
                }
            }

            function showCreateSanctionedPostForm() {
                const officeId = $('#office_id').val();
                const designationId = $('#designation_id').val();
                const designationName = $('#designation_id option:selected').text().trim();
                const officeName = $('#office_id option:selected').text().trim();

                $('#vacancy-info').html(`
                    <div class="card mt-2 shadow-md">
                        <div class="card-header bg-primary-subtle text-white">
                            <h6 class="mb-0">Create New Sanctioned Post</h6>
                        </div>
                        <div class="card-body">
                            <p>Creating sanctioned post for:</p>
                            <ul>
                                <li><strong>Office:</strong> ${officeName}</li>
                                <li><strong>Designation:</strong> ${designationName}</li>
                            </ul>
                            <div class="mb-3">
                                <label for="total_positions">Total Positions:</label>
                                <input type="number" class="form-control" id="total_positions" value="1" min="1" max="50">
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary me-2" onclick="checkVacancies()">Cancel</button>
                                <button type="button" class="btn btn-primary" onclick="saveSanctionedPost()">Create</button>
                            </div>
                        </div>
                    </div>
                `);
            }

            async function saveSanctionedPost() {
                const officeId = $('#office_id').val();
                const designationId = $('#designation_id').val();
                const totalPositions = $('#total_positions').val();

                const data = {
                    office_id: officeId,
                    designation_id: designationId,
                    total_positions: totalPositions
                };

                const success = await fetchRequest("{{ route('admin.apps.hr.sanctioned-posts.quick-create') }}", 'POST',
                    data, 'Sanctioned post created successfully');

                if (success) {
                    $('#createUserSubmit').prop('disabled', false);
                    setTimeout(checkVacancies, 1000);
                }
            }

            function showOverrideOptions() {
                $('#vacancy-info').html(`
                <div class="card mt-2">
                    <div class="card-header bg-warning-subtle text-dark">
                        <h6 class="mb-0">Override Options</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="override_option" id="exceed_sanctioned" value="exceed">
                            <label class="form-check-label" for="exceed_sanctioned">
                                <strong>Exceed Sanctioned Strength</strong><br>
                                <small class="text-muted">Create position in excess of sanctioned strength with justification</small>
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="override_option" id="override_sanctioned" value="override">
                            <label class="form-check-label" for="override_sanctioned">
                                <strong>Override Sanctioned Post Check</strong><br>
                                <small class="text-muted">Bypass sanctioned post validation completely</small>
                            </label>
                        </div>
                        <div id="justification_section" class="mb-3" style="display: none;">
                            <label for="excess_justification">Justification <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="excess_justification" name="excess_justification" 
                                rows="3" placeholder="Provide justification for this action..."></textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="checkVacancies()">Cancel</button>
                            <button type="button" class="btn btn-warning" onclick="applyOverride()">Apply Override</button>
                        </div>
                    </div>
                </div>
            `);

                // Show justification field when exceed option is selected
                $('input[name="override_option"]').change(function() {
                    if ($(this).val() === 'exceed') {
                        $('#justification_section').show();
                    } else {
                        $('#justification_section').hide();
                    }
                });
            }

            function applyOverride() {
                const selectedOption = $('input[name="override_option"]:checked').val();
                if (!selectedOption) return showNotification('Please select an override option.', 'error');

                if (selectedOption === 'exceed') {
                    const justification = $('#excess_justification').val();
                    if (!justification.trim()) {
                        showNotification('Please provide justification for exceeding sanctioned strength.', 'error');
                        return;
                    }

                    // Add hidden inputs to form
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'exceed_sanctioned',
                        value: '1'
                    }).appendTo('#createUserForm');

                    $('<input>').attr({
                        type: 'hidden',
                        name: 'excess_justification',
                        value: justification
                    }).appendTo('#createUserForm');

                    $('#vacancy-info').html(`
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i> User will be created in excess of sanctioned strength.
                        <br><small>Justification: ${justification}</small>
                    </div>
                `);
                } else {
                    // Override sanctioned post check completely
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'override_sanctioned_post',
                        value: '1'
                    }).appendTo('#createUserForm');

                    $('#vacancy-info').html(`
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Sanctioned post validation has been bypassed.
                    </div>
                `);
                }

                $('#createUserSubmit').prop('disabled', false);
            }

            $('#applyForm').on('submit', async function(e) {
                e.preventDefault();
                if (!selectedUser) return showNotification('Please select a user first', 'error');
            });

            $('#createUserForm').on('submit', async function(e) {
                e.preventDefault();

                const submitBtn = $('#createUserSubmit');
                const originalBtnHtml = submitBtn.html();
                submitBtn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm me-2"></span>Processing...');

                const formData = new FormData(this);

                try {
                    const response = await fetch($(this).attr('action'), {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const result = await response.json();

                    if (!response.ok) {
                        if (response.status === 422) {
                            handleValidationErrors(result.errors);
                            return;
                        } else {
                            throw new Error(result.message || result.error || 'An error occurred');
                        }
                    }

                    if (result.success !== false) {
                        showNotification(result.message, result.type);
                    }

                } catch (error) {
                    showNotification(error.message || 'Failed to create user', 'error');
                } finally {
                    submitBtn.prop('disabled', false).html(originalBtnHtml);
                }
            });
        </script>
    @endpush
</x-service-card-layout>