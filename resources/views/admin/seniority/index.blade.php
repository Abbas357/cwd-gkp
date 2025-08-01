<x-app-layout title="Seniority">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Seniority</li>
    </x-slot>

    <div class="inward-tabs mb-3">
        <ul class="nav nav-tabs nav-tabs-table">
            <li class="nav-item">
                <a id="draft-tab" class="nav-link" data-bs-toggle="tab" href="#draft">Draft</a>
            </li>
            <li class="nav-item">
                <a id="published-tab" class="nav-link" data-bs-toggle="tab" href="#published">Published</a>
            </li>
            <li class="nav-item">
                <a id="archived-tab" class="nav-link" data-bs-toggle="tab" href="#archived">Archived</a>
            </li>
        </ul>
    </div>

    <div class="table-responsive">
        <table id="seniority-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
            <thead>
                <tr>
                    <th scope="col" class="p-3">ID</th>
                    <th scope="col" class="p-3">Title</th>
                    <th scope="col" class="p-3">Designation</th>
                    <th scope="col" class="p-3">BPS</th>
                    <th scope="col" class="p-3">Attachment</th>
                    <th scope="col" class="p-3">Uploaded By</th>
                    <th scope="col" class="p-3">Status</th>
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
            var table = initDataTable('#seniority-datatable', {
                ajaxUrl: "{{ route('admin.seniority.index') }}"
                , columns: [{
                        data: "id"
                        , searchBuilderType: "num"
                    }
                    , {
                        data: "title"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "designation"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "bps"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "attachment"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "user"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "status"
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
                , defaultOrderColumn: 8
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
                    text: `<span class="symbol-container create-btn fw-bold"><i class="bi-plus-circle"></i>&nbsp; Add Seniority</span>`
                    , action: function(e, dt, node, config) {
                        pushStateModal({
                            fetchUrl: "{{ route('admin.seniority.create') }}"
                            , btnSelector: '.create-btn'
                            , title: 'Add Seniority'
                            , actionButtonName: 'Add Seniority'
                            , modalSize: 'lg'
                            , includeForm: true
                            , formAction: "{{ route('admin.seniority.store') }}"
                            , modalHeight: '35vh'
                            , hash: false
                            , tableToRefresh: table
                        , });
                    },
                }
            });

            $("#seniority-datatable").on('click', '.publish-btn', async function() {
                const seniorityId = $(this).data("id");
                const message = $(this).data("type");
                const url = "{{ route('admin.seniority.publish', ':id') }}".replace(':id', seniorityId);

                const result = await confirmAction(`Do you want to ${message} this seniority?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#seniority-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#seniority-datatable").on('click', '.archive-btn', async function() {
                const seniorityId = $(this).data("id");
                const url = "{{ route('admin.seniority.archive', ':id') }}".replace(':id', seniorityId);

                const result = await confirmAction(`Do you want to archive this Seniority?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#seniority-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#seniority-datatable").on('click', '.delete-btn', async function() {
                const seniorityId = $(this).data("id");
                const url = "{{ route('admin.seniority.destroy', ':id') }}".replace(':id', seniorityId);

                const result = await confirmAction(`Do you want to delete this seniority?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#seniority-datatable").DataTable().ajax.reload();
                    }
                }
            });

            hashTabsNavigator({
                table: table
                , dataTableUrl: "{{ route('admin.seniority.index') }}"
                , tabToHashMap: {
                    "#draft-tab": '#draft'
                    , "#published-tab": '#published'
                    , "#archived-tab": '#archived'
                , }
                , hashToParamsMap: {
                    '#draft': {
                        status: 'draft'
                    }
                    , '#published': {
                        status: 'published'
                    }
                    , '#archived': {
                        status: 'archived'
                    }
                , }
                , defaultHash: '#draft'
            });

            $('#seniority-datatable').colResizable({
                liveDrag: true
                , resizeMode: 'overflow'
                , postbackSafe: true
                , useLocalStorage: true
                , gripInnerHtml: "<div class='grip'></div>"
                , draggingClass: "dragging"
            , });

            pushStateModal({
                fetchUrl: "{{ route('admin.seniority.detail', ':id') }}",
                btnSelector: '.view-btn',
                title: 'Seniority Details',
                modalSize: 'lg',
                tableToRefresh: table,
            });
            
            if (new URLSearchParams(window.location.search).get("create") === "true") {
                document.querySelector(".create-btn")?.click();
            }
            
        });

    </script>
    @endpush
</x-app-layout>
