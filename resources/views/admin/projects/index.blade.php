<x-app-layout title="Projects">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Projects</li>
    </x-slot>

    <div class="table-responsive">
        <table id="projects-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
            <thead>
                <tr>
                    <th scope="col" class="p-3">ID</th>
                    <th scope="col" class="p-3">Name</th>
                    <th scope="col" class="p-3">Funding Source</th>
                    <th scope="col" class="p-3">Location</th>
                    <th scope="col" class="p-3">Start Date</th>
                    <th scope="col" class="p-3">End Date</th>
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
            var table = initDataTable('#projects-datatable', {
                ajaxUrl: "{{ route('admin.projects.index') }}"
                , columns: [{
                        data: "id"
                        , searchBuilderType: "num"
                    }
                    , {
                        data: "name"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "funding_source"
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
                        data: 'action'
                        , orderable: false
                        , searchable: false
                        , type: "html"
                    }
                ]
                , defaultOrderColumn: 0
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
                    text: `<span class="symbol-container create-btn fw-bold"><i class="bi-plus-circle"></i>&nbsp; Add Project</span>`
                    , action: function(e, dt, node, config) {
                        
                        formWizardModal({
                            title: 'Add Project',
                            fetchUrl: "{{ route('admin.projects.create') }}",
                            btnSelector: '.create-btn',
                            actionButtonName: 'Add Project',
                            modalSize: 'lg',
                            formAction: "{{ route('admin.projects.store') }}",
                            wizardSteps: [
                                {
                                    title: "Basic Info",
                                    fields: ["#step-1"]
                                },
                                {
                                    title: "Budget & Location",
                                    fields: ["#step-2"]
                                },
                                {
                                    title: "Validity & Attachments",
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

            $("#projects-datatable").on('click', '.delete-btn', async function() {
                const projectsId = $(this).data("id");
                const url = "{{ route('admin.projects.destroy', ':id') }}".replace(':id', projectsId);

                const result = await confirmAction(`Do you want to delete this projects?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#projects-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $('#projects-datatable').colResizable({
                liveDrag: true
                , resizeMode: 'overflow'
                , postbackSafe: true
                , useLocalStorage: true
                , gripInnerHtml: "<div class='grip'></div>"
                , draggingClass: "dragging"
            , });

            pushStateModal({
                fetchUrl: "{{ route('admin.projects.detail', ':id') }}",
                btnSelector: '.view-btn',
                title: 'Projects Details',
                modalSize: 'lg',
                tableToRefresh: table,
            });
            
        });

    </script>
    @endpush
</x-app-layout>
