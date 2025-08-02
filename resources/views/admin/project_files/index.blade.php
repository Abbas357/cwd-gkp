<x-app-layout title="Project Files">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Project Files</li>
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
        <table id="downloads-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
            <thead>
                <tr>
                    <th scope="col" class="p-3">ID</th>
                    <th scope="col" class="p-3">File Name</th>
                    <th scope="col" class="p-3">File Type</th>
                    <th scope="col" class="p-3">Project</th>
                    <th scope="col" class="p-3">File</th>
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
            var table = initDataTable('#downloads-datatable', {
                ajaxUrl: "{{ route('admin.project_files.index') }}"
                , columns: [{
                        data: "id"
                        , searchBuilderType: "num"
                    }
                    , {
                        data: "file_name"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "file_type"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "project"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "file"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "uploaded_by"
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
                , defaultOrderColumn: 7
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
                    text: `<span class="symbol-container create-btn fw-bold"><i class="bi-plus-circle"></i>&nbsp; Add Project Files</span>`
                    , action: function(e, dt, node, config) {
                        
                        formWizardModal({
                            title: 'Add Project File',
                            fetchUrl: "{{ route('admin.project_files.create') }}",
                            btnSelector: '.create-btn',
                            actionButtonName: 'Add Project File',
                            modalSize: 'lg',
                            formAction: "{{ route('admin.project_files.store') }}",
                            wizardSteps: [
                                {
                                    title: "File Details",
                                    fields: ["#step-1"]
                                },
                                {
                                    title: "Documents",
                                    fields: ["#step-2"]
                                }
                            ],
                            formSubmitted() {
                                table.ajax.reload();
                            }
                        });

                    },
                }
            });

            $("#downloads-datatable").on('click', '.publish-btn', async function() {
                const downloadId = $(this).data("id");
                const message = $(this).data("type");
                const url = "{{ route('admin.project_files.publish', ':id') }}".replace(':id', downloadId);

                const result = await confirmAction(`Do you want to ${message} this file?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#downloads-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#downloads-datatable").on('click', '.archive-btn', async function() {
                const downloadId = $(this).data("id");
                const url = "{{ route('admin.project_files.archive', ':id') }}".replace(':id', downloadId);

                const result = await confirmAction(`Do you want to archive this file?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#downloads-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#downloads-datatable").on('click', '.delete-btn', async function() {
                const downloadId = $(this).data("id");
                const url = "{{ route('admin.project_files.destroy', ':id') }}".replace(':id', downloadId);

                const result = await confirmAction(`Do you want to delete this file?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#downloads-datatable").DataTable().ajax.reload();
                    }
                }
            });

            hashTabsNavigator({
                table: table
                , dataTableUrl: "{{ route('admin.project_files.index') }}"
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

            $('#downloads-datatable').colResizable({
                liveDrag: true
                , resizeMode: 'overflow'
                , postbackSafe: true
                , useLocalStorage: true
                , gripInnerHtml: "<div class='grip'></div>"
                , draggingClass: "dragging"
            , });

            pushStateModal({
                fetchUrl: "{{ route('admin.project_files.detail', ':id') }}",
                btnSelector: '.view-btn',
                title: 'Download Details',
                modalSize: 'lg',
                tableToRefresh: table,
            });
            
        });

    </script>
    @endpush
</x-app-layout>
