<div class="row" id="step-1">
    <div class="col-md-6 mb-2">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
    </div>
    <div class="col-md-6 mb-2">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
    </div>
    <div class="col-md-6 mb-2">
        <label for="landline_number">Landline Number</label>
        <input type="text" class="form-control" id="landline_number" name="profile[landline_number]" value="{{ old('profile.landline_number') }}">
    </div>
</div>

<div class="row" id="step-2">
    <div class="col-md-6 mb-2">
        <label for="office_id">Office</label>
        <select class="form-select" id="office_id" name="posting[office_id]">
            <option value="">Select Office</option>
            @foreach($data['offices'] as $office)
            <option value="{{ $office->id }}" {{ old('posting.office_id') == $office->id ? 'selected' : '' }}>
                {{ $office->name }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-2">
        <label for="designation_id">Designation</label>
        <select class="form-select" id="designation_id" name="posting[designation_id]">
            <option value="">Select Designation</option>
            @foreach($data['designations'] as $designation)
            <option value="{{ $designation->id }}" {{ old('posting.designation_id') == $designation->id ? 'selected' : '' }} data-bps="{{ $designation->bps }}">
                {{ $designation->name }}
            </option>
            @endforeach
        </select>
        <div id="vacancy-info" class="small"></div>
    </div>            
    <div class="col-md-6 mb-2">
        <label for="start_date">Start Date</label>
        <input type="date" class="form-control" id="start_date" name="posting[start_date]" value="{{ old('posting.start_date', now()->format('Y-m-d')) }}">
    </div>
</div>

<div id="step-3">
    <h5 class="mb-2">Roles Assignment</h5>
    <div class="mb-2">
        <input type="text" id="roleSearch" class="form-control" placeholder="Search for a role..." />
    </div>
    <div id="roles" class="inline-block-items">
        @foreach($data['roles'] as $role)
        <div class="form-check form-switch role-item">
            <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" role="switch" id="role{{ $role->id }}" {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}>
            <label class="form-check-label" for="role{{ $role->id }}">{{ $role->name }}</label>
        </div>
        @endforeach
    </div>

    <h5 class="mb-2">Direct Permissions (Use direct permission as a last resort)</h5>
    <div class="mb-2">
        <input type="text" id="permissionSearch" class="form-control" placeholder="Search for a permission..." />
    </div>
    <div id="permissions" class="inline-block-items">
        @foreach($data['permissions'] as $permission)
        <div class="form-check form-switch permission-item">
            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" role="switch" id="permission{{ $permission->id }}" {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
            <label class="form-check-label" for="permission{{ $permission->id }}">{{ $permission->name }}</label>
        </div>
        @endforeach
    </div>
</div>

<div id="step-4">
    <div class="col-md-12 mb-2">
        <label class="label" data-toggle="tooltip" title="Change Profile Picture">
            <img id="image-label-preview" src="{{ asset('admin/images/default-avatar.jpg') }}" alt="avatar" class="change-image img-fluid rounded-circle">
            <input type="file" id="image" name="image" class="sr-only" accept="image/*">
        </label>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#image-label-preview').attr('src', '{{ asset("admin/images/default-avatar.jpg") }}');
    });

    imageCropper({
        fileInput: '#image'
        , inputLabelPreview: '#image-label-preview'
        , aspectRatio: 9 / 10
    , });

    $('#featured_on').select2({
        theme: "bootstrap-5" 
        , width: '100%'
        , placeholder: 'Select Featured On'
        , closeOnSelect: true
        , dropdownParent: $('#featured_on').closest('.modal')
    , });

    $('#designation_id, #office_id').select2({
        theme: "bootstrap-5"
        , width: '100%'
        , placeholder: 'Select option'
        , closeOnSelect: true
        , dropdownParent: $('#office_id').closest('.modal')
    , });

    document.getElementById('roleSearch').addEventListener('keyup', function() {
        let searchQuery = this.value.toLowerCase();
        let roleItems = document.querySelectorAll('.role-item');

        roleItems.forEach(function(item) {
            let label = item.querySelector('label').innerText.toLowerCase();
            item.style.display = label.includes(searchQuery) ? '' : 'none';
        });
    });

    document.getElementById('permissionSearch').addEventListener('keyup', function() {
        let searchQuery = this.value.toLowerCase();
        let permissionItems = document.querySelectorAll('.permission-item');

        permissionItems.forEach(function(item) {
            let label = item.querySelector('label').innerText.toLowerCase();
            item.style.display = label.includes(searchQuery) ? '' : 'none';
        });
    });

    function createSanctionedPost() {
        const officeId = $('#office_id').val();
        const designationId = $('#designation_id').val();
        const designationName = $('#designation_id option:selected').text().trim();
        const officeName = $('#office_id option:selected').text().trim();
        
        $('#vacancy-info').html(`
            <div class="card mt-2">
                <div class="card-header bg-primary text-white">
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
                        <input type="number" class="form-control" id="total_positions" value="1" min="1">
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" onclick="checkVacancies()">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="saveSanctionedPost()">Create</button>
                    </div>
                </div>
            </div>
        `);
    }

    function saveSanctionedPost() {
        const officeId = $('#office_id').val();
        const designationId = $('#designation_id').val();
        const totalPositions = $('#total_positions').val();
        
        $.ajax({
            url: "{{ route('admin.apps.hr.sanctioned-posts.quick-create') }}",
            type: "POST",
            data: {
                office_id: officeId,
                designation_id: designationId,
                total_positions: totalPositions,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.success) {
                    $('#vacancy-info').html(`
                        <div class="alert alert-success">
                            Sanctioned post created successfully.
                        </div>
                    `);
                    // Re-check vacancies after creation
                    setTimeout(checkVacancies, 1000);
                } else {
                    $('#vacancy-info').html(`
                        <div class="alert alert-danger">
                            ${response.error || 'Failed to create sanctioned post.'}
                        </div>
                    `);
                }
            },
            error: function(xhr) {
                let errorMessage = 'Failed to create sanctioned post.';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMessage = xhr.responseJSON.error;
                }
                $('#vacancy-info').html(`
                    <div class="alert alert-danger">
                        ${errorMessage}
                    </div>
                `);
            }
        });
    }

    // Function to check sanctioned post vacancies - simplified for new user
    function checkVacancies() {
        const officeId = $('#office_id').val();
        const designationId = $('#designation_id').val();
        const postingType = $('#posting_type').val();
        
        // Clear any previous messages
        $('#vacancy-info').html('');
        
        // Return early if not enough data
        if (!officeId || !designationId) {
            return;
        }
        
        $('#vacancy-info').html('<span class="text-info">Checking vacancy...</span>');
        
        // For regular postings (Appointment, Transfer, Promotion)
        $.ajax({
            url: "{{ route('admin.apps.hr.sanctioned-posts.check-exists') }}",
            type: "GET",
            data: {
                office_id: officeId,
                designation_id: designationId
            },
            dataType: 'json',
            success: function(response) {
                if (response.exists) {
                    if (response.has_vacancy) {
                        $('#vacancy-info').html(`
                            <span class="text-success">Vacancy available. (${response.filled}/${response.total} positions filled)</span>
                        `);
                    } else {
                        $('#vacancy-info').html(`
                            <span class="text-danger">No vacancy available. (${response.filled}/${response.total} positions filled)</span>
                            <input type="hidden" name="creating_in_excess" value="true">
                            <div class="form-text text-muted">
                                This position will be created in excess of sanctioned strength.
                            </div>
                        `);
                    }
                } else {
                    // The sanctioned post doesn't exist at all
                    $('#vacancy-info').html(`
                        <span class="text-danger">This position is not sanctioned for the selected office.</span>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" 
                            onclick="createSanctionedPost()">
                            Create Sanctioned Post
                        </button>
                    `);
                }
            },
            error: function() {
                $('#vacancy-info').html('<span class="text-danger">Error checking sanctioned post.</span>');
            }
        });
    }

    // Check vacancies when office or designation changes
    $('#office_id, #designation_id').change(function() {
        checkVacancies();
    });
</script>