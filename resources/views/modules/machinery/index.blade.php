<x-machinery-layout title="Machineries">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    <style>
        
    </style>
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Machineries</li>
    </x-slot>

    <div class="table-responsive">
        <table id="machineries-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
            <thead>
                <tr>
                    <th scope="col" class="p-3">ID</th>
                    <th scope="col" class="p-3">Type</th>
                    <th scope="col" class="p-3">Functional Status</th>
                    <th scope="col" class="p-3">Brand</th>
                    <th scope="col" class="p-3">Model</th>
                    <th scope="col" class="p-3">Model Year</th>
                    <th scope="col" class="p-3">Fuel Type</th>
                    <th scope="col" class="p-3">Registration Number</th>
                    <th scope="col" class="p-3">Chassis Number</th>
                    <th scope="col" class="p-3">Engine Number</th>
                    <th scope="col" class="p-3">Remarks</th>
                    <th scope="col" class="p-3">Added By</th>
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
            var table = initDataTable('#machineries-datatable', {
                ajaxUrl: "{{ route('admin.apps.machineries.all') }}"
                , columns: [{
                        data: "id"
                        , searchBuilderType: "num"
                    }
                    , {
                        data: "type"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "functional_status"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "brand"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "model"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "model_year"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "fuel_type"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "registration_number"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "chassis_number"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "engine_number"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "remarks"
                        , searchBuilderType: "date"
                    }
                    , {
                        data: "added_by"
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
                , defaultOrderColumn: 20
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [0, 7, 8, 9, 11, 13]
                    , visible: false
                    }, {
                        targets: -1,
                        className: 'action-column'
                    }
                ]
                , pageLength: 25
                , customButton: {
                    text: `<span class="symbol-container fw-bold create-btn"><i class="bi-plus-circle"></i>&nbsp; Add Machinery</span>`
                    , action: function(e, dt, node, config) {

                       formWizardModal({
                            title: 'Add Machinery',
                            fetchUrl: "{{ route('admin.apps.machineries.create') }}",
                            btnSelector: '.create-btn',
                            actionButtonName: 'Add Machinery',
                            modalSize: 'lg',
                            formAction: "{{ route('admin.apps.machineries.store') }}",
                            wizardSteps: [
                                {
                                    title: "Basic Info",
                                    fields: ["#step-1"]
                                },
                                {
                                    title: "More Details",
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

            $("#machineries-datatable").on('click', '.delete-btn', async function() {
                const machineryId = $(this).data("id");
                const url = "{{ route('admin.apps.machineries.destroy', ':id') }}".replace(':id', machineryId);

                const result = await confirmAction(`Do you want to delete this machinery?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#machineries-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $('#machineries-datatable').colResizable({
                liveDrag: true
                , resizeMode: 'overflow'
                , postbackSafe: true
                , useLocalStorage: true
                , gripInnerHtml: "<div class='grip'></div>"
                , draggingClass: "dragging"
            , });

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.machineries.detail', ':id') }}",
                btnSelector: '.view-btn',
                title: 'Machinery Details',
                modalSize: 'lg',
                tableToRefresh: table,
            });

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.machineries.history', ':id') }}",
                btnSelector: '.history-btn',
                title: 'Machinery History',
                modalSize: 'xl',
            });

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.machineries.allocation.create', ':id') }}"
                , btnSelector: '.allocate-btn'
                , title: 'Machinery Allocation'
                , actionButtonName: 'Allot Machinery'
                , modalSize: 'lg'
                , includeForm: true
                , formAction: "{{ route('admin.apps.machineries.allocation.store', ':id') }}"
                , modalHeight: '65vh'
                , tableToRefresh: table
            , });
        });

    </script>
    @endpush
</x-machinery-layout>