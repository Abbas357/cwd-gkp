<x-dmis-layout title="Damages">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Damages</li>
    </x-slot>

    <div class="inward-tabs mb-3">
        <ul class="nav nav-tabs nav-tabs-table">
            <li class="nav-item">
                <a id="road-tab" class="nav-link" data-bs-toggle="tab" href="#road">Road</a>
            </li>
            <li class="nav-item">
                <a id="bridge-tab" class="nav-link" data-bs-toggle="tab" href="#bridge">Bridge</a>
            </li>
            <li class="nav-item">
                <a id="culvert-tab" class="nav-link" data-bs-toggle="tab" href="#culvert">Culvert</a>
            </li>
        </ul>
    </div>

    <div class="table-responsive">
        <table id="damages-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Report Date</th>
                    <th>Type</th>
                    <th>Infrastructure Name</th>
                    <th>Office</th>
                    <th>District</th>
                    <th>Damaged Length</th>
                    <th>Damage North Start</th>
                    <th>Damage North End</th>
                    <th>Damage East Start</th>
                    <th>Damage East End</th>
                    <th>Damage Status</th>
                    <th>Damage Nature</th>
                    <th>Approximate Restoration Cost</th>
                    <th>Approximate Rehabilitation Cost</th>
                    <th>Road Status</th>
                    <th>Remarks</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
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
            var table = initDataTable('#damages-datatable', {
                ajaxUrl: "{{ route('admin.apps.dmis.damages.index') }}"
                , columns: [
                    {
                        data: "id",
                        searchBuilderType: "num"
                    },
                    {
                        data: 'report_date',
                        searchBuilderType: "date"
                    },
                    {
                        data: 'type',
                        searchBuilderType: "string"
                    },
                    {
                        data: 'name',
                        searchBuilderType: "string"
                    },
                    {
                        data: 'office',
                        searchBuilderType: "string"
                    },
                    {
                        data: 'district',
                        searchBuilderType: "string"
                    },
                    {
                        data: 'damaged_length',
                        searchBuilderType: "num"
                    },
                    {
                        data: 'damage_north_start',
                        searchBuilderType: "num"
                    },
                    {
                        data: 'damage_north_end',
                        searchBuilderType: "num"
                    },
                    {
                        data: 'damage_east_start',
                        searchBuilderType: "num"
                    },
                    {
                        data: 'damage_east_end',
                        searchBuilderType: "num"
                    },
                    {
                        data: 'damage_status',
                        searchBuilderType: "string"
                    },
                    {
                        data: 'damage_nature',
                        searchBuilderType: "string"
                    },
                    {
                        data: 'approximate_restoration_cost',
                        searchBuilderType: "num"
                    },
                    {
                        data: 'approximate_rehabilitation_cost',
                        searchBuilderType: "num"
                    },
                    {
                        data: 'road_status',
                        searchBuilderType: "string"
                    },
                    {
                        data: 'remarks',
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
                    }   
                ]
                , defaultOrderColumn: 17
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [0, 2, 4, 5, 7, 8, 9, 10, 16]
                    , visible: false
                    }, {
                        targets: -1,
                        className: 'action-column'
                    }
                ]
                , pageLength: 10
                , customButton: {
                    text: `<span class="symbol-container fw-bold create-btn"><i class="bi-plus-circle"></i>&nbsp; Add Damage</span>`
                    , action: function(e, dt, node, config) {

                       formWizardModal({
                            title: 'Add Damage',
                            fetchUrl: "{{ route('admin.apps.dmis.damages.create') }}",
                            btnSelector: '.create-btn',
                            actionButtonName: 'Add Damage',
                            modalSize: 'lg',
                            formAction: "{{ route('admin.apps.dmis.damages.store') }}",
                            wizardSteps: [
                                {
                                    title: "Basic Info",
                                    fields: ["#step-1"]
                                },
                                {
                                    title: "Detail & Coordinates",
                                    fields: ["#step-2"]
                                },
                                {
                                    title: "Cost Info & Images",
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

            $("#damages-datatable").on('click', '.delete-btn', async function() {
                const damageId = $(this).data("id");
                const url = "{{ route('admin.apps.dmis.damages.destroy', ':id') }}".replace(':id', damageId);

                const result = await confirmAction(`Do you want to delete this damage?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#damages-datatable").DataTable().ajax.reload();
                    }
                }
            });

            hashTabsNavigator({
                table: table
                , dataTableUrl: "{{ route('admin.apps.dmis.damages.index') }}"
                , tabToHashMap: {
                    "#road-tab": '#road'
                    , "#bridge-tab": '#bridge'
                    , '#culvert-tab': '#culvert'
                }
                , hashToParamsMap: {
                    '#road': {
                        type: 'Road'
                    }
                    , '#bridge': {
                        type: 'Bridge'
                    }
                    , '#culvert': {
                        type: 'Culvert'
                    }
                }
                , defaultHash: '#road'
            });

            $('#damages-datatable').colResizable({
                liveDrag: true
                , resizeMode: 'overflow'
                , postbackSafe: true
                , useLocalStorage: true
                , gripInnerHtml: "<div class='grip'></div>"
                , draggingClass: "dragging"
            , });

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.dmis.damages.detail', ':id') }}",
                btnSelector: '.view-btn',
                modalType: 'edit',
                title: 'Damage Details',
                modalSize: 'lg',
                tableToRefresh: table,
            });

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.dmis.damages.logs', ':id') }}",
                btnSelector: '.view-logs-btn',
                modalType: 'logs',
                title: 'Damage Logs',
                modalSize: 'xl',
                tableToRefresh: table,
            });

            
        });

    </script>
    @endpush
</x-dmis-layout>
