<x-hr-layout title="Designations">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Designations</li>
    </x-slot>

    <div class="inward-tabs mb-3">
        <ul class="nav nav-tabs nav-tabs-table">
            <li class="nav-item">
                <a id="active-tab" class="nav-link" data-bs-toggle="tab" href="#active">Active</a>
            </li>
            <li class="nav-item">
                <a id="inactive-tab" class="nav-link" data-bs-toggle="tab" href="#inactive">Inactive</a>
            </li>
        </ul>
    </div>

    <table id="designations-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
        <thead>
            <tr>
                <th scope="col" class="p-3">ID</th>
                <th scope="col" class="p-3">Name</th>
                <th scope="col" class="p-3">BPS</th>
                <th scope="col" class="p-3">Created At</th>
                <th scope="col" class="p-3">Updated At</th>
                <th scope="col" class="p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    @push('script')
    <script src="{{ asset('admin/plugins/datatable/js/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = initDataTable('#designations-datatable', {
                ajaxUrl: "{{ route('admin.apps.hr.designations.index') }}",
                columns: [
                    {data: "id", searchBuilderType: "num"},
                    {data: "name", searchBuilderType: "string"},
                    {data: "bps", searchBuilderType: "string"},
                    {data: "created_at", searchBuilderType: "date"},
                    {data: "updated_at", searchBuilderType: "date"},
                    {data: 'action', orderable: false, searchable: false, type: "html"}
                ],
                defaultOrderColumn: 4,
                defaultOrderDirection: 'desc',
                columnDefs: [{
                    targets: [0],
                    visible: false
                    }, {
                        targets: -1,
                        className: 'action-column'
                    }
                ],
                customButton: {
                    text: `<span class="symbol-container create-btn fw-bold"><i class="bi-plus-circle"></i>&nbsp; Add Designation</span>`,
                    action: function(e, dt, node, config) {

                        pushStateModal({
                            fetchUrl: "{{ route('admin.apps.hr.designations.create') }}",
                            btnSelector: '.create-btn',
                            title: 'Add Designation',
                            actionButtonName: 'Add Designation',
                            modalSize: 'md',
                            includeForm: true,
                            formAction: "{{ route('admin.apps.hr.designations.store') }}",
                            hash: false,
                            tableToRefresh: table
                        });

                    },
                }
            });

            hashTabsNavigator({
                table: table,
                dataTableUrl: "{{ route('admin.apps.hr.designations.index') }}",
                tabToHashMap: {
                    "#active-tab": '#active',
                    "#inactive-tab": '#inactive',
                },
                hashToParamsMap: {
                    '#active': { status: 'Active' },
                    '#inactive': { status: 'Inactive' },
                },
                defaultHash: '#active'
            });

            $("#designations-datatable").on('click', '.activate-btn', async function() {
                const designationId = $(this).data("id");
                const message = $(this).data("type");
                const url = "{{ route('admin.apps.hr.designations.activate', ':id') }}".replace(':id', designationId);

                const result = await confirmAction(`Do you want to ${message} this designation?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#designations-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#designations-datatable").on('click', '.delete-btn', async function() {
                const designationId = $(this).data("id");
                const url = "{{ route('admin.apps.hr.designations.destroy', ':id') }}".replace(':id', designationId);

                const result = await confirmAction(`Do you want to delete this designation?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#designations-datatable").DataTable().ajax.reload();
                    }
                }
            });

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.hr.designations.detail', ':id') }}",
                btnSelector: '.view-btn',
                title: 'Designation Detail',
                modalSize: 'md',
                tableToRefresh: table,
            });

        });
    </script>
    @endpush
</x-hr-layout>