<x-app-layout title="Achievements">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Achievements</li>
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
        <table id="achievements-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
            <thead>
                <tr>
                    <th scope="col" class="p-3">ID</th>
                    <th scope="col" class="p-3">Title</th>
                    <th scope="col" class="p-3">Location</th>
                    <th scope="col" class="p-3">Start Date</th>
                    <th scope="col" class="p-3">End Date</th>
                    <th scope="col" class="p-3">Publish By</th>
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

    <script>
        $(document).ready(function() {
            var table = initDataTable('#achievements-datatable', {
                ajaxUrl: "{{ route('admin.achievements.index') }}"
                , columns: [{
                        data: "id"
                        , searchBuilderType: "num"
                    }
                    , {
                        data: "title"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "location"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "start_date"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "end_date"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "publish_by"
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
                , defaultOrderColumn: 9
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [0]
                    , visible: false
                    }, {
                        targets: -1,
                        className: 'action-column'
                    }
                ]
                , pageLength: 25
                , customButton: {
                    text: `<span class="symbol-container create-btn fw-bold"><i class="bi-plus-circle"></i>&nbsp; Add Achievement</span>`
                    , action: function(e, dt, node, config) {
                        
                        formWizardModal({
                            title: 'Add Achievement',
                            fetchUrl: "{{ route('admin.achievements.create') }}",
                            btnSelector: '.create-btn',
                            actionButtonName: 'Add Achievement',
                            modalSize: 'lg',
                            formAction: "{{ route('admin.achievements.store') }}",
                            wizardSteps: [
                                {
                                    title: "Basic Info",
                                    fields: ["#step-1"]
                                },
                                {
                                    title: "Timeline & Files",
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

            $("#achievements-datatable").on('click', '.publish-btn', async function() {
                const achievementId = $(this).data("id");
                const message = $(this).data("type");
                const url = "{{ route('admin.achievements.publish', ':id') }}".replace(':id', achievementId);

                const result = await confirmAction(`Do you want to ${message} this achievement?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#achievements-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#achievements-datatable").on('click', '.archive-btn', async function() {
                const achievementId = $(this).data("id");
                const url = "{{ route('admin.achievements.archive', ':id') }}".replace(':id', achievementId);

                const result = await confirmAction(`Do you want to archive this achievement?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#achievements-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#achievements-datatable").on('click', '.delete-btn', async function() {
                const achievementId = $(this).data("id");
                const url = "{{ route('admin.achievements.destroy', ':id') }}".replace(':id', achievementId);

                const result = await confirmAction(`Do you want to delete this achievement?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#achievements-datatable").DataTable().ajax.reload();
                    }
                }
            });

            hashTabsNavigator({
                table: table
                , dataTableUrl: "{{ route('admin.achievements.index') }}"
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

            $('#achievements-datatable').colResizable({
                liveDrag: true
                , resizeMode: 'overflow'
                , postbackSafe: true
                , useLocalStorage: true
                , gripInnerHtml: "<div class='grip'></div>"
                , draggingClass: "dragging"
            , });

            pushStateModal({
                fetchUrl: "{{ route('admin.achievements.detail', ':id') }}",
                btnSelector: '.view-btn',
                title: 'Achievement Details',
                modalSize: 'lg',
            });
            
            if (new URLSearchParams(window.location.search).get("create") === "true") {
                document.querySelector(".create-btn")?.click();
            }
            
        });

    </script>
    @endpush
</x-app-layout>
