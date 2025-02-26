<x-vehicle-layout title="Vehicles">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    <style>
        
    </style>
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Vehicles</li>
    </x-slot>

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

    <script>
        $(document).ready(function() {
            var table = initDataTable('#vehicles-datatable', {
                ajaxUrl: "{{ route('admin.app.vehicles.all') }}"
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
                    targets: [0, 3, 4, 5, 7, 8, 9, 10, 11, 12]
                    , visible: false
                }]
                , pageLength: 25
                , customButton: {
                    text: `<span class="symbol-container fw-bold create-btn"><i class="bi-plus-circle"></i>&nbsp; Add Vehicle</span>`
                    , action: function(e, dt, node, config) {

                        pushStateModal({
                            fetchUrl: "{{ route('admin.app.vehicles.create') }}"
                            , btnSelector: '.create-btn'
                            , title: 'Add Vehicle'
                            , actionButtonName: 'Add Vehicle'
                            , modalSize: 'lg'
                            , includeForm: true
                            , formAction: "{{ route('admin.app.vehicles.store') }}"
                            , modalHeight: '50vh'
                            , hash: false
                       , }).then((modal) => {
                            pushStateModalFormSubmission(modal, table);
                        });

                    },
                }
            });

            $("#vehicles-datatable").on('click', '.delete-btn', async function() {
                const vehicleId = $(this).data("id");
                const url = "{{ route('admin.app.vehicles.destroy', ':id') }}".replace(':id', vehicleId);

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
                fetchUrl: "{{ route('admin.app.vehicles.detail', ':id') }}",
                btnSelector: '.view-btn',
                title: 'Vehicle Details',
                modalSize: 'lg',
            });

            pushStateModal({
                fetchUrl: "{{ route('admin.app.vehicles.history', ':id') }}",
                btnSelector: '.history-btn',
                title: 'Vehicle History',
                modalSize: 'xl',
            });

            pushStateModal({
                fetchUrl: "{{ route('admin.app.vehicles.allotment.create', ':id') }}"
                , btnSelector: '.allot-btn'
                , title: 'Vehicle Allotment'
                , actionButtonName: 'Allot Vehicle'
                , modalSize: 'lg'
                , includeForm: true
                , formAction: "{{ route('admin.app.vehicles.allotment.store', ':id') }}"
                , modalHeight: '65vh'
            , }).then((modal) => {
                const vehicleModal = $('#' + modal);
                const updateVehicleBtn = vehicleModal.find('button[type="submit"]');
                vehicleModal.find('form').on('submit', async function(e) {
                    e.preventDefault();
                    const form = this;
                    const formData = new FormData(form);
                    const url = $(this).attr('action');
                    setButtonLoading(updateVehicleBtn, true);
                    try {
                        const result = await fetchRequest(url, 'POST', formData);
                        if (result) {
                            setButtonLoading(updateVehicleBtn, false);
                            vehicleModal.modal('hide');
                            table.ajax.reload();
                        }
                    } catch (error) {
                        setButtonLoading(updateVehicleBtn, false);
                        console.error('Error during form submission:', error);
                    }
                });
            });
            
        });

    </script>
    @endpush
</x-vehicle-layout>
