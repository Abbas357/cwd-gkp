<x-app-layout title="Transfers">
    @push('style')
        <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Transfers</li>
    </x-slot>

    <div class="inward-tabs mb-3">
        <ul class="nav nav-tabs nav-tabs-table">
            <li class="nav-item">
                <a id="pending-tab" class="nav-link" data-bs-toggle="tab" href="#pending">Pending</a>
            </li>
            <li class="nav-item">
                <a id="under-review-tab" class="nav-link" data-bs-toggle="tab" href="#under-review">Under Review</a>
            </li>
            <li class="nav-item">
                <a id="approved-tab" class="nav-link" data-bs-toggle="tab" href="#approved">Approved</a>
            </li>
            <li class="nav-item">
                <a id="rejected-tab" class="nav-link" data-bs-toggle="tab" href="#rejected">Rejected</a>
            </li>
        </ul>
    </div>

    <div class="table-responsive">
        <table id="transfer_requests-datatable" width="100%"
            class="table table-striped table-hover table-bordered align-center">
            <thead>
                <tr>
                    <th scope="col" class="p-3">ID</th>
                    <th scope="col" class="p-3">Type</th>
                    <th scope="col" class="p-3">User</th>
                    <th scope="col" class="p-3">Current Office</th>
                    <th scope="col" class="p-3">Current Designation</th>
                    <th scope="col" class="p-3">Requested Office</th>
                    <th scope="col" class="p-3">Requested Designation</th>
                    <th scope="col" class="p-3">Posting Date</th>
                    <th scope="col" class="p-3">Remarks</th>
                    <th scope="col" class="p-3">Created At</th>
                    <th scope="col" class="p-3">Updated At</th>
                    <th scope="col" class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <!--end row-->
    @push('script')
        <script src="{{ asset('admin/plugins/datatable/js/datatables.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/col-resizable.js') }}"></script>
        <script src="{{ asset('admin/plugins/html2canvas/html2canvas.min.js') }}"></script>

        <script>
            $(document).ready(function() {
                var table = initDataTable('#transfer_requests-datatable', {
                    ajaxUrl: "{{ route('admin.transfer_requests.index') }}",
                    columns: [{
                        data: "id",
                        searchBuilderType: "num"
                    }, {
                        data: "type",
                        searchBuilderType: "string"
                    }, {
                        data: "user",
                        searchBuilderType: "string"
                    }, {
                        data: "current_office",
                        searchBuilderType: "string"
                    }, {
                        data: "current_designation",
                        searchBuilderType: "string"
                    }, {
                        data: "requested_office",
                        searchBuilderType: "string"
                    }, {
                        data: "requested_designation",
                        searchBuilderType: "string"
                    }, {
                        data: "posting_date",
                        searchBuilderType: "date"
                    }, {
                        data: "remarks",
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
                    defaultOrderColumn: 5,
                    pushStateToUrl: true,
                    defaultOrderDirection: 'desc',
                    columnDefs: [{
                        targets: [0],
                        visible: false
                    }, {
                        targets: -1,
                        className: 'action-column'
                    }],
                    pageLength: 10,
                    customButton: {
                        text: `<span class="symbol-container create-btn fw-bold"><i class="bi-plus-circle"></i>&nbsp; Add Transfer</span>`,
                        action: function(e, dt, node, config) {

                            pushStateModal({
                                fetchUrl: "{{ route('admin.transfer_requests.create') }}",
                                btnSelector: '.create-btn',
                                title: 'Add Transfer',
                                actionButtonName: 'Add Transfer',   
                                modalSize: 'md',
                                includeForm: true,
                                formAction: "{{ route('admin.transfer_requests.store') }}",
                                hash: false,
                                tableToRefresh: table
                            });

                        },
                    }
                });

                $("#transfer_requests-datatable").on('click', '.delete-btn', async function() {
                    const requestId = $(this).data("id");
                    const url = "{{ route('admin.transfer_requests.destroy', ':id') }}".replace(':id', requestId);

                    const result = await confirmAction(`Do you want to delete this request?`);
                    if (result && result.isConfirmed) {
                        const success = await fetchRequest(url, 'DELETE');
                        if (success) {
                            $("#transfer_requests-datatable").DataTable().ajax.reload();
                        }
                    }
                });

                $("#transfer_requests-datatable").on('click', '.review-btn', async function() {
                    const requestId = $(this).data("id");
                    const url = "{{ route('admin.transfer_requests.review', ':id') }}".replace(':id', requestId);

                    const result = await confirmAction(`Do you want to under review this request?`);
                    if (result && result.isConfirmed) {
                        const success = await fetchRequest(url, 'PATCH');
                        if (success) {
                            $("#transfer_requests-datatable").DataTable().ajax.reload();
                        }
                    }
                });

                $("#transfer_requests-datatable").on('click', '.approve-btn', async function() {
                    const requestId = $(this).data("id");
                    const url = "{{ route('admin.transfer_requests.approve', ':id') }}".replace(':id', requestId);

                    const result = await confirmAction(`Do you want to approve this request?`);
                    if (result && result.isConfirmed) {
                        const success = await fetchRequest(url, 'PATCH');
                        if (success) {
                            $("#transfer_requests-datatable").DataTable().ajax.reload();
                        }
                    }
                });

                $("#transfer_requests-datatable").on('click', '.reject-btn', async function() {
                    const requestId = $(this).data("id");
                    const url = "{{ route('admin.transfer_requests.reject', ':id') }}".replace(':id', requestId);

                    const result = await confirmAction(`Do you want to reject this request?`);
                    if (result && result.isConfirmed) {
                        const success = await fetchRequest(url, 'PATCH');
                        if (success) {
                            $("#transfer_requests-datatable").DataTable().ajax.reload();
                        }
                    }
                });

                hashTabsNavigator({
                    table: table,
                    dataTableUrl: "{{ route('admin.transfer_requests.index') }}",
                    tabToHashMap: {
                        "#pending-tab": '#pending',
                        "#under-review-tab": '#under-review',
                        "#approved-tab": '#approved',
                        "#rejected-tab": '#rejected',
                    },
                    hashToParamsMap: {
                        '#pending': {
                            status: 'Pending'
                        },
                        '#under-review': {
                            status: 'Under Review'
                        },
                        '#approved': {
                            status: 'Approved'
                        },
                        '#rejected': {
                            status: 'Rejected'
                        },
                    },
                    defaultHash: '#pending'
                });

                $('#transfer_requests-datatable').colResizable({
                    liveDrag: true,
                    resizeMode: 'overflow',
                    postbackSafe: true,
                    useLocalStorage: true,
                    gripInnerHtml: "<div class='grip'></div>",
                    draggingClass: "dragging",
                });

                if (new URLSearchParams(window.location.search).get("create") === "true") {
                    document.querySelector(".create-btn")?.click();
                }
            });
        </script>
    @endpush
</x-app-layout>
