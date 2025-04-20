<x-app-layout title="Projects">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Projects</li>
    </x-slot>

    <div class="card-header mb-3">
        <ul class="nav nav-tabs nav-tabs-table">
            <li class="nav-item">
                <a id="draft-tab" class="nav-link" data-bs-toggle="tab" href="#draft">Draft</a>
            </li>
            <li class="nav-item">
                <a id="inprogress-tab" class="nav-link" data-bs-toggle="tab" href="#inprogress">In-Progress</a>
            </li>
            <li class="nav-item">
                <a id="completed-tab" class="nav-link" data-bs-toggle="tab" href="#completed">Completed</a>
            </li>
            <li class="nav-item">
                <a id="archived-tab" class="nav-link" data-bs-toggle="tab" href="#archived">Archived</a>
            </li>
        </ul>
    </div>

    <div class="table-responsive">
        <table id="dev-projects-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
            <thead>
                <tr>
                    <th scope="col" class="p-3">ID</th>
                    <th scope="col" class="p-3">Name</th>
                    <th scope="col" class="p-3">Commencement Date</th>
                    <th scope="col" class="p-3">Total Cost (Millions)</th>
                    <th scope="col" class="p-3">District</th>
                    <th scope="col" class="p-3">Chief Engineer</th>
                    <th scope="col" class="p-3">Progress Percentage</th>
                    <th scope="col" class="p-3">Year of Completion</th>
                    <th scope="col" class="p-3">Uploaded By</th>
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
            var table = initDataTable('#dev-projects-datatable', {
                ajaxUrl: "{{ route('admin.development_projects.index') }}"
                , columns: [{
                        data: "id"
                        , searchBuilderType: "num"
                    }
                    , {
                        data: "name"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "commencement_date"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "total_cost"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "district"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "chief_engineer"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "progress_percentage"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "year_of_completion"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "uploaded_by"
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
                    targets: [0,3,5,6,7]
                    , visible: false
                    }, {
                        targets: -1,
                        className: 'action-column'
                    }
                ]
                , pageLength: 25
                , customButton: {
                    text: `<span class="symbol-container create-btn fw-bold"><i class="bi-plus-circle"></i>&nbsp; Add Dev. Project</span>`
                    , action: function(e, dt, node, config) {
                        
                        formWizardModal({
                            title: 'Add Development Project',
                            fetchUrl: "{{ route('admin.development_projects.create') }}",
                            btnSelector: '.create-btn',
                            actionButtonName: 'Add Development Project',
                            modalSize: 'lg',
                            formAction: "{{ route('admin.development_projects.store') }}",
                            wizardSteps: [
                                {
                                    title: "Basic Info",
                                    fields: ["#step-1"]
                                },
                                {
                                    title: "Project Details",
                                    fields: ["#step-2"]
                                },
                                {
                                    title: "Validity",
                                    fields: ["#step-3"]
                                },
                                {
                                    title: "Progress & Files",
                                    fields: ["#step-4"]
                                }
                            ],
                            formSubmitted() {
                                table.ajax.reload();
                            }
                        });

                    }
                , }
            });

            hashTabsNavigator({
                table: table
                , dataTableUrl: "{{ route('admin.development_projects.index') }}"
                , tabToHashMap: {
                    "#draft-tab": '#draft'
                    , "#inprogress-tab": '#inprogress'
                    , "#completed-tab": '#completed'
                    , "#archived-tab": '#archived'
                , }
                , hashToParamsMap: {
                    '#draft': {
                        status: 'Draft'
                    }
                    , '#inprogress': {
                        status: 'In-Progress'
                    }
                    , '#completed': {
                        status: 'Completed'
                    }
                    , '#archived': {
                        status: 'Archived'
                    }
                , }
                , defaultHash: '#draft'
            });

            $("#dev-projects-datatable").on('click', '.publish-btn', async function() {
                const dev_projectId = $(this).data("id");
                const message = $(this).data("type");
                const url = "{{ route('admin.development_projects.publish', ':id') }}".replace(':id', dev_projectId);

                const result = await confirmAction(`Do you want to ${message} this Project?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#dev-projects-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#dev-projects-datatable").on('click', '.archive-btn', async function() {
                const dev_projectId = $(this).data("id");
                const url = "{{ route('admin.development_projects.archive', ':id') }}".replace(':id', dev_projectId);

                const result = await confirmAction(`Do you want to archive this Project?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#dev-projects-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#dev-projects-datatable").on('click', '.delete-btn', async function() {
                const projectsId = $(this).data("id");
                const url = "{{ route('admin.development_projects.destroy', ':id') }}".replace(':id', projectsId);

                const result = await confirmAction(`Do you want to delete this projects?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#dev-projects-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $('#dev-projects-datatable').colResizable({
                liveDrag: true
                , resizeMode: 'overflow'
                , postbackSafe: true
                , useLocalStorage: true
                , gripInnerHtml: "<div class='grip'></div>"
                , draggingClass: "dragging"
            , });

            pushStateModal({
                fetchUrl: "{{ route('admin.development_projects.detail', ':id') }}"
                , btnSelector: '.view-btn'
                , title: 'Projects Details'
                , modalSize: 'lg'
            , });

            if (new URLSearchParams(window.location.search).get("create") === "true") {
                document.querySelector(".create-btn")?.click();
            }

        });

    </script>
    @endpush
</x-app-layout>
