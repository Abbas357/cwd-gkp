<x-asset-layout title="Assets">
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
        <li class="breadcrumb-item active" aria-current="page">Assets</li>
    </x-slot>
    <div class="table-responsive">
        <table id="assets-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
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
            var table = initDataTable('#assets-datatable', {
                ajaxUrl: "{{ route('admin.apps.assets.all') }}"
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
                , columnDefs: 
                [
                    {
                        targets: [0, 3, 4, 5, 7, 9, 10, 11, 12, 13]
                        , visible: false
                    }, {
                        targets: -1,
                        className: 'action-column'
                    }
                ]
                , pageLength: 25
                , customButtons: [
                    {
                        text: `<span class="symbol-container create-btn"><i class="bi-plus-circle"></i>&nbsp; Add Asset</span>`
                        , action: function(e, dt, node, config) {
                        formWizardModal({
                                title: 'Add Asset',
                                fetchUrl: "{{ route('admin.apps.assets.create') }}",
                                btnSelector: '.create-btn',
                                actionButtonName: 'Add Asset',
                                modalSize: 'lg',
                                formAction: "{{ route('admin.apps.assets.store') }}",
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
                    },
                    {
                        text: `<span class="symbol-container" onclick="openUserQuickCreateModal(onUserCreated)"><i class="bi-plus-circle"></i>&nbsp; Add User</span>`
                        , action: function(e, dt, node, config) {

                        },
                    },
                ]
            });

            $("#assets-datatable").on('click', '.delete-btn', async function() {
                const assetId = $(this).data("id");
                const url = "{{ route('admin.apps.assets.destroy', ':id') }}".replace(':id', assetId);

                const result = await confirmAction(`Do you want to delete this asset?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#assets-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $('#assets-datatable').colResizable({
                liveDrag: true
                , resizeMode: 'overflow'
                , postbackSafe: true
                , useLocalStorage: true
                , gripInnerHtml: "<div class='grip'></div>"
                , draggingClass: "dragging"
            , });

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.assets.detail', ':id') }}",
                btnSelector: '.view-btn',
                title: 'Asset Details',
                modalSize: 'lg',
            });

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.assets.history', ':id') }}",
                btnSelector: '.history-btn',
                title: 'Asset History',
                modalSize: 'xl',
                tableToRefresh: table,
            });

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.assets.allotment.create', ':id') }}"
                , btnSelector: '.allot-btn'
                , title: 'Asset Allotment'
                , actionButtonName: 'Allot Asset'
                , modalSize: 'lg'
                , includeForm: true
                , formAction: "{{ route('admin.apps.assets.allotment.store', ':id') }}"
                , tableToRefresh: table
            , });
            
        });

    </script>
    @endpush
</x-asset-layout>
