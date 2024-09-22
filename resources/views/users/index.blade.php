<x-app-layout>
    @push('style')
    <link href="{{ asset('plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Users</li>
    </x-slot>

    <div class="card-header mb-3">
        <ul class="nav nav-tabs nav-tabs-table">
            <li class="nav-item">
                <a id="active-tab" class="nav-link" data-bs-toggle="tab" href="#active">Active</a>
            </li>
            <li class="nav-item">
                <a id="inactive-tab" class="nav-link" data-bs-toggle="tab" href="#inactive">In Active</a>
            </li>
        </ul>
    </div>

    <table id="users-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
        <thead>
            <tr>
                <th scope="col" class="p-3">ID</th>
                <th scope="col" class="p-3">Name</th>
                <th scope="col" class="p-3">Email</th>
                <th scope="col" class="p-3">Mobile Number</th>
                <th scope="col" class="p-3">Landline Number</th>
                <th scope="col" class="p-3">Designation</th>
                <th scope="col" class="p-3">CNIC</th>
                <th scope="col" class="p-3">Office</th>
                <th scope="col" class="p-3">Password Updated</th>
                <th scope="col" class="p-3">Active</th>
                <th scope="col" class="p-3">Created At</th>
                <th scope="col" class="p-3">Updated At</th>
                <th scope="col" class="p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <div class="modal fade" id="userEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg {{--  modal-dialog-centered --}}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="user-update" class="needs-validation" novalidate>
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="loading-spinner text-center mt-2">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div class="user-details" style="display: none">
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
                            <div class="tab-content p-2 pt-3">
                                <div class="tab-pane fade show active" id="info-tab" role="tabpanel">
                                    <div class="row mb-4">
                                        <div class="col d-flex justify-content-center align-items-center">
                                            <label class="label" data-toggle="tooltip" title="Change Profile Picture">
                                                <img id="image-label-preview" alt="avatar" class="change-image img-fluid rounded-circle">
                                                <input type="file" id="image" name="image" class="sr-only" id="input" name="image" accept="image/*">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" placeholder="Full Name" name="name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email">Email Address</label>
                                            <input type="email" class="form-control" id="email" placeholder="Email Address" name="email" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <label for="name">Password</label>
                                            <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="mobile_number">Mobile No.</label>
                                            <input type="text" class="form-control" id="mobile_number" placeholder="Mobile No" name="mobile_number">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="landline_number">Landline Number.</label>
                                            <input type="text" class="form-control" id="landline_number" placeholder="Mobile No" name="landline_number">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="cnic">CNIC Number</label>
                                            <input type="text" class="form-control" id="cnic" placeholder="CNIC" name="cnic">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="designation">Designation</label>
                                            <select class="form-select" id="designation" name="designation" required></select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="office">Office</label>
                                            <select class="form-select" id="office" name="office" required></select>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="roles-tab" role="tabpanel">
                                    <h4 class="mb-4">Roles assigned</h4>
                                    <div id="roles" class="rand-grid">
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="permissions-tab" role="tabpanel">
                                    <h4 class="mb-4">Direct Permissions</h4>
                                    <div id="permissions" class="rand-grid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" id="update-user-btn" class="btn btn-primary px-3">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--end row-->
    @push('script')
    <script src="{{ asset('plugins/datatable/js/datatables.min.js') }}"></script>
    <script src="{{ asset('plugins/col-resizable.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-mask/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('plugins/cropper/js/cropper.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            
            imageCropper({
                fileInput: '#image',
                inputLabelPreview: '#image-label-preview',
            });

            // new bootstrap.Modal($('#userEdit'), {
            //     backdrop: 'static'
            // });

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
                , dropdownParent: $('#userEdit')
            , });
            $('#office').select2({
                theme: "bootstrap-5"
                , dropdownParent: $('#userEdit')
            , });

            var table = initDataTable('#users-datatable', {
                ajaxUrl: "{{ route('users.index') }}"
                , columns: [{
                    data: "id"
                    , searchBuilderType: "num"
                }, {
                    data: "name"
                    , searchBuilderType: "string"
                }, {
                    data: "email"
                    , searchBuilderType: "string"
                }, {
                    data: "mobile_number"
                    , searchBuilderType: "string"
                }, {
                    data: "landline_number"
                    , searchBuilderType: "string"
                }, {
                    data: "designation"
                    , searchBuilderType: "string"
                }, {
                    data: "cnic"
                    , searchBuilderType: "string"
                }, {
                    data: "office"
                    , searchBuilderType: "string"
                }, {
                    data: "password_updated_at"
                    , searchBuilderType: "date"
                }, {
                    data: "is_active"
                    , searchBuilderType: "string"
                }, {
                    data: "created_at"
                    , searchBuilderType: "date"
                }, {
                    data: "updated_at"
                    , searchBuilderType: "date"
                }, {
                    data: 'action'
                    , orderable: false
                    , searchable: false
                    , type: "html"
                }]
                , defaultOrderColumn: 9
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [7, 8, 9]
                    , visible: false
                }]
            });

            hashTabsNavigator({
                table: table
                , dataTableUrl: "{{ route('users.index') }}"
                , tabToHashMap: {
                    "#active-tab": '#active'
                    , "#inactive-tab": '#inactive'
                }
                , hashToParamsMap: {
                    '#active': {
                        active: 1
                    }
                    , '#inactive': {
                        active: 0
                    }
                }
                , defaultHash: '#active'
            });

            $("#users-datatable").on('click', '.delete-btn', async function() {
                const userId = $(this).data("id");
                const url = "{{ route('users.destroy', ':id') }}".replace(':id', userId);

                const result = await confirmAction('Do you want to delete this user?');

                if (result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#users-datatable").DataTable().ajax.reload();
                    }
                }
            });

            resizableTable('#users-datatable');

            async function openModalFromUrl() {
                const hash = window.location.hash;
                const urlParams = new URLSearchParams(window.location.search);
                const userId = urlParams.get('id');
                const url = "{{ route('users.show', ':id') }}".replace(':id', userId);
                const updateURL = "{{ route('users.update', ':id') }}".replace(':id', userId);
                $('#user-update').attr('action', updateURL);

                if (hash.startsWith('#edit') && userId) {
                    $('#userEdit').modal('show');
                    $('#userEdit .loading-spinner').show();
                    $('#userEdit .user-details').hide();

                    const data = await fetchRequest(url);
                    let user = data.user;

                    if (hash === '#edit-roles') {
                        $('[href="#roles-tab"]').tab('show');
                    } else if (hash === '#edit-permissions') {
                        $('[href="#permissions-tab"]').tab('show');
                    } else {
                        $('[href="#info-tab"]').tab('show');
                    }

                    if (data.user) {
                        $('#name').val(user.name);
                        $('#email').val(user.email);
                        $('#mobile_number').val(user.mobile_number);
                        $('#landline_number').val(user.landline_number);
                        $('#cnic').val(user.cnic);
                        $('#image-label-preview').attr('src', data.profile_picture);

                        $('#designation').empty()
                            .append('<option value="">Choose Designation</option>')
                            .append($.map(data.allDesignations, designation =>
                                `<option value="${designation.name}" ${designation.name === user.designation ? 'selected' : ''}>${designation.name}</option>`
                            ));

                        $('#office').empty()
                            .append('<option value="">Choose Office</option>')
                            .append($.map(data.allOffices, office =>
                                `<option value="${office.name}" ${office.name === user.office ? 'selected' : ''}>${office.name}</option>`
                            ));

                        const rolesContainer = $('#roles');
                        const permissionsContainer = $('#permissions');

                        function isRoleAssigned(role) {
                            return user.roles.some(userRole => userRole.name === role.name);
                        }

                        function isPermissionAssigned(permission) {
                            return user.permissions.some(userPermission => userPermission.name === permission.name);
                        }

                        $.each(data.allRoles, function(index, role) {
                            const isChecked = isRoleAssigned(role) ? 'checked' : '';

                            const $switchHtml = $(`
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="roles[]" value="${role.name}" role="switch" id="role${role.id}" ${isChecked}>
                                        <label class="form-check-label" for="role${role.id}">${role.name}</label>
                                    </div>
                                `);

                            rolesContainer.append($switchHtml);
                        });
                        $.each(data.allPermissions, function(index, permission) {
                            const isChecked = isPermissionAssigned(permission) ? 'checked' : '';

                            const $switchHtml = $(`
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="${permission.name}" role="switch" id="permission${permission.id}" ${isChecked}>
                                        <label class="form-check-label" for="permission${permission.id}">${permission.name}</label>
                                    </div>
                                `);

                            permissionsContainer.append($switchHtml);
                        });

                    } else {
                        $('#userEdit .modal-title').text('Error');
                        $('#userEdit .user-details').html('<p class="pb-0 pt-3 p-4">Failed to load user data.</p>');
                    }

                    $('#userEdit .loading-spinner').hide();
                    $('#userEdit .user-details').show();
                }

            }

            $(document).on('click', '.edit-btn', function() {
                const userId = $(this).data('id');
                const newUrl = `${window.location.pathname}?id=${userId}#edit`;
                history.pushState(null, null, newUrl);
                openModalFromUrl();
            });

            $(window).on('popstate', function() {
                openModalFromUrl();
            });

            $('#userEdit').on('hidden.bs.modal', function() {
                $('#roles').empty();
                $('#permissions').empty();
                $('#user-update').trigger("reset");
                history.pushState(null, null, window.location.pathname);
            });

            openModalFromUrl();

            $(document).on('submit', '#user-update', async function(e) {
                e.preventDefault();
                const form = this;
                const formData = new FormData(form);
                const url = $(this).attr('action');
                
                const result = await fetchRequest(url, 'POST', formData);
                if (result) {
                    form.reset();
                    setButtonLoading('#update-user-btn', false);
                    $('#userEdit').modal('hide');
                    $('#roles').empty();
                    $('#permissions').empty();
                    table.ajax.reload();
                }
            });

        });

    </script>
    @endpush
</x-app-layout>
