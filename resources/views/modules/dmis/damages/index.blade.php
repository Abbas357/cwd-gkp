<x-dmis-layout title="Damages">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Damages</li>
    </x-slot>

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
                    <th>Damage East Start</th>
                    <th>Damage North Start</th>
                    <th>Damage East End</th>
                    <th>Damage North End</th>
                    <th>Damage Status</th>
                    <th>Damage Nature</th>
                    <th>Approximate Restoration Cost</th>
                    <th>Approximate Rehabilitation Cost</th>
                    <th>Road Status</th>
                    <th>Remarks</th>
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
                        data: 'damage_east_start',
                        searchBuilderType: "num"
                    },
                    {
                        data: 'damage_north_start',
                        searchBuilderType: "num"
                    },
                    {
                        data: 'damage_east_end',
                        searchBuilderType: "num"
                    },
                    {
                        data: 'damage_north_end',
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
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
                , defaultOrderColumn: 7
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [0, 6, 7, 8, 9, 12, 13, 14, 15]
                    , visible: false
                    }, {
                        targets: -1,
                        className: 'action-column'
                    }
                ]
                , pageLength: 25
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
                                    title: "Damage Information",
                                    fields: ["#step-2"]
                                },
                                {
                                    title: "Damage Coordinates",
                                    fields: ["#step-3"]
                                },
                                {
                                    title: "Cost and Additional Info",
                                    fields: ["#step-4"]
                                },
                                {
                                    title: "Images",
                                    fields: ["#step-5"]
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
                title: 'Damage Details',
                modalSize: 'lg',
            });

            
        });

    </script>
    @endpush
</x-dmis-layout>
