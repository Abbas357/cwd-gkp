<x-app-layout>
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Users</li>
    </x-slot>

    <div class="card-header mb-3">
        <ul class="nav nav-tabs nav-tabs-table">
            <li class="nav-item">
                <a id="inactive-tab" class="nav-link" data-bs-toggle="tab" href="#inactive">In Active</a>
            </li>
            <li class="nav-item">
                <a id="active-tab" class="nav-link" data-bs-toggle="tab" href="#active">Active</a>
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
    <!--end row-->
    @push('script')
    <script src="{{ asset('admin/plugins/datatable/js/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/col-resizable.js') }}"></script>
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/jquery-mask/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = initDataTable('#users-datatable', {
                ajaxUrl: "{{ route('admin.users.index') }}"
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
                , defaultOrderColumn: 11
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [7, 8, 9]
                    , visible: false
                }]
                , customButton: {
                    text: `<span class="symbol-container fw-bold"><i class="bi-plus-circle"></i>&nbsp; Add User</span>`
                    , action: function(e, dt, node, config) {
                        window.location.href = "{{ route('admin.users.create') }}";
                    },

                }
            , });

            hashTabsNavigator({
                table: table
                , dataTableUrl: "{{ route('admin.users.index') }}"
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
                const url = "{{ route('admin.users.destroy', ':id') }}".replace(':id', userId);

                const result = await confirmAction('Do you want to delete this user?');

                if (result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#users-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#users-datatable").on('click', '.activate-btn', async function() {
                const userId = $(this).data("id");
                const message = $(this).data("type");
                const url = "{{ route('admin.users.activate', ':id') }}".replace(':id', userId);

                const result = await confirmAction(`Do you want to ${message} this user?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#users-datatable").DataTable().ajax.reload();
                    }
                }
            });

            resizableTable('#users-datatable');

            pushStateModal({
                fetchUrl: "{{ route('admin.users.edit', ':id') }}"
                , btnSelector: '.edit-btn'
                , title: 'User Detail'
                , actionButtonName: 'Update User'
                , modalSize: 'xl'
                , includeForm: true
                , formAction: "{{ route('admin.users.update', ':id') }}"
                , modalHeight: '75vh'
            , }).then((modal) => {
                const userModal = $('#' + modal);
                const updateUserBtn = userModal.find('button[type="submit"]');
                userModal.find('form').on('submit', async function(e) {
                    e.preventDefault();
                    const form = this;
                    const formData = new FormData(form);
                    const url = $(this).attr('action');
                    setButtonLoading(updateUserBtn, true);
                    try {
                        const result = await fetchRequest(url, 'POST', formData);
                        if (result) {
                            setButtonLoading(updateUserBtn, false);
                            userModal.modal('hide');
                            table.ajax.reload();
                        }
                    } catch (error) {
                        setButtonLoading(updateUserBtn, false);
                        console.error('Error during form submission:', error);
                    }
                });
            });

        });

    </script>
    @endpush
</x-app-layout>
