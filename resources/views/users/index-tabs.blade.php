<x-app-layout>
    @push('style')
    <link href="{{ asset('plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <ul class="nav nav-tabs nav-tabs-modal nav-primary" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#edit-info" role="tab" aria-selected="true">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class="bi bi-person me-1 fs-6"></i>
                                </div>
                                <div class="tab-title">Info</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#edit-roles" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class="bi bi-list me-1 fs-6"></i>
                                </div>
                                <div class="tab-title">Roles</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#edit-permissions" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class="bi bi-list me-1 fs-6"></i>
                                </div>
                                <div class="tab-title">Permissions</div>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="loading-spinner text-center mt-4">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="tab-content user-details p-1" style="display: none">
                        <div class="tab-pane tab-pane-modal fade show active" id="edit-info" role="tabpanel">
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
                        </div>

                        <div class="tab-pane tab-pane-modal fade" id="edit-roles" role="tabpanel">
                            <div class="col-md-12">
                                <label for="role">Role</label>
                                <input type="text" class="form-control" id="role" placeholder="Role" role="name" required>
                            </div>
                        </div>

                        <div class="tab-pane tab-pane-modal fade" id="edit-permissions" role="tabpanel">
                            <div class="col-md-12">
                                <label for="permission">Permission</label>
                                <input type="text" class="form-control" id="permission" placeholder="Permission" permission="name" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-3">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!--end row-->
    @push('script')
    <script src="{{ asset('plugins/datatable/js/datatables.min.js') }}"></script>
    <script src="{{ asset('plugins/col-resizable.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = initDataTable('#users-datatable', {
                ajaxUrl: "{{ route('users.index') }}"
                , columns: [{
                        data: "id"
                        , searchBuilderType: "num"
                    }
                    , {
                        data: "name"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "email"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "mobile_number"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "landline_number"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "designation"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "cnic"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "office"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "password_updated_at"
                        , searchBuilderType: "date"
                    }
                    , {
                        data: "is_active"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "created_at"
                        , searchBuilderType: "date"
                    }
                    , {
                        data: "updated_at"
                        , searchBuilderType: "date"
                    }
                    , {
                        data: 'action'
                        , orderable: false
                        , searchable: false
                        , type: "html"
                    }
                ]
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

                const modalHashParts = hash.split('-');
                const baseHash = modalHashParts[0];
                const tabHash = modalHashParts[1];

                if (baseHash === '#edit' && userId) {
                    const url = "{{ route('users.show', ':id') }}".replace(':id', userId);
                    $('#userEdit').modal('show');
                    $('#userEdit .loading-spinner').show();
                    $('#userEdit .user-details').hide();

                    const user = await fetchRequest(url);
                    if (user) {
                        $('#userEdit #name').val(user.name);
                        $('#userEdit #email').val(user.email);
                    } else {
                        $('#userEdit .modal-title').text('Error');
                        $('#userEdit .user-details').html('<p>Failed to load user data.</p>');
                    }
                    $('#userEdit .loading-spinner').hide();
                    $('#userEdit .user-details').show();

                    if(tabHash) {
                        $('.nav-tabs-modal a[href="#edit-' + tabHash + '"]').tab("show");
                        $(".tab-pane-modal").removeClass("active show");
                        $("#edit-"+tabHash).addClass("active show");
                    }
                }
            }

            $(document).on('click', '.edit-btn', function() {
                const userId = $(this).data('id');
                const newUrl = `${window.location.pathname}?id=${userId}#edit-info`;
                history.pushState(null, null, newUrl);
                openModalFromUrl();
            });

            $(window).on('popstate', function() {
                openModalFromUrl();
            });

            $('#userEdit').on('hidden.bs.modal', function() {
                history.pushState(null, null, window.location.pathname);
            });

            openModalFromUrl();

        });

    </script>
    @endpush
</x-app-layout>
