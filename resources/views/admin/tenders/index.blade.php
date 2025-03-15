<x-app-layout title="Tenders">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Tenders</li>
    </x-slot>

    <div class="card-header mb-3">
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
        <table id="tenders-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
            <thead>
                <tr>
                    <th scope="col" class="p-3">ID</th>
                    <th scope="col" class="p-3">Title</th>
                    <th scope="col" class="p-3">Date of Advertisment</th>
                    <th scope="col" class="p-3">Closing Date</th>
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
            var table = initDataTable('#tenders-datatable', {
                ajaxUrl: "{{ route('admin.tenders.index') }}"
                , columns: [{
                        data: "id"
                        , searchBuilderType: "num"
                    }
                    , {
                        data: "title"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "date_of_advertisement"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "closing_date"
                        , searchBuilderType: "string"
                    }
                    ,  {
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
                    text: `<span class="symbol-container create-btn fw-bold"><i class="bi-plus-circle"></i>&nbsp; Add Tender</span>`
                    , action: function(e, dt, node, config) {

                        formWizardModal({
                            title: 'Add Tender',
                            fetchUrl: "{{ route('admin.tenders.create') }}",
                            btnSelector: '.create-btn',
                            actionButtonName: 'Add Tender',
                            modalSize: 'lg',
                            formAction: "{{ route('admin.tenders.store') }}",
                            wizardSteps: [
                                {
                                    title: "Basic Info",
                                    fields: ["#step-1"]
                                },
                                {
                                    title: "Description",
                                    fields: ["#step-2"]
                                },
                                {
                                    title: "Documents",
                                    fields: ["#step-3"]
                                }
                            ],
                            formSubmitted() {
                                table.ajax.reload();
                            }
                        });

                    },
                }
            });

            $("#tenders-datatable").on('click', '.publish-btn', async function() {
                const tenderId = $(this).data("id");
                const message = $(this).data("type");
                const url = "{{ route('admin.tenders.publish', ':id') }}".replace(':id', tenderId);

                const result = await confirmAction(`Do you want to ${message} this tender?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#tenders-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#tenders-datatable").on('click', '.archive-btn', async function() {
                const tenderId = $(this).data("id");
                const url = "{{ route('admin.tenders.archive', ':id') }}".replace(':id', tenderId);

                const result = await confirmAction(`Do you want to archive this tender?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#tenders-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#tenders-datatable").on('click', '.delete-btn', async function() {
                const tenderId = $(this).data("id");
                const url = "{{ route('admin.tenders.destroy', ':id') }}".replace(':id', tenderId);

                const result = await confirmAction(`Do you want to delete this tender?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#tenders-datatable").DataTable().ajax.reload();
                    }
                }
            });

            hashTabsNavigator({
                table: table
                , dataTableUrl: "{{ route('admin.tenders.index') }}"
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

            $('#tenders-datatable').colResizable({
                liveDrag: true
                , resizeMode: 'overflow'
                , postbackSafe: true
                , useLocalStorage: true
                , gripInnerHtml: "<div class='grip'></div>"
                , draggingClass: "dragging"
            , });

            pushStateModal({
                fetchUrl: "{{ route('admin.tenders.detail', ':id') }}",
                btnSelector: '.view-btn',
                title: 'Tender Details',
                modalSize: 'lg',
            });

            if (new URLSearchParams(window.location.search).get("create") === "true") {
                document.querySelector(".create-btn")?.click();
            }
        });

    </script>
    @endpush
</x-app-layout>
