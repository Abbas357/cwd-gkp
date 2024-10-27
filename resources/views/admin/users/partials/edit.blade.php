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
        <div class="row p-2">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-4 d-flex justify-content-center align-items-center">
                        <label class="label" data-toggle="tooltip" title="Change Profile Picture">
                            <img id="image-label-preview" src="{{ getProfilePic($data['user']) }}" alt="avatar" class="change-image img-fluid rounded-circle">
                            <input type="file" id="image" name="image" class="sr-only" id="input" name="image" accept="image/*">
                        </label>
                    </div>
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" value="{{ old('name', $data['user']->name) }}" placeholder="Full Name" name="name" required>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" value="{{ old('username', $data['user']->username) }}" placeholder="Username" name="username">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" value="{{ old('email', $data['user']->email) }}" placeholder="Email Address" name="email" required>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mb-3">
                        <label for="mobile_number">Mobile No.</label>
                        <input type="text" class="form-control" id="mobile_number" value="{{ old('mobile_number', $data['user']->mobile_number) }}" placeholder="Mobile No" name="mobile_number">
                    </div>
                    <div class="col-lg-4 mb-3">
                        <label for="landline_number">Landline Number.</label>
                        <input type="text" class="form-control" id="landline_number" value="{{ old('landline_number', $data['user']->landline_number) }}" placeholder="Mobile No" name="landline_number">
                    </div>
                    <div class="col-lg-4 mb-3">
                        <label for="cnic">CNIC Number</label>
                        <input type="text" class="form-control" id="cnic" value="{{ old('cnic', $data['user']->cnic) }}" placeholder="CNIC" name="cnic">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-6">
                        <label for="designation">Designation</label>
                        <select class="form-select" id="designation" name="designation" required>
                            <option value="">Choose Designation</option>
                            @foreach($data['allDesignations'] as $designation)
                            <option value="{{ $designation->name }}" {{ $designation->name === $data['user']->designation ? 'selected' : '' }}> {{ $designation->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label for="office">Office</label>
                        <select class="form-select" id="office" name="office" required>
                            <option value="">Choose Office</option>
                            @foreach($data['allOffices'] as $office)
                            <option value="{{ $office->name }}" {{ $office->name === $data['user']->office ? 'selected' : '' }}> {{ $office->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-6">
                        <label for="bps">BPS</label>
                        <select class="form-select" id="bps" name="bps" required>
                            <option value="">Choose Designation</option>
                            @foreach($data['bps'] as $bps)
                            <option value="{{ $bps->name }}" {{ $bps->name === $data['user']->bps ? 'selected' : '' }}> {{ $bps->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" value="{{ old('title', $data['user']->title) }}" placeholder="Title" name="title">
                        @error('title')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mb-3">
                        <label for="posting_type">Posting Type</label>
                        <select class="form-select form-select-md" id="posting_type" name="posting_type">
                            <option value="">Select Option</option>
                            <option value="appointment" {{ $data['user']->posting_type === 'appointment' ? 'selected' : '' }}>Appointment</option>
                            <option value="transfer" {{ $data['user']->posting_type === 'transfer' ? 'selected' : '' }}>Transfer</option>
                        </select>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <label for="posting_date">Posting Date</label>
                        <input type="date" class="form-control" id="posting_date" value="{{ old('posting_date', $data['user']->posting_date) }}" placeholder="posting_date" name="posting_date">
                    </div>
                    <div class="col-lg-4 mb-3">
                        <label for="posting_order">Posting Order</label> {!! $data['user']->hasMedia('posting_orders') ? '<a class="font-weight-bold" target="_blank" href="' . $data['user']->getFirstMediaUrl('posting_orders') . '">View File</a>' : '' !!}
                        <input type="file" class="form-control" id="posting_order" value="{{ old('posting_order', $data['user']->posting_order) }}" name="posting_order">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mb-3">
                        <label for="exit_type">Exit Type</label>
                        <select class="form-select form-select-md" id="exit_type" name="exit_type">
                            <option value="">Select Option</option>
                            <option value="transfer" {{ $data['user']->exit_type === 'transfer' ? 'selected' : '' }}>Transfer</option>
                            <option value="retire" {{ $data['user']->exit_type === 'retire' ? 'selected' : '' }}>Retire</option>
                        </select>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <label for="exit_date">Exit Date</label>
                        <input type="date" class="form-control" id="exit_date" value="{{ old('exit_date', $data['user']->exit_date) }}" placeholder="exit_date" name="exit_date">
                    </div>
                    <div class="col-lg-4 mb-3">
                        <label for="exit_order">Exit Order</label> {!! $data['user']->hasMedia('exit_orders') ? '<a class="font-weight-bold" target="_blank" href="' . $data['user']->getFirstMediaUrl('exit_orders') . '">View File</a>' : '' !!}
                        <input type="file" class="form-control" id="exit_order" value="{{ old('exit_order', $data['user']->exit_order) }}" name="exit_order">
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <label for="message">Message</label>
                <div class="mb-3">
                    <textarea name="message" id="message" class="form-control" style="height:190px">{{ old('message', $data['user']->message) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="whatsapp">WhatsApp</label>
                    <input type="text" class="form-control" id="whatsapp" value="{{ old('whatsapp', $data['user']->whatsapp) }}" placeholder="whatsapp" name="whatsapp">
                </div>
                <div class="mb-3">
                    <label for="facebook">Facebook</label>
                    <input type="text" class="form-control" id="facebook" value="{{ old('facebook', $data['user']->facebook) }}" placeholder="facebook" name="facebook">
                </div>
                <div class="mb-3">
                    <label for="twitter">X (Formally Twitter)</label>
                    <input type="text" class="form-control" id="twitter" value="{{ old('twitter', $data['user']->twitter) }}" placeholder="twitter" name="twitter">
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="roles-tab" role="tabpanel">
        <h5 class="mb-4">Roles assigned</h5>
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

    <div class="tab-pane fade" id="permissions-tab" role="tabpanel">
        <h5 class="mb-4">Direct Permissions (Use direct permission as a last resort)</h5>
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
    
</div>


<script>
    imageCropper({
        fileInput: '#image'
        , inputLabelPreview: '#image-label-preview'
    , });

    imageCropper({
        fileInput: "#posting_order"
        , inputLabelPreview: "#posting_order"
        , aspectRatio: 1 / 1.58
    });

    imageCropper({
        fileInput: "#exit_order"
        , inputLabelPreview: "#exit_order"
        , aspectRatio: 1 / 1.58
    });

    $('#mobile_number').mask('0000-0000000', {
        placeholder: "____-_______"
    });

    $('#whatsapp').mask('0000-0000000', {
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

    document.getElementById('roleSearch').addEventListener('keyup', function() {
        let searchQuery = this.value.toLowerCase();
        let roleItems = document.querySelectorAll('.role-item');
        
        roleItems.forEach(function(item) {
            let label = item.querySelector('label').innerText.toLowerCase();
            
            if (label.includes(searchQuery)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });

    document.getElementById('permissionSearch').addEventListener('keyup', function() {
        let searchQuery = this.value.toLowerCase();
        let permissionItems = document.querySelectorAll('.permission-item');
        
        permissionItems.forEach(function(item) {
            let label = item.querySelector('label').innerText.toLowerCase();
            
            if (label.includes(searchQuery)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });
</script>
