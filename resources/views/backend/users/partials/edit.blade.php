<ul class="nav nav-tabs nav-primary" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" data-bs-toggle="tab" href="#info-tab" role="tab" aria-selected="true">
            <div class="d-flex align-items-center">
                <div class="tab-icon"><i class="bi bi-chevron-down me-1 fs-6"></i>
                </div>
                <div class="tab-title">Info</div>
            </div>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" data-bs-toggle="tab" href="#roles-tab" role="tab" aria-selected="false">
            <div class="d-flex align-items-center">
                <div class="tab-icon"><i class="bi bi-chevron-down me-1 fs-6"></i>
                </div>
                <div class="tab-title">Roles</div>
            </div>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" data-bs-toggle="tab" href="#permissions-tab" role="tab" aria-selected="false">
            <div class="d-flex align-items-center">
                <div class="tab-icon"><i class="bi bi-chevron-down me-1 fs-6"></i>
                </div>
                <div class="tab-title">Permissions</div>
            </div>
        </a>
    </li>
</ul>

@method('PATCH')
<div class="tab-content p-2 pt-3">
    <div class="tab-pane fade show active" id="info-tab" role="tabpanel">
        <div class="row mb-4">
            <div class="col d-flex justify-content-center align-items-center">
                <label class="label" data-toggle="tooltip" title="Change Profile Picture">
                    <img id="image-label-preview" src="{{ getProfilePic($data['user']) }}" alt="avatar" class="change-image img-fluid rounded-circle">
                    <input type="file" id="image" name="image" class="sr-only" id="input" name="image" accept="image/*">
                </label>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" value="{{ old('name', $data['user']->name) }}" placeholder="Full Name" name="name" required>
            </div>
            <div class="col-md-6">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" id="email" value="{{ old('email', $data['user']->email) }}" placeholder="Email Address" name="email" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="name">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password" name="password">
            </div>
            <div class="col-md-6">
                <label for="mobile_number">Mobile No.</label>
                <input type="text" class="form-control" id="mobile_number" value="{{ old('name', $data['user']->mobile_number) }}" placeholder="Mobile No" name="mobile_number">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="landline_number">Landline Number.</label>
                <input type="text" class="form-control" id="landline_number" value="{{ old('name', $data['user']->landline_number) }}" placeholder="Mobile No" name="landline_number">
            </div>
            <div class="col-md-6">
                <label for="cnic">CNIC Number</label>
                <input type="text" class="form-control" id="cnic" value="{{ old('name', $data['user']->cnic) }}" placeholder="CNIC" name="cnic">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="designation">Designation</label>
                <select class="form-select" id="designation" name="designation" required>
                    <option value="">Choose Designation</option>
                    @foreach($data['allDesignations'] as $designation)
                    <option value="{{ $designation->name }}" {{ $designation->name === $data['user']->designation ? 'selected' : '' }}> {{ $designation->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="office">Office</label>
                <select class="form-select" id="office" name="office" required>
                    <option value="">Choose Office</option>
                    @foreach($data['allOffices'] as $office)
                    <option value="{{ $office->name }}" {{ $office->name === $data['user']->office ? 'selected' : '' }}> {{ $office->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="roles-tab" role="tabpanel">
        <h4 class="mb-4">Roles assigned</h4>
        <div id="roles" class="rand-grid">
            @foreach($data['allRoles'] as $role)
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" role="switch" id="role{{ $role->id }}" @if($data['roles']->pluck('name')->contains($role->name)) checked @endif>
                <label class="form-check-label" for="role{{ $role->id }}">{{ $role->name }}</label>
            </div>
            @endforeach
        </div>
    </div>

    <div class="tab-pane fade" id="permissions-tab" role="tabpanel">
        <h4 class="mb-4">Direct Permissions</h4>
        <div id="permissions" class="rand-grid">
            @foreach($data['allPermissions'] as $permission)
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" role="switch" id="permission{{ $permission->id }}" @if($data['permissions']->pluck('name')->contains($permission->name)) checked @endif>
                <label class="form-check-label" for="permission{{ $permission->id }}">{{ $permission->name }}</label>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    imageCropper({
        fileInput: '#image'
        , inputLabelPreview: '#image-label-preview'
    , });

    $('#mobile_number').mask('0000-0000000', {
        placeholder: "____-_______"
    });

    $('#landline_number').mask('000-000000', {
        placeholder: "___-______"
    });

    $('#cnic').mask('00000-0000000-0', {
        placeholder: "_____-_______-_"
    });

    $('#designation').select2({
        theme: "bootstrap-5"
        , dropdownParent: $('#designation').parent()
    , });
    $('#office').select2({
        theme: "bootstrap-5"
        , dropdownParent: $('#office').parent()
    , });

</script>
