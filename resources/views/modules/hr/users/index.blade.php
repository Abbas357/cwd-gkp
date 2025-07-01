<x-hr-layout>
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Users</li>
    </x-slot>

    <div class="inward-tabs mb-3">
        <ul class="nav nav-tabs nav-tabs-table">
            <li class="nav-item">
                <a id="inactive-tab" class="nav-link" data-bs-toggle="tab" href="#inactive">Inactive</a>
            </li>
            <li class="nav-item">
                <a id="active-tab" class="nav-link" data-bs-toggle="tab" href="#active">Active</a>
            </li>
            <li class="nav-item">
                <a id="archived-tab" class="nav-link" data-bs-toggle="tab" href="#archived">Archived</a>
            </li>
        </ul>
    </div>

    <table id="users-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
        <thead>
            <tr>
                <th scope="col" class="p-3">ID</th>
                <th scope="col" class="p-3">Name</th>
                <th scope="col" class="p-3">Username</th>
                <th scope="col" class="p-3">Email</th>
                <th scope="col" class="p-3">Current Posting</th>
                <th scope="col" class="p-3">Password Updated</th>
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
                ajaxUrl: "{{ route('admin.apps.hr.users.index') }}"
                , columns: [{
                    data: "id"
                    , searchBuilderType: "num"
                }, {
                    data: "name"
                    , searchBuilderType: "string"
                }, {
                    data: "username"
                    , searchBuilderType: "string"
                }, {
                    data: "email"
                    , searchBuilderType: "string"
                }, {
                    data: "current_posting"
                    , searchBuilderType: "string"
                    , orderable: false
                }, {
                    data: "password_updated_at"
                    , searchBuilderType: "date"
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
                , defaultOrderColumn: 0
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [0]
                    , visible: false
                    }, {
                        targets: -1,
                        className: 'action-column'
                    }
                ]
                , pageLength: 10
                , customButton: {
                    text: `<span class="symbol-container fw-bold create-btn"><i class="bi-plus-circle"></i>&nbsp; Add User</span>`
                    , action: function(e, dt, node, config) {

                        formWizardModal({
                            title: 'Add User',
                            fetchUrl: "{{ route('admin.apps.hr.users.create') }}",
                            btnSelector: '.create-btn',
                            actionButtonName: 'Add User',
                            modalSize: 'lg',
                            formAction: "{{ route('admin.apps.hr.users.store') }}",
                            wizardSteps: [
                                {
                                    title: "Basic Info",
                                    fields: ["#step-1"]
                                },
                                {
                                    title: "Posting",
                                    fields: ["#step-2"]
                                },
                                {
                                    title: "Images",
                                    fields: ["#step-4"]
                                }
                            ],
                            formSubmitted() {
                                table.ajax.reload();
                            }
                        });

                    },
                }


            , });

            hashTabsNavigator({
                table: table
                , dataTableUrl: "{{ route('admin.apps.hr.users.index') }}"
                , tabToHashMap: {
                    "#inactive-tab": '#inactive'
                    , "#active-tab": '#active'
                    , '#archived-tab': '#archived'
                }
                , hashToParamsMap: {
                    '#inactive': {
                        status: 'Inactive'
                    }
                    , '#active': {
                        status: 'Active'
                    }
                    , '#archived': {
                        status: 'Archived'
                    }
                }
                , defaultHash: '#active'
            });

            $("#users-datatable").on('click', '.delete-btn', async function() {
                const userId = $(this).data("id");
                const url = "{{ route('admin.apps.hr.users.destroy', ':id') }}".replace(':id', userId);

                const result = await confirmAction('Do you want to delete this user?');

                if (result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#users-datatable").DataTable().ajax.reload();
                    }
                }
            });

            resizableTable('#users-datatable');

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.hr.users.edit', ':id') }}"
                , btnSelector: '.edit-btn'
                , title: 'User Detail'
                , actionButtonName: 'Update User'
                , modalSize: 'lg'
                , includeForm: true
                , formAction: "{{ route('admin.apps.hr.users.update', ':id') }}"
                , tableToRefresh: table
                , formType: 'edit'
            , });

        });

    </script>
    @endpush
</x-hr-layout>
