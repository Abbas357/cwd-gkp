<x-hr-layout>
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Sanctioned Posts</li>
    </x-slot>

    <div class="card-header mb-3">
        <ul class="nav nav-tabs nav-tabs-table">
            <li class="nav-item">
                <a id="inactive-tab" class="nav-link" data-bs-toggle="tab" href="#inactive">Inactive</a>
            </li>
            <li class="nav-item">
                <a id="active-tab" class="nav-link" data-bs-toggle="tab" href="#active">Active</a>
            </li>
        </ul>
    </div>

    <table id="sanctioned-posts-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
        <thead>
            <tr>
                <th scope="col" class="p-3">ID</th>
                <th scope="col" class="p-3">Office</th>
                <th scope="col" class="p-3">Designation</th>
                <th scope="col" class="p-3">Total Positions</th>
                <th scope="col" class="p-3">Filled Positions</th>
                <th scope="col" class="p-3">Vacant Positions</th>
                <th scope="col" class="p-3">Status</th>
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
    <script>
        $(document).ready(function() {
            var table = initDataTable('#sanctioned-posts-datatable', {
                ajaxUrl: "{{ route('admin.apps.hr.sanctioned-posts.index') }}",
                columns: [{
                    data: "id",
                    searchBuilderType: "num"
                }, {
                    data: "office_name",
                    searchBuilderType: "string"
                }, {
                    data: "designation_name",
                    searchBuilderType: "string"
                }, {
                    data: "total_positions",
                    searchBuilderType: "num"
                }, {
                    data: "filled_positions",
                    searchBuilderType: "num"
                }, {
                    data: "vacant_positions",
                    searchBuilderType: "num"
                }, {
                    data: "status",
                    searchBuilderType: "string"
                }, {
                    data: "created_at",
                    searchBuilderType: "date"
                }, {
                    data: "updated_at",
                    searchBuilderType: "date"
                }, {
                    data: 'action',
                    orderable: false,
                    searchable: false,
                    type: "html"
                }],
                defaultOrderColumn: 0,
                defaultOrderDirection: 'desc',
                columnDefs: [{
                    targets: [0],
                    visible: false
                }],
                pageLength: 25,
                customButton: {
                    text: `<span class="symbol-container fw-bold create-btn"><i class="bi-plus-circle"></i>&nbsp; Add Sanctioned Post</span>`,
                    action: function(e, dt, node, config) {
                        pushStateModal({
                            fetchUrl: "{{ route('admin.apps.hr.sanctioned-posts.create') }}",
                            btnSelector: '.create-btn',
                            title: 'Add Sanctioned Post',
                            actionButtonName: 'Add Sanctioned Post',
                            modalSize: 'md',
                            includeForm: true,
                            formAction: "{{ route('admin.apps.hr.sanctioned-posts.store') }}",
                            hash: false,
                            tableToRefresh: table
                        });
                    },
                }
            });

            hashTabsNavigator({
                table: table,
                dataTableUrl: "{{ route('admin.apps.hr.sanctioned-posts.index') }}",
                tabToHashMap: {
                    "#inactive-tab": '#inactive',
                    "#active-tab": '#active'
                },
                hashToParamsMap: {
                    '#inactive': {
                        status: 'Inactive'
                    },
                    '#active': {
                        status: 'Active'
                    }
                },
                defaultHash: '#active'
            });

            $("#sanctioned-posts-datatable").on('click', '.delete-btn', async function() {
                const spId = $(this).data("id");
                const url = "{{ route('admin.apps.hr.sanctioned-posts.destroy', ':id') }}".replace(':id', spId);

                const result = await confirmAction('Do you want to delete this sanctioned post?');

                if (result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#sanctioned-posts-datatable").DataTable().ajax.reload();
                    }
                }
            });

            resizableTable('#sanctioned-posts-datatable');

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.hr.sanctioned-posts.edit', ':id') }}",
                btnSelector: '.edit-btn',
                title: 'Sanctioned Post Detail',
                actionButtonName: 'Update Sanctioned Post',
                modalSize: 'md',
                includeForm: true,
                formAction: "{{ route('admin.apps.hr.sanctioned-posts.update', ':id') }}",
                tableToRefresh: table,
                formType: 'edit'
            })
        });
    </script>
    @endpush
</x-hr-layout>