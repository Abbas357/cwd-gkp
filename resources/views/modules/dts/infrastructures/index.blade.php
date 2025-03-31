<x-dts-layout title="Infrastructures">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Infrastructures</li>
    </x-slot>

    <div class="table-responsive">
        <table id="infrastructure-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Name</th>
                    <th>Length</th>
                    <th>District</th>
                    <th>East Start Coordinate</th>
                    <th>North Start Coordinate</th>
                    <th>East End Coordinate</th>
                    <th>North End Coordinate</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Actions</th>
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
            var table = initDataTable('#infrastructure-datatable', {
                ajaxUrl: "{{ route('admin.apps.dts.infrastructures.index') }}"
                , columns: [
                    {
                        data: "id"
                        , searchBuilderType: "num"
                    }
                    , {
                        data: "type"
                        , searchBuilderType: "date"
                    },
                    {
                        data: 'name',
                        searchBuilderType: "string"
                    },
                    {
                        data: 'length',
                        searchBuilderType: "string"
                    },
                    {
                        data: 'district',
                        searchBuilderType: "string"
                    },
                    {
                        data: 'east_start_coordinate',
                        searchBuilderType: "string"
                    },
                    {
                        data: 'north_start_coordinate',
                        searchBuilderType: "string"
                    },
                    {
                        data: 'east_end_coordinate',
                        searchBuilderType: "string"
                    },
                    {
                        data: 'north_end_coordinate',
                        searchBuilderType: "string"
                    },
                    {
                        data: 'created_at',
                        searchBuilderType: "date"
                    },
                    {
                        data: 'updated_at',
                        searchBuilderType: "date"
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
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
                , pageLength: 25
                , customButton: {
                    text: `<span class="symbol-container fw-bold create-btn"><i class="bi-plus-circle"></i>&nbsp; Add Infrastructure</span>`
                    , action: function(e, dt, node, config) {

                       formWizardModal({
                            title: 'Add Infrastructure',
                            fetchUrl: "{{ route('admin.apps.dts.infrastructures.create') }}",
                            btnSelector: '.create-btn',
                            actionButtonName: 'Add Infrastructure',
                            modalSize: 'lg',
                            formAction: "{{ route('admin.apps.dts.infrastructures.store') }}",
                            wizardSteps: [
                                {
                                    title: "Basic Info",
                                    fields: ["#step-1"]
                                },
                                {
                                    title: "Infrastructure Details",
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

            $("#infrastructure-datatable").on('click', '.delete-btn', async function() {
                const infrastructureId = $(this).data("id");
                const url = "{{ route('admin.apps.dts.infrastructures.destroy', ':id') }}".replace(':id', infrastructureId);

                const result = await confirmAction(`Do you want to delete this infrastructure?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#infrastructure-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $('#infrastructure-datatable').colResizable({
                liveDrag: true
                , resizeMode: 'overflow'
                , postbackSafe: true
                , useLocalStorage: true
                , gripInnerHtml: "<div class='grip'></div>"
                , draggingClass: "dragging"
            , });

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.dts.infrastructures.detail', ':id') }}",
                btnSelector: '.view-btn',
                title: 'infrastructure Details',
                modalSize: 'lg',
            });

            if (new URLSearchParams(window.location.search).get("create") === "true") {
                document.querySelector(".create-btn")?.click();
            }
            
        });

    </script>
    @endpush
</x-dts-layout>
