<x-vehicle-layout title="Vehicles">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <script>
        function onUserCreated(user) {
            // window.location.reload();
        }
    </script>
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Vehicles</li>
    </x-slot>
    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-light border" onclick="openUserQuickCreateModal(onUserCreated)">
            <i class="bi-person-plus"></i> Add User
        </button>
    </div>
    <div class="table-responsive">
        <table id="vehicles-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
            <thead>
                <tr>
                    <th scope="col" class="p-3">ID</th>
                    <th scope="col" class="p-3">Type</th>
                    <th scope="col" class="p-3">Functional Status</th>
                    <th scope="col" class="p-3">Color</th>
                    <th scope="col" class="p-3">Fuel Type</th>
                    <th scope="col" class="p-3">Registration Status</th>
                    <th scope="col" class="p-3">Brand</th>
                    <th scope="col" class="p-3">Model</th>
                    <th scope="col" class="p-3">Registration Number</th>
                    <th scope="col" class="p-3">Model Year</th>
                    <th scope="col" class="p-3">Chassis Number</th>
                    <th scope="col" class="p-3">Engine Number</th>
                    <th scope="col" class="p-3">Remarks</th>
                    <th scope="col" class="p-3">Added By</th>
                    <th scope="col" class="p-3">Assigned To</th>
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
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/quick-create-user.min.js') }}"></script>   

    <script>
        $(document).ready(function() {
            var table = initDataTable('#vehicles-datatable', {
                ajaxUrl: "{{ route('admin.apps.vehicles.all') }}"
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
                        data: "color"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "fuel_type"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "registration_status"
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
                        data: "registration_number"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "model_year"
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
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "added_by"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "assigned_to"
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
                , defaultOrderColumn: 16
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [0, 3, 4, 5, 7, 8, 9, 10, 11, 12, 13]
                    , visible: false
                }]
                , pageLength: 25
                , customButton: {
                    text: `<span class="symbol-container fw-bold create-btn"><i class="bi-plus-circle"></i>&nbsp; Add Vehicle</span>`
                    , action: function(e, dt, node, config) {

                       formWizardModal({
                            title: 'Add Vehicle',
                            fetchUrl: "{{ route('admin.apps.vehicles.create') }}",
                            btnSelector: '.create-btn',
                            actionButtonName: 'Add Vehicle',
                            modalSize: 'lg',
                            formAction: "{{ route('admin.apps.vehicles.store') }}",
                            wizardSteps: [
                                {
                                    title: "Basic Info",
                                    fields: ["#step-1"]
                                },
                                {
                                    title: "Model Info",
                                    fields: ["#step-2"]
                                },
                                {
                                    title: "Reg. info",
                                    fields: ["#step-3"]
                                },
                                {
                                    title: "Images",
                                    fields: ["#step-4"]
                                }
                            ],
                            formSubmitted() {
                                table.ajax.reload();
                            }
                        });

                    },
                }
            });

            $("#vehicles-datatable").on('click', '.delete-btn', async function() {
                const vehicleId = $(this).data("id");
                const url = "{{ route('admin.apps.vehicles.destroy', ':id') }}".replace(':id', vehicleId);

                const result = await confirmAction(`Do you want to delete this vehicle?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#vehicles-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $('#vehicles-datatable').colResizable({
                liveDrag: true
                , resizeMode: 'overflow'
                , postbackSafe: true
                , useLocalStorage: true
                , gripInnerHtml: "<div class='grip'></div>"
                , draggingClass: "dragging"
            , });

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.vehicles.detail', ':id') }}",
                btnSelector: '.view-btn',
                title: 'Vehicle Details',
                modalSize: 'lg',
            });

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.vehicles.history', ':id') }}",
                btnSelector: '.history-btn',
                title: 'Vehicle History',
                modalSize: 'xl',
            });

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.vehicles.allotment.create', ':id') }}"
                , btnSelector: '.allot-btn'
                , title: 'Vehicle Allotment'
                , actionButtonName: 'Allot Vehicle'
                , modalSize: 'lg'
                , includeForm: true
                , formAction: "{{ route('admin.apps.vehicles.allotment.store', ':id') }}"
                , tableToRefresh: table
            , });
            
        });

    </script>
    @endpush
</x-vehicle-layout>
