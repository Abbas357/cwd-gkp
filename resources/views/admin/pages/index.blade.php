<x-app-layout title="Pages">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Pages</li>
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

    <div class="table-responsive">
        <table id="pages-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
            <thead>
                <tr>
                    <th scope="col" class="p-3">ID</th>
                    <th scope="col" class="p-3">Title</th>
                    <th scope="col" class="p-3">Page Type</th>
                    <th scope="col" class="p-3">Attachment</th>
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
            var table = initDataTable('#pages-datatable', {
                ajaxUrl: "{{ route('admin.pages.index') }}"
                , columns: [{
                        data: "id"
                        , searchBuilderType: "num"
                    }
                    , {
                        data: "title"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "page_type"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "attachment"
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
                , defaultOrderColumn: 5
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [0]
                    , visible: false
                }]
                , pageLength: 25
                , customButton: {
                    text: `<span class="symbol-container create-btn fw-bold"><i class="bi-plus-circle"></i>&nbsp; Add Page</span>`
                    , action: function(e, dt, node, config) {
                        pushStateModal({
                            fetchUrl: "{{ route('admin.pages.create') }}"
                            , btnSelector: '.create-btn'
                            , title: 'Add Page'
                            , actionButtonName: 'Add Page'
                            , modalSize: 'xl'
                            , includeForm: true
                            , formAction: "{{ route('admin.pages.store') }}"
                            , modalHeight: '75vh'
                            , hash: false
                        , }).then((modal) => {
                            pushStateModalFormSubmission(modal, table);
                        });
                    },
                }
            });

            $("#pages-datatable").on('click', '.activate-btn', async function() {
                const pageId = $(this).data("id");
                const message = $(this).data("type");
                const url = "{{ route('admin.pages.activate', ':id') }}".replace(':id', pageId);

                const result = await confirmAction(`Do you want to ${message} this page?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#pages-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#pages-datatable").on('click', '.delete-btn', async function() {
                const pageId = $(this).data("id");
                const url = "{{ route('admin.pages.destroy', ':id') }}".replace(':id', pageId);

                const result = await confirmAction(`Do you want to delete this page?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#pages-datatable").DataTable().ajax.reload();
                    }
                }
            });

            hashTabsNavigator({
                table: table
                , dataTableUrl: "{{ route('admin.pages.index') }}"
                , tabToHashMap: {
                    "#active-tab": '#active'
                    , "#inactive-tab": '#inactive'
                , }
                , hashToParamsMap: {
                    '#active': {
                        status: 1
                    }
                    , '#inactive': {
                        status: 0
                    }
                , }
                , defaultHash: '#active'
            });

            $('#pages-datatable').colResizable({
                liveDrag: true
                , resizeMode: 'overflow'
                , postbackSafe: true
                , useLocalStorage: true
                , gripInnerHtml: "<div class='grip'></div>"
                , draggingClass: "dragging"
            , });

            pushStateModal({
                fetchUrl: "{{ route('admin.pages.detail', ':id') }}",
                btnSelector: '.view-btn',
                title: 'Pages Details',
                modalSize: 'lg',
            });
            
        });

    </script>
    @endpush
</x-app-layout>
