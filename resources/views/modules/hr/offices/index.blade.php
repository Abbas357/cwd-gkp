<x-hr-layout title="Offices">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Offices</li>
    </x-slot>

    <div class="card-header mb-3">
        <ul class="nav nav-tabs nav-tabs-table">
            <li class="nav-item">
                <a id="active-tab" class="nav-link" data-bs-toggle="tab" href="#active">Active</a>
            </li>
            <li class="nav-item">
                <a id="inactive-tab" class="nav-link" data-bs-toggle="tab" href="#inactive">Inactive</a>
            </li>
        </ul>
    </div>
    <table id="offices-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
        <thead>
            <tr>
                <th scope="col" class="p-3">ID</th>
                <th scope="col" class="p-3">Name</th>
                <th scope="col" class="p-3">Type</th>
                <th scope="col" class="p-3">Parent Office</th>
                <th scope="col" class="p-3">District</th>
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
            var table = initDataTable('#offices-datatable', {
                ajaxUrl: "{{ route('admin.apps.hr.offices.index') }}",
                columns: [
                    {data: "id", searchBuilderType: "num"},
                    {data: "name", searchBuilderType: "string"},
                    {data: "type", searchBuilderType: "string"},
                    {data: "parent_id", searchBuilderType: "string"},
                    {data: "district", searchBuilderType: "string"},
                    {data: "created_at", searchBuilderType: "date"},
                    {data: "updated_at", searchBuilderType: "date"},
                    {data: 'action', orderable: false, searchable: false, type: "html"}
                ],
                defaultOrderColumn: 6,
                defaultOrderDirection: 'desc',
                columnDefs: [{
                    targets: [0],
                    visible: false
                }],
                customButton: {
                    text: `<span class="symbol-container create-btn fw-bold"><i class="bi-plus-circle"></i>&nbsp; Add Office</span>`,
                    action: function(e, dt, node, config) {

                        pushStateModal({
                            fetchUrl: "{{ route('admin.apps.hr.offices.create') }}",
                            btnSelector: '.create-btn',
                            title: 'Add Office',
                            actionButtonName: 'Add Office',
                            modalSize: 'md',
                            includeForm: true,
                            formAction: "{{ route('admin.apps.hr.offices.store') }}",
                            hash: false,
                            tableToRefresh: table
                        });

                    },
                }
            });

            hashTabsNavigator({
                table: table,
                dataTableUrl: "{{ route('admin.apps.hr.offices.index') }}",
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

            $("#offices-datatable").on('click', '.activate-btn', async function() {
                const officeId = $(this).data("id");
                const message = $(this).data("type");
                const url = "{{ route('admin.apps.hr.offices.activate', ':id') }}".replace(':id', officeId);

                const result = await confirmAction(`Do you want to ${message} this office?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#offices-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#offices-datatable").on('click', '.delete-btn', async function() {
                const officeId = $(this).data("id");
                const url = "{{ route('admin.apps.hr.offices.destroy', ':id') }}".replace(':id', officeId);

                const result = await confirmAction(`Do you want to delete this office?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#offices-datatable").DataTable().ajax.reload();
                    }
                }
            });

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.hr.offices.detail', ':id') }}",
                btnSelector: '.view-btn',
                title: 'Office Detail',
                modalSize: 'md',
            });

        });
    </script>
    @endpush
</x-hr-layout>